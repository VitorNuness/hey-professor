<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    $user      = User::factory()->create();
    $questions = Question::factory(5)->create();

    actingAs($user);
    $response = get(route('dashboard'));

    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});

it('should a paginate result', function () {
    $user = User::factory()->create();
    Question::factory(20)->create();

    actingAs($user);
    get(route('dashboard'))
        ->assertViewHas('questions', function ($value) {
            return $value instanceof LengthAwarePaginator;
        });
});

it('should order by like and unlike, most liked question should be at the top, most unliked questions should be in the bottom', function () {
    $user        = User::factory()->create();
    $anotherUser = User::factory()->create();
    Question::factory(5)->create();
    $mostLikedQuestion = Question::find(3);
    $user->like($mostLikedQuestion);
    $mostUnlikedQuestion = Question::find(1);
    $anotherUser->unlike($mostUnlikedQuestion);

    actingAs($user);
    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) {
            expect($questions)
                ->first()->id->toBe(3)
                ->and($questions)
                ->last()->id->toBe(1);

            return true;
        });
});
