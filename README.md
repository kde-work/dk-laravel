# dk-laravel

**dk-laravel** is a personal pet project created to explore and learn Laravel using PHP 8. This project serves as a playground for experimenting with Laravel's features, modern PHP practices, and architectural patterns like MVC and elements of Domain-Driven Design (DDD).

---

## Features

- **Laravel Framework**: Built with Laravel, leveraging its powerful tools for routing, Eloquent ORM, middleware, and more.
- **PHP 8**: Fully utilizes modern PHP 8 features like attributes, enums, union types, and named arguments.
- **Domain-Driven Design (DDD)**: Implements basic DDD concepts such as Value Objects in the `Domain` layer, Services, Ubiquitous Language, Data Transfer Objects (DTOs), Scoped Queries, Fundamentals of strategic design.
- **Dynamic User Metadata**: Uses a flexible `usermeta` table to store user-related metadata like avatars and gallery photos.
- **Image Processing**: Includes an `ImageProcessorService` for handling image compression and format conversion (e.g., WebP).
- **Queue-Based Background Jobs**: Processes tasks like image optimization asynchronously using Laravel's queue system.
- **Testing**: Comprehensive unit tests for models, services, and controllers using PHPUnit.

---

## Goals

The primary goal of this project is to:
1. Deepen understanding of Laravel's core features.
2. Experiment with PHP 8's modern capabilities.
3. Practice writing clean, testable code with a focus on maintainability.
4. Explore architectural patterns like MVC and integrate elements of DDD.

---

## Installation

To run this project locally:

1. Clone the repository:
```

git clone https://github.com/yourusername/dk-laravel.git
cd dk-laravel

```

2. Install dependencies:
```

composer install
npm install \&\& npm run dev

```

3. Set up the `.env` file:
```

cp .env.example .env

```

4. Generate the application key:
```

php artisan key:generate

```

5. Run migrations:
```

php artisan migrate --seed

```

6. Start the development server:
```

php artisan serve

```

---

## Usage

This project includes the following modules:

1. **User Management**:
- Users can upload avatars and manage photo galleries.
- User metadata is stored in a flexible `usermeta` table.

2. **Image Processing**:
- Images are processed asynchronously using Laravel queues.
- Supports modern formats like WebP and AVIF.

3. **Testing**:
- Unit tests are provided for key components to ensure reliability.

---

## Technologies Used

- PHP 8
- Laravel 10+
- MySQL (or any supported database)
- PHPUnit for testing
- Intervention Image for image processing

---

## Contributing

This project is primarily for personal learning purposes, but contributions are welcome! Feel free to fork the repository, open issues, or submit pull requests.

---

## License

This project is open-source and available under the [MIT License](LICENSE).

---

## Acknowledgments

Special thanks to the Laravel community and documentation for providing excellent resources that inspired this project.
