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

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $destination = "";
        if (!in_array($_FILES['image']['type'], $allowed)) {
            $errors['image'] = "Image format not supported";
        } else {
            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }
    }

    if (empty($errors)) {
        $data = [];
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['role'] = 'user';
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (!empty($destination)) {
            $data['image'] = $destination;
        }

        $query = "INSERT INTO users (username, email, password, role";
        $values = "VALUES (:username, :email, :password, :role";

        if (!empty($data['image'])) {
            $query .= ", image";
            $values .= ", :image";
        }

        $query .= ")";
        $values .= ")";

        $query = $query . ' ' . $values;

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
</head>
<body>
<div class="container">
    <h1 class="text-center"><a href="<?= ROOT ?>/home">InsightInk</a></h1>
    <h2 class="text-center">Create an Account</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            Please fix the errors below
        </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data"> 



    <div class="my-2">
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 2px solid gray;  border-radius: 4px">             
                    <input onchange="display_image_edit(this.files[0])" type="file" name="image">
                 </label>

             
         
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }

                  </script>
            </div>

  
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
                   value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
            <?php if (!empty($errors['username'])): ?>
                <small class="text-danger"><?php echo $errors['username']; ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                   value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
            <?php if (!empty($errors['email'])): ?>
                <small class="text-danger"><?php echo $errors['email']; ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <?php if (!empty($errors['password'])): ?>
                <small class="text-danger"><?php echo $errors['password']; ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="retype_password">Retype Password</label>
            <input type="password" class="form-control" id="retype_password" name="retype_password" placeholder="Retype Password" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="terms" id="terms" value="accept" required <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="terms">
                Accept terms and conditions
            </label>
            <?php if (!empty($errors['terms'])): ?>
                <small class="text-danger"><?php echo $errors['terms']; ?></small>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-info btn-block">Register</button>
    </form>
    <div class="mt-3 text-center">
        Already have an account? <a href="<?= ROOT ?>/login">Login here</a>
    </div>
</div>
</body>
</html>
