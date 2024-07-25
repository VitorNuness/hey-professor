<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to publish a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['is_draft' => true]);

    actingAs($user);
    put(route('question.publish', $question))
        ->assertRedirect();
    $question->refresh();

    expect($question->is_draft)->toBe(0);
});
