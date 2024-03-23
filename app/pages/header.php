<?php
if($_SESSION['USER']){
  $user_image = $_SESSION['USER']['image'];

}
?>


<style>
  header{
    background-color: #7F95D1; /* Change the background color */
  }
 
  .link-gray {
    color: black;
  }

  .link-gray:hover {
    color: black;
    color: lightgray; /* Change color to black on hover */
  }

  
</style>

<header class="p-3  border-bottom">
    
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      
      
      <a href="<?=ROOT?>" class="nav-link px-2 link-dark" style="font-size: 24px;">InSightInk</a>



        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="<?=ROOT?>/myblogs" class="nav-link px-2 link-gray">My Blog</a></li>
          <li><a href="<?=ROOT?>/add" class="nav-link px-2 link-gray">Add Blog</a></li>
          <?php if(!$_SESSION['USER']) {?>
                      
            <li><a href="<?=ROOT?>/login" class="nav-link px-2 link-gray">Login</a></li>

            <?php } ?>
        </ul>

        <form class="row align-items-center mb-3 mb-lg-0 me-lg-3" role="search" action="<?=ROOT?>/search">
            <div class="col-md-auto">
                <input type="search" name="find" class="form-control" placeholder="Search..." aria-label="Search">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-dark">Find</button>
            </div>
        </form>

        <?php if($_SESSION['USER']){ ?>
        <div class="dropdown text-end">
        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                   aria-expanded="false">
               
                    <img src="<?= get_image($user_image) ?>" alt="mdo" width="32" height="32"
                         class="rounded-circle">
                </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="<?=ROOT?>/admin">Admin</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>/settings">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?=ROOT?>/logout">Sign out</a></li>
          </ul>
        </div>
        <?php } ?>
      </div>
    </div>
  </header>



