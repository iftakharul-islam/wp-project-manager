# WP Project Manager API Tests

This directory contains comprehensive PHPUnit test cases for all API routes and endpoints in the WP Project Manager plugin.

## Test Coverage

The test suite includes test cases for the following API modules:

### Core Modules
- **Projects API** (`test-projects.php`) - 10 test cases covering project CRUD operations, favorites, and AI generation
- **Tasks API** (`test-tasks.php`) - 19 test cases covering task management, assignments, filtering, and privacy
- **Task Lists API** (`test-task-lists.php`) - 11 test cases covering task list operations and user assignments
- **Milestones API** (`test-milestones.php`) - 6 test cases covering milestone management and privacy

### Collaboration Modules
- **Comments API** (`test-comments.php`) - 6 test cases covering comment CRUD operations
- **Discussion Board API** (`test-discussion-board.php`) - 8 test cases covering discussions and user assignments
- **Files API** (`test-files.php`) - 7 test cases covering file management and downloads

### User & Access Control
- **Users API** (`test-users.php`) - 7 test cases covering user management and search
- **Roles API** (`test-roles.php`) - 7 test cases covering role management and permissions
- **Categories API** (`test-categories.php`) - 7 test cases covering category management

### System Modules
- **Activities API** (`test-activities.php`) - 2 test cases covering activity tracking
- **My Task API** (`test-mytask.php`) - 5 test cases covering user-specific tasks and activities
- **Settings API** (`test-settings.php`) - 13 test cases covering global and project settings, task types, and AI settings
- **Search API** (`test-search.php`) - 5 test cases covering search functionality

### Integration Modules
- **Trello API** (`test-trello.php`) - 16 test cases covering Trello import functionality
- **Pusher API** (`test-pusher.php`) - 3 test cases covering real-time notifications

## Prerequisites

To run the tests, you need:

1. PHP 7.2 or higher
2. MySQL/MariaDB database
3. WordPress test suite
4. Composer dependencies

## Installation

### 1. Install Composer Dependencies

```bash
composer install
```

### 2. Setup WordPress Test Environment

Run the installation script to set up the WordPress test environment:

```bash
bin/install-wp-tests.sh <db-name> <db-user> <db-pass> [db-host] [wp-version]
```

Example:

```bash
bin/install-wp-tests.sh wp_pm_test root '' localhost latest
```

This script will:
- Download and install WordPress core files to `/tmp/wordpress/`
- Download and install the WordPress test suite to `/tmp/wordpress-tests-lib/`
- Create a test database (if it doesn't exist)
- Configure the test environment

### 3. Environment Variables (Optional)

You can customize the test environment by setting these environment variables:

- `WP_TESTS_DIR` - Path to WordPress test suite (default: `/tmp/wordpress-tests-lib`)
- `WP_CORE_DIR` - Path to WordPress core (default: `/tmp/wordpress/`)

## Running Tests

### Run All API Tests

```bash
vendor/bin/phpunit
```

### Run Specific Test Suite

```bash
# Run only project tests
vendor/bin/phpunit tests/api/test-projects.php

# Run only task tests
vendor/bin/phpunit tests/api/test-tasks.php

# Run only user tests
vendor/bin/phpunit tests/api/test-users.php
```

### Run Tests with Code Coverage

```bash
vendor/bin/phpunit --coverage-html coverage/
```

### Run Tests with Verbose Output

```bash
vendor/bin/phpunit --verbose
```

## Test Structure

### Base Test Case

All API tests extend `PM_API_Test_Case` which provides:

- REST API server setup
- Test user creation (admin, editor, subscriber)
- Authentication helpers
- Common assertions

### Test User Roles

Each test suite has access to these test users:

- `$this->admin_user` - Administrator with full permissions
- `$this->editor_user` - Editor with limited permissions
- `$this->subscriber_user` - Subscriber with minimal permissions

### Test Patterns

Tests follow these patterns:

1. **Success Cases** - Test successful API requests with proper authentication
2. **Unauthorized Cases** - Test API requests without authentication (401)
3. **Permission Cases** - Test API requests with insufficient permissions (403)
4. **Not Found Cases** - Test API requests for non-existent resources (404)
5. **Validation Cases** - Test API requests with invalid data (400)

Example test structure:

```php
public function test_get_projects() {
    wp_set_current_user($this->admin_user);
    
    $request = new WP_REST_Request('GET', '/pm/v2/projects');
    $response = $this->server->dispatch($request);
    
    $this->assertEquals(200, $response->get_status());
}

public function test_get_projects_unauthorized() {
    wp_set_current_user(0);
    
    $request = new WP_REST_Request('GET', '/pm/v2/projects');
    $response = $this->server->dispatch($request);
    
    $this->assertEquals(401, $response->get_status());
}
```

## Continuous Integration

To run tests in CI environments:

1. Install WordPress test suite in CI pipeline
2. Configure database credentials
3. Run `composer install`
4. Execute `vendor/bin/phpunit`

Example GitHub Actions workflow:

```yaml
name: Run Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:5.7
        env:
          MYSQL_ROOT_PASSWORD: root
          MYSQL_DATABASE: wp_pm_test
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3
    
    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '7.4'
          extensions: mysqli, pdo_mysql
          
      - name: Install dependencies
        run: composer install
        
      - name: Install WordPress test suite
        run: bin/install-wp-tests.sh wp_pm_test root root 127.0.0.1 latest
        
      - name: Run tests
        run: vendor/bin/phpunit
```

## Troubleshooting

### Database Connection Issues

If you encounter database connection errors:

1. Ensure MySQL/MariaDB is running
2. Verify database credentials
3. Check that the test database exists
4. Confirm the database user has proper permissions

### WordPress Test Suite Not Found

If you see "Could not find wordpress-tests-lib":

1. Run the installation script: `bin/install-wp-tests.sh`
2. Verify `WP_TESTS_DIR` environment variable
3. Check that `/tmp/wordpress-tests-lib` exists

### Plugin Not Loading

If the plugin doesn't load in tests:

1. Ensure `cpm.php` exists in the plugin root
2. Check that Composer autoloader is installed
3. Verify all plugin dependencies are present

## Contributing

When adding new API endpoints:

1. Create test cases in the appropriate test file
2. Cover success, error, and permission scenarios
3. Follow existing test patterns
4. Ensure tests pass before committing

## Test Naming Conventions

- Test files: `test-{module}.php`
- Test classes: `PM_{Module}_API_Test`
- Test methods: `test_{action}_{scenario}`

Examples:
- `test_get_projects()` - Test successful retrieval
- `test_create_project_unauthorized()` - Test without authentication
- `test_update_project_invalid_data()` - Test with invalid input

## API Documentation

For detailed API documentation, refer to:
- Route definitions in `/routes/` directory
- Controller implementations in `/src/` directory
- Postman collection in `postman_collection.json`

## License

This test suite is part of the WP Project Manager plugin and is licensed under GPL2.
