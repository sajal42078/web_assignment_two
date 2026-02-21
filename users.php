<?php
require_once __DIR__ . '/header.php'; // Admin header include (session + login check)
?>

<h2 class="mb-4">Manage Users</h2>

<a href="create_user.php" class="btn btn-success mb-3">Add New User</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed: " . $conn->error);
        }

        if($result->num_rows > 0):
            while($user = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td>
                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php
            endwhile;
        else:
        ?>
        <tr>
            <td colspan="4" class="text-center">No users available yet.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/footer.php'; // Admin footer include ?>