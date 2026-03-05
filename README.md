# Task Management API Documentation

API untuk manajemen tugas (task management) yang dibangun dengan Laravel 12, menggunakan JWT Authentication dan PostgreSQL database.

## � Quick Setup

### Prerequisites
- PHP 8.2+
- Composer
- PostgreSQL
- Node.js & NPM (optional, untuk frontend assets)

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd backend-task-management
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   ```
   Kemudian edit file `.env` dan atur konfigurasi database Anda.

4. **Generate Keys**
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```

5. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed  # Optional: untuk data sample
   ```

6. **Start Server**
   ```bash
   php artisan serve
   ```

API akan tersedia di `http://localhost:8000/api`

## 📁 Project Structure

```
backend-task-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # JWT Auth endpoints
│   │   │   ├── TaskController.php          # CRUD Task operations
│   │   │   └── MasterStatusController.php  # Master Status API
│   │   ├── Requests/
│   │   │   ├── LoginRequest.php            # Login validation
│   │   │   ├── RegisterRequest.php         # Register validation
│   │   │   └── TaskRequest.php             # Task CRUD validation
│   │   └── Resources/
│   │       ├── UserResource.php            # User API response format
│   │       ├── TaskResource.php            # Task API response format
│   │       └── MasterStatusResource.php    # Status API response format
│   ├── Models/
│   │   ├── User.php                        # User model with JWT
│   │   ├── Task.php                        # Task model with relationships
│   │   └── MasterStatus.php                # Master Status model
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── 2026_03_04_080823_create_users_table.php
│   │   ├── 2026_03_04_080830_create_master_status_table.php
│   │   ├── 2026_03_04_080838_create_tasks_table.php
│   │   └── 0001_01_01_000001_create_cache_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── MasterStatusSeeder.php          # Default status data
├── routes/
│   └── web.php                             # API routes definition
├── .env.example                            # Environment template
├── .gitignore                              # Git exclusion rules
└── README.md                               # This documentation
```

## 📋 Table of Contents

