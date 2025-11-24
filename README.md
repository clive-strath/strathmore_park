# Strathmore Parking System Documentation

## Overview

The Strathmore Parking System is a comprehensive web-based parking management solution built with Laravel. It provides real-time parking lot monitoring, user role-based access control, and automated parking activity tracking for educational institutions.

## Features

### Core Functionality
- **Real-time Parking Monitoring**: Live updates of parking lot availability
- **Role-Based Access Control**: Three distinct user roles (Admin, Security, Student)
- **Activity Tracking**: Complete audit trail of all parking activities
- **WebSocket Integration**: Real-time updates using Pusher
- **Responsive Design**: Mobile-friendly interface

### User Roles
- **Admin**: Full system management, user administration, parking lot configuration
- **Security**: Vehicle entry/exit management, parking lot monitoring
- **Student**: View parking availability, personal parking history

## System Architecture

### Technology Stack
- **Backend**: Laravel 11.x
- **Database**: MariaDB/MySQL
- **Frontend**: Blade Templates with Vue.js components
- **Real-time Communication**: Pusher WebSockets
- **Authentication**: Laravel's built-in authentication system

### Project Structure
```
parking-system/
├── app/
│   ├── Http/Controllers/          # Application controllers
│   ├── Models/                    # Eloquent models
│   ├── Events/                    # Event handling
│   └── Providers/                 # Service providers
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Sample data
├── resources/views/               # Blade templates
├── routes/                        # Route definitions
└── storage/                       # Logs and uploads
```

## Database Schema

### Users Table
```sql
- id (Primary Key)
- name (String)
- email (String, Unique)
- password (Hashed)
- role (Enum: admin, security, student)
- car_number_plate (String, Optional)
- security_badge_number (String, Optional)
- timestamps
```

### Parking Lots Table
```sql
- id (Primary Key)
- name (String)
- total_spots (Integer)
- available_spots (Integer)
- is_active (Boolean)
- timestamps
```

### Parking Activities Table
```sql
- id (Primary Key)
- parking_lot_id (Foreign Key)
- user_id (Foreign Key)
- action (Enum: entry, exit)
- spots_before (Integer)
- spots_after (Integer)
- timestamps
```

## API Endpoints

### Authentication Routes
- `GET /` - Welcome/Landing page
- `POST /login` - User login
- `POST /logout` - User logout
- `POST /register` - User registration

### Dashboard Routes
- `GET /dashboard` - Main dashboard (role-based)

### Security Routes (Protected)
- `POST /security/parking-lot/{parkingLot}/add-vehicle` - Record vehicle entry
- `POST /security/parking-lot/{parkingLot}/remove-vehicle` - Record vehicle exit

### Admin Routes (Protected)
- `PUT /admin/parking-lot/{parkingLot}` - Update parking lot details
- `POST /admin/parking-lot/{parkingLot}/toggle` - Toggle parking lot status
- `PUT /admin/users/{user}` - Update user information
- `DELETE /admin/users/{user}` - Delete user
- `POST /admin/register` - Admin user registration

## Models and Relationships

### User Model
- **Relationships**: Has many ParkingActivities
- **Methods**: `isAdmin()`, `isSecurity()`, `isStudent()`
- **Fillable**: name, email, password, role, car_number_plate, security_badge_number

### ParkingLot Model
- **Relationships**: Has many ParkingActivities
- **Methods**: `hasAvailableSpots()`, `isFull()`, `isEmpty()`, `getOccupancyPercentage()`
- **Fillable**: name, total_spots, available_spots, is_active

### ParkingActivity Model
- **Relationships**: BelongsTo User, BelongsTo ParkingLot
- **Fillable**: user_id, parking_lot_id, action, spots_before, spots_after

## Installation Guide

### Prerequisites
- PHP 8.2+
- Composer
- MariaDB/MySQL
- Node.js & NPM
- Pusher account (for real-time features)

### Setup Steps

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd parking-system
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Configure Pusher**
   - Update `.env` file with Pusher credentials
   - Configure broadcast driver

6. **Build Assets**
   ```bash
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

## Configuration

### Environment Variables
```env
APP_NAME="Strathmore Parking"
APP_ENV=local
APP_KEY=base64:your-app-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=strathmore_p
DB_USERNAME=root
DB_PASSWORD=your-password

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
```

## User Guide

### Admin Dashboard
- **Parking Lot Management**: Create, update, and deactivate parking lots
- **User Management**: Add, edit, and remove users
- **System Monitoring**: View overall system statistics

### Security Dashboard
- **Vehicle Entry**: Record vehicles entering parking lots
- **Vehicle Exit**: Record vehicles leaving parking lots
- **Real-time Monitoring**: Live parking lot status updates

### Student Dashboard
- **Parking Availability**: View current parking lot status
- **Personal History**: Track personal parking activities
- **Spot Reservation**: (Future feature)

## Security Features

### Authentication
- Laravel's built-in authentication system
- Role-based middleware protection
- Session management

### Authorization
- `CheckRole` middleware for route protection
- Model-level authorization methods
- CSRF protection on all forms

### Data Validation
- Request validation on all inputs
- SQL injection prevention through Eloquent ORM
- XSS protection with Blade templating

## Real-time Features

### WebSocket Integration
- Pusher integration for live updates
- `ParkingSpotUpdated` event broadcasting
- Real-time dashboard updates

### Event System
- Custom events for parking activities
- Event listeners for system notifications
- Queue-based event processing

## Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter UserTest

# Generate coverage report
php artisan test --coverage
```

### Test Coverage
- Model relationships and methods
- Controller endpoints
- Authentication and authorization
- Business logic validation

## Deployment

### Production Setup
1. **Environment Configuration**
   - Set `APP_ENV=production`
   - Configure production database
   - Set up SSL certificates

2. **Optimization**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

3. **Queue Setup**
   ```bash
   php artisan queue:work
   ```

### Monitoring
- Log monitoring in `storage/logs`
- Performance monitoring with Laravel Telescope
- Error tracking with external services

## Troubleshooting

### Common Issues

1. **500 Server Error**
   - Check `.env` file configuration
   - Verify database connection
   - Check file permissions

2. **Real-time Updates Not Working**
   - Verify Pusher configuration
   - Check WebSocket connection
   - Ensure JavaScript is enabled

3. **Authentication Issues**
   - Clear session cache: `php artisan session:clear`
   - Regenerate application key: `php artisan key:generate`
   - Check middleware configuration

### Debug Mode
Enable debug mode in `.env`:
```env
APP_DEBUG=true
```

## Contributing

### Code Standards
- Follow PSR-12 coding standards
- Use Laravel conventions
- Write comprehensive tests
- Document all public methods

### Git Workflow
1. Create feature branch
2. Make changes with tests
3. Submit pull request
4. Code review and merge

## License

This project is licensed under the MIT License. See LICENSE file for details.

## Support

For technical support:
- Check the troubleshooting section
- Review Laravel documentation
- Contact the development team

## Future Enhancements

### Planned Features
- Mobile application
- Payment integration
- Advanced analytics dashboard
- Vehicle recognition system
- Automated spot allocation

### Technical Improvements
- API versioning
- Caching optimization
- Database optimization
- Enhanced security features
