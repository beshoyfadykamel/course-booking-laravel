<div align="center">

# 🎓 Course Booking & Management System

**A Professional Learning Management Platform** | Advanced Course & Student Management Solution

A comprehensive and scalable **Learning Management Platform (LMS)** built with modern technologies and best practices. Manage courses, students, enrollments, and bookings with an intuitive admin dashboard and powerful features designed for educational institutions.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

</div>

---

## 📋 Quick Navigation

- [Overview](#overview)
- [Key Features](#key-features)
- [Screenshots](#screenshots)
- [Tech Stack](#tech-stack)
- [Database Schema](#database-schema)
- [Project Structure](#project-structure)
- [Installation Guide](#installation-guide)
- [Available Commands](#available-commands)
- [API Routes](#api-routes-overview)

---

## 🎯 Overview

**Course Booking System** is a robust, production-ready Learning Management Platform designed for educational institutions and training centers. It provides administrators with powerful tools to manage courses, student profiles, and course enrollments efficiently.

Built with **Laravel 12**, **TailwindCSS**, and **Alpine.js**, the platform delivers a seamless user experience with real-time search, soft delete functionality, and comprehensive dashboard analytics. The system supports both **Arabic (RTL)** and **English (LTR)** interfaces with automatic language switching.

### Key Highlights
- ✅ Full CRUD operations with soft-delete & recycle bin
- ✅ Real-time AJAX search across all modules
- ✅ Multi-language support (English & Arabic)
- ✅ Beautiful, responsive design with TailwindCSS
- ✅ Role-based access control (Admin/User)
- ✅ Email verification & password reset
- ✅ Image upload with validation
- ✅ Comprehensive admin dashboard with statistics



---

## 📸 Screenshots

### Landing Page
Beautiful, modern landing page with hero section, feature highlights, and call-to-action buttons.

![Landing Page](screenshots/01-landing-page.png)

### Authentication Pages
Secure login and registration flows with email verification and password reset functionality.

| Login Page | Register Page |
|:---:|:---:|
| ![Login](screenshots/02-login-page.png) | ![Register](screenshots/07-create-student.png) |

### Admin Dashboard
Real-time statistics dashboard showcasing course count, student enrollments, and booking metrics.

![Dashboard](screenshots/03-dashboard.png)

### Course Management Module
Complete course administration with CRUD operations, status management, and enrolled students overview.

| Course List | Create Course | Course Details |
|:---:|:---:|:---:|
| ![Course List](screenshots/04-courses-list.png) | ![Create Course](screenshots/05-create-course.png) | ![Course Details](screenshots/11-course-detail.png) |

### Student Management Module
Comprehensive student profile management with image uploads, country association, and enrollment tracking.

| Student List | Create Student | Student Profile |
|:---:|:---:|:---:|
| ![Student List](screenshots/06-students-list.png) | ![Add Student](screenshots/07-create-student.png) | ![Student Details](screenshots/12-student-detail.png) |

### Course Booking Management
Enroll students in courses with intuitive booking interface and status management.

| Bookings List | Create Booking |
|:---:|:---:|
| ![Bookings](screenshots/08-bookings-list.png) | ![New Booking](screenshots/09-create-booking.png) |

### Additional Features
User profile management, recycle bin for soft-deleted records, and email notifications.

| User Profile | Recycle Bin |
|:---:|:---:|
| ![Profile](screenshots/10-profile.png) | ![Trash](screenshots/13-recycle-bin.png) |

---

## ✨ Key Features

### 🔐 Authentication & Security
- User registration and secure login
- Email verification system
- Password reset via email
- User profile management
- Secure password change functionality
- CSRF protection on all forms
- Role-based access control

### 📚 Course Management
- **Add & Edit Courses** - Create new courses with title, description, and status
- **Search & Filter** - Real-time AJAX search by course title, ID, or status
- **Pagination** - Efficient browsing of large course lists
- **View Enrollments** - See all students enrolled in a specific course
- **Status Management** - Activate or deactivate courses
- **Soft Delete** - Non-permanent deletion with recycle bin recovery
- **Bulk Operations** - Manage multiple courses efficiently

### 👨‍🎓 Student Management
- **Profile Management** - Maintain comprehensive student records
- **Image Uploads** - Upload and manage student profile pictures
- **Country Association** - Organize students by country
- **Enrollment History** - Track course enrollments per student
- **Advanced Search** - Search by name, email, ID, or enrollment status
- **Contact Information** - Store and manage student details
- **Soft Delete & Recovery** - Restore accidentally deleted student records

### 📅 Booking Management
- **Student Enrollment** - Enroll students in courses
- **Unique Constraint** - Prevent duplicate course enrollments
- **Status Tracking** - Active/Inactive booking status
- **AJAX Search** - Real-time booking search and filtering
- **Pagination** - Browse large booking lists efficiently
- **Soft Delete** - Non-permanent deletion option
- **Recycle Bin Access** - Restore deleted bookings

### 🌐 Internationalization (i18n)
- **Bilingual Support** - Full Arabic (RTL) and English (LTR) interface
- **Dynamic Language Switching** - Change language from sidebar without page reload
- **Translated Content** - All labels, messages, and validation messages fully translated
- **RTL/LTR Auto-Detection** - Layout automatically adjusts based on selected language
- **Persistent Language State** - User language preference saved in session

### 🔍 Advanced Search & Filtering
- **Real-time AJAX Search** - Instant results without page reload
- **Multi-field Search** - Search across multiple fields simultaneously
- **Term Highlighting** - Search results highlight matching keywords
- **Nested Search** - Search enrollments within course/student detail pages
- **Pagination Support** - Search results with pagination controls

### ♻️ Recycle Bin & Data Recovery
- **Soft Delete** - Safe deletion across all modules (Courses, Students, Bookings)
- **Dedicated Recycle Bin** - Separate view for deleted records
- **One-Click Restore** - Easily restore individual records
- **Permanent Deletion** - Option to permanently delete from trash
- **Search in Trash** - Find deleted records quickly

### 📱 Responsive Design
- **Mobile-First Layout** - Optimized for all screen sizes
- **Adaptive Navigation** - Collapsible sidebar on mobile devices
- **Touch-Friendly UI** - Easy interaction on touch devices
- **Modern Design** - Tailwind CSS utility-first styling
- **Smooth Animations** - Enhanced user experience with transitions
- **Dark Theme** - Professional dark-themed interface

---

## 🏗️ Tech Stack

| Component | Technology | Version |
|:---|:---|:---|
| **Backend Framework** | Laravel | 12.x |
| **Server-side Language** | PHP | 8.2+ |
| **Database** | MySQL | 8.0+ |
| **Frontend Framework** | Alpine.js | 3.x |
| **CSS Framework** | TailwindCSS | 3.x |
| **Build Tool** | Vite | Latest |
| **Authentication** | Laravel Breeze | 2.3+ |
| **HTTP Client** | Axios | Latest |
| **Icons** | Font Awesome | 6.x |
| **DOM Utilities** | jQuery | 3.x |
| **ORM** | Eloquent | Built-in |
| **Validation** | Laravel Validation | Built-in |



---

## 📊 Database Schema

The system uses a well-structured relational database design with five core tables:

```
                 ┌──────────────────────────┐
                 │        users            │
                 ├──────────────────────────┤
                 │ id (PK)                  │
                 │ name                     │
                 │ email (UNIQUE)           │
                 │ password                 │
                 │ role                     │
                 │ email_verified_at        │
                 │ remember_token           │
                 │ created_at, updated_at   │
                 │ deleted_at (soft delete) │
                 └──────────┬───────────────┘
                            │
              ┌─────────────┼──────────────┐
              │             │              │
     ┌────────▼────────┐    │         ┌────▼────────────┐
     │  countries      │    │         │    courses       │
     ├─────────────────┤    │         ├──────────────────┤
     │ id (PK)         │    │         │ id (PK)          │
     │ name (UNIQUE)   │    │         │ user_id (FK) ────┘
     │ created_at      │    │         │ title            │
     │ updated_at      │    │         │ description      │
     └────────┬────────┘    │         │ status (enum)    │
              │             │         │ created_at       │
              │             │         │ updated_at       │
              │             │         │ deleted_at (SFT) │
              │             │         └───────┬──────────┘
              │             │                 │
        ┌─────▼──────────┐   │                │
        │   students     │   │                │
        ├────────────────┤   │                │
        │ id (PK)        │   │                │
        │ user_id (FK) ──┘   │                │
        │ name           │                    │
        │ email (UNIQUE)     │                │
        │ image          │                    │
        │ country_id(FK) │                    │
        │ status (enum)  │                    │
        │ created_at     │                    │
        │ updated_at     │                    │
        │ deleted_at(SFT) │                   │
        └────────┬────────┘                    │
                 │                             │
                 │  (Many-to-Many via Pivot)  │
                 └────────────┬────────────────┘
                              │
                    ┌─────────▼──────────┐
                    │    bookings        │
                    ├────────────────────┤
                    │ id (PK)            │
                    │ user_id (FK) ──┐   │
                    │ student_id(FK) │   │
                    │ course_id (FK) │   │
                    │ status (enum)  │   │
                    │ created_at     │   │
                    │ updated_at     │   │
                    │ deleted_at(SFT)│   │
                    │ UNIQUE:        │   │
                    │(student_id,    │   │
                    │ course_id)     │   │
                    └────────────────┘   │
                                         │
                                    (references users)
```

### Table Specifications

| Table | Columns | Key Features |
|:---|:---|:---|
| **users** | id, name, email, password, role, created_at, updated_at, deleted_at | Soft deletes, Email verification |
| **countries** | id, name, created_at, updated_at | Serves as reference for students |
| **courses** | id, user_id, title, description, status, created_at, updated_at, deleted_at | FK to users, Soft deletes, Enum status |
| **students** | id, user_id, name, email, image, country_id, status, created_at, updated_at, deleted_at | FK to users & countries, Soft deletes, Image upload |
| **bookings** | id, user_id, student_id, course_id, status, created_at, updated_at, deleted_at | Junction table, Composite unique constraint, Soft deletes |

### Table Relationships

| Relation | From Table | To Table | Type | Cascade |
|:---|:---|:---|:---|:---|
| **Creator** | courses → users | courses.user_id → users.id | Many-to-One | OnDelete:CASCADE |
| **Creator** | students → users | students.user_id → users.id | Many-to-One | OnDelete:CASCADE |
| **Creator** | bookings → users | bookings.user_id → users.id | Many-to-One | OnDelete:CASCADE |
| **Location** | students → countries | students.country_id → countries.id | Many-to-One | OnDelete:SET NULL |
| **Enrollment** | bookings → students | bookings.student_id → students.id | Many-to-One | OnDelete:CASCADE |
| **Enrollment** | bookings → courses | bookings.course_id → courses.id | Many-to-One | OnDelete:CASCADE |

### Key Constraints

- ✅ **Foreign Keys**: All relationships with cascade rules
- ✅ **Unique Constraints**: Email uniqueness, Country name uniqueness
- ✅ **Composite Unique**: (student_id + course_id) on bookings table
- ✅ **Soft Deletes**: All core tables support soft delete recovery
- ✅ **Timestamps**: created_at & updated_at on all tables



---

## 📁 Project Structure

```
course-booking-system/
│
├── app/
│   ├── Helpers/
│   │   └── helpers.php                    # Search highlighting utility
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php         # Dashboard with stats
│   │   │   ├── CourseController.php       # Course CRUD + soft delete
│   │   │   ├── StudentController.php      # Student CRUD + soft delete
│   │   │   ├── BookingController.php      # Booking CRUD + soft delete
│   │   │   ├── ProfileController.php      # User profile management
│   │   │   └── Auth/
│   │   │       ├── AuthenticatedSessionController.php
│   │   │       ├── RegisteredUserController.php
│   │   │       └── ...
│   │   │
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   └── AdminCheck.php
│   │   │
│   │   └── Requests/
│   │       ├── StoreCourseRequest.php
│   │       ├── StoreStudentRequest.php
│   │       ├── StoreBookingRequest.php
│   │       └── ...
│   │
│   ├── Models/
│   │   ├── User.php                       # User model with roles
│   │   ├── Course.php                     # Course with soft deletes
│   │   ├── Student.php                    # Student with soft deletes
│   │   ├── Booking.php                    # Booking pivot model
│   │   ├── Country.php                    # Country model
│   │   └── Traits/
│   │       └── ...
│   │
│   ├── Policies/
│   │   ├── CoursePolicy.php               # Course authorization
│   │   ├── StudentPolicy.php              # Student authorization
│   │   ├── BookingPolicy.php              # Booking authorization
│   │   └── UserPolicy.php                 # User authorization
│   │
│   ├── Providers/
│   │   └── AppServiceProvider.php         # Service provider setup
│   │
│   └── View/
│       └── Components/
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php              # Landing page
│   │   ├── home.blade.php                 # Dashboard
│   │   ├── layouts/
│   │   │   ├── master.blade.php           # Main layout with sidebar
│   │   │   └── guest.blade.php            # Auth layout
│   │   ├── courses/
│   │   │   ├── index.blade.php            # Course list
│   │   │   ├── create.blade.php           # Create form
│   │   │   ├── edit.blade.php             # Edit form
│   │   │   ├── show.blade.php             # Course details
│   │   │   └── recycle.blade.php          # Deleted courses
│   │   ├── students/
│   │   │   ├── index.blade.php            # Student list
│   │   │   ├── create.blade.php           # Create form
│   │   │   ├── edit.blade.php             # Edit form
│   │   │   ├── show.blade.php             # Student profile
│   │   │   └── recycle.blade.php          # Deleted students
│   │   ├── bookings/
│   │   │   ├── index.blade.php            # Booking list
│   │   │   ├── create.blade.php           # Create booking form
│   │   │   ├── edit.blade.php             # Edit booking
│   │   │   ├── show.blade.php             # Booking details
│   │   │   └── recycle.blade.php          # Deleted bookings
│   │   ├── profile/
│   │   │   └── edit.blade.php             # Profile management
│   │   └── auth/
│   │       ├── login.blade.php
│   │       ├── register.blade.php
│   │       ├── forgot-password.blade.php
│   │       └── reset-password.blade.php
│   │
│   ├── css/
│   │   └── app.css                        # Custom CSS
│   │
│   └── js/
│       └── app.js                         # JavaScript entry point
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_02_05_150000_create_countries_table.php
│   │   ├── 2026_02_05_151711_create_courses_table.php
│   │   ├── 2026_02_05_202242_create_students_table.php
│   │   ├── 2026_02_06_124715_create_bookings_table.php
│   │   ├── 2026_02_10_030124_add_unique_student_course_to_bookings_table.php
│   │   └── 2026_02_20_000000_add_soft_deletes_to_users_table.php
│   │
│   ├── factories/
│   │   ├── CourseFactory.php               # Fake course data
│   │   ├── StudentFactory.php              # Fake student data
│   │   └── UserFactory.php                 # Fake user data
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php              # Main seeder
│       ├── CourseSeeder.php                # Course data seeder
│       └── StudentSeeder.php               # Student data seeder
│
├── routes/
│   ├── web.php                            # Application routes
│   ├── auth.php                           # Authentication routes
│   ├── admin.php                          # Admin routes
│   └── console.php                        # Console commands
│
├── lang/
│   ├── en/
│   │   ├── auth.php                       # English auth messages
│   │   ├── messages.php                   # English ui messages
│   │   ├── pagination.php                 # English pagination
│   │   ├── passwords.php                  # English password messages
│   │   └── validation.php                 # English validation rules
│   │
│   └── ar/
│       ├── auth.php                       # Arabic auth messages
│       ├── messages.php                   # Arabic ui messages
│       ├── pagination.php                 # Arabic pagination
│       ├── passwords.php                  # Arabic password messages
│       └── validation.php                 # Arabic validation rules
│
├── tests/
│   ├── Feature/                           # Feature tests
│   │   └── CourseTest.php                 # Example test
│   │
│   ├── Unit/                              # Unit tests
│   │   └── ExampleTest.php
│   │
│   └── TestCase.php                       # Base test class
│
├── storage/
│   ├── app/                               # File storage
│   ├── framework/                         # Framework storage
│   └── logs/                              # Application logs
│
├── config/
│   ├── app.php                            # App configuration
│   ├── auth.php                           # Auth configuration
│   ├── database.php                       # Database configuration
│   ├── filesystems.php                    # File storage config
│   ├── mail.php                           # Mail configuration
│   └── ...
│
├── artisan                                # Laravel CLI
├── composer.json                          # PHP dependencies
├── package.json                           # Node dependencies
├── vite.config.js                         # Vite configuration
├── tailwind.config.js                     # Tailwind CSS config
├── README.md                              # This file
└── .env.example                           # Environment example
```



---

## 🚀 Installation Guide

### Prerequisites

Ensure you have the following installed on your system:

- **PHP** ≥ 8.2 ([Download](https://www.php.net/))
- **Composer** ≥ 2.x ([Download](https://getcomposer.org/))
- **Node.js** ≥ 18.x ([Download](https://nodejs.org/))
- **npm** ≥ 9.x (comes with Node.js)
- **MySQL** ≥ 8.0 ([Download](https://www.mysql.com/))

### Step-by-Step Installation

#### 1. Clone the Repository
```bash
git clone https://github.com/your-username/course-booking-system.git
cd course-booking-system
```

#### 2. Install PHP Dependencies
```bash
composer install
```

#### 3. Install JavaScript Dependencies
```bash
npm install
```

#### 4. Environment Setup
```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 5. Configure Database

Open `.env` and configure your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=course_booking
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### 6. Run Migrations and Seeders
```bash
# Create database tables
php artisan migrate

# Seed sample data
php artisan db:seed
```

#### 7. Build Frontend Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

#### 8. Start the Development Server
```bash
php artisan serve
```

The application will be available at **http://127.0.0.1:8000**

### Optional: Create Admin Account
To create an admin account, use the Tinker command:
```bash
php artisan tinker

# In Tinker shell:
User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);
```

---

## 📜 Available Commands

### Setup & Maintenance
```bash
# Full setup (recommended for fresh install)
composer setup

# Install dependencies without scripts
composer install --no-scripts

# Generate app key
php artisan key:generate

# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Create application cache
php artisan config:cache
```

### Database
```bash
# Run all pending migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset all tables
php artisan migrate:reset

# Recreate all tables
php artisan migrate:refresh

# Seed the database
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=CourseSeeder
```

### Development
```bash
# Start Laravel development server
php artisan serve

# Start with custom port
php artisan serve --port=8001

# Run Vite dev server
npm run dev

# Build for production
npm run build

# Start server and Vite simultaneously
composer dev
```

### Testing
```bash
# Run all tests
php artisan test

composer test

# Run tests with coverage
php artisan test --coverage
```

### Code Quality
```bash
# Format code with Pint
./vendor/bin/pint

# Test code styling
./vendor/bin/pint --test
```

### Tinker (Interactive Shell)
```bash
# Start interactive shell
php artisan tinker

# Inside Tinker:
App\Models\Course::all();
App\Models\Student::count();
App\Models\User::first();
```

---

## 🗺️ API Routes Overview

### Authentication Routes
| Method | Route | Description |
|:---|:---|:---|
| `GET` | `/login` | Show login form |
| `POST` | `/login` | Authenticate user |
| `GET` | `/register` | Show registration form |
| `POST` | `/register` | Create new account |
| `POST` | `/logout` | Log out user |
| `GET` | `/forgot-password` | Show forgot password form |
| `POST` | `/forgot-password` | Send password reset email |
| `GET` | `/reset-password/{token}` | Show reset password form |
| `POST` | `/reset-password` | Update password |
| `POST` | `/email/verification-notification` | Send verification email |
| `GET` | `/verify-email/{id}/{hash}` | Verify email address |

### Dashboard & Home
| Method | Route | Description |
|:---|:---|:---|
| `GET` | `/` | Landing page (guest) |
| `GET` | `/home` | Dashboard (authenticated) |

### Course Management Routes
| Method | Route | Description |
|:---|:---|:---|
| `GET` | `/courses` | List all courses |
| `GET` | `/courses/create` | Show create course form |
| `POST` | `/courses` | Store new course |
| `GET` | `/courses/{id}` | View course details |
| `GET` | `/courses/{id}/edit` | Show edit course form |
| `PUT` | `/courses/{id}` | Update course |
| `DELETE` | `/courses/{id}` | Soft delete course |
| `GET` | `/courses/recycle` | View deleted courses |
| `POST` | `/courses/{id}/restore` | Restore deleted course |
| `DELETE` | `/courses/{id}/delete-permanently` | Permanently delete course |
| `GET` | `/courses/search` | AJAX search courses |

### Student Management Routes
| Method | Route | Description |
|:---|:---|:---|
| `GET` | `/students` | List all students |
| `GET` | `/students/create` | Show create student form |
| `POST` | `/students` | Store new student |
| `GET` | `/students/{id}` | View student profile |
| `GET` | `/students/{id}/edit` | Show edit student form |
| `PUT` | `/students/{id}` | Update student |
| `DELETE` | `/students/{id}` | Soft delete student |
| `GET` | `/students/recycle` | View deleted students |
| `POST` | `/students/{id}/restore` | Restore deleted student |
| `DELETE` | `/students/{id}/delete-permanently` | Permanently delete student |
| `GET` | `/students/search` | AJAX search students |

### Booking Management Routes
| Method | Route | Description |
|:---|:---|:---|
| `GET` | `/bookings` | List all bookings |
| `GET` | `/bookings/create` | Show create booking form |
| `POST` | `/bookings` | Store new booking |
| `GET` | `/bookings/{id}` | View booking details |
| `GET` | `/bookings/{id}/edit` | Show edit booking form |
| `PUT` | `/bookings/{id}` | Update booking |
| `DELETE` | `/bookings/{id}` | Soft delete booking |
| `GET` | `/bookings/recycle` | View deleted bookings |
| `POST` | `/bookings/{id}/restore` | Restore deleted booking |
| `DELETE` | `/bookings/{id}/delete-permanently` | Permanently delete booking |
| `GET` | `/bookings/search` | AJAX search bookings |

### User Profile Routes
| Method | Route | Description |
|:---|:---|:---|
| `GET` | `/profile` | Show profile edit form |
| `PATCH` | `/profile` | Update profile information |
| `DELETE` | `/profile` | Delete user account |

### Language Routes
| Method | Route | Description |
|:---|:---|:---|
| `POST` | `/lang/{language}` | Switch application language |

---

## 🧪 Testing

The project includes a basic test structure ready for expansion. Run tests with:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/CourseTest.php

# Run with code coverage
php artisan test --coverage
```

Example test file location: `tests/Feature/`

---

## 🔧 Configuration

### Localization (i18n)
The application supports both English and Arabic. Default locale can be set in `config/app.php`:

```php
'locale' => 'en', // or 'ar'
```

### Mail Configuration
Configure email settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Course Booking System"
```

### File Storage
Configure file storage in `config/filesystems.php`. By default, uploaded files are stored in `storage/app/public/`.

---

## 📚 Documentation Resources

- [Laravel Documentation](https://laravel.com/docs)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch: `git checkout -b feature/amazing-feature`
3. **Commit** your changes: `git commit -m 'Add amazing feature'`
4. **Push** to the branch: `git push origin feature/amazing-feature`
5. **Open** a Pull Request with a clear description

### Code Standards
- Follow PSR-12 PHP coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

---

## 📝 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

---

## 🙋 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/your-username/course-booking-system/issues) section
2. Create a new issue with detailed information
3. Include error messages and steps to reproduce

---

## 🎯 Roadmap

Future enhancements planned for this project:

- [ ] API authentication with Laravel Passport
- [ ] Advanced reporting and analytics dashboard
- [ ] Email notifications for enrollment changes
- [ ] PDF certificate generation
- [ ] Student progress tracking
- [ ] Payment gateway integration
- [ ] Video course support
- [ ] Discussion forums
- [ ] Mobile app (React Native)
- [ ] Performance optimizations and caching

---

<div align="center">

Made with ❤️ by [Your Name/Team]

**[⬆ Back to Top](#course-booking--management-system)**

</div> 
