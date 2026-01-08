# Candidate Management System

A comprehensive Laravel application for managing job candidate applications with Excel import functionality and role-based access control.

## Features

-   **Excel File Processing**: Import candidate data from Excel files
-   **Role-Based Access Control**: Admin and Staff roles
-   **Candidate Management**: Full CRUD operations for candidates
-   **Interview Scheduling**: Schedule and manage interviews
-   **Status Tracking**: Track candidate status (pending, hired, rejected, etc.)
-   **User Management**: Admin can create, update, and manage staff accounts
-   **Account Activation/Deactivation**: Admin can activate or deactivate staff accounts
-   **Public Candidate Search**: Candidates can search for their application status using phone number

## Technologies Used

-   Laravel 11.x
-   PHP 8.2+
-   MySQL
-   Tailwind CSS
-   JavaScript
-   Excel Processing with PhpSpreadsheet

## Installation

1. Clone the repository:

    ```bash
    git clone <repository-url>
    cd igl_task
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Install Node.js dependencies (if needed):

    ```bash
    npm install
    npm run build
    ```

4. Copy the environment file and configure your settings:

    ```bash
    cp .env.example .env
    ```

5. Generate application key:

    ```bash
    php artisan key:generate
    ```

6. Configure your database settings in `.env` file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. Run migrations to create database tables:

    ```bash
    php artisan migrate
    ```

8. Seed the database with default users (optional):

    ```bash
    php artisan db:seed
    ```

9. Start the development server:
    ```bash
    php artisan serve
    ```

## Default Accounts

The system comes with two default users:

-   **Admin**: admin@example.com / password
-   **Staff**: staff@example.com / password

## Excel File Format

The Excel file should have the following columns in order:

1. SL (Serial Number)
2. Image
3. Profile Info (Name, Age, Phone, Email)
4. Career Summary (Company : Position)
5. Experience & Status

### Profile Info Format

```
Name: John Doe
Age: 28
Phone: +1234567890
Email: john.doe@example.com
```

### Career Summary Format

```
Company Name : Position Title
```

## User Roles

### Admin

-   Full access to all features
-   Manage candidates
-   Schedule interviews
-   Import candidates from Excel
-   Manage staff accounts (create, update, activate/deactivate)
-   View all reports

### Staff

-   View and manage candidates
-   Schedule interviews
-   Import candidates from Excel
-   Update candidate statuses

### Public Access

-   Search for candidate application status using phone number

## User Management

Admin users can manage staff accounts through the User Management interface:

-   **Add Staff Members**: Create new staff accounts with name, email, and password
-   **Edit Staff Members**: Update staff account details
-   **Activate/Deactivate**: Enable or disable staff accounts without deleting them
-   **Delete Staff Members**: Remove staff accounts permanently

Inactive staff members cannot log in to the system and will receive an appropriate message.

## Candidate Management

### Adding Candidates

-   Manual entry through the web interface
-   Bulk import from Excel files

### Candidate Statuses

-   **Pending**: Application received, awaiting review
-   **Interview Scheduled**: Interview has been scheduled
-   **Interview Completed**: Interview conducted
-   **Passed**: Passed initial interview
-   **Second Interview Scheduled**: Second interview scheduled
-   **Hired**: Selected for the position
-   **Rejected**: Application declined

### Interview Scheduling

-   Schedule interviews for multiple candidates at once
-   Bulk scheduling with range selection
-   Individual candidate scheduling
-   Second interview scheduling for qualified candidates

## Public Search Feature

Candidates can search for their application status using their phone number:

-   Accessible without login
-   Shows current application status
-   Provides updates on interview schedules

## Security Features

-   Role-based access control
-   Account activation/deactivation
-   Inactive user protection (cannot log in)
-   CSRF protection
-   Input validation

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── CandidateController.php
│   │   └── UserController.php
│   ├── Middleware/
│   │   └── RoleMiddleware.php
│   └── ...
├── Models/
│   ├── Candidate.php
│   └── User.php
├── ...
database/
├── factories/
├── migrations/
└── seeders/
resources/
├── views/
│   ├── layouts/
│   ├── auth/
│   ├── candidates/
│   ├── users/
│   └── ...
routes/
└── web.php
```

## Custom Middleware

### RoleMiddleware

Protects routes based on user roles. Usage:

```php
Route::middleware('role:admin')->group(function () {
    // Admin-only routes
});
```

## Database Migrations

The application includes several migrations:

-   User table with role and status fields
-   Candidate table with all necessary fields
-   Status tracking for candidates
-   Soft deletes for users (if implemented)

## API Endpoints

### Authentication

-   `GET /login` - Show login form
-   `POST /login` - Authenticate user
-   `POST /logout` - Logout user

### Candidates

-   `GET /candidates` - List all candidates
-   `GET /candidates/create` - Show create form
-   `POST /candidates` - Store new candidate
-   `GET /candidates/{candidate}` - Show candidate
-   `GET /candidates/{candidate}/edit` - Show edit form
-   `PUT /candidates/{candidate}` - Update candidate
-   `DELETE /candidates/{candidate}` - Delete candidate

### User Management (Admin only)

-   `GET /users` - List all users
-   `GET /users/create` - Show create form
-   `POST /users` - Store new user
-   `GET /users/{user}/edit` - Show edit form
-   `PUT /users/{user}` - Update user
-   `DELETE /users/{user}` - Delete user
-   `PATCH /users/{user}/toggle-status` - Toggle user status

### Public Search

-   `GET /candidate/search` - Show search form
-   `POST /candidate/search` - Perform search

## Testing

Run the application tests:

```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

If you encounter any issues or have questions, please open an issue in the repository.
