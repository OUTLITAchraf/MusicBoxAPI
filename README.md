# MusicBox API

A RESTful API built with Laravel for managing a music library, including artists, albums, and songs. This API allows users to perform CRUD operations on music data with secure authentication.

## Features

- **Artist Management**: Create, read, update, and delete artists with details like name, genre, and country.
- **Album Management**: Manage albums linked to artists, including title, genre, and release date.
- **Song Management**: Handle songs associated with albums, with title and duration.
- **Search Functionality**: Search for songs by various criteria.
- **Authentication**: Secure API access using Laravel Sanctum for token-based authentication.
- **API Documentation**: Interactive API documentation powered by Swagger (L5-Swagger).

## Requirements

- PHP ^8.1
- Composer
- Laravel ^10.10
- MySQL or compatible database

## Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd MusicBoxAPI
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Environment setup**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Configure your database settings in `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=musicbox_api
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**:
   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional)**:
   ```bash
   php artisan db:seed
   ```

7. **Start the server**:
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`.

## Authentication

This API uses Laravel Sanctum for authentication. To access protected endpoints:

1. **Register a user**:
   ```bash
   POST /api/register
   Content-Type: application/json

   {
     "name": "Your Name",
     "email": "your@email.com",
     "password": "yourpassword",
     "password_confirmation": "yourpassword"
   }
   ```

2. **Login to get a token**:
   ```bash
   POST /api/login
   Content-Type: application/json

   {
     "email": "your@email.com",
     "password": "yourpassword"
   }
   ```

   Response includes a token. Use this token in the `Authorization` header for subsequent requests:
   ```
   Authorization: Bearer your_token_here
   ```

3. **Logout**:
   ```bash
   POST /api/logout
   Authorization: Bearer your_token_here
   ```

## API Endpoints

All protected endpoints require authentication via Bearer token.

### Artists
- `GET /api/artists` - List all artists
- `GET /api/artist/{id}` - Get specific artist
- `POST /api/create-artist` - Create new artist
- `PUT /api/update-artist/{id}` - Update artist
- `DELETE /api/delete-artist/{id}` - Delete artist

### Albums
- `GET /api/albums` - List all albums
- `GET /api/album/{id}` - Get specific album
- `POST /api/create-album` - Create new album
- `PUT /api/update-album/{id}` - Update album
- `DELETE /api/delete-album/{id}` - Delete album

### Songs
- `GET /api/songs` - List all songs
- `GET /api/song/{id}` - Get specific song
- `GET /api/songs/search` - Search songs
- `POST /api/create-song` - Create new song
- `PUT /api/update-song/{id}` - Update song
- `DELETE /api/delete-song/{id}` - Delete song

## API Documentation

Interactive API documentation is available via Swagger. After starting the server, visit:
```
http://localhost:8000/api/documentation
```

## Testing

Run the test suite:
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## License

This project is licensed under the MIT License.
