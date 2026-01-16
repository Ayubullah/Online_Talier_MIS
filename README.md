# 🧵 Online Tailor Management Information System (MIS)

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
![Status](https://img.shields.io/badge/Status-Active-success?style=for-the-badge)

**A comprehensive web-based management system designed specifically for tailoring businesses to streamline operations, manage orders, track employees, and handle financial transactions.**

[Features](#-features) • [Installation](#-installation) • [Documentation](#-documentation) • [Screenshots](#-screenshots) • [Contributing](#-contributing)

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [API Documentation](#-api-documentation)
- [Contributing](#-contributing)
- [License](#-license)
- [Support](#-support)

---

## 🎯 Overview

The Online Tailor Management Information System is a full-featured Laravel application that helps tailoring businesses manage their daily operations efficiently. The system provides comprehensive tools for managing customers, employees, orders (clothing and vests), assignments, payments, and generating invoices with barcode support.

### Key Highlights

- ✅ **Complete Order Management** - Track cloth and vest orders from creation to completion
- ✅ **Employee Management** - Manage employee details, assignments, and payments
- ✅ **Customer Management** - Maintain customer records with phone-based search
- ✅ **Financial Tracking** - Handle payments, invoices, and generate reports
- ✅ **Multi-language Support** - English, Farsi (فارسی), and Pashto (پښتو)
- ✅ **Role-based Access Control** - Admin and User roles with different permissions
- ✅ **Barcode Integration** - Generate barcodes for easy tracking
- ✅ **Search Functionality** - Quick search by phone number across all modules

---

## ✨ Features

### 👥 Customer Management
- Complete customer database with contact information
- Phone number-based search functionality
- Customer payment tracking and history
- Invoice generation with printable formats
- Size measurement printing for records

### 👔 Order Management
- **Cloth Orders**: Full lifecycle management for clothing orders
  - Create, edit, and view cloth measurements
  - Print invoices and size sheets
  - Track order status and progress
- **Vest Orders**: Similar comprehensive management for vest orders
  - Complete vest measurement tracking
  - Status management and reporting

### 👨‍💼 Employee Management
- Employee profile management with photos
- Role-based access (Admin/Employee)
- Assignment tracking for cloth and vest orders
- Payment and salary management
- Specialized rate tracking for different order types

### 📋 Assignment System
- Assign orders to employees
- Track pending and completed assignments
- Real-time status updates
- Employee-specific assignment views

### 💰 Financial Management
- Payment processing and tracking
- Invoice generation with barcode support
- Payment reports and analytics
- Customer payment history
- Employee payment records

### 🔍 Advanced Search
- Phone number-based search across all modules
- Quick access to customer and order information
- Integrated search results with action buttons

### 🌐 Multi-language Support
- **English** - Default language
- **Farsi (فارسی)** - Persian language support
- **Pashto (پښتو)** - Pashto language support
- Easy language switching via session-based locale

### ⚙️ System Administration
- Database backup and restore functionality
- Cache management
- Application optimization tools
- Settings management
- Backup history and download

### 📊 Reporting & Analytics
- Payment reports
- Employee performance tracking
- Order status reports
- Financial summaries

---

## 🛠 Technology Stack

### Backend
- **Laravel 12.x** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL/MariaDB** - Database (SQLite for development)

### Frontend
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **Vite** - Next-generation frontend tooling

### Additional Packages
- **milon/barcode** - Barcode generation
- **openai-php/laravel** - AI integration capabilities
- **tom-select** - Enhanced select dropdowns

### Development Tools
- **Pest PHP** - Testing framework
- **Laravel Pint** - Code style fixer
- **Laravel Pail** - Log viewer

---

## 📦 Requirements

Before installing, ensure your system meets the following requirements:

- **PHP**: >= 8.2
- **Composer**: Latest version
- **Node.js**: >= 18.x and npm
- **Database**: MySQL 8.0+ / MariaDB 10.3+ / SQLite 3
- **Web Server**: Apache / Nginx
- **PHP Extensions**:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML

---

## 🚀 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/Ayubullah/Online_Talier_MIS.git
cd Online_Talier_MIS
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Install Node Dependencies

```bash
npm install
```

### Step 4: Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### Step 5: Configure Database

Edit the `.env` file and update your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=talier_mis
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 6: Run Migrations

```bash
php artisan migrate
```

### Step 7: Seed Database (Optional)

```bash
php artisan db:seed
```

### Step 8: Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### Step 9: Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Quick Start (All-in-One Command)

For a complete development environment setup:

```bash
composer dev
```

This command starts:
- Laravel development server
- Queue worker
- Laravel Pail (log viewer)
- Vite development server

---

## ⚙️ Configuration

### Application Settings

Key configuration files located in the `config/` directory:

- `app.php` - Application settings
- `database.php` - Database configuration
- `auth.php` - Authentication settings
- `barcode.php` - Barcode generation settings

### Storage & Uploads

Ensure the following directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
```

### Email Configuration

Configure mail settings in `.env` for email notifications:

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

---

## 📖 Usage

### First-Time Setup

1. **Create Admin Account**: Register the first admin user through the registration page
2. **Configure Settings**: Access Settings page to configure system preferences
3. **Add Employees**: Create employee profiles in the Employees section
4. **Add Customers**: Start adding customers through the Customers section

### Basic Workflow

1. **Customer Registration**: Add new customers with their contact information
2. **Order Creation**: Create cloth or vest orders with measurements
3. **Assignment**: Assign orders to available employees
4. **Progress Tracking**: Monitor assignment status and updates
5. **Payment Processing**: Record payments and generate invoices
6. **Completion**: Mark orders as complete and update employee records

### User Roles

#### Admin
- Full system access
- Employee and customer management
- Order and assignment management
- Payment and invoice processing
- System settings and backups
- Reports and analytics

#### User (Employee)
- View assigned orders
- Update order status
- View personal transactions
- Access size information

---

## 📁 Project Structure

```
Online_Talier_MIS/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   └── Middleware/       # Custom middleware
│   ├── Models/               # Eloquent models
│   └── Services/             # Business logic services
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript files
├── routes/
│   ├── web.php              # Web routes
│   └── auth.php             # Authentication routes
├── public/                   # Public assets
└── storage/                  # Storage and uploads
```

### Key Directories

- **Controllers**: Handle HTTP requests and business logic
- **Models**: Define database relationships and business rules
- **Views**: Blade templates for the user interface
- **Migrations**: Database schema definitions
- **Routes**: Application route definitions

---

## 🔌 API Documentation

### Search Endpoints

#### Get Cloth Measurement Details
```
GET /api/cloth-measurement/{id}
```

#### Get Vest Measurement Details
```
GET /api/vest-measurement/{id}
```

### Authentication

The application uses Laravel's built-in authentication system with session-based authentication.

---

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Contribution Guidelines

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Style

We use Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

### Testing

Run tests using Pest:

```bash
php artisan test
```

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🆘 Support

For support, email [your-email@example.com] or open an issue in the repository.

### Common Issues

**Issue**: Database connection error
- **Solution**: Verify `.env` database credentials and ensure database exists

**Issue**: Permission denied errors
- **Solution**: Run `chmod -R 775 storage bootstrap/cache`

**Issue**: Assets not loading
- **Solution**: Run `npm install && npm run build`

---

## 👨‍💻 Author

**Ayubullah**

- GitHub: [@Ayubullah](https://github.com/Ayubullah)

---

## 🙏 Acknowledgments

- Laravel Framework and community
- All contributors who have helped improve this project
- Tailoring businesses for inspiring this solution

---

<div align="center">

**⭐ Star this repository if you find it helpful!**

Made with ❤️ using Laravel

</div>
