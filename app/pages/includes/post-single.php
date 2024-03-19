<?php 
if(!empty($_POST)){
  $query = "insert into comments (comment_text) VALUES (:comment_text)";
  query($query, ['comment' => $_POST['comment']]);
  

}

?>

<div class="container">
<div class="row justify-content-center">

    <div class="card col-lg-12  border-0 justify-content-center" style="width: 50%;height:50%;">
    <h1><?=$row['title']?></h1>
  <img class="card-img-top" src="<?=get_image($row['image'])?>" alt="Card image cap">
  <div class="card-body">
    <p class="card-text"><?=$row['content']?></p>
    <h5>By <?=$row2['username']?></h5>
  </div>
</div>


  <form method="post">
    <label for="commentField">
      <input type="text" name="comment">
    </label>
  </form>



</div>
</div>