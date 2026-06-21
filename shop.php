<?php

include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 1000");
$about_query = mysqli_query($conn, "SELECT * FROM about_story WHERE id=1");
$about_story = mysqli_fetch_assoc($about_query);

// គណនាចំនួនទំនិញសរុបនៅក្នុងកន្ត្រក ដើម្បីបង្ហាញនៅលើ Badge នៃ Navbar
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $cart_count += $qty;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI', Arial, sans-serif;
        }

        body{
            background: linear-gradient(135deg, #fff5eb 0%, #ffe3cc 50%, #ffd2b3 100%);
            background-attachment: fixed; 
            color: #333;
        }

        .header{
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(12px);          
            -webkit-backdrop-filter: blur(12px);
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;                                     
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 122, 0, 0.15); 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .logo{
            color: #111111; 
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .menu a{
            color: #333333; 
            text-decoration: none;
            margin-left: 25px;
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s ease;
        }

        .menu a:hover{
            color: #ff7a00; 
        }

        /* បន្ថែមរចនាបថ Badge លើកន្ត្រកទំនិញ */
        .cart-badge {
            background: #ff7a00;
            color: white;
            padding: 2px 7px;
            border-radius: 50%;
            font-size: 12px;
            margin-left: 4px;
            font-weight: bold;
        }

        .title{
            text-align:center;
            padding:60px 20px 20px;
        }

        .title h1{
            font-size:36px;
            color:#222;
            font-weight: 800;
        }

        .title p{
            color:#666;
            margin-top:10px;
            font-size: 15px;
        }

        .products{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 30px;
            padding: 40px 10%; 
        }

        .card{
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px; 
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .card:hover{
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px rgba(255, 122, 0, 0.12); 
        }

        .img-container {
            overflow: hidden;
            width: 100%;
            height: 220px; 
            background: #fff;
        }

        .card img{
            width:100%;
            height:100%;
            object-fit:cover;
            transition: transform 0.6s ease;
        }

        .card:hover .img-container img {
            transform: scale(1.05);
        }

        .card-content{
            padding: 20px; 
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-content h3{
            margin-bottom: 8px;
            color: #111;
            font-size: 18px; 
            font-weight: 700;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .description{
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price{
            color: #ff7a00;
            font-size: 22px; 
            font-weight: 800;
            margin-bottom: 15px;
        }

        .btn{
            display:block;
            text-align: center;
            background: #ff7a00;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.2);
            transition: 0.3s ease;
        }

        .btn:hover{
            background: #e56d00;
            box-shadow: 0 6px 20px rgba(255, 122, 0, 0.35);
        }

        .footer{
            background: rgba(34, 34, 34, 0.95);
            color:white;
            text-align:center;
            padding:25px;
            margin-top:60px;
            backdrop-filter: blur(5px);
        }

        @media(max-width:768px){
            .header{
                flex-direction:column;
                padding: 15px 20px;
            }
            .menu{
                margin-top:15px;
            }
            .products{
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); 
                padding: 20px 5%;
                gap: 20px;
            }
            .img-container {
                height: 200px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">DSR_SHOP</div>
    <div class="menu">
        <a href="index.php">HOME</a>
        <a href="shop.php">SHOP</a>
        <a href="card.php">CART <span class="cart-badge"><?php echo $cart_count; ?></span></a>
        <a href="About.php">ABOUT</a>
        <a href="contact.php font-weight:bold;">CONTACT</a>
    </div>
</div>

<div class="title">
    <h1>Our Products</h1>
    <p>Latest electronic products collection</p>
</div>

<div class="products">
<?php while($product = mysqli_fetch_assoc($result)){ ?>
    <div class="card">
        <div class="img-container">
            <img src="<?php echo $product['img']; ?>" alt="Product Image">
        </div>
        <div class="card-content">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="description"><?php echo htmlspecialchars($product['des']); ?></p>
            <div class="price">$<?php echo number_format($product['price'], 2); ?></div>
            <a href="cart.php?id=<?php echo $product['id']; ?>" class="btn">Add To Cart</a>
        </div>
    </div>
<?php } ?>
</div>

<div class="footer">
    <p>© 2026 DSR_SHOP. All Rights Reserved.</p>
</div>

</body>
</html>