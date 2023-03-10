<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    use HasFactory;

    protected $table = 'user_feedback';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'user_type',
        'subject',
        'message',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
