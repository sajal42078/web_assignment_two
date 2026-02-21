<?php
require_once __DIR__ . '/header.php'; // Admin header include (session + login check)
?>

<h2 class="mb-4">Admin Dashboard</h2>
<a href="create_post.php" class="btn btn-success mb-3">Create New Post</a>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Image</th>
      <th>Location</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if(!$result){
        die("Query failed: " . $conn->error);
    }

    if($result->num_rows > 0):
        while($post = $result->fetch_assoc()):
    ?>
    <tr>
      <td><?= $post['id'] ?></td>
      <td><?= htmlspecialchars($post['title']) ?></td>
      <td>
        <?php if($post['image']): ?>
          <img src="../uploads/<?= htmlspecialchars($post['image']) ?>" width="80" alt="<?= htmlspecialchars($post['title']) ?>">
        <?php else: ?>
          No Image
        <?php endif; ?>
      </td>
      <td><?= htmlspecialchars($post['location_name']) ?></td>
      <td>
        <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
        <a href="delete_post.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
      </td>
    </tr>
    <?php
        endwhile;
    else:
    ?>
    <tr>
      <td colspan="5" class="text-center">No posts available yet.</td>
    </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php
require_once __DIR__ . '/footer.php'; // Admin footer include
?>