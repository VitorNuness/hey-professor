<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to update the question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    put(route('question.update', $question), [
        'question' => 'Updated question?',
    ])->assertRedirect();

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
