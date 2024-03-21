<?php

include '../core/init.php';
$post_id = $_GET['post_id'];
$last_date =$_GET['last_date'];


$query = "SELECT * from comments where post_id = :post_id and date>:date";
$new_posts = query($query,['post_id'=>$post_id,'date'=>$last_date]);


header('Content-Type: application/json');
echo json_encode($new_posts);

// $post_id = $_GET['post_id'];

// $query = "SELECT id from posts where slug=:slug";
// $row = query_row($query, ['slug'=> $slug]);


// $post_id = $row['post_id'];

// $query = "SELECT * from comments where post_id=:post_id";
// $new_comments = query($query,['post' =>$post_id]);

