
# 🔧 FIXORA

**FIXORA** is a multi-service booking and professional matching platform designed to connect customers with qualified professionals in Morocco.

The platform allows customers to find services, book appointments, and communicate with professionals, while professionals can manage their services and booking requests.

---

## 📌 Project Overview

FIXORA aims to simplify the process of finding and booking reliable services through a user-friendly and multilingual web application.

The platform was fully designed and developed by me, from the initial idea and database architecture to the final user interface and business logic.

The platform supports three main roles:

- 👤 **Customer:** Browse services, find professionals, and make bookings.
- 🔧 **Professional:** Manage services, receive booking requests, and manage appointments.
- 🛡️ **Admin:** Manage users, services, bookings, and platform activities.

---

## 👩‍💻 My Role & Contribution

This is a **solo project**. I was responsible for the entire development lifecycle:

- **Concept & Architecture:** Designed the database schema, defined business rules, and structured the MVC architecture.
- **Backend Development:** Built authentication with Laravel Breeze, implemented role-based access control, and developed booking workflows.
- **Frontend Development:** Created responsive interfaces using Blade, Tailwind CSS, and Alpine.js.
- **Multilingual System:** Implemented dynamic content translations using Spatie Translatable.

---

## ✨ Main Features

### 👤 Customer
- Create an account and log in.
- Browse available services.
- Search for professionals.
- View professional profiles and service details.
- Make and manage booking requests.
- Track booking status.

### 🔧 Professional
- Manage professional profile.
- Manage offered services.
- Receive booking requests.
- Accept or reject booking requests.
- Manage appointments.

### 🛡️ Admin
- Manage customers and professionals.
- Manage services and categories.
- Monitor bookings.
- Manage platform information.

### 🌍 Multilingual Support
FIXORA supports three languages:
- 🇫🇷 French
- 🇬🇧 English
- 🇩🇪 German

### 🔐 Authentication & Security
- User authentication.
- Role-based access control.
- Protected routes.
- Secure password handling.

---

## 🛠️ Technologies Used

| Technology | Description |
|---|---|
| Laravel 12 | Backend framework |
| PHP | Server-side programming |
| MySQL | Database |
| Laravel Breeze | Authentication |
| Spatie Translatable | Multilingual database content |
| Blade | Template engine |
| Tailwind CSS v4 | Styling |
| Alpine.js | Frontend interactions |
| Vite | Asset bundling |

---

## 🏗️ Project Architecture

FIXORA follows the **MVC (Model-View-Controller)** architecture provided by Laravel.

- **Models:** Handle database interactions.
- **Views:** Display the user interface using Blade.
- **Controllers:** Handle application logic and user requests.
- **Database:** Stores users, services, bookings, and related information.

---

## 🗄️ Database

The application uses **MySQL** to manage its data.

The database handles the main entities of the platform, including:

- Users
- Roles
- Services
- Categories
- Professional profiles
- Bookings
- Booking statuses

---

## 🎨 Design

FIXORA focuses on a modern, clean, and user-friendly interface.

The design aims to provide:
- Simple navigation.
- Responsive layouts.
- Clear service presentation.
- Consistent visual elements.
- An intuitive experience for customers and professionals.

---

## 📋 Business Rules

- Each user has a specific role: Customer, Professional, or Admin.
- Customers can create booking requests.
- Professionals can manage the booking requests they receive.
- Booking status changes depend on the professional's response.
- Administrative actions are restricted to administrators.
- The platform supports multilingual content.

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/lobnaelamrany/fixora.git
cd fixora
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Create the environment file

```bash
cp .env.example .env
```

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Configure the database

Update your `.env` file with your MySQL database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fixora
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Build frontend assets

```bash
npm run build
```

### 9. Start the development server

```bash
php artisan serve
```

In another terminal, you can run:

```bash
npm run dev
```

Open your browser and visit:

```text
http://127.0.0.1:8000
```

---

## 🔮 Future Improvements

- Online payment integration.
- Advanced search and filtering.
- Customer reviews and ratings.
- Notifications system.
- Improved booking management.
- Additional platform features.

---

## 👩‍💻 Author

**Lobna El Amrany**

- GitHub: [@lobnaelamrany](https://github.com/lobnaelamrany)
- Email: [lobnaelamrany4@gmail.com](mailto:lobnaelamrany4@gmail.com)
- Location: Morocco 🇲🇦

---

<p align="center">
  Made with ❤️ by Lobna El Amrany
</p>
