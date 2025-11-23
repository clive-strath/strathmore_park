<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ParkingSpotUpdated;
use App\Models\ParkingLot;
use App\Models\ParkingActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'security']);
    }

    public function index()
    {
        $parkingLots = ParkingLot::all();
        return view('dashboards.security', ['parkingLots' => $parkingLots]);
    }

    public function addVehicle(ParkingLot $parkingLot)
    {
        $user = Auth::user();
        Log::info('addVehicle called', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'lot_id' => $parkingLot->id,
            'available_spots' => $parkingLot->available_spots
        ]);

        if ($parkingLot->available_spots <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No available spots'
            ], 400);
        }

        $spotsBefore = $parkingLot->available_spots;
        $parkingLot->decrement('available_spots');
        $parkingLot->refresh();

        ParkingActivity::create([
            'parking_lot_id' => $parkingLot->id,
            'user_id'        => $user->id,
            'action'         => 'entry',
            'spots_before'   => $spotsBefore,
            'spots_after'    => $parkingLot->available_spots,
        ]);

        // Broadcast parking lot update
        broadcast(new ParkingSpotUpdated($parkingLot));

        return response()->json([
            'success'        => true,
            'available_spots'=> $parkingLot->available_spots,
            'message'        => 'Vehicle added successfully'
        ]);
    }

    public function removeVehicle(ParkingLot $parkingLot)
    {
        $user = Auth::user();
        Log::info('removeVehicle called', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'lot_id' => $parkingLot->id,
            'available_spots' => $parkingLot->available_spots,
            'total_spots' => $parkingLot->total_spots
        ]);

        if ($parkingLot->available_spots >= $parkingLot->total_spots) {
            return response()->json([
                'success' => false,
                'message' => 'No vehicles to remove'
            ], 400);
        }

        $spotsBefore = $parkingLot->available_spots;
        $parkingLot->increment('available_spots');
        $parkingLot->refresh();

        ParkingActivity::create([
            'parking_lot_id' => $parkingLot->id,
            'user_id'        => $user->id,
            'action'         => 'exit',
            'spots_before'   => $spotsBefore,
            'spots_after'    => $parkingLot->available_spots,
        ]);

        broadcast(new ParkingSpotUpdated($parkingLot));

        return response()->json([
            'success'        => true,
            'available_spots'=> $parkingLot->available_spots,
            'message'        => 'Vehicle removed successfully'
        ]);
    }
}
