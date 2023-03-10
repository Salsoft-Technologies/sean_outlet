<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{
    use HasFactory;

    protected $table = "report_user";
    protected $primaryKey = "id";

    protected $fillable = [
        'female_id',
        'male_id',
        'reason',
    ];

    public function female_info(){
        return $this->belongsTo(User::class, 'female_id');
    }

    public function male_info(){
        return $this->belongsTo(User::class, 'male_id');
    }
}
