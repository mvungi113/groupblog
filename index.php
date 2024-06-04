<?php 

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/database/config.php';
?>

<div class="row p-2">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="row">
      <?php
         $sql = "SELECT * FROM posts ORDER BY id DESC";
         
         $result = $conn->query($sql);
 
         while($rows = $result -> fetch_assoc()):?>
                
      <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
      
          <div class="card mt-2">
            <img class="card-img" src="./post/uploads/images/<?php echo $rows['image'] ?>" style="height:200px; width:100%" alt="Card image">
            <div class="col-12 px-0" style="margin-top: -20px;">
              <span class="badge text-light" style="border-radius: 0% !important; padding: 10px; background-color:#e11d48">
                <?php echo $rows['category'] ?>
              </span>

            </div>
            <div class="card-body" style="height: 100px;">
            <h5 class="card-text"  style="font-size: 16px;"><?php echo $rows['created_at'] ?></h5>
              <h4 class="card-text" style="font-size: 16px;"><?php echo $rows['title'] ?></h4>
            </div>
          </div>
      </div>
                
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
