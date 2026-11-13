[task_management_api_documentation.md](https://github.com/user-attachments/files/34803553/task_management_api_documentation.md)
# 📋 Task Management API (Laravel)

A robust and RESTful Task Management API built with **Laravel** and secured using **Laravel Sanctum**. This backend service allows users to register, manage their profiles, organize tasks into categories, mark favorite tasks, and filter or sort their workload efficiently.

---

## 🚀 Features

- **Authentication & Authorization**: Secure user registration, login, and logout powered by **Laravel Sanctum** (Bearer Token).
- **User & Profile Management**: Complete CRUD operations for user profiles and user-specific task/profile retrieval.
- **Task Management**: Create, read, update, and delete tasks with custom ordering and administrative global view (`checkUser` middleware).
- **Categorization System**: Organize tasks by assigning multiple categories to tasks and filtering tasks by category.
- **Favorites System**: Easily bookmark/unbookmark important tasks and retrieve a dedicated list of favorite tasks.
- **Ready-to-Use API Collection**: Pre-configured **Thunder Client** collection included for instant testing.

---

## 🛠️ Tech Stack

- **Framework**: Laravel (PHP)
- **Authentication**: Laravel Sanctum
- **Database**: MySQL / PostgreSQL / SQLite
- **API Testing**: Thunder Client (VS Code Extension)

---

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Environment Configuration:**
   Copy the example environment file and configure your database credentials:
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Run Database Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Start the Development Server:**
   ```bash
   php artisan serve
   ```
   The API will be available at: `http://127.0.0.1:8000/api`

---

## 🧪 Testing with Thunder Client

This repository includes a complete **Thunder Client** collection containing pre-configured requests for every endpoint.

1. Open the project in **VS Code**.
2. Install the **Thunder Client** extension if you haven't already.
3. Navigate to the Thunder Client tab -> **Collections** -> **Import**.
4. Select the `thunder-collection_tasks-api.json` file located in the root (or `/docs`) directory of this project.
5. **Authentication Setup**:
   - Run the `Login` request to receive your `access_token`.
   - Copy the token and set it in your Thunder Client Environment variable (`{{token}}`) or paste it directly under the **Auth -> Bearer** tab for protected routes.

> **⚠️ Security Note:** Make sure to remove any personal tokens, real passwords, or local `.env` secrets before exporting and committing your Thunder Client JSON file to GitHub.

---

## 📚 API Endpoints Reference

**Base URL:** `/api`  
**Required Headers for Protected Routes:**
```http
Accept: application/json
Authorization: Bearer <your_sanctum_token>
```

### 1. Health Check
| Method | Endpoint | Auth | Description |
| :--- | :--- | :---: | :--- |
| `GET` | `/welcome to api` | ❌ | Check if the API service is running |

---

### 2. Authentication & Users
| Method | Endpoint | Auth | Description |
| :--- | :--- | :---: | :--- |
| `POST` | `/register` | ❌ | Register a new user account |
| `POST` | `/login` | ❌ | Authenticate user and retrieve Sanctum token |
| `POST` | `/logout` | ✅ | Revoke current user access token |
| `GET` | `/user` | ✅ | Get currently authenticated user details |
| `GET` | `/users` | ❌ | List all users |
| `POST` | `/users` | ❌ | Create a new user |
| `GET` | `/users/{id}` | ❌ | Get specific user details |
| `PUT/PATCH` | `/users/{id}` | ❌ | Update specific user |
| `DELETE` | `/users/{id}` | ❌ | Delete specific user |
| `GET` | `/user/{id}/profile` | ❌ | Get the profile associated with a specific user |
| `GET` | `/user/{id}/tasks` | ❌ | Get all tasks belonging to a specific user |

---

### 3. Profiles *(Protected)*
| Method | Endpoint | Auth | Description |
| :--- | :--- | :---: | :--- |
| `GET` | `/profile` | ✅ | Retrieve profiles |
| `POST` | `/profile` | ✅ | Create a user profile |
| `GET` | `/profile/{id}` | ✅ | View a specific profile |
| `PUT/PATCH` | `/profile/{id}` | ✅ | Update a specific profile |
| `DELETE` | `/profile/{id}` | ✅ | Delete a specific profile |

---

### 4. Tasks *(Protected)*
| Method | Endpoint | Auth | Description |
| :--- | :--- | :---: | :--- |
| `GET` | `/tasks` | ✅ | Get all tasks for the authenticated user |
| `POST` | `/tasks` | ✅ | Create a new task |
| `GET` | `/tasks/{id}` | ✅ | Get details of a specific task |
| `PUT/PATCH` | `/tasks/{id}` | ✅ | Update an existing task |
| `DELETE` | `/tasks/{id}` | ✅ | Delete a task |
| `GET` | `/tasks/all` | ✅ | Get all tasks across system *(Requires `checkUser` middleware)* |
| `GET` | `/tasks/ordered` | ✅ | Get tasks sorted in a specific order |
| `GET` | `/tasks/{id}/user` | ✅ | Get the creator/owner of a specific task |

---

### 5. Task Favorites *(Protected)*
| Method | Endpoint | Auth | Description |
| :--- | :--- | :---: | :--- |
| `GET` | `/tasks/favorites` | ✅ | List all tasks marked as favorite |
| `POST` | `/tasks/{id}/favorite` | ✅ | Add a task to favorites |
| `DELETE` | `/tasks/{id}/favorite` | ✅ | Remove a task from favorites |

---

### 6. Categories & Task Relations *(Protected)*
| Method | Endpoint | Auth | Description |
| :--- | :--- | :---: | :--- |
| `GET` | `/categories` | ✅ | List all categories |
| `POST` | `/categories` | ✅ | Create a new category |
| `GET` | `/categories/{id}` | ✅ | Get details of a specific category |
| `PUT/PATCH` | `/categories/{id}` | ✅ | Update a category |
| `DELETE` | `/categories/{id}` | ✅ | Delete a category |
| `POST` | `/tasks/{taskId}/categories` | ✅ | Attach categories to a specific task |
| `GET` | `/tasks/{tasksId}/categories` | ✅ | Get all categories assigned to a specific task |
| `GET` | `/categories/{categoryId}/tasks` | ✅ | Get all tasks under a specific category |

---

## 💡 Developer Notes & Best Practices

1. **Route Ordering Tip in `api.php`:**
   In Laravel, static routes like `GET /tasks/favorites` should be placed **above** `Route::apiResource('tasks', TaskController::class)` (you already placed it above—great job!). Otherwise, Laravel will treat the word `"favorites"` as an `{id}` parameter for `tasks/{id}`.
2. **URL Naming:**
   Consider changing `Route::get('welcome to api', ...)` to `Route::get('welcome', ...)` or `Route::get('health', ...)` to avoid spaces (`%20`) in URLs.

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
