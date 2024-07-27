<?php

namespace App\Http\Controllers\Auth\Github;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\{RedirectResponse};
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::query()
            ->updateOrCreate(
                ['github_nickname' => $githubUser->getNickname(), 'email' => $githubUser->getEmail()],
                [
                    'name'              => $githubUser->getName(),
                    'password'          => fake()->password(20, 40),
                    'email_verified_at' => now(),
                ]
            );

        Auth::login($user);

        return to_route('dashboard');
    }
}
