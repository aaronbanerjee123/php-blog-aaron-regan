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

    if (empty($errors)) {
        $data = [];
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['role'] = 'user';
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
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
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
                   value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            <?php if (!empty($errors['username'])): ?>
                <small class="text-danger"><?php echo $errors['username']; ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                   value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <?php if (!empty($errors['email'])): ?>
                <small class="text-danger"><?php echo $errors['email']; ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <?php if (!empty($errors['password'])): ?>
                <small class="text-danger"><?php echo $errors['password']; ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="retype_password">Retype Password</label>
            <input type="password" class="form-control" id="retype_password" name="retype_password"
                   placeholder="Retype Password">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="terms" id="terms"
                   value="accept" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="terms">
                Accept terms and conditions
            </label>
            <?php if (!empty($errors['terms'])): ?>
                <small class="text-danger"><?php echo $errors['terms']; ?></small>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-info btn-block">register</button>
    </form>
    <div class="mt-3 text-center">
        Already have an account? <a href="<?= ROOT ?>/login">Login here</a>
    </div>
</div
