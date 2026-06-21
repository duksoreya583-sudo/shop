<footer class="footer">
    <div class="footer-container">

        <div class="footer-box">
            <h2>DRS_SHOP</h2>
            <p>
                DRS_SHOP is an online shopping website and the exclusive importer of iPhones, offering a wide range of electronics, smartphones, laptops, cameras, and accessories
            </p>
        </div>

        <div class="footer-box">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="shop.php">SHOP</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>

        <div class="footer-box">
            <h3>Categories</h3>
            <ul>
                <li><a href="#">LABTOP</a></li>
                <li><a href="#">SMART PHONE</a></li>
                <li><a href="#">CAMERA</a></li>
                <li><a href="#">ACCESSORIES</a></li>
            </ul>
        </div>

        <div class="footer-box">
            <h3>Contact Us</h3>
            <p>Email: DRS_SHOP@gmail.com</p>
            <p>Phone: +855 87 497254</p>
            <p>Address: PREY VENG, Cambodia</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© <?php echo date("Y"); ?> DRS_SHOP. All Rights Reserved.</p>
    </div>
</footer>

<style>
.footer{
    /* កែ background ឱ្យដូចពណ៌ដំបូល Navbar ខាងលើ (Cream/Light Yellow) */
    background: #fffdf0; 
    /* កែពណ៌អក្សរទូទៅទៅជាពណ៌ខ្មៅ */
    color: #111111; 
    padding: 50px 20px 0;
    margin-top: 50px;
    border-top: 1px solid #eaeaea; /* បន្ថែមបន្ទាត់កាត់ស្រាលៗនៅផ្នែកខាងលើ footer */
}

.footer-container{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: auto;
}

/* ចំណងជើងធំៗដូរជាពណ៌ខ្មៅដិត */
.footer-box h2,
.footer-box h3{
    margin-bottom: 15px;
    color: #000000;
    font-weight: bold;
}

.footer-box p{
    line-height: 1.8;
    font-size: 14px;
}

.footer-box ul{
    list-style: none;
}

.footer-box ul li{
    margin: 10px 0;
}

/* លីង (Links) ទាំងអស់ដូរជាពណ៌ខ្មៅ */
.footer-box ul li a{
    text-decoration: none;
    color: #222222; 
    transition: 0.3s;
}

/* ពេលយក Mouse ដាក់លើ លីងនឹងដូរជាពណ៌ទឹកក្រូច (ដូចប៊ូតុង Buy Now) */
.footer-box ul li a:hover{
    color: #ff7a00; 
    padding-left: 5px;
}

.footer-bottom{
    text-align: center;
    padding: 20px;
    margin-top: 30px;
    /* ប្តូរពណ៌ខ្សែបន្ទាត់បាតក្រោមទៅជាពណ៌ប្រផេះស្រាល */
    border-top: 1px solid #e5e5e5; 
    font-size: 14px;
    color: #555555;
}

@media(max-width:768px){
    .footer{
        text-align: center;
    }
}
</style>