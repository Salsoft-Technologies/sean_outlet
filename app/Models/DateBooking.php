<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateBooking extends Model
{
    use HasFactory;

    protected $table = "date_bookings";
    protected $primaryKey = "id";

    public const COMPLETED = 'completed';
    public const UPCOMING = 'upcoming';

    protected $fillable = [
        'male_id',
        'card_holder_name',
        'card_number',
        'cvv',
        'expiry_date',
        'female_id', 
        'slot_id', 
        'price',
        'commission',
        'status'
    ];

    public function female_info(){
        return $this->belongsTo(User::class, 'female_id');
    }

    public function male_info(){
        return $this->belongsTo(User::class, 'male_id');
    }

    public function slot_info(){
        return $this->belongsTo(TimeSlot::class, 'slot_id');
    }
}
