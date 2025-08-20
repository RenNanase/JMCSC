<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'receipt_number',
        'purchase_date'
    ];

    protected $casts = [
        'purchase_date' => 'date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
