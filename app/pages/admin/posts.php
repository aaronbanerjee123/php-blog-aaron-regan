<?php if($action == 'add'):?>
          <div class="col-md-6 mx-auto">
          <form method="post" enctype="multipart/form-data">
          <a href="home">
            <img class="mb-4 rounded-circle shadow" src="<?=ROOT?>/assets/images/logo.jpg" alt="" width="92" height="92" style="object-fit:cover;">
          </a>
        
          <h1 class="h3 mb-3 fw-normal">Create Post</h1>

        <?php if(!empty($errors)){ ?>
          <div class="alert alert-danger">
            Please fix the errors below
          </div>
        <?php  }?>

          <div class="my-2">
                Featured Image: <br>
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover;">                  </div>
                    <input onchange="display_image_edit(this.files[0])" type="file" name="image">
                 </label>

             
                
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }

                  </script>
            </div>

            <div class="form-floating">
                    <input value="<?php echo old_value('title')?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="title">
                    <label for="floatingInput">title</label>
                  </div>

                  <?php if(!empty($errors['title'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['title'];?>
                    </div>
                    <?php }?>
        


                  <div>
                    <textarea rows="4" name="content" value="<?=old_value('content')?>" id="floatingInput" placeholder="content" style="width:100%;"></textarea>
                  </div>

                  <?php if(!empty($errors['content'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['content'];?>
                    </div>
                    <?php }?>

                    

                  <?php
                    $query = "select * from categories order by id desc";
                    $categories = query($query);


                  ?>

                  <div class="form-floating my-3">
                    <select name="category_id" class="form-select">                    
                    <?php if(!empty($categories)):?>
                        <?php foreach($categories as $category) :?>
                            <option value="<?=old_value('category_id', $category['id'])?>"><?=$category["category"]?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                        </select>
                        <label for="form-floating">Category</label>
                      </div>

    

                  
                  <button class="mt-4 w-30 btn btn-lg btn-primary float-end" type="submit">Save</button>
                  <a href = "<?=ROOT?>/admin/posts/"><button class="mt-4 w-30 btn btn-lg btn-primary " type="button">back</button>
              </a>
                  </form>
        </div>


<?php elseif($action == 'edit'):?>

                  <div class="col-md-6 mx-auto">
                  <form method="post" enctype="multipart/form-data">
                  <a href="home">
                    <img class="mb-4 rounded-circle shadow" src="<?=ROOT?>/assets/images/logo.jpg" alt="" width="92" height="92" style="object-fit:cover;">
                  </a>
                
                  <h1 class="h3 mb-3 fw-normal">Edit Post</h1>

              <?php if(!empty($row)):?>

                <?php if(!empty($errors)){ ?>
                  <div class="alert alert-danger">
                    Please fix the errors below
                  </div>
                <?php  }?>
                    

                <div class="my-2">
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover;">
                    <input type="file" name="image" onchange="display_image_edit(this.files[0])">
                  </label>
                
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }
                  </script>
                </div>

                  <div class="form-floating">
                    <input value="<?php echo old_value('title',$row['title'])?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="title">
                    <label for="floatingInput">title</label>
                  </div>

                  <?php if(!empty($errors['title'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['title'];?>
                    </div>
                    <?php }?>
        


                  <div class="form-floating">
                    <input value="<?php echo old_value('content',$row['content'])?>" name="content" type="content" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">content</label>
                  </div>


                  <?php if(!empty($errors['content'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['content'];?>
                    </div>
                    <?php }?>

                           

                  <?php
                    $query = "select * from categories order by id desc";
                    $categories = query($query);


                  ?>
                    

                    <div class="form-floating my-3">
                    <select name="category_id" class="form-select">


                    <?php if(!empty($categories)):?>
                        <?php foreach($categories as $category) :?>
                            <option value="<?=old_value('category_id', $category['id'])?>"><?=$category["category"]?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                        </select>
                        <label for="form-floating">Category</label>
                      </div>


                  
                  <button class="mt-4 w-30 btn btn-lg btn-primary float-end" type="submit">Save</button>
                  <a href = "<?=ROOT?>/admin/posts/"><button class="mt-4 w-30 btn btn-lg btn-primary " type="button">back</button>
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
            
              <h1 class="h3 mb-3 fw-normal">Delete Post</h1>

          <?php if(!empty($row)):?>

            <?php if(!empty($errors)){ ?>
              <div class="alert alert-danger">
                Please fix the errors below
              </div>
            <?php  }?>

              <div class="form-floating">
                <div class="form-control mb-2">
                <?=old_value('title',$row['title'])?>
              </div>
            </div>
              
              </div>

              <?php if(!empty($errors['title'])){ ?>
                <div class="text-danger">
                    <?php echo $errors['title'];?>
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
              <a href = "<?=ROOT?>/admin/posts/"><button class="mt-4 w-30 btn btn-lg btn-primary " type="button">back</button>
          </a>

          </form>
          <?php endif;?>
      </div>


<?php else:?>


<h1>Posts page
    <button class="btn btn-primary"><a class="text-white" href="<?=ROOT?>/admin/posts/add">Add New Post</a></button>
</h1>


<div class="table-responsive">
<table class="table">
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Slug</th>
        <th>Image</th>
        <th>Date</th>
        <th>Action</th>
    </tr>


    <?php 
       
        // $limit = 10;  
        // $offset = ($PAGE['page_number'] - 1)*$limit;

        $query = "select * from posts order by id desc";
        $rows = query($query); //confused how we have access to query here
    ?>

    <?php if(!empty($rows)) { ?>
        <?php foreach($rows as $row){ ?>
    <tr>
        <td><?=$row['id']?></td>
        <td><?=esc($row['title'])?></td>
        <td><?=$row['slug']?></td>

        <td>
  
          <img src="<?=get_image($row['image'])?>" style="width:100px;height:100px;object-fit:cover;">
        </td>

        <td><?=$row['date']?></td>
     
        <td><a class="text-white" href="<?=ROOT?>/admin/posts/edit/<?=$row['id']?>"><button class="btn btn-warning text-white btn-sm"><i class="bi bi-pencil-square"></i></button></a></td>
        
<!--            
        <a class="text-white" href="<?=ROOT?>/admin/posts/edit/<?=$row['id']?>">Add New</a>
        <td><button class="btn btn-danger text-white btn-sm"><i class="bi bi-trash-fill"></i></button></td>
     -->
    
        <td><a class="text-white" href="<?=ROOT?>/admin/posts/delete/<?=$row['id']?>"><button class="btn btn-danger text-white btn-sm"><i class="bi bi-pencil-square"></i></button></a></td>

    
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

