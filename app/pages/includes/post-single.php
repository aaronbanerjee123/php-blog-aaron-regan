

<?php 

$query = "select * from comments";
$comments = query($query);

if(!empty($_POST)){
  $query = "insert into comments (comment_text) VALUES (:comment_text)";
  query($query, ['comment_text' => $_POST['comment']]);

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




  <form method="POST" id="comment_form">
    <div class="form-group">
      <input type="text" name="comment_name" id="comment_name" class="form-control"
             placeholder="Enter Name" />
    </div>


    <div class="form-group">
      <textarea type="text" name="comment_content" id="comment_content" class="form-control"
             placeholder="Enter Comment"></textarea>
    </div>


    <div class="form-group">
      <textarea type="submit" name="submit" id="submit" class="btn btn-info"
             placeholder="Enter Comment"></textarea>
    </div>
  </form>
  <span id="comment_message"></span>
  <br />
  <div id="display_comment"></div>
</div>

</div>
</div>

<script>
  $(document).ready(function() {
    $('#comment_form')
  })
</script>