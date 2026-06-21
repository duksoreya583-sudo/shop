<?php
include 'db.php';

// ទាញទិន្នន័យពី Database សម្រាប់ផ្នែកខាងលើបង្អស់ (Our Story)
$about_query = mysqli_query($conn, "SELECT * FROM about_story WHERE id=1");
$about_story = mysqli_fetch_assoc($about_query);

// ទាញទិន្នន័យពី Database សម្រាប់ផ្នែក Cards
$cards_query = mysqli_query($conn, "SELECT * FROM about_cards ORDER BY id ASC");
?>
<!--តើត្រូវថែមអីគេដើម្បីអាចដាក់cardបានច្រើនទៀត -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - DSR_SHOP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Global Styles & Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fff5eb 0%, #ffe3cc 50%, #ffd2b3 100%);
            background-attachment: fixed;
            color: #333;
            line-height: 1.7;
            overflow-x: hidden; /* ការពារកុំឱ្យធ្លាយអេក្រង់ទៅឆ្វេងស្តាំ */
        }

        /* NAVBAR Style */
        .header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #222;
            letter-spacing: 1px;
        }

        .menu a {
            text-decoration: none;
            color: #444;
            font-weight: 600;
            margin-left: 25px;
            transition: 0.3s;
            font-size: 15px;
        }

        .menu a:hover {
            color: #ff6b00;
        }

        /* Container សម្រាប់ផ្ទុកមាតិកាទូទៅ */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ======= ផ្នែក OUR STORY បែបពេញអេក្រង់ (FULL WIDTH SECTION) ======= */
        .story-section-wrapper {
            background: #ffffff;
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            padding: 80px 10%;
            margin-bottom: 60px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.03);
        }

        .story-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .story-text {
            flex: 1;
        }

        .story-text h2 {
            font-size: 2.8rem;
            margin-bottom: 25px;
            color: #111;
            font-weight: 800;
            position: relative;
            display: inline-block;
        }

        /* បន្ថែមបន្ទាត់ពីក្រោមចំណងជើងឱ្យមើលទៅស្អាត */
        .story-text h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 60px;
            height: 4px;
            background: #ff6b00;
            border-radius: 2px;
        }

        .story-text p {
            color: #555;
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: justify;
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .story-img {
            flex: 1;
            text-align: center;
        }

        .story-img img {
            width: 100%;
            max-width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transition: transform 0.5s ease;
        }

        .story-img img:hover {
            transform: scale(1.02);
        }

        /* ======= ផ្នែក VALUES SECTION ======= */
        .values-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .value-card {
            background: rgba(255, 255, 255, 0.7);
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-5px);
            background: #ffffff;
        }

        .value-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .value-card h3 {
            font-size: 1.4rem;
            color: #222;
            margin-bottom: 15px;
        }

        .value-card p {
            color: #666;
            font-size: 0.95rem;
        }

        /* ======= ផ្នែក STATS SECTION ======= */
        .stats-section {
            background: #222;
            color: #fff;
            padding: 50px 20px;
            text-align: center;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            border-radius: 20px;
            margin-bottom: 60px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .stat-item h4 {
            font-size: 2.5rem;
            color: #ff6b00;
            margin-bottom: 5px;
        }

        .stat-item p {
            font-size: 1rem;
            color: #ccc;
            letter-spacing: 1px;
        }

        /* ======= ផ្នែក CALL TO ACTION (CTA) ======= */
        .about-cta {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1468495244123-6c6c332eeece?ixlib=rb-4.0.3') center/cover no-repeat;
            color: #fff;
            padding: 80px 20px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 60px;
        }

        .about-cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .about-cta p {
            font-size: 1.1rem;
            color: #ddd;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .about-cta .cta-btn {
            display: inline-block;
            background: #ff6b00;
            color: #fff;
            padding: 14px 35px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 30px;
            transition: 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 107, 0, 0.4);
        }

        .about-cta .cta-btn:hover {
            background: #e65c00;
            transform: translateY(-2px);
        }

        /* ======= RESPONSIVE DESIGN (សម្រាប់ទូរស័ព្ទ) ======= */
        @media (max-width: 992px) {
            .header {
                padding: 15px 5%;
            }
            .story-container {
                flex-direction: column-reverse;
                gap: 30px;
            }
            .story-section-wrapper {
                padding: 50px 5%;
            }
            .story-img img {
                height: 320px;
            }
            .story-text h2 {
                font-size: 2.2rem;
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
            <a href="About.php">ABOUT</a>
            <a href="contact.php">CONTACT</a>
        </div>
    </div>

    <section class="story-section-wrapper">
        <div class="story-container">
            <div class="story-text">
                <h2><?= htmlspecialchars($about_story['title'] ?? 'Our Story'); ?></h2>
                <p><?= nl2br(htmlspecialchars($about_story['description1'] ?? 'No description available for the first section yet.')); ?></p>
                <p><?= nl2br(htmlspecialchars($about_story['description2'] ?? 'No description available for the second section yet.')); ?></p>
            </div>
            <div class="story-img">
                <?php if(!empty($about_story['img_path']) && file_exists($about_story['img_path'])): ?>
                    <img src="<?= htmlspecialchars($about_story['img_path']); ?>" alt="Our Story Image">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1468495244123-6c6c332eeece?ixlib=rb-4.0.3" alt="Default Store Image">
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="container">
        
        <section class="values-section">
            <?php 
            if(mysqli_num_rows($cards_query) > 0) {
                while($card = mysqli_fetch_assoc($cards_query)) {
            ?>
                    <div class="value-card">
                        <div class="value-icon"><?= htmlspecialchars($card['icon']); ?></div>
                        <h3><?= htmlspecialchars($card['title']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($card['description'])); ?></p>
                    </div>
            <?php 
                }
            } else {
                echo "<p style='text-align:center; grid-column: 1/-1;'>No cards found.</p>";
            }
            ?>
        </section>

        <section class="stats-section">
            <div class="stat-item">
                <h4>5K+</h4>
                <p>Happy Customers</p>
            </div>
            <div class="stat-item">
                <h4>100%</h4>
                <p>Original Products</p>
            </div>
            <div class="stat-item">
                <h4>24/7</h4>
                <p>Customer Support</p>
            </div>
        </section>

        <section class="about-cta">
            <h2>Ready to Upgrade Your Smartphone?</h2>
            <p>Visit our online store now to unlock exclusive deals, premium discounts, and exciting free gifts with your purchase!</p>
            <a href="shop.php" class="cta-btn">Shop Now</a>
        </section>

    </div>

</body>
</html>