<?php
include 'db.php';

if(isset($_POST['save'])){

    $name  = $_POST['name'];
    $des   = $_POST['des'];
    $price = $_POST['price'];

    // Upload Image
    $imageName = $_FILES['img']['name'];
    $tmpName   = $_FILES['img']['tmp_name'];

    $folder = "uploads/" . time() . "_" . $imageName;

    if(move_uploaded_file($tmpName, $folder)){

        $sql = "INSERT INTO products
                (name, des, img, price, created_at)
                VALUES
                ('$name', '$des', '$folder', '$price', NOW())";

        if(mysqli_query($conn, $sql)){
            header("Location: dashboard.php");
            exit();
        }else{
            echo "Database Error: " . mysqli_error($conn);
        }

    }else{
        echo "Image Upload Failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
        }

        .container{
            width:500px;
            margin:40px auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            color:#333;
            margin-bottom:20px;
        }

        label{
            font-weight:bold;
        }

        input, textarea{
            width:100%;
            padding:10px;
            margin-top:5px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:5px;
        }

        button{
            width:100%;
            background:#28a745;
            color:white;
            border:none;
            padding:12px;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover{
            background:#218838;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Add Product</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="des" required></textarea>

        <label>Price ($)</label>
        <input type="number"
               name="price"
               step="0.01"
               min="0"
               required>

        <label>Product Image</label>
        <input type="file"
               name="img"
               accept="image/*"
               required>

        <button type="submit" name="save">
            Save Product
        </button>

    </form>

</div>

</body>
</html>