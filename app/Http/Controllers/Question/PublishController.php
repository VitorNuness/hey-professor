<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\{RedirectResponse};
use Illuminate\Support\Facades\Gate;

class PublishController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        Gate::authorize('publish', $question);

        $question->update(['is_draft' => false]);

        return back();
    }
}
