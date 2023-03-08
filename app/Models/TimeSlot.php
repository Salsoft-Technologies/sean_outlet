<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $table = "time_slots";
    protected $primaryKey = "id";

    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    protected $fillable = [
        'user_id',
        'date',
        'from',
        'to',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
