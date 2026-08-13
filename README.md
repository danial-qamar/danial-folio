<p align="center">
  <h1 align="center">DanialFolio</h1>
  <p align="center">A Modern Portfolio & Blog Platform Built with Laravel</p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Filament-3.x-FFAA00?style=flat" alt="Filament">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

---

## Introduction

DanialFolio is a powerful, modular portfolio and blog platform built on Laravel's robust foundation, combining flexibility with user-friendly administration.

**Key Highlights:**
- **Modular Architecture** - Components integrate seamlessly like building blocks
- **No-Code Management** - 100% managed through an intuitive Control Panel
- **Flexible Deployment** - From simple landing pages to complex multi-page sites
- **Professional Results** - Perfect for developers, designers, and creative professionals

---

## What's New in v2.2.0

November, 2025

### Major Features
- **Juno Theme** - First official theme with tabbed interface
- **Portfolio Gallery** - Complete redesign with advanced filtering and quick view
- **Fast Search** - Debounced search for Blog and Portfolio sections
- **Quickbar** - Quick access menu for faster navigation
- **Dashboard Redesign** - Improved layout with new widgets
- **GitHub Integration** - Display repositories and contributions (Juno Theme)

---

## Features

### Content Management
- Blog system with password protection and reading time
- Portfolio/Projects with categories, tags, and SEO optimization
- Page builder with modular content blocks
- Newsletter subscription integration
- Advanced search and filtering

### User Interface
- **Saturn UI** - Modern, responsive design system
- Multiple themes (Default, Juno)
- Dark/Light mode with inverse theme support
- Browser mockup component for project showcases
- Customizable hero sections with multiple layouts

### Professional Tools
- Resume/CV management and download
- LinkedIn "Open to Work" badge integration
- Skills and certifications display
- Course tracking
- Customer/Client showcase
- Social media integration

### Admin Panel
- Intuitive Filament-powered dashboard
- Real-time notifications and alerts
- Analytics integration (Google Analytics)
- Contact form with reCAPTCHA v2
- WhatsApp integration
- Email inbox management

### Developer Features
- Modular component architecture
- Maintenance and Discovery modes
- SEO-friendly URLs and meta tags
- Query optimization for performance
- Comprehensive documentation
- Module visibility controls

---

## Installation

### Quick Start (Composer)

```bash
composer create-project danialqamar/folio
cd folio
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
php artisan serve
```

### Manual Installation

```bash
# Clone the repository
git clone https://github.com/danial-qamar/danial-folio.git
cd folio

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate
php artisan storage:link

# Setup database
php artisan migrate:fresh --seed

# Start development servers
php artisan serve

# In a new terminal
npm run dev
```

---

## System Requirements

**Server Requirements:**
- PHP 8.2 or higher
- PHP Extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo, GD, Zip
- Database: MySQL 5.7+, PostgreSQL 10+, or SQLite 3.8+
- Composer 2.0 or higher
- Node.js 18+ and NPM 10.2+

**Recommended:**
- PHP 8.3+
- MySQL 8.0+ or PostgreSQL 14+
- Redis for caching and sessions

---

## Advanced Features

### Content Blocks
The application provides versatile code blocks and structural components that enable countless customization possibilities. Components are organized into three categories:
- **Components** - Reusable UI elements
- **Design** - Layout and styling options
- **Core** - Fundamental system modules

### Maintenance Mode
Enable maintenance mode while keeping essential features active:
- Contact form accessibility
- Social media links
- Custom maintenance message

### Discovery Mode
Preview your application during maintenance:
- Visible only to administrators
- Visual indicator banner
- Test changes before going live

### Module Management
Customize which core modules appear on your site:
- Header & Navigation
- Hero Section
- About Section
- Projects/Portfolio
- Customers/Clients
- Contact Form
- Newsletter
- Footer

---

## Technology Stack

DanialFolio is built with industry-leading technologies:

| Technology | Purpose | Creator |
|------------|---------|---------|
| **Laravel** | PHP Framework | Taylor Otwell |
| **Filament** | Admin Panel Toolkit | Dan Harrin, Zep Fietje & Community |
| **Livewire** | Real-time Components | Caleb Porzio |
| **Tailwind CSS** | Utility-first CSS | Adam Wathan |
| **Alpine.js** | JavaScript Framework | Caleb Porzio |

---

## Contributing

We welcome contributions from the community! Here's how you can help:

### Reporting Issues
- Use GitHub Issues for bug reports
- Include steps to reproduce
- Provide environment details
- Add screenshots if applicable

### Pull Requests
- Fork the repository
- Create a feature branch
- Follow PSR-12 coding standards
- Write descriptive commit messages
- Update documentation as needed

### Feature Requests
- Open a discussion on GitHub
- Describe the use case
- Explain the expected behavior

---

## Security

If you discover a security vulnerability, please email security contact privately. Do not open public issues for security concerns.

---

## License

DanialFolio is open-source software licensed under the [MIT license](LICENSE).

---

## Acknowledgments

**Special Thanks:**
- [danialfolio](https://github.com/danial-qamar/danial-folio) — the upstream project this is based on
- Taylor Otwell and the Laravel team
- Dan Harrin, Zep Fietje, and the Filament team
- Caleb Porzio for Livewire and Alpine.js
- The entire PHP and Laravel community

---

---

<p align="center">
  <strong>DanialFolio — Personal Portfolio</strong>
</p>

