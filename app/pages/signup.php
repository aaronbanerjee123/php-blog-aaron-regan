<?php
$errors = [];

if (!empty($_POST)) {
    // Your PHP form validation and submission logic here

    if (empty($_POST['username'])) {
        $errors['username'] = "A username is required";
    } else if (!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
        $errors['username'] = "A username has to be just letters";
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'A password is required';
    } else if (strlen($_POST['password']) < 8) {
        $errors['password'] = "Password needs to be 8 or more characters";
    } else if ($_POST['password'] !== $_POST['retype_password']) {
        $errors['password'] = "Passwords do not match";
    }

    $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
    $email = query($query, ['email' => $_POST['email']]);

    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required';
    } else if ($email) {
        $errors['email'] = "That email is already in use";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Not a valid email";
    }

    if (empty($_POST['terms'])) {
        $errors['terms'] = 'Please accept the terms';
    }

  echo $_POST['password']."<br>". $_POST['retype_password'];


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
          }

    if(empty($errors)){
      $data = [];
      $data['username'] = $_POST['username'];
      $data['email'] = $_POST['email'];
      $data['role'] = 'user';
      $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);

     
      $query = "insert into users (username,email,password,role) values (:username,:email,:password,:role)";// full colons means provided later
    
      if(!empty($destination))
      {
        $data['image'] = $destination;
        $query = "insert into users (username,email,password,role,image) values (:username,:email,:password,:role,:image)";
      }
      

      query($query, $data);
      redirect_login();

      
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>InsightInk - Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFEBE7;
        }

        .container {
            margin-top: 5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn {
            border-radius: 0.5rem;
        }

        .text-danger {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .text-muted {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 10px;
        }

        .text-center a {
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: none;
        }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?=ROOT?>/assets/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin w-100 m-auto">
  <form method="post">
    <a href="home">
      <img class="mb-4 rounded-circle shadow" src="<?=ROOT?>/assets/images/logo.jpg" alt="" width="92" height="92" style="object-fit:cover;">
    </a>
   
    <h1 class="h3 mb-3 fw-normal">Create account</h1>

  <?php if(!empty($errors)){ ?>
    <div class="alert alert-danger">
      Please fix the errors below
    </div>
  <?php  }?>

    <div class="form-floating">
      <input value="<?php echo old_value('username')?>" name="username" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
      <label for="floatingInput">Username</label>
    </div>

    <?php if(!empty($errors['username'])){ ?>
      <div class="text-danger">
          <?php echo $errors['username'];?>
      </div>
      <?php }?>


    <div class="form-floating">
      <input value="<?php echo old_value('email')?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>

    <?php if(!empty($errors['email'])){ ?>
      <div class="text-danger">
          <?php echo $errors['email'];?>
      </div>
      <?php }?>

    <div class="form-floating">
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
</div
