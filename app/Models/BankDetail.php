<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;

class BankDetail extends Model
{
    use HasFactory;

    protected $table = "bank_details";
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'bank_id',
        'account_number',
        'account_holder_name',
    ];

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
