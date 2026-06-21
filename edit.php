<?php
include 'db.php';

$id = $_GET['id'];

$query = mysqli_query($conn,"SELECT * FROM products WHERE id='$id'");
$product = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $name  = $_POST['name'];
    $des   = $_POST['des'];
    $price = $_POST['price'];

    // Check Image Upload
    if(!empty($_FILES['img']['name'])){

        $imageName = $_FILES['img']['name'];
        $tmpName   = $_FILES['img']['tmp_name'];

        $newImage = "uploads/" . time() . "_" . $imageName;

        move_uploaded_file($tmpName,$newImage);

        $sql = "UPDATE products SET
                name='$name',
                des='$des',
                price='$price',
                img='$newImage'
                WHERE id='$id'";
// តើគួរបន្ថែមអីទៀតដើម្បីអោយ អាចហៅពីទិន្នន៍យពី database ដើម្បីអាចកែប្រើទិន្នន៍យក្នងfile about.phpបាន
// ប្រាប់របៀបធ្វើម្តងមួយជំហាន
    }else{

        $sql = "UPDATE products SET
                name='$name',
                des='$des',
                price='$price'
                WHERE id='$id'";
    }

    if(mysqli_query($conn,$sql)){
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Product</title>

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

.container{
    width:600px;
    max-width:95%;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

input,
textarea{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    margin-bottom:20px;
}

textarea{
    height:120px;
    resize:none;
}

.preview{
    text-align:center;
    margin-bottom:20px;
}

.preview img{
    width:180px;
    height:180px;
    object-fit:cover;
    border-radius:12px;
    border:3px solid #eee;
}

.btn{
    width:100%;
    padding:14px;
    background:#ff6b00;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}

.btn:hover{
    background:#e65c00;
}

.back{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    color:#ff6b00;
    font-weight:bold;
}

</style>

</head>
<body>

<div class="container">

<a href="dashboard.php" class="back">
← Back to Products
</a>

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

<label>Product Name</label> <input
type="text"
name="name"
value="<?= $product['name']; ?>"
required>

<label>Description</label>

<textarea
name="des"
required><?= $product['des']; ?></textarea>

<label>Price ($)</label> <input
type="number"
name="price"
step="0.01"
value="<?= $product['price']; ?>"
required>

<div class="preview">
    <p><strong>Current Image</strong></p>
    <br>
    <img src="<?= $product['img']; ?>">
</div>

<label>Change Image (Optional)</label> <input
type="file"
name="img"
accept="image/*">

<button
type="submit"
name="update"
class="btn">
Update Product </button>

</form>

</div>

</body>
</html>
