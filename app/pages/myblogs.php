<?php 
  if(!$_SESSION['USER']){
    redirect_login();
  }
    $user_id = $_SESSION['USER']['id'];
    $user_image = $_SESSION['USER']['image'];
    $query = "select posts.*, categories.category from posts join categories on posts.category_id = categories.id where user_id=:user_id";
    $rows = query($query, ['user_id'=> $user_id]);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
  
    <title>Home · My Blog</title>


    <link href="<?=ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    
    <style>
       body {
      background-color: #FFEBE7;
    }
    </style>

  </head>
  <body>
  <?php
        require_once('header.php');
        ?>


  <!--slider -->
  <!-- <link rel="stylesheet" href="<?=ROOT?>/assets/slider/ism/css/my-slider.css"/>
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
</div> -->
  <!-- end slider -->

    <main class="p-2">
        <h3 class="mx-4">Featured</h3>

      <?php if($rows): ?>
                  <div class="row">
                      <?php foreach($rows as $row): ?>
                          <div class="col-md-6">
                              <?php include '../app/pages/includes/post-card.php'; ?>
                          </div>
                      <?php endforeach; ?>
                  </div>
              <?php else: ?>
                  <div class="text-center">
                      Looks like you haven't posted anything yet
                  </div>
      <?php endif; ?>

</main>
    <script src="<?=ROOT?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>


