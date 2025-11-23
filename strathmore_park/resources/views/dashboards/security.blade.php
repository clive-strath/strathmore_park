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
        margin-bottom: 1.5rem;
    }
    
    .available-spots {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0.5rem 0;
        color: #1e40af;
    }
    
    .spots-text {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .btn-add-vehicle, .btn-remove-vehicle {
        flex: 1;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-add-vehicle {
        background: #16a34a;
        border: none;
        color: white;
    }
    
    .btn-add-vehicle:hover:not(:disabled) {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(22, 163, 74, 0.3);
    }
    
    .btn-remove-vehicle {
        background: #dc2626;
        border: none;
        color: white;
    }
    
    .btn-remove-vehicle:hover:not(:disabled) {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3);
    }
    
    .btn-add-vehicle:disabled, .btn-remove-vehicle:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    #alert-container {
        margin-bottom: 1.5rem;
    }
    
    .alert {
        border-radius: 0.5rem;
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }
    
    .alert-success {
        background: #dcfce7;
        color: #166534;
    }
    
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }
</style>

<div class="container-lg">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <img src="{{ asset('images/logo.png') }}" alt="Strathmore University Logo" style="height: 50px; margin-bottom: 1rem;">
        <h1><i class="fas fa-shield-alt"></i> Security Dashboard</h1>
        <p>Welcome, <strong>{{ auth()->user()->name }}</strong>!</p>
        <div class="user-info">
            <p><i class="fas fa-id-badge"></i> <strong>Badge Number:</strong> {{ auth()->user()->security_badge_number }}</p>
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alert-container"></div>

    <!-- Parking Lots Management Section -->
    <div class="mt-4">
        <h2 class="section-title">
            <i class="fas fa-parking"></i> Manage Parking Lots
        </h2>

        <div class="row" id="parking-lots">
            @foreach($parkingLots as $lot)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="parking-lot-card" data-lot-id="{{ $lot->id }}">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Parking Lot {{ $lot->name }}</h5>
                        <div class="parking-info">
                            <div class="available-spots">
                                <span class="spots-number">{{ $lot->available_spots }}</span> / {{ $lot->total_spots }}
                            </div>
                            <p class="spots-text">available spots</p>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-add-vehicle"
                                    data-lot-id="{{ $lot->id }}"
                                    {{ $lot->available_spots <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-plus-circle"></i> Entry
                            </button>
                            <button class="btn btn-remove-vehicle"
                                    data-lot-id="{{ $lot->id }}"
                                    {{ $lot->available_spots >= $lot->total_spots ? 'disabled' : '' }}>
                                <i class="fas fa-minus-circle"></i> Exit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Show alert message
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertContainer.innerHTML = alertHTML;
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

// Attach event listeners to buttons
function attachEventListeners() {
    // Add Vehicle Entry listeners
    document.querySelectorAll('.btn-add-vehicle').forEach(button => {
        button.removeEventListener('click', handleAddVehicle);
        button.addEventListener('click', handleAddVehicle);
    });

    // Remove Vehicle Exit listeners
    document.querySelectorAll('.btn-remove-vehicle').forEach(button => {
        button.removeEventListener('click', handleRemoveVehicle);
        button.addEventListener('click', handleRemoveVehicle);
    });
}

function handleAddVehicle(e) {
    e.preventDefault();
    const lotId = this.dataset.lotId;
    const button = this;

    button.disabled = true;

    fetch(`/security/parking-lot/${lotId}/add-vehicle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json().then(data => ({
            status: response.status,
            data: data
        }));
    })
    .then(({ status, data }) => {
        console.log('Response data:', data);
        if (status === 200 && data.success) {
            updateLotUI(lotId, data.available_spots);
            showAlert(data.message, 'success');
        } else {
            showAlert(data.message || 'Failed to add vehicle', 'error');
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Failed to add vehicle. Please check your connection and try again.', 'error');
        button.disabled = false;
    });
}

function handleRemoveVehicle(e) {
    e.preventDefault();
    const lotId = this.dataset.lotId;
    const button = this;

    button.disabled = true;

    fetch(`/security/parking-lot/${lotId}/remove-vehicle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json().then(data => ({
            status: response.status,
            data: data
        }));
    })
    .then(({ status, data }) => {
        console.log('Response data:', data);
        if (status === 200 && data.success) {
            updateLotUI(lotId, data.available_spots);
            showAlert(data.message, 'success');
        } else {
            showAlert(data.message || 'Failed to remove vehicle', 'error');
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Failed to remove vehicle. Please check your connection and try again.', 'error');
        button.disabled = false;
    });
}

function updateLotUI(lotId, availableSpots) {
    const card = document.querySelector(`[data-lot-id="${lotId}"]`);
    if (card) {
        const spotsNumber = card.querySelector('.spots-number');
        const addBtn = card.querySelector('.btn-add-vehicle');
        const removeBtn = card.querySelector('.btn-remove-vehicle');
        const totalSpotsText = card.querySelector('.available-spots').textContent;
        const totalSpots = parseInt(totalSpotsText.split('/')[1].trim());

        // Update spots display
        spotsNumber.textContent = availableSpots;

        // Update button states
        addBtn.disabled = availableSpots <= 0;
        removeBtn.disabled = availableSpots >= totalSpots;

        // Re-attach listeners after update
        attachEventListeners();
    }
}

// Initial attachment of event listeners
document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners();
});

// Listen for real-time updates via WebSocket
if (typeof window.Echo !== 'undefined') {
    window.Echo.channel('parking-updates')
        .listen('ParkingSpotUpdated', (e) => {
            console.log('Parking update received:', e);
            updateLotUI(e.id, e.available_spots);
        });
} else {
    console.warn('WebSocket (Echo) not available - real-time updates disabled');
}
</script>
@endsection
