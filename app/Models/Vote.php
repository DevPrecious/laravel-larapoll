<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['poll_id', 'option_id', 'user_id', 'staked'];


    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
