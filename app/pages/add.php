<?php 
    $query = "select * from categories";
    $rows = query($query, []);
    $user_image = $_SESSION['USER']['image'];

    if(!empty($_POST)) {
        $errors = [];
    
        if(empty($_POST['title'])) {
            $errors['title'] = "A title is required";
        }
      
        if(empty($_POST['content'])) {
            $errors['content'] = 'Content required';
        }
    
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if(!empty($_FILES['image']['name'])) {
            $destination = "";
            if(!in_array($_FILES['image']['type'], $allowed)) {
                $errors['image'] = "Image format not supported";
            } else {
                $folder = "uploads/";
                if(!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $destination = $folder . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            }
        } else {
            $errors['image'] = 'Post needs an image';
        }
  
        $slug = str_to_url($_POST['title']);
  
        if(empty($errors)) {
            $data = [];
            $data['title'] = $_POST['title'];
            $data['content'] = $_POST['content'];
            $data['slug'] = str_to_url($_POST['title']);
            $data['category_id'] = $_POST['category_id'];
            $data['user_id'] = user('id');
            $data['image'] = $destination;
            $query = "insert into posts (title, content, category_id, slug, user_id, image) values (:title, :content, :category_id, :slug, :user_id, :image)";
            query($query, $data);
            redirect_home();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Blog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #FFEBE7;
        }
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>

    <!-- Slider -->
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
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h1>Add a New Blog</h1>

                <div class="my-2">
                    Featured Image: <br>
                    <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 5px solid #7F95D1; border-radius: 10px;">
                        <div style="text-align: center;">
                            <input onchange="display_image_edit(this.files[0])" type="file" name="image" style="margin-top: 10px;">
                        </div>
                    </label>

                    <script>
                        function display_image_edit(file) {
                            document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
                        }
                    </script>
                </div>

                <?php if(!empty($errors['image'])): ?>
                    <div class="alert alert-danger">
                        <?=$errors['image']?>
                    </div>
                <?php endif; ?>

                <div class="form-group my-3">
                    <label for="titleFormControlInput1">Title</label>
                    <input type="text" class="form-control" id="titleFormControlInput1" value="<?=old_value('title')?>" name="title" placeholder="Enter title">
                </div>

                <?php if(!empty($errors['title'])): ?>
                    <div class="alert alert-danger">
                        <?=$errors['title']?>
                    </div>
                <?php endif; ?>

                <div class="form-group my-3">
                    <label for="exampleFormControlSelect1">Select the category</label>
                    <select class="form-control" name="category_id" id="exampleFormControlSelect1">
                        <?php foreach($rows as $row): ?>
                            <option value="<?=$row['id']?>"><?=$row['category']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group my-3">
                    <label for="contentArea">Content</label>
                    <textarea class="form-control" name="content" value="<?=old_value('content')?>" id="contentArea" rows="3"></textarea>
                </div>

                <?php if(!empty($errors['content'])): ?>
                    <div class="alert alert-danger">
                        <?=$errors['content']?>
                    </div>
                <?php endif; ?>

                <button type="submit" data-role="update" class="btn btn-info my-3">Submit</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('button[data-role=update]').on('click', function() {
                alert('hello');
            });
        });
    </script>
</body>
</html>
