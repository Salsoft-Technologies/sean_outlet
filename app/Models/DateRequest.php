<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateRequest extends Model
{
    use HasFactory;

    protected $table = "date_requests";
    protected $primaryKey = "id";

    public const ACCEPTED = 'accepted';
    public const REJECTED = 'rejected';
    public const PENDING = 'pending';

    protected $fillable = [
        'male_id',
        'female_id',
        'slot_id',
        'status',
    ];

    public function male_info(){
        return $this->belongsTo(User::class, 'male_id');
    }

    public function slot_info(){
        return $this->belongsTo(TimeSlot::class, 'slot_id');
    }
}
