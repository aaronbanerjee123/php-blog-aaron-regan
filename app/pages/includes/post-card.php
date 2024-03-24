<div class="col-md-6">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary"><?=$row['category']?></strong>
            <a href="<?=ROOT?>/post/<?=$row['slug']?>" style="text-decoration: none; color: inherit;">
                <h3 class="mb-0"><?=$row['title']?></h3>
            </a>
            <div class="mb-1 text-muted"><?=date("Y-m-d",strtotime($row['date']))?></div>
            <p class="card-text mb-auto"><?=substr($row['content'],0,200)?></p>
        </div>
        <div class="col-lg-5 col-12 d-lg-block" style="max-height: 150px;">
            <img src="<?=get_image($row['image'])?>" class="bd-placeholder-img w-100" height="250" style="object-fit:cover;" />
        </div>
        <!-- Edit Button -->
        <?php if($row['user_id'] == user('id')) { ?>
            <a href="<?=ROOT?>/edit/<?=$row['id']?>" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 mt-5" style="width:20%;">Edit</a>
          <?php } ?>

        </div>
</div>






 <!-- <div class="col-md-6">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary"><?=$row['category']?></strong>
          

          <a href="<?=ROOT?>/post/<?=$row['slug']?>">
          <h3 class="mb-0"><?=$row['title']?></h3>
         </a>
          
          <div class="mb-1 text-muted"><?=date("Y-m-d",strtotime($row['date']))?></div>
          <p class="card-text mb-auto"><?=substr($row['content'],0,200)?></p>
          <a href="<?=ROOT?>/post/<?=$row['slug']?>" class="stretched-link">Continue reading</a>
        </div>
        <div class="col-lg-5 col-12 d-lg-block">
          <img src="<?=get_image($row['image'])?>" class="bd-placeholder-img w-100"  height="250" style="object-fit:cover;" />
        </div> 
      </div>
    </div> -->
