<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;

    protected $fillable = ['acc_number', 'acc_name', 'bank_code', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
