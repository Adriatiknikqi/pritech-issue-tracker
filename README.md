# Mini Issue Tracker

A Laravel 13 Mini Issue Tracker where a small team can manage projects, issues, tags, and comments.

## Features

### Projects

- List projects
- Create projects
- Edit projects
- Delete projects
- Show project details with related issues

### Issues

- List issues
- Create issues
- Edit issues
- Delete issues
- Show issue details
- Filter issues by status
- Filter issues by priority
- Filter issues by tag

### Tags

- List tags
- Create tags with unique names
- Attach tags to issues via AJAX without page reload
- Detach tags from issues via AJAX without page reload

### Comments

- Load comments via AJAX
- Paginated comments
- Add new comments via AJAX
- Show validation errors on the page
- Clear the comment form after successful submission

### Demo Data

- Factories and seeders for projects, issues, tags, and comments

## Requirements

- PHP 8.3+
- Composer
- Node.js
- NPM
- SQLite

## Installation

Clone the repository:

```bash
git clone https://github.com/Adriatiknikqi/pritech-issue-tracker.git
cd pritech-issue-tracker
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Copy the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Make sure `.env` uses SQLite:

```env
DB_CONNECTION=sqlite
```

Run migrations and seed demo data:

```bash
php artisan migrate:fresh --seed
```

Build frontend assets:

```bash
npm run build
```

Run the application:

```bash
php artisan serve
```

Open the app in your browser:

```text
http://127.0.0.1:8000
```

## Development

Run the Laravel server:

```bash
php artisan serve
```

Run the Vite development server:

```bash
npm run dev
```

## Main Technologies

- Laravel 13
- Blade
- Eloquent ORM
- SQLite
- JavaScript Fetch API
- Tailwind CSS

## Database Structure

### Projects

- name
- description
- start_date
- deadline

### Issues

- project_id
- title
- description
- status: open, in_progress, closed
- priority: low, medium, high
- due_date

### Tags

- name
- color

### Comments

- issue_id
- author_name
- body

### Pivot Table

- issue_tag
    - issue_id
    - tag_id

## Notes

The implementation uses:

- Resource controllers
- Form Request validation
- Eloquent relationships
- Eager loading
- Migrations
- Factories
- Seeders
- Blade templates
- AJAX interactions for tags and comments
- Public GitHub repository with logical commits
