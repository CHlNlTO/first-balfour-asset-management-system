<p align="center"><a href="https://www.firstbalfour.com" target="_blank"><img src="https://bmm.firstbalfour.com/image/logo.gif" width="400" alt="First Balfour Logo"></a></p>

<p align="center">
  <a href="https://github.com/clarkwayneabutal/first-balfour-asset-management-system/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

## About the Project

The **Asset Management System** is a web application developed for **First Balfour, Inc.**, a leading engineering and construction company based in the Philippines. This system is designed to efficiently manage the company's assets, track their status, and ensure seamless operational workflows.

## Features

-   **Simple, Fast Routing Engine**: Utilizes Laravel's robust routing capabilities.
-   **Elegant ORM**: Built with Eloquent for intuitive database interactions.
-   **Real-time Updates**: Incorporates real-time asset status updates using Alpine.js.
-   **Responsive Design**: Styled with Tailwind CSS for a modern, responsive interface.
-   **Secure Authentication**: Implements Laravel's authentication for secure access.
-   **Comprehensive Asset Tracking**: Detailed views and management of assets.

## Technologies Used

-   **PHP 8.2.12**
-   **Laravel 11.12.0**
-   **Filament 3.2.57**
-   **Tailwind CSS**
-   **Alpine.js**
-   **MySQL Database**
-   **XAMPP**
-   **Heroicons**

## Getting Started

### Prerequisites

-   **PHP 8.2.12** or higher
-   **Composer**
-   **Node.js** and **npm**
-   **XAMPP** (for local development)
-   **MySQL Database**

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/clarkwayneabutal/first-balfour-asset-management-system.git
    cd first-balfour-asset-management-system
    ```

2. **Install dependencies:**

    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Set up environment variables:**

    Copy the `.env.example` file to `.env` and configure your database and other settings.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Run migrations:**

    ```bash
    php artisan migrate --seed
    ```

5. **Run worker:**

    ```bash
    php artisan queue:table
    php artisan queue:work --sleep=0 --tries=1 --timeout=120 --stop-when-empty
    ```

6. **Run Import/Export worker:**

    ```bash
    php artisan queue:work database --queue=imports,default --sleep=0
    ```


7. **Serve the application:**

    ```bash
    php artisan serve
    ```

## Usage

-   **Dashboard**: Access the dashboard to view a summary of assets.
-   **Assets Management**: Add, edit, delete, and view assets with ease.
-   **User Authentication**: Secure login and registration for users.
-   **Real-time Updates**: Get real-time updates on asset statuses.

## Development

### File Structure

```
├── app
│ ├── Console
│ ├── Exceptions
│ ├── Http
│ ├── Models
│ ├── Providers
│ └── ...
├── bootstrap
├── config
├── database
│ ├── factories
│ ├── migrations
│ └── seeders
├── public
├── resources
│ ├── css
│ ├── js
│ ├── views
│ └── ...
├── routes
│ └── web.php
├── storage
├── tests
└── ...
```

## Contact

**Clark Wayne Abutal**
4th Year Student Web Developer
[LinkedIn](https://www.linkedin.com/in/clark-wayne-abutal-1005001aa/) | Email: clark.wayne023@gmail.com

**First Balfour, Inc.**
First Balfour Building, 106 Valero St., Salcedo Village, Makati City, Philippines
[Website](https://www.firstbalfour.com)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
