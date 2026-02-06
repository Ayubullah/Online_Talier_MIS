# Contributing to Online Tailor MIS

Thank you for your interest in contributing to the Online Tailor Management Information System! This document provides guidelines and instructions for contributing.

## Code of Conduct

By participating in this project, you agree to maintain a respectful and professional environment for all contributors.

## How Can I Contribute?

### Reporting Bugs

If you find a bug, please create an issue with:

- **Clear title and description**
- **Steps to reproduce** the issue
- **Expected behavior** vs **actual behavior**
- **Screenshots** if applicable
- **Environment details** (PHP version, Laravel version, etc.)

### Suggesting Enhancements

We welcome feature suggestions! When proposing enhancements:

- Provide a clear description of the feature
- Explain the use case and benefits
- Consider backwards compatibility
- Discuss potential implementation approaches

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Follow the coding standards** (see below)
3. **Write tests** for new features
4. **Update documentation** as needed
5. **Ensure all tests pass** before submitting
6. **Write a clear PR description** explaining changes

## Development Setup

1. Clone your fork
2. Install dependencies: `composer install && npm install`
3. Copy `.env.example` to `.env`
4. Generate app key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Start dev server: `composer dev`

## Coding Standards

### PHP/Laravel

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
- Use Laravel Pint for formatting: `./vendor/bin/pint`
- Follow Laravel naming conventions
- Write meaningful variable and function names

### JavaScript/CSS

- Use ES6+ features
- Follow consistent indentation (2 spaces)
- Comment complex logic
- Use meaningful class names (BEM methodology)

### Database

- Always create migrations for schema changes
- Include rollback logic in migrations
- Use meaningful migration names

### Commits

Write clear commit messages:

```
type(scope): subject

body (optional)
```

Types: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`

Example:
```
feat(customer): add phone number validation

Add validation for phone number format when creating customers
```

## Testing

- Write tests for new features
- Ensure existing tests pass
- Aim for meaningful test coverage
- Use descriptive test names

Run tests:
```bash
php artisan test
```

## Documentation

- Update README.md for user-facing changes
- Document complex functions/methods
- Update API documentation if endpoints change
- Add comments for non-obvious code

## Questions?

Feel free to open an issue for questions or reach out to maintainers.

Thank you for contributing! 🎉




