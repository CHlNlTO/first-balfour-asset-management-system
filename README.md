<p align="center"><a href="https://www.firstbalfour.com" target="_blank"><img src="https://firstbalfour.com/wp-content/uploads/2023/06/first-balfour-logo-white-hd.png" width="400" alt="First Balfour Logo"></a></p>

## About the Project

The **Asset Management System** is a web application developed for **First Balfour, Inc.**, a leading engineering and construction company based in the Philippines. This system is designed to efficiently manage the company's assets, track their status, and ensure seamless operational workflows.

## Features

### Core Asset Management
- **Multi-Type Asset Support**: Manage Hardware, Software, and Peripheral assets
- **Comprehensive Asset Tracking**: Track assets from acquisition to retirement
- **Asset Lifecycle Management**: Monitor acquisition dates, warranty periods, and retirement schedules
- **Asset Assignment System**: Assign assets to employees with detailed tracking
- **Asset Status Management**: Track asset statuses (Active, Inactive, Retired, etc.)

### Advanced Features
- **Bulk Import/Export**: Import assets from Excel files and export comprehensive reports
- **Role-Based Access Control**: Secure authentication with Filament Shield permissions
- **Real-time Dashboard**: Live updates and comprehensive asset overview
- **Advanced Search & Filtering**: Powerful search capabilities across all asset types
- **Automated Notifications**: Email notifications for asset assignments and renewals
- **Purchase Order Integration**: Track purchase orders, invoices, and vendor information
- **Cost Code Management**: Organize assets by cost codes and departments

### Reporting & Analytics
- **Comprehensive Reports**: Detailed asset reports with assignment history
- **Export Capabilities**: Export data to Excel format for further analysis
- **Asset Analytics**: Track asset utilization and lifecycle metrics
- **Assignment Reports**: Monitor asset assignments and employee allocations

## Technologies Used

### Backend
- **PHP 8.2+**
- **Laravel 11.37.0** - Modern PHP framework
- **Filament 3.2.133** - Admin panel and form builder
- **Livewire 3.4** - Full-stack framework for dynamic interfaces
- **MySQL** - Database management system

### Frontend
- **Tailwind CSS 3.4.5** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **Vite 5.0** - Build tool and development server
- **Heroicons** - Beautiful SVG icons

### Additional Packages
- **Laravel Excel (Maatwebsite)** - Import/Export functionality
- **Filament Shield** - Role and permission management
- **Laravel Socialite** - OAuth authentication
- **Microsoft Azure AD** - Enterprise authentication
- **Pest PHP** - Testing framework

## Getting Started

### Prerequisites

- **PHP 8.2+** with required extensions
- **Composer** - PHP dependency manager
- **Node.js 18+** and **npm** - For frontend assets
- **MySQL 8.0+** - Database server
- **XAMPP** (recommended for local development)

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/clarkwayneabutal/first-balfour-asset-management-system.git
    cd first-balfour-asset-management-system
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies and build assets:**

    ```bash
    npm install
    npm run dev
    ```

4. **Set up environment variables:**

    Copy the `.env.example` file to `.env` and configure your database and other settings.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure database:**

    Update your `.env` file with your database credentials:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=asset_management
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

6. **Run database migrations and seeders:**

    ```bash
    php artisan migrate --seed
    ```

7. **Create admin user and set up permissions:**

    ```bash
    php artisan shield:install --fresh
    php artisan shield:super-admin
    ```

8. **Start the queue worker (for import/export functionality):**

    ```bash
    php artisan queue:work database --queue=imports,default --sleep=0
    ```

9. **Serve the application:**

    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`

## Usage

### Getting Started
1. **Login**: Access the system using your credentials
2. **Dashboard**: View comprehensive asset overview and statistics
3. **Asset Management**: Create, edit, and manage different types of assets

### Key Workflows
- **Adding Assets**: Use the asset creation wizard to add hardware, software, or peripheral assets
- **Asset Assignment**: Assign assets to employees with detailed tracking
- **Import/Export**: Bulk import assets from Excel or export comprehensive reports
- **Asset Tracking**: Monitor asset lifecycle, status changes, and assignments
- **Reporting**: Generate detailed reports for asset management and compliance

### User Roles
- **Super Admin**: Full system access and user management
- **Admin**: Asset management and reporting capabilities
- **User**: View assigned assets and basic operations

## Development

### Key Directories
- `app/Filament/Resources/` - Asset management resources and forms
- `app/Models/` - Eloquent models for assets, employees, and assignments
- `app/Exports/` - Excel export functionality
- `database/migrations/` - Database schema definitions
- `resources/css/` - Tailwind CSS customizations

## Contact

**Clark Wayne Abutal**
4th Year Student Web Developer
[LinkedIn](https://www.linkedin.com/in/clark-wayne-abutal-1005001aa/) | Email: clark.wayne023@gmail.com

**First Balfour, Inc.**
First Balfour Building, 106 Valero St., Salcedo Village, Makati City, Philippines
[Website](https://www.firstbalfour.com)

## License

**PROPRIETARY SOFTWARE - ALL RIGHTS RESERVED**

This software is proprietary to **First Balfour, Inc.** and is not for sale, distribution, or copying. All rights are reserved. This software is developed exclusively for internal use by First Balfour, Inc. and its authorized personnel.

**Copyright © 2024 First Balfour, Inc. All rights reserved.**

Unauthorized copying, distribution, or modification of this software is strictly prohibited and may result in legal action.
