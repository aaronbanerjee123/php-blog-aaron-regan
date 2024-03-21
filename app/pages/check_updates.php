<?php
include '../core/init.php';
$query = "SELECT * from posts where date > :last_date";
$new_posts = query($query, ['last_date' => $_GET['last_date'] ?? 0]);


header('Content-Type: application/json');
echo json_encode($new_posts);