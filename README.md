<div align="center">

# 🎉 TELEVENT
### Event Management System — Built with Laravel

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

A web platform for submitting and managing campus or organizational events with an admin approval system.

</div>

---

## 📌 About

**TELEVENT** is a web-based event management application that allows users to submit event proposals online. Admins then review each submission and decide whether to approve or reject it. Approved events are displayed publicly on the main page.

This project was built to digitize the event proposal process that is typically handled manually.

---

## ✨ Features

| Feature | Description |
|---|---|
| 🔐 **Authentication** | User registration & login with validation |
| 📝 **Event Submission** | Submit events along with supporting documents |
| 📁 **File Uploads** | Upload proposal, timeline, budgeting, and poster files |
| ✅ **Approval System** | Admin can approve or reject event proposals |
| 👤 **User Profile** | Manage personal info and view event history |
| 🔍 **Event Search** | Search through all approved events |
| 🛡️ **Admin Dashboard** | Manage all events and users from one place |

### Supported Event Types
`Exhibition` · `Festival` · `Competition` · `Seminar` · `Webinar`

---

## 🛠️ Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Database:** MySQL
- **Frontend:** Blade Template Engine, Bootstrap
- **Storage:** Laravel File Storage (local disk)
- **Auth:** Laravel Built-in Authentication

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/username/televent.git
cd televent

# 2. Install PHP dependencies
composer install

# 3. Copy the environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Run migrations and seeders
php artisan migrate --seed

# 6. Create storage symlink
php artisan storage:link

# 7. Start the development server
php artisan serve
```

Open your browser and go to: **http://localhost:8000**

---

## 👥 Default Accounts (After Seeding)

| Role | Email | Password |
|---|---|---|
| Admin | admin@televent.com | password |

> Regular users can sign up through the Register page.

---

## 📂 Project Structure

```
TELEVENT/
├── app/
│   ├── Http/Controllers/
│   │   ├── EventController.php         # Event CRUD & logic
│   │   ├── AdminDashboardController    # Admin management
│   │   ├── UserProfileController       # User profile
│   │   └── Auth/                       # Login & Register
│   ├── Models/
│   │   ├── Event.php                   # Event model
│   │   ├── User.php                    # User model
│   │   └── Document.php               # Document model
├── database/
│   └── migrations/                     # Database schema
├── resources/views/                    # Blade templates
└── routes/web.php                      # Application routes
```

---

## 🔄 Workflow

```
User Register / Login
        ↓
Submit Event + Upload Documents
        ↓
Status: PENDING (awaiting review)
        ↓
Admin Reviews Proposal
        ↓
   ┌──────────────┐
APPROVED        REJECTED
   ↓
Visible on Public Event Page
```

---

## 📸 Screenshots

> *Coming soon — add your app screenshots here*

---

## 🤝 Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you'd like to change.

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

<div align="center">
  Built with ❤️ using Laravel
</div>
