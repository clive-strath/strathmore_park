@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #1e40af 0%, #0f766e 100%);
        color: white;
        padding: 2rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
    }
    
    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .dashboard-header p {
        margin: 0.25rem 0;
        opacity: 0.95;
    }
    
    .user-info {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: #1e40af;
    }
    
    .parking-lot-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .parking-lot-card:hover {
        border-color: #1e40af;
        box-shadow: 0 10px 25px rgba(30, 64, 175, 0.1);
        transform: translateY(-5px);
    }
    
    .parking-lot-card .card-body {
        padding: 1.5rem;
    }
    
    .parking-lot-card .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    
    .parking-info {
        text-align: center;
    }
    
    .available-spots {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }
    
    .available-spots.available {
        color: #16a34a;
    }
    
    .available-spots.full {
        color: #dc2626;
    }
    
    .spots-text {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        font-weight: 600;
        border-radius: 0.5rem;
    }
</style>

<div class="container-lg">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <img src="{{ asset('images/logo.png') }}" alt="Strathmore University Logo" style="height: 50px; margin-bottom: 1rem;">
        <h1><i class="fas fa-graduation-cap"></i> Student Dashboard</h1>
        <p>Welcome back, <strong>{{ auth()->user()->name }}</strong>!</p>
        <div class="user-info">
            <p><i class="fas fa-car"></i> <strong>Your Vehicle:</strong> {{ auth()->user()->car_number_plate }}</p>
        </div>
    </div>

    <!-- Parking Lots Section -->
    <div class="mt-4">
        <h2 class="section-title">
            <i class="fas fa-parking"></i> Available Parking Lots
        </h2>

        <div class="row" id="parking-lots">
            @foreach($parkingLots as $lot)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="parking-lot-card" data-lot-id="{{ $lot->id }}">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Parking Lot {{ $lot->name }}</h5>
                        <div class="parking-info">
                            <div class="available-spots {{ $lot->available_spots > 0 ? 'available' : 'full' }}">
                                <span class="spots-number">{{ $lot->available_spots }}</span>
                            </div>
                            <p class="spots-text">out of {{ $lot->total_spots }} spots available</p>
                            @if($lot->available_spots > 0)
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Available</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Full</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
window.Echo.channel('parking-updates')
    .listen('ParkingSpotUpdated', (e) => {
        console.log('Parking update received:', e);

        const card = document.querySelector(`[data-lot-id="${e.id}"]`);
        if (card) {
            const spotsNumber = card.querySelector('.spots-number');
            const availableSpots = card.querySelector('.available-spots');
            const badge = card.querySelector('.badge');

            spotsNumber.textContent = e.available_spots;
            availableSpots.style.color = e.available_spots > 0 ? 'green' : 'red';

            if (e.available_spots > 0) {
                badge.className = 'badge bg-success';
                badge.textContent = 'Available';
            } else {
                badge.className = 'badge bg-danger';
                badge.textContent = 'Full';
            }
        }
    });
</script>
@endsection
