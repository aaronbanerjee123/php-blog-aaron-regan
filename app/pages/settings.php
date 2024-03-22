<?php 
    $row = $_SESSION['USER']; 
    $id = $_SESSION['USER']['id'];
    $user_image = $_SESSION['USER']['image'];
  
    echo $id;
    if(!empty($_POST)){
        if($row){
  
        $errors = [];
    
        if(empty($_POST['username'])){
          $errors['username'] = "A username is required";
        }else if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])){
            $errors['username'] = "A username has to be just letters";
        }
      
        if(!empty($_POST['password']) && strlen($_POST['password']) < 8){
          $errors['password'] = "Password needs to be 8 or more characters";
        }else if($_POST['password'] !== $_POST['retype_password']){
          $errors['password'] = "Passwords do not match";
        }
    
        $query = "select id from users where email = :email && id != :id limit 1";// full colons means provided later
        $email = query($query, ['email'=>$_POST['email'],'id' => $id]); // could use $_POST['email'] if i did email = ? in query
        // to query for info you just type query function, but you must use prepared statements when configuring things in the database like in functions page
    
        if(empty($_POST['email'])){
          $errors['email'] = 'A email is required';
        }else if($email){
            $errors['email'] = "That email is already in use";
        }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ 
          $errors['email'] = "Not a valid email";
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
            }
  
  
        if(empty($errors)){
          $data = [];
          $data['username'] = $_POST['username'];
          $data['email'] = $_POST['email'];
          $data['role'] = $_POST['role'];
          $data['id'] = $id;
        
        
         
        if(empty($_POST['password'])){
            $query = "update users set username=:username, email=:email, role=:role where id = :id limit 1";// full colons means provided later
            if(!empty($destination)){
                $data['image'] = $destination;
                $query = "update users set username=:username, email=:email,role=:role,image=:image where id = :id limit 1";// full colons means provided later
              }
        }else{
          $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
          $query = "update users set username=:username, email=:email, password=:password, role=:role where id = :id limit 1";// full colons means provided later 
          if(!empty($destination)){
            $data['image'] = $destination;
            $query = "update users set username=:username, email=:email,role=:role,password=:password,image=:image where id = :id limit 1";// full colons means provided later
          }
        }
          
         
     
        
  
          query($query, $data);
          
          $query2 = "select * from users where id=:id limit 1";
          $row2 = query($query2,['id'=>$id]);
          $_SESSION['USER'] = $row2[0];

          redirect_home();
    
        }
      } //uploads/Screen Shot 2023-03-13 at 11.24.55 AM.png
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
  
    <title>Home · My Blog</title>


    <link href="<?=ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    
    <!-- Custom styles for this template -->
    <link href="<?=ROOT?>/assets/css/headers.css" rel="stylesheet">
  </head>
  <body>
  
  <?php
  require_once("header.php")
  ?>



<div class="col-md-6 mx-auto">
                  <form method="post" enctype="multipart/form-data">
              
                
                  <h1 class="h3 mb-3 fw-normal text-center">Edit account</h1>

              <?php if(!empty($row)):?>

                <?php if(!empty($errors)){ ?>
                  <div class="alert alert-danger">
                    Please fix the errors below
                  </div>
                <?php  }?>
                    

                <div class="my-2">
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit mb-4" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 5px solid lightgray; border-radius: 10px;"></div>
                    <input type="file" name="image" onchange="display_image_edit(this.files[0])" class= "mb-4 ">
                  </label>
                
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }
                  </script>
                </div>


                <div class="form-floating">
                    <input value="<?php echo old_value('username',$row['username'])?>" name="username" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
                    <label for="floatingInput">Username</label>
                  </div>

                  <?php if(!empty($errors['username'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['username'];?>
                    </div>
                    <?php }?>

                    <div class="form-floating my-3">
           
          </div>
            
          <?php if(!empty($errors['role'])){ ?>
            <div class="text-danger">
                <?php echo $errors['role'];?>
            </div>
            <?php }?>


            <div class="form-floating my-3">
                    <input value="<?php echo old_value('email',$row['email'])?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                  </div>

                  <?php if(!empty($errors['email'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['email'];?>
                    </div>
                    <?php }?>

                  <div class="form-floating my-3">
                    <input value="<?php echo old_value('password')?>"  name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                  </div>

                  <?php if(!empty($errors['password'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['password'];?>
                    </div>
                    <?php }?>


                  <div class="form-floating">
                    <input value="<?php echo old_value('retype_password')?>"  name="retype_password" type="password" class="form-control" id="floatingPassword" placeholder="Retype Password">
                    <label for="floatingPassword">Retype Password</label>
                  </div>

                  <button class="mt-4 w-30 btn btn-lg btn-success float-end" type="submit">save</button>
                  <a href="<?=ROOT?>/home"><button class="mt-4 w-30 btn btn-lg btn-dark" type="button">back</button></a>


              <?php endif;?>
              </form>
              </div>
</body>
</html>