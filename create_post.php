<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $excerpt = trim($_POST['excerpt']);
    $content = trim($_POST['content']);
    $location_name = trim($_POST['location_name']);
    $location_map_embed = trim($_POST['location_map_embed']);
    $image = '';

    // Image upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $target_dir = __DIR__ . '/../uploads/';
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO posts (title, excerpt, content, image, location_name, location_map_embed) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssss', $title, $excerpt, $content, $image, $location_name, $location_map_embed);
    $stmt->execute();

    header('Location: dashboard.php');
    exit;
}
?>

<h2>Create New Post</h2>
<form method="post" enctype="multipart/form-data">
  <div class="mb-2">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-2">
    <label>Excerpt</label>
    <textarea name="excerpt" class="form-control" rows="2" required></textarea>
  </div>
  <div class="mb-2">
    <label>Content</label>
    <textarea name="content" class="form-control" rows="5" required></textarea>
  </div>
  <div class="mb-2">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
    <!-- এখানে যে ছবি আপলোড করবে, সেটা uploads/ ফোল্ডারে যাবে -->
  </div>
  <div class="mb-2">
    <label>Location Name</label>
    <input type="text" name="location_name" class="form-control">
  </div>
  <div class="mb-2">
    <label>Google Map Embed</label>
    <textarea name="location_map_embed" class="form-control" rows="2"></textarea>
  </div>
  <button class="btn btn-success" type="submit">Create Post</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>