<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'trainer_level',
        'is_available',
        'is_active',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'trainer_service');
    }

    /**
     * Get available schedule slots for this trainer on a given date.
     */
    public function availableSlotsOn(string $date)
    {
        return $this->schedules()
            ->where('date', $date)
            ->where('is_full', false)
            ->where('is_active', true)
            ->get();
    }
}
