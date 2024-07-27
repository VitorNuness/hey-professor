<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to publish a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['is_draft' => true]);

    actingAs($user);
    put(route('question.publish', $question))
        ->assertRedirect();
    $question->refresh();

    expect($question->is_draft)->toBe(0);
});

it('should make sure that only the person who has created the question can publish the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['is_draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    put(route('question.publish', $question))
        ->assertForbidden();

    actingAs($rightUser);
    put(route('question.publish', $question))
        ->assertRedirect();
});
