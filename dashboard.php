<?php

include 'db.php';

// Total Products
$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$count_data = mysqli_fetch_assoc($count_query);
$total_products = $count_data['total'];

// Latest Products
$products = mysqli_query(
    $conn,
    "SELECT * FROM products ORDER BY id DESC LIMIT 10"
);
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<title>Electro Shop Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f4f6f9;
}

/* Sidebar */

.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#111827,#1f2937);
    color:white;
    box-shadow:4px 0 15px rgba(0,0,0,.1);
}

.sidebar h2{
    text-align:center;
    padding:25px;
    font-size:24px;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.sidebar a{
    display:block;
    color:#d1d5db;
    text-decoration:none;
    padding:15px 25px;
    transition:.3s;
}

.sidebar a:hover{
    background:#374151;
    color:white;
    padding-left:35px;
}

/* Main */

.main{
    margin-left:260px;
}

/* Header */

.header{
    background:white;
    padding:20px 30px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.header h1{
    color:#333;
}

/* Cards */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
    padding:30px;
}

.card{
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    transition:.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card:nth-child(1){
    border-left:5px solid #3b82f6;
}

.card:nth-child(2){
    border-left:5px solid #10b981;
}

.card:nth-child(3){
    border-left:5px solid #f59e0b;
}

.card:nth-child(4){
    border-left:5px solid #ef4444;
}

.card h3{
    color:#666;
    margin-bottom:10px;
}

.card .number{
    font-size:38px;
    font-weight:bold;
}

/* Table */

.table-container{
    padding:0 30px 30px;
}

.table-box{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.table-header{
    background:#ff6b00;
    color:white;
    padding:18px;
    font-size:20px;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f9fafb;
}

table th,
table td{
    padding:15px;
    border-bottom:1px solid #eee;
    text-align:center;
}

table tr:hover{
    background:#f9fafb;
}

table img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:10px;
}

.btn{
    padding:8px 14px;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-size:14px;
}

.edit{
    background:#f59e0b;
}

.delete{
    background:#ef4444;
}

/* Responsive */

@media(max-width:768px){

    .sidebar{
        position:relative;
        width:100%;
        height:auto;
    }

    .main{
        margin-left:0;
    }

    .cards{
        grid-template-columns:1fr;
    }

    table{
        font-size:13px;
    }

    table img{
        width:50px;
        height:50px;
    }
}

</style>

</head>
<body>

<div class="sidebar">


<h2>⚡ Electro Shop</h2>

<a href="dashboard.php">🏠 Dashboard</a>
<a href="products.php">📦 Products</a>
<a href="insert_product.php">➕ Add Product</a>
<a href="#">🛒 Orders</a>
<a href="#">👥 Customers</a>
<a href="#">📊 Reports</a>
<a href="#">⚙ Settings</a>


</div>

<div class="main">


<div class="header">
    <h1>Admin Dashboard</h1>
</div>

<div class="cards">

    <div class="card">
        <h3>Total Products</h3>
        <div class="number"><?= $total_products ?></div>
    </div>

    <div class="card">
        <h3>Total Orders</h3>
        <div class="number">0</div>
    </div>

    <div class="card">
        <h3>Total Customers</h3>
        <div class="number">0</div>
    </div>

    <div class="card">
        <h3>Total Revenue</h3>
        <div class="number">$0</div>
    </div>

</div>

<div class="table-container">
    <button class="btn btn-primary text-light" p-3 m-3><a href="insert_product.php" class="text-light list-none">Add product</a></button>

    <div class="table-box">

        <div class="table-header">
            Latest Products
        </div>

        <table>

            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($products)){ ?>

            <tr>

                <td><?= $row['id'] ?></td>

                <td>
                    <img src="<?= $row['img'] ?>" alt="">
                </td>

                <td><?= $row['name'] ?></td>

                <td>
                    $<?= number_format($row['price'],2) ?>
                </td>

                <td><?= $row['des'] ?></td>

                <td><?= $row['created_at'] ?></td>

                <td>

                    <a class="btn edit"
                    href="edit.php?id=<?= $row['id'] ?>">
                        Edit
                    </a>

                    <a class="btn delete"
                    href="delete.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Delete Product?')">
                        Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>


</div>

</body>
</html>
