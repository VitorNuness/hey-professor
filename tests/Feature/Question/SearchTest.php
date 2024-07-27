<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to search a question by text', function () {
    $user           = User::factory()->create();
    $wrongQuestions = Question::factory(10)->create([
        'question' => 'You dont find me.',
    ]);
    $expectedQuestion = Question::factory()->create([
        'question' => 'Im find this question?',
    ]);

    actingAs($user);
    get(route('dashboard', [
        'search' => 'question',
    ]))->assertDontSee('You dont find me.')
        ->assertSee($expectedQuestion->question);
});
