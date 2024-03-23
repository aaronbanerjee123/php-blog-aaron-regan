<?php 
    $user_image = $_SESSION['USER']['image'];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
  
    <title>Home · My Blog</title>
  <style>
    body {
            background-color: #FFEBE7;
        }
  </style>
    <link href="<?=ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    
    <!-- Custom styles for this template -->
    <link href="<?=ROOT?>/assets/css/headers.css" rel="stylesheet">
  </head>
  
  <body>
 
  <?php
  require_once("header.php");
  ?>


  <!--slider -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/slider/ism/css/my-slider.css"/>
  <script src="<?=ROOT?>/assets/slider/ism/js/ism-2.2.min.js"></script>
    

<div class="ism-slider" data-transition_type="fade" data-play_type="loop" id="my-slider">
  <ol>
    <li>
      <img src="<?=ROOT?>/assets/slider/ism/image/slides/flower-729514_1280.jpg">
      <div class="<?=ROOT?>/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
    <li>
      <img src="<?=ROOT?>/assets/slider/ism/image/slides/beautiful-701678_1280.jpg">
      <div class="<?=ROOT?>/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
    <li>
      <img src="<?=ROOT?>/assets/slider/ism/image/slides/summer-192179_1280.jpg">
      <div class="<?=ROOT?>/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
    <li>
      <img src="<?=ROOT?>/assets/slider/ism/image/slides/city-690332_1280.jpg">
      <div class="<?=ROOT?>/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
  </ol>
</div>
  <!-- end slider -->

    <main class="p-2">
        <h3 class="mx-4">Search</h3>

 <div class="row my-2">
        <?php 
          $find = $_GET['find'] ?? null;

          if($find){
            $find = "%$find%";
            $query = "select posts.*, categories.category from posts join categories on posts.category_id= categories.id join users on posts.user_id = users.id where posts.title like :find or categories.category like :find or users.username like :find order by posts.id desc limit 6";
            $rows = query($query, ['find'=> $find]);
          }   


          if(!empty($rows)){
            foreach($rows as $row){
              include '../app/pages/includes/post-card.php';
            }
          }else{
             include '../app/pages/notFound.php';
          }
          
        ?>
   

  </div>


    </main>


    <script src="<?=ROOT?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
