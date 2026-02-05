# Security Policy

## Supported Versions

We release patches for security vulnerabilities for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability within this package, please send an email to the maintainers. All security vulnerabilities will be promptly addressed.

**Please do not open public issues for security vulnerabilities.**

### What to Include

When reporting a vulnerability, please include:

- Description of the vulnerability
- Steps to reproduce the issue
- Potential impact
- Suggested fix (if any)

### Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Fix Timeline**: Varies based on severity

### Severity Levels

- **Critical**: Immediate attention, patch within 24-48 hours
- **High**: Patch within 1 week
- **Medium**: Patch within 2-4 weeks
- **Low**: Patch in next regular release

## Security Best Practices

When using this package:

1. **Keep Updated**: Always use the latest version
2. **Validate Input**: Always validate user input on the server side
3. **CSRF Protection**: Use Laravel's CSRF protection
4. **Honeypot**: Use the `honeypot()` method for bot protection
5. **Sanitize Output**: The package auto-escapes output, but verify in your context

## Disclosure Policy

- Security issues are disclosed after a fix is released
- Credit is given to security researchers (if desired)
- CVE IDs are assigned for significant vulnerabilities

Thank you for helping keep this package secure!
