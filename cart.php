<?php
session_start();
include 'db.php';

// ១. មុខងារលុបទំនិញចេញម្ដងមួយៗតាម ID (Remove action)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]); // លុបផលិតផលនោះចេញពី session array
    }
    header("Location: cart.php"); 
    exit();
}

// ២. មុខងារលុបទំនិញទាំងអស់ចោល (Clear Cart)
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']); // លុបកន្ត្រកទំនិញទាំងមូលចោល
    header("Location: cart.php");
    exit();
}

// ៣. មុខងារធ្វើបច្ចុប្បន្នភាពចំនួនទំនិញឡើងចុះ (Update action)
if (isset($_POST['update_cart'])) {
    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $id => $new_qty) {
            $new_qty = intval($new_qty);
            if ($new_qty <= 0) {
                unset($_SESSION['cart'][$id]); // ប្រសិនបើបញ្ចូលលេខ 0 ឬតិចជាងនេះ គឺលុបចេញពីកន្ត្រក
            } else {
                $_SESSION['cart'][$id] = $new_qty; // កំណត់ចំនួនទំនិញថ្មី
            }
        }
    }
    header("Location: cart.php");
    exit();
}

// ៤. ពិនិត្យមើលថាតើមានការបញ្ជូន ID របស់ផលិតផលមកពីទំព័រ shop.php ឬទេ (Add to cart)
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    
    header("Location: cart.php");
    exit();
}

// ៥. មុខងារ Checkout ដំណើរការការបញ្ជាទិញ និងសម្អាតកន្ត្រកទំនិញ (Checkout Action)
if (isset($_POST['checkout_cart'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        
        $grand_total = 0;
        $items_to_save = [];

        // ១. អានទិន្នន័យដើម្បីគណនាតម្លៃសរុបជាមុនសិន
        foreach ($_SESSION['cart'] as $id => $qty) {
            $safe_id = mysqli_real_escape_string($conn, $id);
            $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$safe_id'");
            $product = mysqli_fetch_assoc($query);
            
            if ($product) {
                $subtotal = $product['price'] * $qty;
                $grand_total += $subtotal;
                $items_to_save[] = [
                    'product_id' => $product['id'],
                    'qty' => $qty,
                    'price' => $product['price']
                ];
            }
        }

        if (!empty($items_to_save)) {
            // ២. បញ្ចូលទិន្នន័យទៅក្នុងតារាង orders
            mysqli_query($conn, "INSERT INTO orders (total_amount) VALUES ('$grand_total')");
            $order_id = mysqli_insert_id($conn); // យក ID របស់ Order ដែលទើបតែបង្កើតថ្មីៗ

            // ៣. បញ្ចូលទំនិញនីមួយៗទៅក្នុងតារាង order_items
            foreach ($items_to_save as $item) {
                mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                     VALUES ('$order_id', '{$item['product_id']}', '{$item['qty']}', '{$item['price']}')");
            }

            // រក្សាទុកសារជោគជ័យបណ្ដោះអាសន្នទៅក្នុង Session ដើម្បីបង្ហាញនៅទំព័រ Report
            $_SESSION['success_message'] = "Order Placed Successfully! Your Order ID is #" . $order_id . " (Total Paid: $" . number_format($grand_total, 2) . ")";
            unset($_SESSION['cart']); // សម្អាតកន្ត្រកទំនិញចោល
            
            header("Location: order_report.php"); // ផ្ទេរទៅទំព័ររបាយការណ៍
            exit();
        }
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff5eb; padding: 40px; color: #333; }
        .cart-container { max-width: 950px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); }
        h2 { border-bottom: 2px solid #ff7a00; padding-bottom: 10px; margin-bottom: 20px; color: #ff7a00; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #ff7a00; color: white; font-weight: 600; }
        .input-qty { width: 70px; padding: 6px; border-radius: 5px; border: 1px solid #ccc; text-align: center; font-size: 14px;}
        .total { font-size: 22px; font-weight: bold; text-align: right; margin-top: 20px; color: #222; }
        .btn-update { background: #28a745; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; transition: 0.3s; }
        .btn-update:hover { background: #218838; }
        .btn-clear { display: inline-block; background-color: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 20px; transition: 0.3s;}
        .btn-clear:hover { background-color: #c82333; }
        .btn-checkout { background-color: #ff7a00; color: white; padding: 10px 25px; border: none; border-radius: 6px; font-weight: 600; float: right; margin-top: 20px; box-shadow: 0 4px 12px rgba(255,122,0,0.2); transition: 0.3s; cursor: pointer;}
        .btn-checkout:hover { background-color: #e56d00; }
        .btn-delete { color: #dc3545; text-decoration: none; font-weight: bold; }
        .btn-delete:hover { text-decoration: underline; }
        .back-link { display: inline-block; margin-bottom: 15px; color: #ff7a00; text-decoration: none; font-weight: 600; }
        .alert-success { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 600; text-align: center; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="cart-container">
    <a href="shop.php" class="back-link">← Continue Shopping</a>
    <h2>Shopping Cart</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert-success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // លុបវាចេញវិញក្រោយពេលបង្ហាញរួច
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <form method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    foreach ($_SESSION['cart'] as $id => $qty): 
                        $id = mysqli_real_escape_string($conn, $id);
                        $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
                        $product = mysqli_fetch_assoc($query);
                        if ($product):
                            $subtotal = $product['price'] * $qty;
                            $grand_total += $subtotal;
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td>
                                <input type="number" name="qty[<?php echo $product['id']; ?>]" value="<?php echo $qty; ?>" min="1" class="input-qty">
                            </td>
                            <td><strong>$<?php echo number_format($subtotal, 2); ?></strong></td>
                            <td>
                                <a href="cart.php?action=delete&id=<?php echo $product['id']; ?>" class="btn-delete" onclick="return confirm('Remove this product?');">Remove</a>
                            </td>
                        </tr>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </tbody>
            </table>

            <div style="margin-top: 15px;">
                <button type="submit" name="update_cart" class="btn-update">Update Quantities</button>
            </div>
        </form>

        <div class="total">Total Amount: $<?php echo number_format($grand_total, 2); ?></div>
        
        <a href="cart.php?action=clear" class="btn-clear" onclick="return confirm('Are you sure you want to clear cart?');">Clear Cart</a>
        
        <form method="POST" style="display: inline;">
            <button type="submit" name="checkout_cart" class="btn-checkout" onclick="return confirm('Do you want to complete this order?');">Proceed to Checkout</button>
        </form>

    <?php else: ?>
        <p style="text-align: center; margin-top: 50px; color: #888; font-size: 18px;">Your cart is empty!</p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="shop.php" style="background: #ff7a00; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 600;">Go to Shop</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>