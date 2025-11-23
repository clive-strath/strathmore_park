<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ParkingLot;
use Illuminate\Broadcasting\Channel;

class ParkingSpotUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $parkingLot;

    public function __construct(ParkingLot $parkingLot)
    {
        $this->parkingLot = $parkingLot;
    }

    public function broadcastOn()
    {
        return new Channel('parking-updates');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->parkingLot->id,
            'name' => $this->parkingLot->name,
            'total_spots' => $this->parkingLot->total_spots,
            'available_spots' => $this->parkingLot->available_spots,
            'is_active' => $this->parkingLot->is_active,
        ];
    }
}
