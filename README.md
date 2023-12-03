# Project Name

TwoQCompany-FullStackApp

## Table of Contents

- [Project Overview](#project-overview)
- [Architecture](#architecture)
- [Database](#database)
- [Libraries and Dependencies](#libraries-and-dependencies)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Project Overview

CRUD Company using Laravel & AJAX

## Architecture

Describe the high-level architecture of your project. Include information about how the different components interact and any design patterns you've employed. Mention any significant packages or design decisions.

```plaintext
|-- app
|   |-- Console
|   |-- Exceptions
|   |-- Http
|   |   |-- Controllers
|   |   |-- Middleware
|   |   |-- ...
|   |-- Models
|   |-- Providers
|   |-- Repositories
|-- config
|-- database
|-- public
|-- resources
|-- routes
|-- ...
```

### Custom Repositories

A custom directory named "Repositories" has been added to the application structure. This directory is intended to house the majority of the business logic, encapsulating the application's specific requirements. The purpose is to prevent cluttering controllers with extensive business logic, allowing controllers to focus on handling requests and responses.

### How to Use Repositories


Controllers should follow a pattern where they primarily handle incoming requests, extract relevant data, and then delegate the business logic to the appropriate repository. This separation helps maintain a clean and organized codebase.

Example of how a controller might interact with a repository:


```php
use App\Repositories\YourRepository;

class YourController extends Controller
{
    protected $yourRepository;

    public function __construct(YourRepository $yourRepository)
    {
        $this->yourRepository = $yourRepository;
    }

    public function yourControllerMethod(Request $request)
    {
        // Extract data from the request
        $requestData = $request->only(['key1', 'key2']);

        // Delegate the business logic to the repository
        $result = $this->yourRepository->performBusinessLogic($requestData);

        // Process the result and return a response
        // ...

        return response()->json($result);
    }
}
```

### Adding Business Logic

Repositories within the "Repositories" directory are expected to contain the business logic. Each repository should have methods dedicated to specific tasks, ensuring a clear separation of concerns.

```php

namespace App\Repositories;

class YourRepository
{
    public function performBusinessLogic(array $data)
    {
        // Your business logic goes here
        // ...

        return $result;
    }
}
```

Repositories within the "Repositories" directory are expected to contain the business logic. Each repository should have methods dedicated to specific tasks, ensuring a clear separation of concerns.

### 404 page handler
Added handler for 404 page


## Database

### Database Schema

```plaintext
users
  - id
  - name
  - email
  ...

company
  - id
  - name
  - email
  - logo
  - website
```

## Libraries and Dependencies

- **Laravel Version**: 8.x
- **Database**: MySQL.
- **ORM**: Eloquent
- **Authentication**: Laravel UI
- **Frontend**: [Blade], [AJAX], [Bootstrap],[SweetAlert2],[Yajra Datatable], [Javascript]

## Installation

```bash
# Clone the repository
git clone https://github.com/your-username/your-project.git

# Install dependencies
composer install
npm install

# Set up the database
php artisan migrate --seed

npm run serve

# Start the development server
php artisan serve
```
