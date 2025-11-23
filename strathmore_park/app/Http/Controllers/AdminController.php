<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingLot;
use App\Models\User;
use App\Events\ParkingSpotUpdated;

use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('dashboards.admin');
    }
    
    // User Management Methods
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:student,security,admin',
        ]);
        
        $user->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }
    
    public function deleteUser(Request $request, User $user)
    {
        // Prevent deleting the current admin
        if ($user->id === $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account'
            ], 403);
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
    public function updateLot(Request $request, ParkingLot $parkingLot)
{
$validated = $request->validate([
    'total_spots' => 'required|integer|min:0',
    'is_active' => 'required|boolean',
]);
$parkingLot->update([
    'total_spots' => $validated['total_spots'],
    'available_spots' => $validated['total_spots'],
    'is_active' => $validated['is_active'],
]);
broadcast(new ParkingSpotUpdated($parkingLot, $request->user()))->toOthers();
return response()->json([
    'success' => true,
    'message' => 'Parking lot updated successfully',
    'lot' => $parkingLot
]);
}
public function toggleLot(ParkingLot $parkingLot)
{
$parkingLot->update([
'is_active' => !$parkingLot->is_active
]);
broadcast(new ParkingSpotUpdated($parkingLot, request()->user()))->toOthers();
return response()->json([
'success' => true,
'is_active' => $parkingLot->is_active,
'message' => $parkingLot->is_active ? 'Lot activated' : 'Lot deactivated'
]);
}
}
