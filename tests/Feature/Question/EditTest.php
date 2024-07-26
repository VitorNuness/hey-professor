<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to open a question to edit', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    get(route('question.edit', $question))
        ->assertSuccessful();
});

it('should return a view', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    get(route('question.edit', $question))
        ->assertViewIs('question.edit');
});

it('should make sure that only question with status DRAFT can be edited', function () {
    $user          = User::factory()->create();
    $draftQuestion = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);
    $publishedQuestion = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => false]);

    actingAs($user);
    get(route('question.edit', $publishedQuestion))
        ->assertForbidden();
    get(route('question.edit', $draftQuestion))
        ->assertSuccessful();
});
