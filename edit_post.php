<?php
require_once __DIR__ . '/header.php'; // admin header (session check + DB)
?>

<h2 class="mb-4">Edit Post</h2>

<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-danger'>Invalid post ID.</p>";
    require_once __DIR__ . '/footer.php';
    exit;
}

$post_id = intval($_GET['id']);

// Fetch existing post
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-danger'>Post not found.</p>";
    require_once __DIR__ . '/footer.php';
    exit;
}

$post = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $location = trim($_POST['location']);
    $image = $post['image']; // Default old image

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = basename($_FILES["image"]["name"]);
    }

    $update_sql = "UPDATE posts SET title=?, content=?, location_name=?, image=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $title, $content, $location, $image, $post_id);

    if ($update_stmt->execute()) {
        echo "<div class='alert alert-success'>Post updated successfully!</div>";
        // Refresh post data
        $post['title'] = $title;
        $post['content'] = $content;
        $post['location_name'] = $location;
        $post['image'] = $image;
    } else {
        echo "<div class='alert alert-danger'>Error updating post: " . $conn->error . "</div>";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($post['location_name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Current Image</label><br>
        <?php if ($post['image']): ?>
            <img src="../uploads/<?= htmlspecialchars($post['image']) ?>" width="120" alt="<?= htmlspecialchars($post['title']) ?>">
        <?php else: ?>
            <p>No image uploaded.</p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Upload New Image (optional)</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update Post</button>
    <a href="posts.php" class="btn btn-secondary">Back to Posts</a>
</form>

<?php
require_once __DIR__ . '/footer.php';
?>