<div align="center">

# 🌟 Tarek Al-Khair (طريق الخير)

[![GitHub stars](https://img.shields.io/github/stars/BesherElMajzoub/alkheer?style=for-the-badge&logo=github)](https://github.com/BesherElMajzoub/alkheer/stargazers)
[![License](https://img.shields.io/github/license/BesherElMajzoub/alkheer?style=for-the-badge&color=blue)](LICENSE)

**A comprehensive Laravel-based Event Management and Volunteer Registration System**

</div>

<br />

## 📋 Table of Contents

- [About The Project](#-about-the-project)
- [✨ Features](#-features)
- [🛠 Requirements](#-requirements)
- [🚀 Installation](#-installation)
- [💻 Usage](#-usage)
- [📂 Project Structure](#-project-structure)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

---

## 📖 About The Project

**Tarek Al-Khair** (طريق الخير) is an elegant web application built with **Laravel 12** and styled with **Tailwind CSS v4**. It is designed to manage charity events, track volunteer registrations, and simplify communication by assigning drivers and interacting directly with them via WhatsApp integration. The project ensures smooth user registration while providing administrators with a powerful dashboard to control events and oversee participants.

### Tech Stack

- **Backend:** Laravel 12 / PHP 8.2
- **Frontend:** Tailwind CSS v4, Blade Templating, Vite
- **Database:** MySQL / SQLite
- **Client Handling:** Axios

## ✨ Features

- **Event Showcase:** View upcoming activities and events in a clean format.
- **Easy Registration:** Simple public-facing forms to join events as a volunteer or participant.
- **Admin Dashboard:** Secure backend to create, edit, and delete events.
- **Driver Management:** Assign or unassign drivers specific to each event.
- **WhatsApp Integration:** Direct click-to-chat WhatsApp link generation for scheduled drivers.
- **Registration Control:** Admins can view and easily manage event registrations.

## 🛠 Requirements

Before you begin, ensure you have met the following requirements:

- **PHP**: `>= 8.2`
- **Composer**: Latest version
- **Node.js**: LTS version (with NPM)

## 🚀 Installation

Follow these steps to get the project up and running on your local machine:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/BesherElMajzoub/alkheer.git
    cd alkheer
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies:**

    ```bash
    npm install
    ```

4. **Environment Setup:**
   Duplicate the `.env.example` file and configure your local database variables.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Database Migration & Seeding:**
   Run the database migrations. _(Add `--seed` if there are seeders ready)_
    ```bash
    php artisan migrate
    ```

## 💻 Usage

### Starting the Development Server

To run the application locally, you'll need two terminal windows.

**Terminal 1 (Backend):**

```bash
php artisan serve
```

**Terminal 2 (Frontend Assets Compiler):**

```bash
npm run dev
```

Alternatively, you can run the pre-configured Concurrent command in Composer if available:

```bash
composer run dev
```

### Accessing the App

- **Public Site:** `http://localhost:8000`
- **Admin Panel:** `http://localhost:8000/admin/login`

_(Admins will require appropriate seed/credentials which you can establish in `DatabaseSeeder.php`)_

## 📂 Project Structure

A quick overview of the essential directories structure in this Laravel project:

```text
├── app/                  # Core application logic, Controllers, and Models
├── bootstrap/            # Application bootstrapping scripts
├── config/               # Configuration settings
├── database/             # Database migrations, seeders, and factories
├── public/               # Public entry point and static assets
├── resources/            # Blade Views, CSS, JS, and localization files
├── routes/               # Routes definitions (web routes, admin group)
├── tests/                # Feature and Unit tests
└── README.md             # You are here!
```

## 🤝 Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.
