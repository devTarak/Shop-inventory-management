# T Shop Inventory mangement

This project aims to simplify and streamline inventory management for retail shops. It provides an intuitive interface for tracking products, managing stock levels, and generating reports. With its modular architecture and robust features, T Shop Inventory Management helps businesses maintain accurate inventory records and improve operational efficiency.

## Features

- Built on [CodeIgniter 4](https://codeigniter.com/)
- MVC architecture (Models, Views, Controllers)
- Environment-based configuration
- Composer dependency management
- PHPUnit integration for testing

## Requirements

- PHP 7.4 or higher
- MySQL or compatible database
- Web server (Apache, Nginx, etc.)

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/sdipos.git
   cd sdipos
   ```
2. Install dependencies:
    ```sh
    composer install
    ```
3. Copy the example environment file and configure:
    ```sh
    cp .env.example .env
    ```
4. Set writable permissions: Ensure the writable directory is writable by the web server
5. Set up your web server: Point your web server's document root to the public directory.
## Project Structure
```sh
app/        # Application code (Controllers, Models, Views, etc.)
public/     # Web server root
system/     # CodeIgniter core
writable/   # Writable files (cache, logs, uploads)
tests/      # Unit and feature tests
vendor/     # Composer dependencies
```