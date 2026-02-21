<?php
require_once 'includes/config.php';

// Check if form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    // Get and sanitize input
    $post_id = intval($_POST['post_id']);
    $name = $conn->real_escape_string(trim($_POST['name']));
    $comment = $conn->real_escape_string(trim($_POST['comment']));

    // Simple validation
    if($post_id > 0 && !empty($name) && !empty($comment)){
        $sql = "INSERT INTO comments (post_id, name, comment, created_at) 
                VALUES ($post_id, '$name', '$comment', NOW())";

        if($conn->query($sql)){
            // Redirect back to post page
            header("Location: post.php?id=$post_id");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "All fields are required!";
    }
} else {
    echo "Invalid request!";
}
?>