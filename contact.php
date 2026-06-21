<?php
$message = "";

if(isset($_POST['send'])){
    $message = "Thank you! Your message has been sent successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body{
    background: #ffe2cc; 
    color:#333;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* ==========================================
   HEADER / NAVBAR (ប្តូរទៅជាពណ៌ស និង អក្សរខ្មៅ)
   ========================================== */
header{
    background: rgba(255, 255, 255, 0.85); /* ពណ៌សរថ្លា */
    backdrop-filter: blur(10px);          /* បន្ថែមព្រាលផ្ទៃខាងក្រោយឱ្យកាន់តែស្អាត */
    -webkit-backdrop-filter: blur(10px);
    color: #111827; 
    padding:15px 8%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:sticky;
    top:0;
    z-index:1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
}

.logo{
    font-size:30px;
    font-weight:bold;
    color: #ff6b00; /* រក្សាពណ៌ទឹកក្រូចដើម្បីជាចំណុចទាក់ទាញ */
}

nav a{
    color: #111827; /* ប្តូរពណ៌អក្សរ Menu ទៅជាពណ៌ខ្មៅទាំងអស់ */
    text-decoration:none;
    margin-left:20px;
    font-weight:600;
    transition:.3s;
}

nav a:hover{
    color: #ff6b00; /* ពេលយកម៉ៅដាក់ពីលើចេញពណ៌ទឹកក្រូច */
}

/* CONTAINER */
.wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

/* Contact Section Grid */
.contact-section{
    max-width: 1100px;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

/* ==========================================
   CARD ខាងឆ្វេង: CONTACT INFO (លេងពណ៌ពន្លឺព្រះអាទិត្យ)
   ========================================== */
.contact-info{
    background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 50%, #ff6b00 100%);
    padding: 40px;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.contact-info h2{
    color: #fff;
    font-size: 28px;
    margin-bottom: 15px;
    position: relative;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* បន្ទាត់តូចពីក្រោមចំណងជើង */
.contact-info h2::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 50px;
    height: 3px;
    background-color: #fff;
    border-radius: 2px;
}

.contact-info p{
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 35px;
    line-height: 1.6;
    font-size: 15px;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.contact-info .item{
    display: flex;
    align-items: center;
    gap: 15px;
}

/* លេងស្ទាយរង្វង់ជុំវិញ Icon */
.contact-info .item .icon-box {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.25);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    flex-shrink: 0;
    transition: 0.3s;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.contact-info .item:hover .icon-box {
    background: #fff;
    color: #ff6b00;
    transform: scale(1.1);
}

.contact-info .item .details {
    font-size: 15px;
    line-height: 1.4;
    text-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.contact-info .item strong{
    color: #fff;
    display: block;
    margin-bottom: 2px;
}

/* ==========================================
   CARD ខាងស្តាំ: CONTACT FORM
   ========================================== */
.contact-form{
    background: #ffffff;
    padding: 40px;
}

.contact-form h2{
    font-size: 28px;
    margin-bottom: 25px;
    color: #222;
}

.input-group {
    position: relative;
    margin-bottom: 20px;
}

input,
textarea{
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e1e1e1;
    border-radius: 8px;
    background: #f9f9f9;
    font-size: 15px;
    transition: all 0.3s ease;
}

textarea{
    height: 130px;
    resize: none;
}

input:focus,
textarea:focus{
    outline: none;
    border-color: #ff6b00;
    background: #fff;
    box-shadow: 0 0 10px rgba(255, 107, 0, 0.15);
}

button{
    width: 100%;
    padding: 14px;
    border: none;
    background: #ff6b00;
    color: white;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
    transition: all 0.3s ease;
}

button:hover{
    background: #e55f00;
    box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
    transform: translateY(-2px);
}

button:active {
    transform: translateY(0);
}

.success{
    background: #d4edda;
    color: #155724;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 8px;
    border-left: 5px solid #28a745;
    font-size: 15px;
}

.footer{
    background:#111827;
    color:white;
    text-align:center;
    padding:20px;
}

/* RESPONSIVE DESIGN */
@media(max-width:850px){
    .contact-section{
        grid-template-columns: 1fr;
    }
    .contact-info {
        gap: 30px;
    }
}
</style>
</head>

<body>

<header>
    <div class="logo">DSR_SHOP</div>
    <nav>
        <a href="index.php">Home</a>
        <a href="shop.php">Shop</a>
        <a href="About.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<div class="wrapper">
    <div class="contact-section">
        
        <div class="contact-info">
            <div>
                <h2>Get In Touch</h2>
                <p>We'd love to hear from you. Send us a message and our team will respond as soon as possible.</p>
            </div>

            <div class="info-list">
                <div class="item">
                    <div class="icon-box"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="details">
                        <strong>Address</strong>
                        Prey Veng, Cambodia
                    </div>
                </div>

                <div class="item">
                    <div class="icon-box"><i class="fa-solid fa-phone"></i></div>
                    <div class="details">
                        <strong>Phone</strong>
                        +855 87 49 72 54
                    </div>
                </div>

                <div class="item">
                    <div class="icon-box"><i class="fa-solid fa-envelope"></i></div>
                    <div class="details">
                        <strong>Email</strong>
                        DSR_SHOP@gmail.com
                    </div>
                </div>

                <div class="item">
                    <div class="icon-box"><i class="fa-solid fa-clock"></i></div>
                    <div class="details">
                        <strong>Working Hours</strong>
                        Monday - Saturday<br>8:00 AM - 6:00 PM
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-form">
            <h2>Send Message</h2>

            <?php if($message != ""){ ?>
                <div class="success">
                    <i class="fa-solid fa-circle-check"></i> <?= $message ?>
                </div>
            <?php } ?>

            <form method="POST">
                <div class="input-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="input-group">
                    <input type="text" name="subject" placeholder="Subject" required>
                </div>
                <div class="input-group">
                    <textarea name="message" placeholder="Write your message..." required></textarea>
                </div>
                <button type="submit" name="send">Send Message</button>
            </form>
        </div>

    </div>
</div>

<div class="footer">
    © 2026 DSR_SHOP. All Rights Reserved.
</div>

</body>
</html>