# Moradix Blog  
A simple dynamic blog built with **PHP OOP** and **JSON Database**

This project is a fully dynamic blog system created without using traditional databases such as MySQL.  
All data including users, posts, and settings are stored inside **JSON files**.

The project is built using **Object-Oriented Programming**, featuring a full admin panel, validation system, authentication, search, categories, and more.

---

## 🚀 Features

### 🧑‍💻 User Side
- View all published posts  
- Category filtering: Scientific, Technology, Research, Design  
- Search by title and content  
- "Top Posts" based on views  
- "Last Posts" based on publish date  
- Single post page with image, content, date, and views  

---

### 🔐 Admin Panel
- Secure login system  
- Display posts list (ID, Title, Views, Date, Actions)  
- Create new posts (title, category, content, image)  
- Edit and delete posts  
- Display admin name in header  
- Logout  

---

## 🧱 Technologies
- PHP 8+  
- Full OOP structure  
- Composer Autoload  
- JSON-based storage  
- Pure HTML & CSS  
- No JavaScript
- no mvc
- Custom template system  

---

## 📂 Folder Structure
```
├── assets
│ ├── css
│ └── images
├── database
├── src
│ ├── Classes
│ ├── Entities
│ ├── Exceptions
│ ├── Models
│ └── Templates
├── vendor
├── composer.json
└── index.php
```

---



▶️ How to Run

- git clone``` https://github.com/YourUser/YourRepo.git ```
- composer install
- ``` php -S localhost:8000 ```
- ``` http://localhost:8000/index.php ```

---


🎯 Project Purpose
This project was created to learn:

OOP in PHP

JSON storage instead of a database

Authentication & validation

CRUD operations

Understanding structure before learning MVC
