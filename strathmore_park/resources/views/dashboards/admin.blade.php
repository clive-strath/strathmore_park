@extends('layouts.app')

@section('content')
<style>
    .admin-container {
        display: flex;
        gap: 0;
        min-height: calc(100vh - 100px);
    }
    
    .admin-sidebar {
        width: 280px;
        background: #f8fafc;
        border-right: 1px solid #e2e8f0;
        padding: 2rem 0;
        position: sticky;
        top: 100px;
        height: calc(100vh - 100px);
        overflow-y: auto;
    }
    
    .sidebar-brand {
        padding: 0 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .sidebar-brand img {
        height: 35px;
    }
    
    .sidebar-brand h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    
    .sidebar-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .sidebar-nav li {
        margin: 0;
    }
    
    .sidebar-nav a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    
    .sidebar-nav a:hover {
        background: #e0e7ff;
        color: #1e40af;
        border-left-color: #1e40af;
    }
    
    .sidebar-nav a.active {
        background: #e0e7ff;
        color: #1e40af;
        border-left-color: #1e40af;
        font-weight: 600;
    }
    
    .sidebar-nav i {
        width: 20px;
        text-align: center;
    }
    
    .sidebar-user {
        position: absolute;
        bottom: 2rem;
        left: 0;
        right: 0;
        padding: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }
    
    .user-name {
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        font-size: 0.875rem;
    }
    
    .user-role {
        color: #64748b;
        margin: 0;
        font-size: 0.75rem;
    }
    
    .admin-content {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
    }
    
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        font-weight: 600;
        border-radius: 0.5rem;
        font-size: 0.875rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
    
    .btn-save {
        background: #1e40af;
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        background: #1e3a8a;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 64, 175, 0.3);
    }
    
    .btn-toggle-lot {
        background: #f59e0b;
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-toggle-lot:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
    }
    
    .btn-group-custom {
        display: flex;
        gap: 0.75rem;
    }
    
    .info-section {
        background: #f0f9ff;
        border-left: 4px solid #1e40af;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 1rem;
    }
    
    .info-section p {
        margin: 0.25rem 0;
        color: #0c4a6e;
    }
    
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.5em;
        border: 1px solid #cbd5e1;
    }
    
    .form-switch .form-check-input:checked {
        background-color: #16a34a;
        border-color: #16a34a;
    }
    
    .users-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .users-table thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .users-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #1e293b;
        font-size: 0.875rem;
    }
    
    .users-table td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .users-table tbody tr:hover {
        background: #f8fafc;
    }
    
    .user-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .user-badge.student {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .user-badge.security {
        background: #fef3c7;
        color: #b45309;
    }
    
    .user-badge.admin {
        background: #fecaca;
        color: #991b1b;
    }
    
    .btn-edit, .btn-delete {
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 0.5rem;
    }
    
    .btn-edit {
        background: #3b82f6;
        color: white;
    }
    
    .btn-edit:hover {
        background: #2563eb;
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background: #dc2626;
    }
    
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    
    .modal-backdrop.show {
        display: block;
    }
    
    .modal-dialog {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        min-width: 400px;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1e293b;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }
    
    .btn-modal-cancel {
        background: #e2e8f0;
        color: #1e293b;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
    }
    
    .btn-modal-save {
        background: #1e40af;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
    }
    
    .content-section {
        display: none;
    }
    
    .content-section.active {
        display: block;
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
</style>

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h3>Parking</h3>
        </div>
        
        <ul class="sidebar-nav">
            <li><a href="#" data-section="dashboard" class="nav-link active"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="#" data-section="parking-lots" class="nav-link"><i class="fas fa-parking"></i> Parking Lots</a></li>
            <li><a href="#" data-section="users" class="nav-link"><i class="fas fa-users"></i> Users</a></li>
        </ul>
        
        <div class="sidebar-user">
            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <p class="user-name">{{ auth()->user()->name }}</p>
            <p class="user-role">Administrator</p>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-content">
        <!-- Dashboard Section -->
        <div id="dashboard" class="content-section active">
            <div class="dashboard-header">
                <h1><i class="fas fa-cog"></i> Admin Dashboard</h1>
                <p>Welcome back, <strong>{{ auth()->user()->name }}</strong>!</p>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="parking-lot-card">
                        <div class="card-body text-center">
                            <i class="fas fa-parking" style="font-size: 2rem; color: #1e40af; margin-bottom: 1rem;"></i>
                            <h5 style="color: #1e293b; font-weight: 700;">{{ $allLots->count() }}</h5>
                            <p style="color: #64748b; margin: 0;">Total Parking Lots</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="parking-lot-card">
                        <div class="card-body text-center">
                            <i class="fas fa-users" style="font-size: 2rem; color: #0f766e; margin-bottom: 1rem;"></i>
                            <h5 style="color: #1e293b; font-weight: 700;">{{ $allUsers->count() ?? 0 }}</h5>
                            <p style="color: #64748b; margin: 0;">Total Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="parking-lot-card">
                        <div class="card-body text-center">
                            <i class="fas fa-graduation-cap" style="font-size: 2rem; color: #16a34a; margin-bottom: 1rem;"></i>
                            <h5 style="color: #1e293b; font-weight: 700;">{{ $allUsers->where('role', 'student')->count() ?? 0 }}</h5>
                            <p style="color: #64748b; margin: 0;">Students</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="parking-lot-card">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt" style="font-size: 2rem; color: #f59e0b; margin-bottom: 1rem;"></i>
                            <h5 style="color: #1e293b; font-weight: 700;">{{ $allUsers->where('role', 'security')->count() ?? 0 }}</h5>
                            <p style="color: #64748b; margin: 0;">Security</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Parking Lots Section -->
        <div id="parking-lots" class="content-section">
            <h2 class="section-title">
                <i class="fas fa-parking"></i> Manage All Parking Lots
            </h2>

            <div class="row">
                @foreach($allLots as $lot)
                <div class="col-lg-6 mb-4">
                    <div class="parking-lot-card" data-lot-id="{{ $lot->id }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                <span><i class="fas fa-map-marker-alt"></i> Parking Lot {{ $lot->name }}</span>
                                <span class="status-badge badge {{ $lot->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $lot->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </h5>
                        
                            <form class="update-lot-form" data-lot-id="{{ $lot->id }}">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-hashtag"></i> Total Spots</label>
                                    <input type="number" class="form-control total-spots-input"
                                           name="total_spots" value="{{ $lot->total_spots }}" min="0" required>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="active-{{ $lot->id }}"
                                           name="is_active" {{ $lot->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active-{{ $lot->id }}">
                                        <i class="fas fa-check-circle"></i> Lot is Active
                                    </label>
                                </div>
                                <div class="btn-group-custom">
                                    <button type="submit" class="btn btn-save">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                    <button type="button" class="btn btn-toggle-lot"
                                            data-lot-id="{{ $lot->id }}">
                                        <i class="fas fa-power-off"></i> Toggle
                                    </button>
                                </div>
                            </form>

                            <div class="info-section">
                                <p><i class="fas fa-info-circle"></i> <strong>Current Available:</strong></p>
                                <p style="font-size: 1.5rem; font-weight: 700; color: #1e40af;">
                                    <span class="available-spots">{{ $lot->available_spots }}</span> / {{ $lot->total_spots }} spots
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Users Section -->
        <div id="users" class="content-section">
            <h2 class="section-title">
                <i class="fas fa-users"></i> Manage Users
            </h2>
            
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allUsers ?? [] as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div class="user-avatar" style="width: 35px; height: 35px; font-size: 0.875rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="user-badge {{ strtolower($user->role) }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->role === 'student')
                                <small>{{ $user->car_number_plate ?? 'N/A' }}</small>
                            @elseif($user->role === 'security')
                                <small>Badge: {{ $user->security_badge_number ?? 'N/A' }}</small>
                            @else
                                <small>Admin</small>
                            @endif
                        </td>
                        <td>
                            <button class="btn-edit" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-delete" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: #64748b;">
                            No users found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal-backdrop">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5>Edit User</h5>
            <button class="modal-close" onclick="closeModal('editUserModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editUserForm">
                <input type="hidden" id="userId">
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" id="userName" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="userEmail" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select class="form-control" id="userRole" required>
                        <option value="student">Student</option>
                        <option value="security">Security</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-cancel" onclick="closeModal('editUserModal')">Cancel</button>
            <button class="btn-modal-save" onclick="saveUser()">Save Changes</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteUserModal" class="modal-backdrop">
    <div class="modal-dialog" style="min-width: 350px;">
        <div class="modal-header">
            <h5>Delete User</h5>
            <button class="modal-close" onclick="closeModal('deleteUserModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <strong id="deleteUserName"></strong>? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-cancel" onclick="closeModal('deleteUserModal')">Cancel</button>
            <button class="btn-delete" onclick="confirmDelete()" style="padding: 0.5rem 1rem;">Delete User</button>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let userToDelete = null;

// Sidebar Navigation
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all links
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        // Add active class to clicked link
        this.classList.add('active');
        
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Show selected section
        const sectionId = this.dataset.section;
        const section = document.getElementById(sectionId);
        if (section) {
            section.classList.add('active');
        }
    });
});

