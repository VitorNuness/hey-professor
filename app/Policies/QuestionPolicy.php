<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    public function publish(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }

    public function update(User $user, Question $question): bool
    {
        return $question->is_draft
            && $question->createdBy->is($user);
    }

    public function archive(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }

    public function destroy(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }
}
