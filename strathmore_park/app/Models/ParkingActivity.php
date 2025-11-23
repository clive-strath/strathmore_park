<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingActivity extends Model
{
    protected $fillable = [
        'user_id',
        'parking_lot_id',
        'action',
        'spots_before',
        'spots_after',
        'entry_time',
        'exit_time',
        'status'
    ];

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
