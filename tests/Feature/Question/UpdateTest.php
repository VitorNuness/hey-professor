<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, put};

it('should be able to update the question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    put(route('question.update', $question), [
        'question' => 'Updated question?',
    ])->assertRedirect(route('question.index'));

    $question->refresh();

    expect($question->question)->toBe('Updated question?');
});
it('should make sure that only question with status DRAFT can be updateed', function () {
    $user          = User::factory()->create();
    $draftQuestion = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);
    $publishedQuestion = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => false]);

    actingAs($user);
    put(route('question.update', $publishedQuestion), [
        'question' => 'Updated question?',
    ])->assertForbidden();
    put(route('question.update', $draftQuestion), [
        'question' => 'Updated question?',
    ])->assertRedirect();
});

it('should make sure that only the person who has created the question can update the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['is_draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    put(route('question.update', $question), [
        'question' => 'Updated question?',
    ])->assertForbidden();

    actingAs($rightUser);
    put(route('question.update', $question), [
        'question' => 'Updated question?',
    ])->assertRedirect();
});

it('should be able to update a question bigger than 255 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    $request->assertRedirect();
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('should update as a draft all the time', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?',
        'is_draft' => true,
    ]);
});

it('should check if ends with question mark ?', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
    ]);
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

it('should have at least 10 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    $request->assertSessionHasErrors([
        'question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question']),
    ]);
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});
