Certainly! Here's the revised README file with instructions for installing prerequisites using Git Bash, suitable for Windows environments:

---

# Space Hub

Space Hub is a web application built using the Laravel framework, designed to connect users with spaces for events. Leveraging Laravel's powerful features, Space Hub aims to provide a seamless and efficient experience for both administrators and end-users.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Features

- **User Authentication**: Secure user registration and authentication.
- **Space Listings**: Browse and search for available spaces.
- **Booking System**: Reserve spaces for events.
- **Admin Dashboard**: Manage spaces, bookings, and users.
- **Notifications**: Email notifications for bookings and updates.

## Installation

### Prerequisites
Before you begin, ensure you have the following installed:

- PHP >= 7.4

  Install PHP using Git Bash:
  ```sh
  pacman -S php
  ```

  Alternatively, download PHP from [windows.php.net](https://windows.php.net/download).

- Composer

  Install Composer using Git Bash:
  ```sh
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php composer-setup.php --install-dir=bin --filename=composer
  ```

  Add Composer to your PATH.

- MySQL or another supported database

  Install MySQL using Git Bash:
  ```sh
  pacman -S mysql
  ```

  Alternatively, download MySQL from [dev.mysql.com](https://dev.mysql.com/downloads/mysql).

- Node.js & NPM

  Install Node.js & NPM using Git Bash:
  ```sh
  pacman -S nodejs npm
  ```

  Alternatively, download Node.js & NPM from [nodejs.org](https://nodejs.org/).

### Steps

1. **Clone the repository:**
    ```sh
    git clone https://github.com/your-username/spacehub.git
    cd spacehub
    ```

2. **Install PHP dependencies:**
    ```sh
    composer install
    ```

3. **Install Node dependencies:**
    ```sh
    npm install
    ```

4. **Copy the `.env.example` file to `.env`:**
    ```sh
    cp .env.example .env
    ```

5. **Generate an application key:**
    ```sh
    php artisan key:generate
    ```

6. **Configure your database settings in the `.env` file:**
    ```sh
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

7. **Run the database migrations:**
    ```sh
    php artisan migrate
    ```

## Configuration

### Environment Variables

Ensure these environment variables are set in your `.env` file:

- `APP_NAME` - Name of your application
- `APP_ENV` - Environment (e.g., `local`, `production`)
- `APP_KEY` - Application key (generated during installation)
- `APP_DEBUG` - Debug mode (`true` or `false`)
- `APP_URL` - URL of your application

## Usage

### Running the Application

Start the development server:
```sh
php artisan serve
```
Access the application at `http://localhost:8000`.

### Compiling Assets

Compile front-end assets:
```sh
npm run dev
```
For production:
```sh
npm run production
```

## Testing

### Running Tests

Execute tests:
```sh
php artisan test
```

## Contributing

Contributions are welcome! Follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Make changes and commit (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Open a Pull Request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---


