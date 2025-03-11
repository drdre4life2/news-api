#  News Aggregator

## Overview
This is a Laravel 12 application that aggregates news articles from multiple sources such as NewsAPI, The New York Times, and The Guardian. It fetches, stores, and serves news articles via API endpoints while supporting filtering, caching, and pagination.

## Features
- Fetches news from external APIs using queued jobs.
- Stores news articles in a database.
- Provides API endpoints for retrieving news.
- Supports filtering by category, author, source, and full-text search.
- Implements caching to optimize performance.
- Scheduled commands for periodic news fetching.

## Installation

### Prerequisites
- PHP 8.3
- Composer
- Laravel 12
- MySQL
- Redis (for caching and queues)

### Setup
1. Clone the repository:
 ```sh
   git clone https://github.com/drdre4life2/news-api.git
   cd news-api
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Copy and configure environment variables:
   ```sh
   cp .env.example .env
   ```
   - Set your database credentials.
   - Configure API keys for news sources.

4. Generate application key:
   ```sh
   php artisan key:generate
   ```

5. Run migrations:
   ```sh
   php artisan migrate
   ```


6. Queue setup:
   ```sh
   php artisan queue:work
   ```

7. Start the application:
   ```sh
   php artisan serve
   ```

## Usage

### Fetch News from External APIs
To manually fetch news from external sources, run:
```sh
php artisan fetch-news
```

### API Endpoints
#### 1. Retrieve News
```http
GET /api/news
```
**Query Parameters:**
- `category`: Filter by category
- `author`: Filter by author
- `source`: Filter by source
- `date`: Pagination control

Example:
```http
GET /api/news?category=technology&author=John
```

#### 2. Fetch News Manually
```http
POST /api/news/fetch
```
Triggers a background job to fetch news from external sources.

## Caching Strategy
- News data is cached for **62 minutes** to improve performance.
- Cached results are based on filters applied.
- To clear the cache manually, run:
  ```sh
  php artisan cache:clear
  ```

## Testing
To run unit and feature tests:
```sh
php artisan test
```

## License
This project is licensed under the MIT License.

