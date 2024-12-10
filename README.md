# Todo API

A RESTful API built with Laravel 11 for managing todo items. The API supports creating, reading, updating, and deleting todos, with features for filtering, sorting, and searching.

## Features

- Full CRUD operations for todo items
- Filterable by status (not_started, in_progress, completed)
- Searchable by title and details
- Sortable by multiple fields
- Pagination support
- Comprehensive API documentation
- Automated tests with high coverage

## API Documentation

The API documentation is available at:
- [API Documentation](http://localhost:8000/api/documentation)

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+
- Laravel 11.x

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/todo-api.git
cd todo-api
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_api
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Run migrations:
```bash
php artisan migrate
```

6. Generate API documentation:
```bash
php artisan l5-swagger:generate
```

## Usage

Start the development server:
```bash
php artisan serve
```

### API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/todos` | List all todos |
| POST | `/api/todos` | Create a new todo |
| PUT | `/api/todos/{id}` | Update a todo |
| DELETE | `/api/todos/{id}` | Delete a todo |

### Query Parameters

List endpoint (`GET /api/todos`) supports the following query parameters:

- `status`: Filter by status (not_started, in_progress, completed)
- `search`: Search in title and details
- `sort_by`: Field to sort by (title, status, created_at)
- `sort_direction`: Sort direction (asc, desc)
- `page`: Page number for pagination

### Example Requests

List todos:
```bash
curl http://localhost:8000/api/todos
```

Create todo:
```bash
curl -X POST http://localhost:8000/api/todos \
-H "Content-Type: application/json" \
-d '{
    "title": "Complete Project",
    "details": "Finish the API implementation",
    "status": "not_started"
}'
```

Update todo:
```bash
curl -X PUT http://localhost:8000/api/todos/1 \
-H "Content-Type: application/json" \
-d '{
    "title": "Complete Project",
    "details": "API implementation completed",
    "status": "completed"
}'
```

Delete todo:
```bash
curl -X DELETE http://localhost:8000/api/todos/1
```

## Testing

Run the test suite:
```bash
php artisan test
```

Run tests with coverage report:
```bash
php artisan test --coverage
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
