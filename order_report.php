<?php
session_start();
include 'db.php';

// ទាញយកព័ត៌មានពីការបញ្ជាទិញទាំងអស់ពី Database (បង្ហាញអាលថ្មីៗមុនគេ)
$orders_query = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Report - របាយការណ៍បញ្ជាទិញ</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff5eb; padding: 40px; color: #333; }
        .report-container { max-width: 950px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); }
        h2 { border-bottom: 2px solid #ff7a00; padding-bottom: 10px; margin-bottom: 20px; color: #ff7a00; display: flex; justify-content: space-between; align-items: center; }
        .btn-shop { background: #ff7a00; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.3s; }
        .btn-shop:hover { background: #e56d00; }
        .order-card { border: 1px solid #ffe3cc; border-radius: 8px; margin-bottom: 25px; overflow: hidden; background: #fffcf9; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .order-header { background: #ffe3cc; padding: 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; color: #d66600; font-size: 15px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        th { background-color: #fafafa; color: #666; font-weight: 600; }
        .text-right { text-align: right; }
        .grand-total-row { font-weight: bold; background: #fdfdfd; font-size: 16px; color: #222; }
        .no-orders { text-align: center; padding: 50px; color: #888; font-size: 18px; }
        .alert-success { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 600; text-align: center; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="report-container">
    <h2>
        <span>📦 Order Report (របាយការណ៍បញ្ជាទិញ)</span>
        <a href="shop.php" class="btn-shop">Back to Shop</a>
    </h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert-success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); 
            ?>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($orders_query) > 0): ?>
        <?php while ($order = mysqli_fetch_assoc($orders_query)): ?>
            <div class="order-card">
                <div class="order-header">
                    <span>Order ID: #<?php echo $order['id']; ?></span>
                    <span>Date: <?php echo date('Y-m-d h:i A', strtotime($order['created_at'])); ?></span>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $order_id = $order['id'];
                        // ទាញយកទំនិញដែលពាក់ព័ន្ធនឹងការកុម្ម៉ង់នេះ ដោយប្រើ LEFT JOIN ដើម្បីយកឈ្មោះផលិតផលពីតារាង products
                        $items_query = mysqli_query($conn, "
                            SELECT oi.*, p.name AS product_name 
                            FROM order_items oi 
                            LEFT JOIN products p ON oi.product_id = p.id 
                            WHERE oi.order_id = '$order_id'
                        ");
                        
                        while ($item = mysqli_fetch_assoc($items_query)):
                            $subtotal = $item['price'] * $item['quantity'];
                        ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($item['product_name'] ?? 'Unknown Product (លុបចេញពីហាង)'); ?></strong></td>
                                <td class="text-right">$<?php echo number_format($item['price'], 2); ?></td>
                                <td class="text-right"><?php echo $item['quantity']; ?></td>
                                <td class="text-right">$<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                        
                        <tr class="grand-total-row">
                            <td colspan="3" class="text-right">Total Amount Paid:</td>
                            <td class="text-right" style="color: #ff7a00; font-size: 18px;">$<?php echo number_format($order['total_amount'], 2); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-orders">No orders found. មិនទាន់មានប្រវត្តិនៃការកុម្ម៉ង់ទំនិញនៅឡើយទេ។</p>
    <?php endif; ?>
</div>

</body>
</html>