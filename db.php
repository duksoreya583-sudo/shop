<?php
$dbhost = 'localhost';
$user = 'root';
$pass = '';
$database = 'online_shop';

try {
    // Connection to MySQL
    $conn = new mysqli($dbhost, $user, $pass);
    if (!$conn) {
        die('Fail ' . mysqli_connect_error());
    }

    // Create database if not exists
    $create_db = "CREATE DATABASE IF NOT EXISTS $database";
    if (mysqli_query($conn, $create_db)) {
        $message = "successfully";
    } else {
        $message = "create database fail";
    }

    // Use database
    mysqli_select_db($conn, $database);

    // Create table products (តារាងផ្ទុកផលិតផល)
    $create_table = "CREATE TABLE IF NOT EXISTS products(
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        des TEXT,
        img VARCHAR(255),
        price DECIMAL(10,2) DEFAULT 0.00,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );";
    mysqli_query($conn, $create_table);

    // បញ្ចូលទិន្នន័យគំរូផលិតផល ប្រសិនបើមិនទាន់មានសោះ
    $check_products_empty = mysqli_query($conn, "SELECT * FROM products LIMIT 1");
    if (mysqli_num_rows($check_products_empty) == 0) {
        $insert_products = "INSERT INTO products (name, price, img, des) VALUES
        ('iPhone 15 Pro', 999.00, 'iphone.jpg', 'Latest Apple iPhone with Titanium design.'),
        ('Samsung Galaxy S24', 899.00, 'samsung.jpg', 'Flagship AI smartphone from Samsung.'),
        ('MacBook Air M3', 1199.00, 'macbook.jpg', 'Thin and light laptop with M3 chip.');";
        mysqli_query($conn, $insert_products);
    }

    // Create table slides
    $create_slides_table = "CREATE TABLE IF NOT EXISTS slides (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        sub_title TEXT,
        file_path VARCHAR(255) NOT NULL,
        file_type VARCHAR(50) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );";
    mysqli_query($conn, $create_slides_table);

    // Create table about_story
    $create_about_table = "CREATE TABLE IF NOT EXISTS about_story (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description1 TEXT,
        description2 TEXT,
        img_path VARCHAR(255) NOT NULL,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";
    mysqli_query($conn, $create_about_table);
    
    // បង្កើតតារាង about_cards
    $create_cards_table = "CREATE TABLE IF NOT EXISTS `about_cards` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `icon` VARCHAR(50) NOT NULL,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    mysqli_query($conn, $create_cards_table);

    // ពិនិត្យមើលថាតើមានទិន្នន័យក្នុង about_cards ហើយឬនៅ ដើម្បីកុំអោយវាទុបប្លិក (Duplicate)
    $check_cards_empty = mysqli_query($conn, "SELECT * FROM `about_cards` LIMIT 1");
    if (mysqli_num_rows($check_cards_empty) == 0) {
        $insert_cards = "INSERT INTO `about_cards` (`icon`, `title`, `description`) VALUES
        ('💎', 'High Quality', 'Every electronic product and smartphone undergoes rigorous quality checks to guarantee 100% authentic and premium products.'),
        ('🤝', 'Trusted Service', 'We offer competitive prices, high reliability, and absolute honesty, ensuring a worry-free shopping experience with no hidden costs.'),
        ('🛡️', 'Excellent Warranty', 'Enjoy clear official manufacturer warranties alongside dedicated maintenance and support from our expert technical team.'),
        ('🚀', 'Fast Delivery', 'Fast, reliable, and secure delivery service right to your doorstep, covering all 25 provinces and cities nationwide.');";
        mysqli_query($conn, $insert_cards);
    }

    // បញ្ចូលទិន្នន័យគំរូដំបូងបង្អស់សម្រាប់ about_story ប្រសិនបើមិនទាន់មានទិន្នន័យទាល់តែសោះ (សម្រាប់តែ ID=1)
    $check_empty = mysqli_query($conn, "SELECT * FROM about_story WHERE id=1");
    if(mysqli_num_rows($check_empty) == 0){
        mysqli_query($conn, "INSERT INTO about_story (id, title, description1, description2, img_path) 
        VALUES (1, 'Our Story', 'ការពិពណ៌នាទី១...', 'ការពិពណ៌នាទី២...', 'About_card-top/default.jpg')");
    }
    // Create table for general orders
$create_orders_table = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_amount DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);";
mysqli_query($conn, $create_orders_table);

// Create table for specific order items
$create_order_items_table = "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);";
mysqli_query($conn, $create_order_items_table);

// user
// បង្កើតតារាងសម្រាប់រក្សាទុកព័ត៌មានគណនីអ្នកប្រើប្រាស់ (Users Table)
$create_users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);";
mysqli_query($conn, $create_users_table);

} catch (\Throwable $th) {
    die('fail ' . $th);
}
?>