<?php
include 'db.php';

// ១. ទាញទិន្នន័យ Slide ទាំងអស់ចេញពី Database
$slide_result = mysqli_query($conn, "SELECT * FROM slides ORDER BY id DESC LIMIT 11






");

// ២. ទាញទិន្នន័យផលិតផល
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Electro Shop</title>

    <style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:'Segoe UI',sans-serif;
    }

    body{
        background: linear-gradient(180deg, #fffdf2 0%, #fffbf0 50%, #f7f9fa 100%);
        color:#333;
        min-height: 100vh;
    }

    /* HEADER & NAVBAR */
    header{
        background: linear-gradient(135deg, #fffcf0 0%, #fffde6 50%, #ffffff 100%); 
        color: #222;
        padding:15px 8%;
        display:flex;
        justify-content:space-between;
        align-items:center;
        position:sticky;
        top:0;
        z-index:1000;
        box-shadow: 0 4px 20px rgba(255, 165, 0, 0.12); 
        border-bottom: 1px solid rgba(255, 200, 0, 0.2);
    }

    .logo{
        font-size:30px;
        font-weight:bold;
        color: #000000; 
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }

    nav a{
        color: #444; 
        text-decoration:none;
        margin-left:20px;
        font-weight:600;
        transition:.3s;
    }

    nav a:hover{
        color: #ff6b00; 
    }

    /* ======= MODERN ANIMATED CAROUSEL STYLE ======= */
    .carousel-section {
        max-width: 1200px;
        margin: 40px auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 20px;
        overflow: hidden;
    }

    .carousel-item {
        height: 500px; 
        background: #000; 
        overflow: hidden;
    }

    /* ចលនា Zoom រូបភាព/វីដេអូ តិចៗពេល Slide មកដល់ (Ken Burns Effect) */
    .carousel-item video,
    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover; 
        transform: scale(1);
        transition: transform 3.5s ease-in-out;
    }

    .carousel-item.active video,
    .carousel-item.active img {
        transform: scale(1.08); /* ពង្រីកធំឡើងៗសន្សឹមៗ */
    }

    /* ធ្វើឱ្យ background caption ព្រាលៗបែបកញ្ចក់ (Glassmorphism) */
    .carousel-caption {
        background: rgba(0, 0, 0, 0.45); 
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        padding: 35px;
        border-radius: 15px;
        bottom: 12%;
        max-width: 650px;
        margin: 0 auto;
        border: 1px solid rgba(255, 255, 255, 0.1);
        opacity: 0;
        transform: translateY(30px);
        transition: transform 0.8s ease, opacity 0.8s ease;
    }

    /* នៅពេល Slide សកម្ម ឱ្យអក្សររុញឡើងលើ និងបង្ហាញខ្លួនមកច្បាស់ */
    .carousel-item.active .carousel-caption {
        opacity: 1;
        transform: translateY(0);
    }

    .carousel-caption h5 {
        font-size: 40px;
        font-weight: 800;
        margin-bottom: 12px;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .carousel-caption p {
        font-size: 17px;
        margin-bottom: 20px;
        color: #e0e0e0;
    }

    .carousel-caption .btn-warning {
        background: #ff6b00;
        border: none;
        padding: 10px 25px;
        font-weight: 600;
        border-radius: 30px;
        transition: 0.3s ease;
    }

    .carousel-caption .btn-warning:hover {
        background: #e65c00;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(230, 92, 0, 0.4);
    }

    /* កែទម្រង់ប៊ូតុងឆ្វេងស្តាំឱ្យមូលស្អាត */
    .carousel-control-prev, .carousel-control-next {
        width: 6%;
    }
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.3);
        padding: 20px;
        border-radius: 50%;
        background-size: 50% 50%;
        transition: 0.3s;
    }
    .carousel-control-prev-icon:hover, .carousel-control-next-icon:hover {
        background-color: #ff6b00;
    }

    /* TITLE */
    .section-title{
        text-align:center;
        font-size:36px;
        margin:50px 0 30px;
        color: #222;
        font-weight: 700;
    }

    /* PRODUCTS */
    .products{
        max-width:1200px;
        margin:auto;
        padding:0 20px 60px;
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
        gap:25px;
    }

    .card{
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 220, 150, 0.3);
        border-radius:15px;
        overflow:hidden;
        box-shadow:0 4px 15px rgba(230, 150, 0, 0.06);
        transition:.3s;
        display:flex;
        flex-direction:column;
        backdrop-filter: blur(5px);
    }

    .card:hover{
        transform:translateY(-8px);
        box-shadow: 0 8px 25px rgba(255, 107, 0, 0.15);
        border-color: rgba(255, 107, 0, 0.3);
    }

    .card img{
        width:100%;
        height:250px;
        object-fit:cover;
    }

    .card-content{
        padding:20px;
        display:flex;
        flex-direction:column;
        flex:1;
    }

    .card h3{
        margin-bottom:10px;
        font-size:22px;
        color: #222;
    }

    .price{
        color:#ff6b00;
        font-size:24px;
        font-weight:bold;
        margin-bottom:10px;
    }

    .card p{
        color:#555;
        line-height:1.6;
        flex:1;
    }

    .buy-btn{
        margin-top:20px;
        text-align:center;
        background:#ff6b00;
        color:white;
        text-decoration:none;
        padding:12px;
        border-radius:6px;
        font-weight: 600;
        transition: .3s;
    }

    .buy-btn:hover{
        background:#e65c00;
        box-shadow: 0 4px 12px rgba(230, 92, 0, 0.3);
    }

    /* MOBILE BREAKPOINTS */
    @media(max-width:768px){
        header{
            flex-direction:column;
            gap:10px;
        }

        nav{
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
        }

        .carousel-item {
            height: 350px; 
        }

        .carousel-caption {
            padding: 20px;
            bottom: 5%;
            width: 90%;
        }

        .carousel-caption h5 {
            font-size: 24px;
        }
        
        .carousel-caption p {
            font-size: 14px;
        }
    }
    </style>
