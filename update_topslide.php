<?php
include 'db.php';

// ១. ទាញទិន្នន័យចាស់មកបង្ហាញក្នុង Form (យក ID = 1 មកប្រើ)
$query = mysqli_query($conn, "SELECT * FROM about_story WHERE id=1");
$story = mysqli_fetch_assoc($query);

$message = "";

// ២. នៅពេលចុចប៊ូតុង Update
if(isset($_POST['update_story'])){
    $title        = mysqli_real_escape_string($conn, $_POST['title']);
    $description1 = mysqli_real_escape_string($conn, $_POST['description1']);
    $description2 = mysqli_real_escape_string($conn, $_POST['description2']);
    $newImage     = $story['img_path']; // រក្សាទុករូបភាពចាស់សិន ប្រសិនបើមិនមានការ Upload ថ្មី

    // ពិនិត្យមើលថាតើមានការ Upload រូបភាពថ្មីឬទេ
    if(!empty($_FILES['img']['name'])){
        $imageName = $_FILES['img']['name'];
        $tmpName   = $_FILES['img']['tmp_name'];
        
        // បង្កើត Folder បើមិនទាន់មាន
        if (!file_exists('About_card-top')) {
            mkdir('About_card-top', 0777, true);
        }

        // កំណត់ផ្លូវទៅកាន់ folder About_card-top
        $newImage  = "About_card-top/" . time() . "_" . $imageName;

        // ផ្លាស់ទីរូបភាពទៅកាន់ folder Target
        if(move_uploaded_file($tmpName, $newImage)){
            // លុបរូបភាពចាស់ចេញពី folder (បើមាន និងមិនមែនជារូបភាពលំនាំដើម)
            if(file_exists($story['img_path']) && $story['img_path'] != 'About_card-top/default.jpg'){
                unlink($story['img_path']);
            }
        }
    }

    // ធ្វើបច្ចុប្បន្នភាពទិន្នន័យទៅក្នុង Database
    $sql = "UPDATE about_story SET 
            title='$title', 
            description1='$description1', 
            description2='$description2', 
            img_path='$newImage' 
            WHERE id=1";

    if(mysqli_query($conn, $sql)){
        $message = "<div class='success'>ធ្វើបច្ចុប្បន្នភាពបានជោគជ័យ!</div>";
        // ទាញទិន្នន័យថ្មីម្តងទៀតដើម្បីបង្ហាញលើ Form
        $query = mysqli_query($conn, "SELECT * FROM about_story WHERE id=1");
        $story = mysqli_fetch_assoc($query);
    } else {
        $message = "<div class='error'>មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit About Our Story</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 600px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px;}
        label { display: block; margin: 15px 0 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        textarea { height: 100px; resize: none; }
        .preview-img { width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin: 10px 0; border: 2px solid #ddd; }
        .btn { width: 100%; padding: 12px; background: #ff6b00; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; margin-top: 20px;}
        .btn:hover { background: #e65c00; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;}
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;}
    </style>
</head>
<body>

<div class="container">
    <h2>កែប្រែព័ត៌មាន Our Story</h2>
    <?= $message; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <label>ចំណងជើង (Title)</label>
        <input type="text" name="title" value="<?= htmlspecialchars($story['title'] ?? ''); ?>" required>

        <label>ការពិពណ៌នាទី ១ (Paragraph 1)</label>
        <textarea name="description1" required><?= htmlspecialchars($story['description1'] ?? ''); ?></textarea>

        <label>ការពិពណ៌នាទី ២ (Paragraph 2)</label>
        <textarea name="description2" required><?= htmlspecialchars($story['description2'] ?? ''); ?></textarea>

        <label>រូបភាពបច្ចុប្បន្ន</label><br>
        <img src="<?= htmlspecialchars($story['img_path'] ?? 'About_card-top/default.jpg'); ?>" class="preview-img" alt="Current Image"><br>

        <label>ប្តូររូបភាពថ្មី (មិនបង្ខំ)</label>
        <input type="file" name="img" accept="image/*">

        <button type="submit" name="update_story" class="btn">រក្សាទុកការផ្លាស់ប្តូរ</button>
    </form>
</div>

</body>
</html>