- [Quick Setup](#-quick-setup)
- [Project Structure](#-project-structure)
- [Base URL](#-base-url)
- [Auth Endpoints](#-auth-endpoints)
- [Master Status Endpoints](#-master-status-endpoints)
- [Task Endpoints](#-task-endpoints)
- [Status Codes](#-status-codes)

## 🌐 Base URL

```
http://localhost:8000/api
```

## 🔑 Auth Endpoints

### 1. Register User

**POST** `/api/auth/register`

**Authentication:** ❌ Not Required

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "Password123!",
    "password_confirmation": "Password123!"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, email format, max 255 characters, unique
- `password`: required, min 8 characters, must contain uppercase, lowercase, number, and symbol
- `password_confirmation`: required, must match password

**Response Success (201):**
```json
{
    "success": true,
    "message": "Registrasi berhasil."
}
```

**Response Error (422):**
```json
{
    "success": false,
    "message": "Validation errors",
    "errors": {
        "email": ["Email sudah digunakan."],
        "password": ["Password harus minimal 8 karakter dengan kombinasi huruf kecil, huruf besar, angka, dan simbol."]
    }
}
```

---

### 2. Login User

**POST** `/api/auth/login`

**Authentication:** ❌ Not Required

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "Password123!"
}
```

**Validation Rules:**
- `email`: required, email format
- `password`: required, string

**Response Success (200):**
```json
{
    "success": true,
    "message": "Login berhasil.",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

**Response Error (401):**
```json
{
    "success": false,
    "message": "Email atau password tidak valid."
}
```

**Response Error (422):**
```json
{
    "success": false,
    "message": "Validation errors",
    "errors": {
        "email": ["Email wajib diisi."],
        "password": ["Password wajib diisi."]
    }
}
```

---

### 3. Logout User

**POST** `/api/auth/logout`

**Authentication:** ✅ Required

**Request Body:** None

**Response Success (200):**
```json
{
    "success": true,
    "message": "Logout berhasil."
}
```

**Response Error (401):**
```json
{
    "success": false,
    "message": "Token tidak valid."
}
```

---

### 4. Get User Detail

**GET** `/api/auth/user`

**Authentication:** ✅ Required

**Request Body:** None

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "id_user": "b4545b66-4bb1-43ad-a8a0-18a869d58470",
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": null,
        "created_at": "2026-03-04T09:46:57.000000Z",
        "updated_at": "2026-03-04T09:46:57.000000Z"
    }
}
```

**Response Error (401):**
```json
{
    "success": false,
    "message": "Token tidak valid."
}
```

---

## 📊 Master Status Endpoints

### 1. Get All Master Status

**GET** `/api/master-status`

**Authentication:** ❌ Not Required

**Request Body:** None

**Response Success (200):**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Pending",
            "created_at": "2026-03-04T08:43:02.000000Z",
            "updated_at": "2026-03-04T08:43:02.000000Z"
        },
        {
            "id": 2,
            "name": "Progress",
            "created_at": "2026-03-04T08:43:02.000000Z",
            "updated_at": "2026-03-04T08:43:02.000000Z"
        },
        {
            "id": 3,
            "name": "Done",
            "created_at": "2026-03-04T08:43:02.000000Z",
            "updated_at": "2026-03-04T08:43:02.000000Z"
        }
    ]
}
```

---

## 📝 Task Endpoints

### 1. Get All Tasks

**GET** `/api/tasks`

**Authentication:** ✅ Required

**Request Body:** None

**Description:** Mengambil semua task yang dimiliki oleh user yang sedang login.

**Response Success (200):**
```json
{
    "data": [
        {
            "id_task": "622f27ca-ee2b-4578-af1d-c99f3ad6218d",
            "title": "Belajar Laravel",
            "description": "Membuat API Task Management",
            "id_status": 1,
            "created_at": "2026-03-04T16:31:31.000000Z",
            "updated_at": "2026-03-04T16:31:31.000000Z"
        },
        {
            "id_task": "722f27ca-ee2b-4578-af1d-c99f3ad6218e",
            "title": "Belajar Vue.js",
            "description": "Frontend development",
            "id_status": 2,
            "created_at": "2026-03-04T17:00:00.000000Z",
            "updated_at": "2026-03-04T17:00:00.000000Z"
        }
    ]
}
```

**Response Error (401):**
```json
{
    "success": false,
    "message": "Token tidak valid."
}
```

---

### 2. Create New Task

**POST** `/api/tasks`

**Authentication:** ✅ Required

**Request Body:**
```json
{
    "title": "Belajar Node.js",
    "description": "Road to backend engineer",
    "id_status": 1
}
```

**Validation Rules:**
- `title`: required, string, max 255 characters
- `description`: optional, string
- `id_status`: required, integer, must exist in master_status table (1, 2, or 3)

**Response Success (201):**
```json
{
    "success": true,
    "message": "Task berhasil dibuat.",
    "data": {
        "id_task": "622f27ca-ee2b-4578-af1d-c99f3ad6218d",
        "title": "Belajar Node.js",
        "description": "Road to backend engineer",
        "id_status": 1,
        "created_at": "2026-03-04T16:31:31.000000Z",
        "updated_at": "2026-03-04T16:31:31.000000Z"
    }
}
```

**Response Error (422):**
```json
{
    "success": false,
    "message": "Validation errors",
    "errors": {
        "title": ["Judul wajib diisi."],
        "id_status": ["Status wajib dipilih."]
    }
}
```

---

### 3. Get Task Detail

**GET** `/api/tasks/{id_task}`

**Authentication:** ✅ Required

**Request Body:** None

**Parameters:**
- `id_task`: UUID of the task

**Description:** Mengambil detail task berdasarkan ID. User hanya bisa mengakses task yang dimilikinya sendiri.

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "id_task": "622f27ca-ee2b-4578-af1d-c99f3ad6218d",
        "title": "Belajar Laravel",
        "description": "Membuat API Task Management",
        "id_status": 1,
        "created_at": "2026-03-04T16:31:31.000000Z",
        "updated_at": "2026-03-04T16:31:31.000000Z"
    }
}
```

**Response Error (404):**
```json
{
    "success": false,
    "message": "Task tidak ditemukan."
}
```

---

### 4. Update Task

**PUT** `/api/tasks/{id_task}`

**Authentication:** ✅ Required

**Parameters:**
- `id_task`: UUID of the task

**Request Body:**
```json
{
    "title": "Belajar Laravel - Updated",
    "description": "Updated description",
    "id_status": 2
}
```

**Validation Rules:**
- `title`: required, string, max 255 characters
- `description`: optional, string
- `id_status`: required, integer, must exist in master_status table (1, 2, or 3)

**Description:** Update task berdasarkan ID. User hanya bisa update task yang dimilikinya sendiri.

**Response Success (200):**
```json
{
    "success": true,
    "message": "Task berhasil diupdate.",
    "data": {
        "id_task": "622f27ca-ee2b-4578-af1d-c99f3ad6218d",
        "title": "Belajar Laravel - Updated",
        "description": "Updated description",
        "id_status": 2,
        "created_at": "2026-03-04T16:31:31.000000Z",
        "updated_at": "2026-03-04T17:30:00.000000Z"
    }
}
```

**Response Error (404):**
```json
{
    "success": false,
    "message": "Task tidak ditemukan."
}
```

**Response Error (422):**
```json
{
    "success": false,
    "message": "Validation errors",
    "errors": {
        "title": ["Judul wajib diisi."],
        "id_status": ["Status yang dipilih tidak valid."]
    }
}
```

---

### 5. Delete Task

**DELETE** `/api/tasks/{id_task}`

**Authentication:** ✅ Required

**Request Body:** None

**Parameters:**
- `id_task`: UUID of the task

**Description:** Hapus task berdasarkan ID. User hanya bisa menghapus task yang dimilikinya sendiri.

**Response Success (200):**
```json
{
    "success": true,
    "message": "Task berhasil dihapus."
}
```

**Response Error (404):**
```json
{
    "success": false,
    "message": "Task tidak ditemukan."
}
```

---

## 📊 Status Codes

| Code | Description |
|------|-------------|
| 200 | OK - Request successful |
| 201 | Created - Resource created successfully |
| 401 | Unauthorized - Invalid or missing token |
| 404 | Not Found - Resource not found |
| 422 | Unprocessable Entity - Validation errors |
| 500 | Internal Server Error - Server error |

---

## 🎯 Master Status Reference

| ID | Name | Description |
|----|------|-------------|
| 1 | Pending | Task yang belum dikerjakan |
| 2 | Progress | Task yang sedang dikerjakan |
| 3 | Done | Task yang sudah selesai |

---

## 💡 Notes

- Task hanya bisa diakses oleh pemiliknya (user isolation)
- Password harus minimal 8 karakter yang mengandung huruf besar, kecil, angka, dan simbol
- Email harus unique dalam sistem

---
