<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<h1 class="mb-4 text-center">Travel Memories Blog</h1>

<div class="row">
<?php
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

if($result->num_rows > 0):
    while($row = $result->fetch_assoc()):
?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <?php if($row['image']): ?>
                <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($row['excerpt']) ?></p>
                <a href="post.php?id=<?= $row['id'] ?>" class="btn btn-primary mt-auto">Read More</a>
            </div>
        </div>
    </div>
<?php
    endwhile;
else:
?>
    <div class="col-12">
        <p class="text-center">No posts available yet.</p>
    </div>
<?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>