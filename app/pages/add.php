<?php 
 $query = "select * from categories";
 $rows = query($query,[]);

    if(!empty($_POST)){
        $errors = [];
    
        if(empty($_POST['title'])){
          $errors['title'] = "A title is required";
        }
      
    
        if(empty($_POST['content'])){
          $errors['content'] = 'Content required';
        }
    
  
        $allowed = ['image/jpeg','image/png','image/webp'];
            if(!empty($_FILES['image']['name'])){
            
              $destination = "";
              if(!in_array($_FILES['image']['type'], $allowed))
              {
                $errors['image'] = "Image format not supported";
              }else
              // "/Applications/XAMPP/xamppfiles/htdocs/PHP-Blog/public/
                $folder = "uploads/";
                if(!file_exists($folder))
                {
                  mkdir($folder, 0777, true);
                }
                $destination = $folder .$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                // resize_image($destination);
                
                // resize_image($destination);
            }else{
              $errors['image'] = 'Post needs an image';
            }
  
            $slug = str_to_url($_POST['title']);
          //   echo $slug;
          //   $query = "select id from categories where slug = :slug limit 1";// full colons means provided later
          //   $slug2 = query($query, ['slug'=>$slug]); // could use $_POST['email'] if i did email = ? in query
          //   // to query for info you just type query function, but you must use prepared statements when configuring things in the database like in functions page
        
         
  
        if(empty($errors)){
            
          $data = [];
          $data['title'] = $_POST['title'];
          $data['content'] = $_POST['content'];
          $data['slug'] = str_to_url($_POST['title']);
          $data['category_id'] = $_POST['category_id'];
          $data['user_id'] = user('id');
    
          $data['image'] = $destination;
          $query = "insert into posts (title,content,category_id,slug,user_id,image) values (:title,:content,:category_id,:slug,:user_id,:image)";// full colons means provided later
         
          print_r($data);
      
          query($query, $data);
          redirect_blogs();
          
        }
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
          <li><a href="<?=ROOT?>/blog" class="nav-link px-2 link-dark">Blog</a></li>
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
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>/admin">Admin</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
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



<div class="container text-center">
  <form method="post">
    <div class="form-group">
    <h1>Add a new Blog</h1>

      <div class="my-2">
        Featured Image: <br>
        <label class="d-block">
          <img class="mx-auto d-block image-preview-edit" src="" style="cursor:pointer;width:150px;height:150px;object-fit:cover;">     
          </div>
          <input onchange="display_image_edit(this.files[0])" type="file" name="image">
        </label>

      <script>
        function display_image_edit(file) {
          document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
        }
      </script>
    </div>

    <?php if(!empty($errors['image'])){ ?>
          <div class="alert alert-danger">
            <?=$errors['image']?>
          </div>
        <?php  }?> 

    <div class="form-group my-3">
      <label for="titleFormControlInput1">Title</label>
      <input type="text" class="form-control" id="titleFormControlInput1" value="<?=old_value('title')?>" name="title" placeholder="Enter title">
    </div>

    <?php if(!empty($errors['title'])){ ?>
          <div class="alert alert-danger">
            <?=$errors['title']?>
          </div>
        <?php  }?> 

    <div class="form-group my-3">
      <label for="exampleFormControlSelect1">Select the category</label>
      <select class="form-control" name="category_id" id="exampleFormControlSelect1">
        <?php
            foreach($rows as $row){ ?>
                <option value="<?=$row['id']?>"><?=$row['category']?></option>
            <?php   } ?>
      </select>
    </div>



    <div class="form-group my-3">
      <label for="contentArea">content</label>
      <textarea class="form-control" name="content"  value="<?=old_value('content')?>" id="contentArea" rows="3"></textarea>
    </div>

    <?php if(!empty($errors['content'])){ ?>
          <div class="alert alert-danger">
            <?=$errors['content']?>
          </div>
        <?php  }?> 

    <button type="submit" class="btn btn-primary my-3">Submit</button>
  </form>
</div>

</body>
</html>