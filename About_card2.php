<?php
include 'db.php';

$message = "";
$edit_mode = false;
$edit_id = "";
$edit_icon = "";
$edit_title = "";
$edit_description = "";

// ១. ដំណើរការនៅពេលចុចប៊ូតុង Save (Insert ឬ Update)
if (isset($_POST['save_card'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (empty($id)) {
        // ច្រកចូលថ្មី (Insert)
        $query = "INSERT INTO about_cards (icon, title, description) VALUES ('$icon', '$title', '$description')";
        if (mysqli_query($conn, $query)) {
            $message = "<div class='alert success'>Card added successfully!</div>";
        } else {
            $message = "<div class='alert error'>Error adding card!</div>";
        }
    } else {
        // ធ្វើបច្ចុប្បន្នភាព (Update)
        $query = "UPDATE about_cards SET icon='$icon', title='$title', description='$description' WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            $message = "<div class='alert success'>Card updated successfully!</div>";
        } else {
            $message = "<div class='alert error'>Error updating card!</div>";
        }
    }
}

// ២. ដំណើរការនៅពេលចុចលុប (Delete)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (mysqli_query($conn, "DELETE FROM about_cards WHERE id=$id")) {
        header("Location: About_card2.php");
        exit();
    }
}

// ៣. ទាញទិន្នន័យមកបំពេញក្នុង Form នៅពេលចុច Edit
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = intval($_GET['edit']);
    $edit_query = mysqli_query($conn, "SELECT * FROM about_cards WHERE id=$id");
    if (mysqli_num_rows($edit_query) == 1) {
        $row = mysqli_fetch_assoc($edit_query);
        $edit_id = $row['id'];
        $edit_icon = $row['icon'];
        $edit_title = $row['title'];
        $edit_description = $row['description'];
    }
}

// ទាញទិន្នន័យទាំងអស់មកបង្ហាញក្នុងតារាង (ដាក់នៅត្រង់នេះដើម្បីឱ្យទទួលបានទិន្នន័យថ្មីបំផុតជានិច្ច)
$all_cards = mysqli_query($conn, "SELECT * FROM about_cards ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About Cards - DSR_SHOP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background: #f4f7f6; color: #333; padding: 40px 20px; }
        .admin-container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        h2 { margin-bottom: 25px; color: #222; border-bottom: 2px solid #ff6b00; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 500; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
        textarea { height: 100px; resize: vertical; }
        .btn { display: inline-block; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn-primary { background: #ff6b00; color: #fff; }
        .btn-primary:hover { background: #e65c00; }
        .btn-secondary { background: #6c757d; color: #fff; margin-left: 10px; }
        .btn-edit { background: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; font-size: 12px; margin-right: 5px; }
        .btn-delete { background: #dc3545; color: #fff; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        .alert { padding: 12px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #222; color: #fff; }
        tr:hover { background: #f9f9f9; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #ff6b00; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>

<div class="admin-container">
    <a href="About.php" class="back-link">← Back to About Page</a>
    <h2>Manage About Cards (Values Section)</h2>
    
    <?= $message; ?>

    <form action="About_card2.php" method="POST">
        <input type="hidden" name="id" value="<?= $edit_id; ?>">
        
        <div class="form-group">
            <label>Icon (Emoji or Text)</label>
            <input type="text" name="icon" value="<?= htmlspecialchars($edit_icon); ?>" placeholder="e.g. 🚀, 💎, 🛡️" required>
        </div>
        
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($edit_title); ?>" placeholder="e.g. Fast Delivery" required>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" placeholder="Enter card description detail..." required><?= htmlspecialchars($edit_description); ?></textarea>
        </div>
        
        <button type="submit" name="save_card" class="btn btn-primary">
            <?= $edit_mode ? "Update Card" : "Add New Card"; ?>
        </button>
        <?php if($edit_mode): ?>
            <a href="About_card2.php" class="btn btn-secondary">Cancel Edit</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Icon</th>
                <th style="width: 22%;">Title</th>
                <th style="width: 50%;">Description</th>
                <th style="width: 20%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($all_cards)): ?>
                <tr>
                    <td style="font-size: 24px;"><?= htmlspecialchars($row['icon']); ?></td>
                    <td><strong><?= htmlspecialchars($row['title']); ?></strong></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td>
                        <a href="About_card2.php?edit=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="About_card2.php?delete=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this card?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?> <!-- បានជួសជុលពី endwith មក endwhile -->
        </tbody>
    </table>
</div>

</body>
</html>