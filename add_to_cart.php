<?php
session_start();

// ពិនិត្យមើលថាតើមានការបញ្ជូន ID របស់ផលិតផលមកឬទេ
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // ប្រសិនបើមិនទាន់មានកន្ត្រកទិញ (Cart) ទេ ត្រូវបង្កើតវាជា Array ទទេមួយ
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // ប្រសិនបើផលិតផលនេះមានក្នុងកន្ត្រកហើយ ត្រូវថែមចំនួន (Quantity) + 1
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        // ប្រសិនបើមិនទាន់មានទេ គឺកំណត់ចំនួនស្មើ ១
        $_SESSION['cart'][$product_id] = 1;
    }
}

// នៅពេលថែមចូលកន្ត្រកជោគជ័យ ឱ្យវាត្រឡប់ទៅទំព័រ shop.php វិញ
header("Location: shop.php");
exit();
?>
<h1>hello</h1>