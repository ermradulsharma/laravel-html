# Contributing to Laravel HTML & Form Builder

Thank you for considering contributing to this project! We welcome contributions from the community.

## How to Contribute

### Reporting Bugs

If you find a bug, please open an issue on GitHub with:

- A clear, descriptive title
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- Laravel version and PHP version
- Any relevant code samples

### Suggesting Features

We welcome feature suggestions! Please open an issue with:

- A clear description of the feature
- Use cases and examples
- Why this feature would be useful

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Install dependencies**: `composer install`
3. **Make your changes**
4. **Add tests** for new features
5. **Run tests**: `./vendor/bin/phpunit`
6. **Follow coding standards**: PSR-12
7. **Commit your changes** with clear commit messages
8. **Push to your fork** and submit a pull request

### Coding Standards

- Follow PSR-12 coding standards
- Use strict typing (`declare(strict_types=1)`)
- Add PHPDoc blocks for all public methods
- Write descriptive variable and method names
- Keep methods focused and single-purpose

### Testing

- Write tests for all new features
- Ensure all tests pass before submitting PR
- Aim for high code coverage
- Test with multiple Laravel versions if applicable

### Documentation

- Update README.md if adding new features
- Add examples to wiki documentation
- Update CHANGELOG.md following Keep a Changelog format
- Include inline code comments for complex logic

## Development Setup

```bash
# Clone your fork
git clone https://github.com/YOUR_USERNAME/laravel-html.git
cd laravel-html

# Install dependencies
composer install

# Run tests
./vendor/bin/phpunit
```

## Code Review Process

1. All PRs require review before merging
2. Maintainers will review within 1-2 weeks
3. Address any feedback or requested changes
4. Once approved, maintainers will merge

## Community Guidelines

- Be respectful and inclusive
- Provide constructive feedback
- Help others learn and grow
- Follow the Code of Conduct

## Questions?

Feel free to open an issue for questions or join discussions!

Thank you for contributing! 🎉
