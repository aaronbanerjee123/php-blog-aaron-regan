<?php 
    $user_image= $_SESSION['USER']['image'];
    print_r($user_image);
  
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
  
    <title>Home · My Blog</title>

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
        <h3 class="mx-4">Featured</h3>

 <div class="row my-2" id="blogs-container">
  
        <?php 

        $query = "select posts.*,categories.category from posts join categories on posts.category_id= categories.id order by posts.id desc";
        $rows = query($query);


          if($rows){
            foreach($rows as $row){
              include '../app/pages/includes/post-card.php';
            }
          }else{
            echo "No items found";
          }
          
        ?>
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
    // Function to fetch updates from the server
    function checkForUpdates() {
        $.ajax({
            url: '../app/pages/check_updates.php',
            method: 'GET',
            data: {
                last_date: last_date, // Pass the last timestamp to the server
          
            },
            success: function(response) {
                // Process the updates received from the server
                console.log('Updates:', response);

                response.forEach(function(blog) {
                  
                    $.ajax({
                       url: '../app/pages/includes/post-card-async.php',
                      method: 'POST',
                      data: {
                            id: blog.id
                            
                        },
                        success: function(htmlResponse) {
                            // Prepend the HTML content generated by PHP to the blog container
                            $('#blogs-container').prepend(htmlResponse);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching HTML content:', error);
                        }
                    });
                });

                // Update the last timestamp to the latest one received
                last_date = formatDateTime(new Date());
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    var last_date = formatDateTime(new Date()); // Initialize last timestamp
    var id = ''; // Initialize blog ID
    // Call the function to check for updates every 5 seconds (adjust as needed)
    setInterval(checkForUpdates, 5000); // 5000 milliseconds = 5 seconds
});

 </script>

  </body>
  

</html>

