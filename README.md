
# 🎬 Movie App - Laravel Project

## 🔥 Description
This is a Laravel-based Movie Application that allows users to browse movies, view details, and submit ratings. Admins can manage movies through a backend interface. The project also includes APIs and push notification functionality.

---

## 🚀 Features

### ✅ Frontend
- User authentication (Register/Login)
- Movie listing page with:
  - Movie image
  - Title
  - Publication date
  - Link to detailed view
- Single movie detail page with:
  - Image
  - Title
  - Description
  - Runtime
  - IMDB rating
  - Publication date
- Users can:
  - Add a rating for each movie (only once)
  - Edit their own rating
- Latest push notifications shown on the top bar
- Fully functional API with prefix `/api/v1`

---

### ✅ Backend
- Admins can add and edit movies
- Each admin can only manage (edit/delete) the movies they created (using Laravel Policies)
- API is protected with Laravel Sanctum Authentication
- Artisan command to send push notifications with movie title and description
- Scheduled job to update movie ratings daily at **8:00 PM** based on the last month's user reviews

---

## ⚙️ Installation Guide

### 1️⃣ Clone the repository
```bash
git clone https://github.com/TiwariSundaram01/movie_app.git
cd movie_app
```

### 2️⃣ Install dependencies
```bash
composer update
```

### 3️⃣ Create and configure `.env`
- Copy `.env.example` to `.env`
```bash
cp .env.example .env
```
- Update the database and app configuration in `.env` file:

Example:
```
DB_DATABASE=movie_app
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://127.0.0.1:8000
```

### 4️⃣ Generate app key
```bash
php artisan key:generate
```

### 5️⃣ Run database migrations
```bash
php artisan migrate
```

### 6️⃣ Start the development server
```bash
php artisan serve
```
Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔐 API Authentication
- API routes are protected with Laravel Sanctum.
- You must be authenticated to access `/api/v1` routes.

---

## ⏰ Scheduled Tasks
- A cron job runs daily at 8:00 PM to update movie ratings based on last month’s reviews.

---

## 🔔 Push Notifications
- Custom Artisan command to send push notifications with the movie title and description.
- Notifications are displayed on the top bar.

---

## 💌 Contact
If you face any issues or have questions, feel free to contact me.
