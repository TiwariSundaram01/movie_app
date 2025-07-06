# 🎬 Movie App - Laravel Project

A fully functional Laravel-based movie application with authentication, movie management, rating system, APIs, and push notifications.

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

* Login/Register system
* List all movies with:

  * Poster
  * Title
  * Publication date
  * View more button
* Movie detail view with:

  * Description
  * Runtime (hours + minutes)
  * IMDb rating
  * Poster
* ⭐ Rate a movie (1–10 stars)

  * Edit existing rating
* 🔔 See push notifications at the top bar
* 💡 Responsive and clean UI with Bootstrap

---

### ✅ Admin Features (Backend)

* Admin can add/edit/delete their own movies
* Movie poster upload
* Laravel Policy ensures only the creator can update/delete
* Push notifications via Artisan command
* Scheduled jobs update average ratings every day at **8:00 PM**
* Authenticated API access using **Laravel Sanctum**

---

## 🔐 API Features

* Prefix: `/api/v1`
* Auth required (Sanctum Token)
* Routes to:

  * Get all movies
  * View single movie
  * Rate a movie
  * Auth endpoints (register/login)

---

## ⚙️ Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/TiwariSundaram01/movie_app.git
cd movie_app
```

### 2️⃣ Install Dependencies

```bash
composer install
npm install && npm run dev
```

### 3️⃣ Create `.env` File

```bash
cp .env.example .env
```

Update DB credentials and app details in `.env`:

```env
DB_DATABASE=movie_app
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://127.0.0.1:8000
```

### 4️⃣ Generate App Key

```bash
php artisan key:generate
```

### 5️⃣ Run Migrations

```bash
php artisan migrate
```

### 6️⃣ Start Server

```bash
php artisan serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🛠 Artisan Commands

### 📤 Push Notification Command

Sends a push notification with the movie's title and description.

```bash
php artisan notify:movie "Movie Title" "Movie Description"
```

---

## ⏱ Scheduler

A cron job runs every day at **8:00 PM** and updates the IMDb ratings for all movies based on the past month's user ratings.

Add this to your server cron:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🧪 Testing APIs (Optional)

Use Postman or any REST client.

### Authentication

* `POST /api/v1/register`
* `POST /api/v1/login`

Include Bearer Token for the following:

* `GET /api/v1/movies`
* `POST /api/v1/movies/{id}/rate`

---

## 🧑‍💻 Developed By

**Sundaram Dinesh Tiwari**
[GitHub Profile](https://github.com/TiwariSundaram01)

---

## 🙋‍♂️ Need Help?

If you encounter any issues, feel free to raise them in the GitHub Issues section or connect via LinkedIn.