</head>
<body>

<header>
    <div class="logo">DSR_SHOP</div>

    <nav>
        <a href="#">Home</a>
        <a href="shop.php">Shop</a>
        <a href="About.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<section class="carousel-section">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-pause="false">
        
        <div class="carousel-inner">
            
            <?php 
            $isFirst = true; 
            
            if($slide_result && mysqli_num_rows($slide_result) > 0) {
                while($slide = mysqli_fetch_assoc($slide_result)){ 
                    $activeClass = $isFirst ? 'active' : '';
                    $isFirst = false;
            ?>
                <div class="carousel-item <?= $activeClass ?>" data-bs-interval="4000"> 
                    
                    <?php if($slide['file_type'] == 'video'){ ?>
                        <video autoplay loop muted playsinline>
                            <source src="<?= $slide['file_path'] ?>" type="video/mp4">
                        </video>
                    <?php } else { ?>
                        <img src="<?= $slide['file_path'] ?>" alt="banner">
                    <?php } ?>

                    <div class="carousel-caption">
                        <h5><?= htmlspecialchars($slide['title']) ?></h5>
                        <p><?= htmlspecialchars($slide['sub_title']) ?></p>
                        <a href="shop.php" class="btn btn-warning text-white">Explore Now</a>
                    </div>
                </div>
            <?php 
                } 
            } else { 
            ?>
                <div class="carousel-item active" data-bs-interval="4000">
                    <img src="https://i.pinimg.com/1200x/4f/8f/b4/4f8fb4c92dabf354bc733a925344e3b8.jpg" alt="default banner">
                    <div class="carousel-caption">
                        <h5>Hello Welcome to DSR_SHOP</h5>
                        <p>Special Promos & Mega Discounts Available Now!</p>
                        <a href="shop.php" class="btn btn-warning text-white">Explore Now</a>
                    </div>
                </div>
            <?php } ?>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<h2 class="section-title">KING OF PRODUCT</h2>

<section class="products">

<?php 
if($result) {
    while($row = mysqli_fetch_assoc($result)){ 
?>
    <div class="card">
        <img src="<?= htmlspecialchars($row['img']) ?>" alt="product">
        <div class="card-content">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
            <div class="price">$<?= number_format($row['price'], 2) ?></div>
            <p><?= htmlspecialchars($row['des']) ?></p>
            <a href="#" class="buy-btn">Buy Now</a>
        </div>
    </div>
<?php 
    }
} 
?>

</section>

<?php include 'include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>