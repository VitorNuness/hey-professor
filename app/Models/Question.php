<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Builder, Model, Prunable, SoftDeletes};

class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    /** @var array<string> $cast */
    protected $cast = [
        'is_draft' => 'bool',
    ];

    /**
     * @return HasMany<Vote>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * @return BelongsTo<User,Question>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }
}
