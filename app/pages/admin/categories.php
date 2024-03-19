<?php if($action == 'add'):?>
          <div class="col-md-6 mx-auto">
          <form method="post" enctype="multipart/form-data">
          <a href="home">
            <img class="mb-4 rounded-circle shadow" src="<?=ROOT?>/assets/images/logo.jpg" alt="" width="92" height="92" style="object-fit:cover;">
          </a>
        
          <h1 class="h3 mb-3 fw-normal">Create Category</h1>

        <?php if(!empty($errors)){ ?>
          <div class="alert alert-danger">
            Please fix the errors below
          </div>
        <?php  }?>

       
          <div class="form-floating">
            <input value="<?php echo old_value('category')?>" name="category" type="text" class="form-control mb-2" id="floatingInput" placeholder="category">
            <label for="floatingInput">category</label>
          </div>

          <?php if(!empty($errors['category'])){ ?>
            <div class="text-danger">
                <?php echo $errors['category'];?>
            </div>
            <?php }?>



          <div class="form-floating my-3">
            <select name="disabled" class="form-select">
              <option value="0">Yes</option>
              <option value="1">No</option>
            </select>
            <label for="form-select">Active</label>
          </div>

            
          
          <button class="mt-4 w-30 btn btn-lg btn-primary float-end" type="submit">Create</button>
          <a href = "<?=ROOT?>/admin/categories/"><button class="mt-4 w-30 btn btn-lg btn-primary" type="button">back</button></a>
        </form>
      </div>



<?php elseif($action == 'edit'):?>

                  <div class="col-md-6 mx-auto">
                  <form method="post" enctype="multipart/form-data">
                  <a href="home">
                    <img class="mb-4 rounded-circle shadow" src="<?=ROOT?>/assets/images/logo.jpg" alt="" width="92" height="92" style="object-fit:cover;">
                  </a>
                
                  <h1 class="h3 mb-3 fw-normal">Edit Category</h1>

              <?php if(!empty($row)):?>

                <?php if(!empty($errors)){ ?>
                  <div class="alert alert-danger">
                    Please fix the errors below
                  </div>
                <?php  }?>
                    

                <div class="my-2">
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover;"></div>
                    <input type="file" name="image" onchange="display_image_edit(this.files[0])">
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
            <select name="role" class="form-select">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
            <label for="form-select">Role</label>
          </div>

            
          <?php if(!empty($errors['role'])){ ?>
            <div class="text-danger">
                <?php echo $errors['role'];?>
            </div>
            <?php }?>


                  <div class="form-floating">
                    <input value="<?php echo old_value('email',$row['email'])?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
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

                  
                  <button class="mt-4 w-30 btn btn-lg btn-primary float-end" type="submit">Save</button>
                  <a href = "<?=ROOT?>/admin/categories/"><button class="mt-4 w-30 btn btn-lg btn-primary " type="button">back</button>
              </a>

              <?php endif;?>
              </form>
              </div>


<?php elseif($action == 'delete'):?>
              <div class="col-md-6 mx-auto">
              <form method="post">
              <a href="home">
                <img class="mb-4 rounded-circle shadow" src="<?=ROOT?>/assets/images/logo.jpg" alt="" width="92" height="92" style="object-fit:cover;">
              </a>
            
              <h1 class="h3 mb-3 fw-normal">Delete Category</h1>

          <?php if(!empty($row)):?>

            <?php if(!empty($errors)){ ?>
              <div class="alert alert-danger">
                Please fix the errors below
              </div>
            <?php  }?>

              <div class="form-floating">
                <div class="form-control mb-2">
                <?=old_value('category',$row['category'])?>
              </div>
            </div>
              
              </div>

              <?php if(!empty($errors['category'])){ ?>
                <div class="text-danger">
                    <?php echo $errors['category'];?>
                </div>
                <?php }?>

              <div class="form-floating">
                <div class="form-control mb-2">
                <?=old_value('slug',$row['slug'])?>
              </div>
            </div>

              <?php if(!empty($errors['slug'])){ ?>
                <div class="text-danger">
                    <?php echo $errors['slug'];?>
                </div>
                <?php }?>


              
              <button class="mt-4 w-30 btn btn-lg btn-danger float-end" type="submit" value="delete" name="deleteBtn">Delete</button>
              <a href = "<?=ROOT?>/admin/categories/"><button class="mt-4 w-30 btn btn-lg btn-primary " type="button">back</button>
          </a>

          </form>
          <?php endif;?>
      </div>


<?php else:?>


<h1>Categories Page
    <button class="btn btn-primary"><a class="text-white" href="<?=ROOT?>/admin/categories/add">Add New</a></button>
</h1>


<div class="table-responsive">
<table class="table">
    <tr>
        <th>#</th>
        <th>Category</th>
        <th>Slug</th>
        <th>Disabled</th>
        <th>Action</th>
    </tr>


    <?php 
       
        // $limit = 10;  
        // $offset = ($PAGE['page_number'] - 1)*$limit;

        $query = "select * from categories order by id desc";
        $rows = query($query); //confused how we have access to query here
    ?>

    <?php if(!empty($rows)) { ?>
        <?php foreach($rows as $row){ ?>
    <tr>
        <td><?=$row['id']?></td>
        <td><?=esc($row['category'])?></td>
        <td><?=$row['slug']?></td>
        <td><?=$row['disabled']?></td>

      
     
        
<!--            
        <a class="text-white" href="<?=ROOT?>/admin/categories/edit/<?=$row['id']?>">Add New</a>
        <td><button class="btn btn-danger text-white btn-sm"><i class="bi bi-trash-fill"></i></button></td>
     -->
    
        <td><a class="text-white" href="<?=ROOT?>/admin/categories/delete/<?=$row['id']?>"><button class="btn btn-danger text-white btn-sm"><i class="bi bi-pencil-square"></i></button></a></td>

    
    </tr>

        <?php } ?>
    <?php } ?>
</table>

<div class="col-md-12 mb-4">
  <a href="<?=$PAGE['first_link']?>">
    <button class="btn btn-primary">First Page</button>
   </a>
   <a href="<?=$PAGE['prev_link']?>">
    <button class="btn btn-primary">Prev Page</button>
   </a>
   <a href="<?=$PAGE['next_link']?>">
    <button class="btn btn-primary float-end">Next Page</button>
   </a>
</div>

</div>

<?php endif;?>