// Modal Functions
function openModal(modalId) {
    document.getElementById(modalId).classList.add('show');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

// User Management Functions
function editUser(userId, userName, userEmail, userRole) {
    document.getElementById('userId').value = userId;
    document.getElementById('userName').value = userName;
    document.getElementById('userEmail').value = userEmail;
    document.getElementById('userRole').value = userRole;
    openModal('editUserModal');
}

function saveUser() {
    const userId = document.getElementById('userId').value;
    const userName = document.getElementById('userName').value;
    const userEmail = document.getElementById('userEmail').value;
    const userRole = document.getElementById('userRole').value;
    
    fetch(`/admin/users/${userId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            name: userName,
            email: userEmail,
            role: userRole
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User updated successfully!');
            closeModal('editUserModal');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to update user'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the user');
    });
}

function deleteUser(userId, userName) {
    userToDelete = userId;
    document.getElementById('deleteUserName').textContent = userName;
    openModal('deleteUserModal');
}

function confirmDelete() {
    if (!userToDelete) return;
    
    fetch(`/admin/users/${userToDelete}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User deleted successfully!');
            closeModal('deleteUserModal');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to delete user'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the user');
    });
}

// Close modal when clicking outside
document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
    backdrop.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
        }
    });
});

document.querySelectorAll('.update-lot-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const lotId = this.dataset.lotId;
        const totalSpots = this.querySelector('[name="total_spots"]').value;
        const isActive = this.querySelector('[name="is_active"]').checked;

        fetch(`/admin/parking-lot/${lotId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                total_spots: parseInt(totalSpots),
                is_active: isActive
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                updateAdminLotUI(data.lot);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

document.querySelectorAll('.btn-toggle-lot').forEach(button => {
    button.addEventListener('click', function() {
        const lotId = this.dataset.lotId;

        fetch(`/admin/parking-lot/${lotId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const card = document.querySelector(`[data-lot-id="${lotId}"]`);
                const statusBadge = card.querySelector('.status-badge');
                const checkbox = card.querySelector('[name="is_active"]');

                statusBadge.className = `status-badge badge ${data.is_active ? 'bg-success' : 'bg-secondary'}`;
                statusBadge.textContent = data.is_active ? 'Active' : 'Inactive';
                checkbox.checked = data.is_active;

                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

function updateAdminLotUI(lot) {
    const card = document.querySelector(`[data-lot-id="${lot.id}"]`);
    if (card) {
        card.querySelector('.available-spots').textContent = lot.available_spots;
        card.querySelector('.total-spots-input').value = lot.total_spots;
        card.querySelector('[name="is_active"]').checked = lot.is_active;

        const statusBadge = card.querySelector('.status-badge');
        statusBadge.className = `status-badge badge ${lot.is_active ? 'bg-success' : 'bg-secondary'}`;
        statusBadge.textContent = lot.is_active ? 'Active' : 'Inactive';
    }
}

window.Echo.channel('parking-updates')
    .listen('ParkingSpotUpdated', (e) => {
        console.log('Parking update received:', e);
        const card = document.querySelector(`[data-lot-id="${e.id}"]`);
        if (card) {
            card.querySelector('.available-spots').textContent = e.available_spots;
        }
    });
</script>
@endsection
