<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingLot;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $parkingLots = ParkingLot::where('is_active', true)->get();

        if ($user->isStudent()) {
            return view('dashboards.student', compact('parkingLots'));
        } elseif ($user->isSecurity()) {
            return view('dashboards.security', compact('parkingLots'));
        } elseif ($user->isAdmin()) {
            $allLots = ParkingLot::all();
            $allUsers = User::all();
            return view('dashboards.admin', compact('allLots', 'allUsers'));
        }

        abort(403, 'Unauthorized access');
    }
}
