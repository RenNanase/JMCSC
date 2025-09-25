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
        'scrn',
        'registered_by',
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

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Generate SCRN after the member is created (when ID is available)
        static::created(function ($member) {
            $member->generateScrn();
        });
    }

    /**
     * Generate SCRN based on sequential count of members
     * Format: SC + 5-digit zero-padded number
     * Example: SC00001, SC00002, SC00003 (sequential regardless of ID)
     */
    public function generateScrn()
    {
        if (!$this->scrn && $this->id) {
            // Get the next sequential SCRN number based on existing member count
            $nextNumber = self::whereNotNull('scrn')->count() + 1;
            
            // Check if number exceeds maximum allowed (99999)
            if ($nextNumber > 99999) {
                throw new \Exception('SCRN count exceeds maximum allowed limit of 99,999');
            }

            $scrn = 'SC' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            
            // Ensure uniqueness by checking if SCRN already exists
            while (self::where('scrn', $scrn)->where('id', '!=', $this->id)->exists()) {
                $nextNumber++;
                if ($nextNumber > 99999) {
                    throw new \Exception('Unable to generate unique SCRN: limit exceeded');
                }
                $scrn = 'SC' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
            
            // Update without triggering model events to prevent infinite loop
            $this->updateQuietly(['scrn' => $scrn]);
        }

        return $this->scrn;
    }


    /**
     * Static method to generate SCRN for existing members
     */
    public static function generateScrnForExistingMembers()
    {
        $members = self::whereNull('scrn')->get();
        $updated = 0;

        foreach ($members as $member) {
            try {
                $member->generateScrn();
                $updated++;
            } catch (\Exception $e) {
                \Log::error('Failed to generate SCRN for member ID ' . $member->id . ': ' . $e->getMessage());
            }
        }

        return $updated;
    }

    /**
     * Get the user who registered this member
     */
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
