# 🍕 Pizza Order Management Website

This project is a **Pizza Order Management System** built using **Laravel Framework** with a **MySQL database**.  
The frontend is developed using **HTML, CSS, Bootstrap, and JavaScript**, providing a responsive and user-friendly interface for customers and administrators.

---

## 🌟 Features
- 🍕 Browse and order pizzas online  
- 🧾 Add to cart and checkout system  
- 👩‍💼 Admin panel for managing pizza items and customer orders  
- 🔐 User authentication (login/register)  
- 💾 Order data stored in MySQL database  
- 📱 Fully responsive design using Bootstrap  
- ⚙️ Simple and clean UI for both users and admins  

---

## 🛠️ Technologies Used
- **Backend:** Laravel (PHP Framework)  
- **Frontend:** HTML5, CSS3, Bootstrap, JavaScript  
- **Database:** MySQL  

---

## ⚙️ Installation & Setup

### Step 1: Clone the repository
```bash
git clone https://github.com/MgKhai/pizza-order-management-system.git
cd pizza-order-website
```
### Step 2: Install dependencies
```bash
composer install
npm install
```

### Step 3: Configure the .env file
Copy .env.example to .env and update the database information:
```bash
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### Step 4: Generate key and migrate tables
```bash
php artisan key:generate
php artisan migrate --seed
```

### Step 5: Run the project
```bash
php artisan serve
```

### Default Admin Login
- email    : superadmin@gmail.com
- password : admin123456

