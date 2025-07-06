````md
# 🎬 Movie App - Laravel Project

A fully functional Laravel-based movie application with:

- ✅ Authentication (Login/Register)
- 🎞 Movie management (CRUD for Admin)
- ⭐ Rating system
- 🔔 Push notifications
- 🔐 Token-based API access using Sanctum
- 🕒 Daily scheduled tasks (rating updates)

---

## 📸 Screenshots

### 🔹 Add New Movie Form  
![Add movies](https://github.com/user-attachments/assets/7f8e898a-3c1b-42ad-a18f-53567996ef86)

### 🔹 Add Rating Modal  
![Add rating](https://github.com/user-attachments/assets/76e5473d-7c6f-4e43-baef-c2f9b1c28792)

### 🔹 Homepage with Notifications  
![homepage with notification](https://github.com/user-attachments/assets/a36dfd8e-b754-4939-80a2-e35080efc486)

### 🔹 Login Page  
![Login](https://github.com/user-attachments/assets/e9860517-f2a5-4a4c-81a8-05bff7c143e4)

### 🔹 Register Page  
![Register](https://github.com/user-attachments/assets/e9f98f46-e818-4fe1-a83d-810f28b3e46f)

---

## 🚀 Features

### ✅ User Features (Frontend)
- Register/Login
- List all movies with poster, title, publish date, and detail button
- View single movie with description, runtime, rating, and image
- Submit and update rating (1–10)
- View latest push notifications in top bar
- Responsive Bootstrap design

---

### ✅ Admin Features (Backend)
- Add, edit, delete movies
- Poster upload
- Only movie creators can update/delete (via Laravel Policies)
- Send push notifications via Artisan command
- Update ratings daily via scheduled job
- Sanctum-protected API access

---

## 🔄 Web Routes

### 🔓 Public Routes

| Route        | Method | Description                  |
|--------------|--------|------------------------------|
| `/`          | GET    | Show register page           |
| `/add_admin` | GET    | Show register page for admin |
| `/login`     | GET    | Show login page              |
| `/register`  | POST   | Handle user registration     |
| `/login`     | POST   | Handle user login            |

---

### 🔐 Authenticated User Routes (`auth:sanctum`)

| Route                | Method | Description                   |
|----------------------|--------|-------------------------------|
| `/logout`            | GET    | Logout                        |
| `/movie/list`        | GET    | Show all movies               |
| `/movie/show/{id}`   | GET    | Show details of a movie       |
| `/rating/add`        | GET    | Show rating form              |
| `/rating/store`      | POST   | Store/update a user rating    |
| `/notifications`     | GET    | Fetch unread notifications    |

---

### 🛡 Admin Routes (`auth:sanctum`, `is.admin`)

| Route                | Method | Description                   |
|----------------------|--------|-------------------------------|
| `/movie/add`         | GET    | Add new movie form            |
| `/movie/edit/{id}`   | GET    | Edit movie form               |
| `/movie/store`       | POST   | Store new or edited movie     |
| `/movie/delete`      | POST   | Delete a movie                |

---

## 🛠 Artisan Command

### 🔔 Send Push Notification to All Users

```bash
php artisan send:movie-notification
````

* Sends latest movie's title and description to all users
* Notifications are shown on top of the frontend

---

## ⏱ Scheduler

A scheduled job runs **daily at 8:00 PM** to update IMDb ratings based on last month’s user reviews.

### 🔧 Crontab Setup

Add this line to your server’s cron:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔐 API Routes (Prefix `/api/v1`)

All routes require Sanctum Token except login/register.

| Route                      | Method | Auth | Description         |
| -------------------------- | ------ | ---- | ------------------- |
| `/api/v1/register`         | POST   | ❌    | Register a user     |
| `/api/v1/login`            | POST   | ❌    | Login and get token |
| `/api/v1/movies`           | GET    | ✅    | List all movies     |
| `/api/v1/movies/{id}`      | GET    | ✅    | View a single movie |
| `/api/v1/movies/{id}/rate` | POST   | ✅    | Rate a movie        |

---

## ⚙️ Installation Guide

### 1️⃣ Clone the repository

```bash
git clone https://github.com/TiwariSundaram01/movie_app.git
cd movie_app
```

### 2️⃣ Install dependencies

```bash
composer install
npm install && npm run dev
```

### 3️⃣ Configure `.env` file

```bash
cp .env.example .env
```

Update database and app info:

```env
DB_DATABASE=movie_app
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://127.0.0.1:8000
```

### 4️⃣ Generate application key

```bash
php artisan key:generate
```

### 5️⃣ Run migrations

```bash
php artisan migrate
```

### 6️⃣ Start the server

```bash
php artisan serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🧪 API Testing

Use Postman or similar:

1. Register or login to get token
2. Add this in headers:

```
Authorization: Bearer <token>
```

Example test:

```http
GET /api/v1/movies
POST /api/v1/movies/5/rate
```

---

## 🙋‍♂️ Developed By

**Sundaram Dinesh Tiwari**
🔗 [GitHub](https://github.com/TiwariSundaram01)

