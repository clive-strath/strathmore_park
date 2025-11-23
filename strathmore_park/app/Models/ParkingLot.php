<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model

{
    protected $fillable = [
        'name',
        'total_spots',
        'available_spots',
        'is_active'
    ];

    public function activities()
    {
        return $this->hasMany(ParkingActivity::class);
    }

    public function hasAvailableSpots(): bool
    {
        return $this->is_active && $this->available_spots > 0;
    }

    public function isFull(): bool
    {
        return $this->available_spots <= 0;
    }

    public function isEmpty(): bool
    {
        return $this->available_spots >= $this->total_spots;
    }

    public function getOccupancyPercentage(): float
    {
        if ($this->total_spots == 0) {
        return 0;
        }
    return (($this->total_spots - $this->available_spots) / $this->total_spots) * 100;
    }
}
