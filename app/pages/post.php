<?php 
    $slug = $url[1];
    $user_image = $_SESSION['USER']['image'];

    $user_id = $_SESSION['USER']['id'];

    $query = "SELECT id from posts where slug=:slug limit 1";
    $row = query_row($query, ['slug' => $slug]);

    $post_id = $row['id'];

    if(!empty($_POST)){
      $comment = $_POST['comment'];
      $query = "INSERT into comments (comment,post_id,user_id) values (:comment, :post_id, :user_id)";
      query($query, ['user_id' => $user_id, 'post_id' => $post_id, 'comment' => $comment]);
    
    }

 

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
  
    <title>Home · My Blog</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/headers/">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="<?=ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    
    <!-- Custom styles for this template -->
    <link href="<?=ROOT?>/assets/css/headers.css" rel="stylesheet">
  </head>
  
  <body>
 
  <header class="p-3  border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
        <img class="bi me-2" src="<?=ROOT?>/assets/images/logo.jpg" width="60" height="60" style="object-fit:cover;"/>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="<?=ROOT?>" class="nav-link px-2 link-secondary">Home</a></li>
          <li><a href="<?=ROOT?>/myblogs" class="nav-link px-2 link-dark">My Blogs</a></li>
          <li><a href="<?=ROOT?>/contact" class="nav-link px-2 link-dark">Contact</a></li>
          <li><a href="<?=ROOT?>/add" class="nav-link px-2 link-dark">Add Blog</a></li>
        </ul>

       
        <form class="row align-items-center mb-3 mb-lg-0 me-lg-3" role="search" action="<?=ROOT?>/search">
            <div class="col-md-auto">
                <input type="search" name="find" class="form-control" placeholder="Search..." aria-label="Search">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">Find</button>
            </div>
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?=get_image($user_image)?>" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>/admin">Admin</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>/Settings">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?=ROOT?>/logout">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>


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


 <div class="row my-2">
  
        <?php 
          $row = null;
          
          if ($slug) {
            $query = "select * from posts join categories on posts.category_id= categories.id where posts.slug=:slug limit 1";
            $row = query_row($query,['slug'=>$slug]);     
          }
          if(!empty($row)){ 
            $user_id = $row['user_id'];
            $query_2 = "select users.username from users where id=:id limit 1";
            $row2 = query_row($query_2, ['id' => $row['user_id']]);
            include '../app/pages/includes/post-single.php';      
         }else{
            echo "No items found";
          }
          


        ?>
      <form method="POST" id="comment_form">

            <div class="form-group">
              <input type="text" name="comment" id="comment" class="form-control"
                    placeholder="Enter Comment"></textarea>
            </div>

            <button type = "submit" class="btn btn-primary">Submit</button>

    </form>
       <div id="display_comments">
       <?php 
          $query = "SELECT comments.*, users.username from comments join users on comments.user_id = users.id where post_id=:post_id";
          $rows = query($query,['post_id'=>$post_id]);
          if(!empty($rows)){
          foreach ($rows as $row) { ?>
            <div class="form-group">
              <h1><?=$row['comment']?></h1>
              <h5>Comment by <?=$row['username']?></h5>
            </div>
            <?php }
          }?>
      </div>

      <div id="newest"></div>

   

  </div>
</main>


    <script src="<?=ROOT?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   
   <script>
    function formatDateTime(date) {
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');
    let hours = String(date.getHours()).padStart(2, '0');
    let minutes = String(date.getMinutes()).padStart(2, '0');
    let seconds = String(date.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
} 

     $(document).ready(function() {
      let post_id = <?php echo $post_id;?>;
      let user_id = <?php echo $user_id;?>

      

      let last_date = formatDateTime(new Date());
        function fetchComments() {
            $.ajax({
              url: 'http://localhost/zoots/app/pages/check_comments.php',
                method: 'GET', // Change the request type to GET
                data: {
                    post_id:post_id,
                    last_date:last_date,
                    user_id:user_id
                    // Pass the post_id as a query parameter
                },
                success: function(response) {
                    // Handle success response
                    console.log('Comments fetched successfully:', response);
            
                    response.forEach(function(comment) {
                  
                      
                    $('#newest').append('<div class="form-group"><h1>' + comment.comment + '</h1><h5>Comment by ' + comment.username + '</h5></div>');
                });
                  
         
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error fetching comments:', error);
                }
            });
            last_date = formatDateTime(new Date());

        }
        // Fetch comments initially when the document is ready
  
        // Set interval to fetch comments every 4 seconds
        setInterval(fetchComments, 10000); // 4000 milliseconds = 4 seconds
    });
     </script>
  
  
  
  </body>
</html>
