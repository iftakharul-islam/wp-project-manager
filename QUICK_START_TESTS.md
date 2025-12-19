# Quick Start Guide - API Tests

## Installation (First Time Setup)

```bash
# 1. Install Composer dependencies
composer install

# 2. Setup WordPress test environment
bin/install-wp-tests.sh wp_pm_test root '' localhost latest
```

## Running Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run a specific test file
vendor/bin/phpunit tests/api/test-projects.php

# Run with verbose output
vendor/bin/phpunit --verbose

# Run with colors
vendor/bin/phpunit --colors=always
```

## Test Files Overview

| File | Endpoints | Focus Area |
|------|-----------|------------|
| test-projects.php | 8 | Project CRUD, favorites, AI generation |
| test-tasks.php | 19 | Task management, assignments, filtering |
| test-task-lists.php | 10 | Task list operations |
| test-milestones.php | 5 | Milestone management |
| test-comments.php | 5 | Comment CRUD operations |
| test-discussion-board.php | 7 | Discussion boards |
| test-files.php | 6 | File management |
| test-users.php | 5 | User management |
| test-categories.php | 6 | Category CRUD |
| test-roles.php | 5 | Role management |
| test-settings.php | 12 | Global & project settings |
| test-mytask.php | 4 | User-specific tasks |
| test-search.php | 2 | Search functionality |
| test-trello.php | 12 | Trello integration |
| test-pusher.php | 1 | Real-time notifications |
| test-activities.php | 2 | Activity tracking |

**Total: 109+ endpoints tested**

## Troubleshooting

### "Could not find wordpress-tests-lib"
```bash
# Re-run the installation script
bin/install-wp-tests.sh wp_pm_test root '' localhost latest
```

### Database Connection Errors
```bash
# Ensure MySQL is running
sudo service mysql start

# Verify credentials match what you used in install-wp-tests.sh
```

### Tests Fail with "Class not found"
```bash
# Reinstall Composer dependencies
rm -rf vendor/
composer install
```

## CI/CD

Tests automatically run on:
- Push to `master` or `develop` branches
- Pull requests to `master` or `develop` branches

View results in GitHub Actions tab.

## Documentation

- Full documentation: `tests/api/README.md`
- Implementation summary: `API_TEST_SUMMARY.md`
- Workflow configuration: `.github/workflows/api-tests.yml`

## Support

For issues or questions:
1. Check `tests/api/README.md` for detailed troubleshooting
2. Review test patterns in existing test files
3. Consult the WordPress REST API testing documentation
