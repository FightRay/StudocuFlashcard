<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelCreateOrUpdate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;
    use ModelCreateOrUpdate;

    protected $fillable = [
        'user_id',
        'card_id',
        'answer',
        'correct'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card() : BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
