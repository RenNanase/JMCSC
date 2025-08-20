<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_name',
        'member_nric',
        'member_mrn',
        'member_email',
        'member_phoneNum',
        'member_gender',
        'member_address',
        'member_dob',
        'is_active',
        'is_flagged',
        'is_ecard_given',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'member_dob' => 'date',
        'is_active' => 'boolean',
        'is_ecard_given' => 'boolean',
    ];
}
