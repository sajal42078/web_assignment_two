<?php
require_once 'includes/config.php';
include 'includes/header.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "<p class='text-center'>Invalid Post ID</p>";
    include 'includes/footer.php';
    exit;
}

$post_id = intval($_GET['id']);
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = $conn->query($sql);

if($result->num_rows == 0){
    echo "<p class='text-center'>Post not found</p>";
    include 'includes/footer.php';
    exit;
}

$post = $result->fetch_assoc();
?>

<div class="row">
    <div class="col-12">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <?php if($post['image']): ?>
            <img src="uploads/<?= htmlspecialchars($post['image']) ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($post['title']) ?>">
        <?php endif; ?>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

        <?php if($post['location_map_embed']): ?>
            <div class="mb-4">
                <?= $post['location_map_embed'] ?>
            </div>
        <?php endif; ?>

        <h4>Comments</h4>
        <?php
        $comment_sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
        $comment_result = $conn->query($comment_sql);

        if($comment_result->num_rows > 0):
            while($comment = $comment_result->fetch_assoc()):
        ?>
            <div class="mb-2">
                <strong><?= htmlspecialchars($comment['name']) ?></strong> 
                <small class="text-muted">(<?= $comment['created_at'] ?>)</small>
                <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
            </div>
        <?php
            endwhile;
        else:
            echo "<p>No comments yet.</p>";
        endif;
        ?>

        <form method="post" action="comment_submit.php">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">
            <div class="mb-2">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Comment</label>
                <textarea name="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button class="btn btn-primary">Submit Comment</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>