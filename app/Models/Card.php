<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelCreateOrUpdate;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory;
    use ModelCreateOrUpdate;

    protected $fillable = [
        'question',
        'answer'
    ];

    public function answers() : HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
