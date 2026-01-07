# Candidate Management System

A comprehensive Laravel application for managing job candidate applications with Excel import functionality and role-based access control.

## Features

- **Excel File Processing**: Import candidate data from Excel files
- **Role-Based Access Control**: Admin, Staff, and Candidate roles
- **Candidate Management**: Full CRUD operations for candidates
- **Interview Scheduling**: Schedule and manage interviews
- **Status Tracking**: Track candidate status (pending, hired, rejected, etc.)

## Requirements

- PHP 8.2+
- MySQL
- Composer
- Node.js and npm

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd candidate-management-system
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Create a MySQL database and update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=candidate_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations:
```bash
php artisan migrate
```

7. Build assets:
```bash
npm run build
```

8. Start the development server:
```bash
php artisan serve
```

## Default Users

The system comes with three default users:

- **Admin**: admin@example.com / password
- **Staff**: staff@example.com / password
- **Candidate**: candidate@example.com / password

## Excel File Format

The Excel file should have the following columns in order:

| Column | Field | Description |
|--------|-------|-------------|
| A | Name | Candidate's full name |
| B | Email | Candidate's email address |
| C | Phone | Candidate's phone number |
| D | Experience Years | Number of years of experience |
| E | Institute | Previous workplace/Institute |
| F | Position | Position held at the institute |
| G | Age | Candidate's age |

Example:
```
Name,Email,Phone,Experience Years,Institute,Position,Age
John Doe,john.doe@email.com,+1234567890,5,ABC University,Software Engineer,30
```

## Usage

1. **Login**: Access the application and login with your credentials
2. **Import Candidates**: Use the "Import from Excel" feature to add candidates
3. **Manage Candidates**: View, edit, or delete candidate records
4. **Schedule Interviews**: Select candidates and schedule interviews
5. **Track Status**: Monitor candidate progress through the hiring process

## Role Permissions

- **Admin**: Full access to all features
- **Staff**: Can upload Excel files and view candidates
- **Candidate**: Can view their own status

## Folder Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── Auth/
│       │   └── LoginController.php
│       └── CandidateController.php
├── Models/
│   ├── User.php
│   └── Candidate.php
config/
├── database.php
database/
├── migrations/
│   └── create_candidates_table.php
├── seeders/
│   └── UserSeeder.php
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── auth/
│   │   └── login.blade.php
│   ├── admin/
│   │   └── dashboard.blade.php
│   ├── staff/
│   │   └── dashboard.blade.php
│   ├── candidate/
│   │   └── dashboard.blade.php
│   └── candidates/
│       ├── index.blade.php
│       ├── show.blade.php
│       ├── edit.blade.php
│       ├── import.blade.php
│       ├── upcoming.blade.php
│       ├── completed.blade.php
│       ├── hired.blade.php
│       └── rejected.blade.php
routes/
└── web.php
```

## API Endpoints

- `GET /login` - Login page
- `POST /login` - Login authentication
- `POST /logout` - Logout
- `GET /dashboard` - Dashboard redirect
- `GET /admin/dashboard` - Admin dashboard
- `GET /staff/dashboard` - Staff dashboard
- `GET /candidate/dashboard` - Candidate dashboard
- `GET /candidates` - All candidates
- `GET /candidates/create` - Create candidate form
- `POST /candidates` - Create candidate
- `GET /candidates/{id}` - View candidate
- `GET /candidates/{id}/edit` - Edit candidate form
- `PUT /candidates/{id}` - Update candidate
- `DELETE /candidates/{id}` - Delete candidate
- `GET /candidates/import/form` - Import form
- `POST /candidates/import` - Import candidates
- `GET /candidates/hired` - Hired candidates
- `GET /candidates/rejected` - Rejected candidates
- `GET /candidates/schedule/interview/form` - Schedule interview form
- `POST /candidates/schedule/interview` - Schedule interviews
- `GET /candidates/upcoming-interviews` - Upcoming interviews
- `GET /candidates/completed-interviews` - Completed interviews
- `GET /candidates/download/phones` - Download phone numbers

## Security

- Passwords are hashed using Laravel's default hashing algorithm
- CSRF protection is enabled
- Input validation is implemented for all forms
- Role-based access control prevents unauthorized access

## Technologies Used

- Laravel 11
- MySQL
- Tailwind CSS
- PhpSpreadsheet
- Vite

## License

This project is open source and available under the MIT License.