<?php
include_once './include/header.php';
include_once '../database/config.php';

if (isset($_POST['submit'])) {
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $body = mysqli_real_escape_string($conn, $_POST['body']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $created_at = date('Y-m-d H:i:s');
  $image = $_FILES['image']['name'];

  // Check if an image is uploaded
  if ($image) {
    $target = './uploads/images/' . basename($image);
    $image_sql = ", image='$image'";
  } else {
    $image_sql = '';
  }

  $sql = "UPDATE posts SET title='$title', body='$body', category='$category', created_at='$created_at'$image_sql WHERE id='$id'";

  if ($conn->query($sql) === TRUE) {
    if ($image) {
      if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        header('Location: index.php');
        exit;
      } else {
        echo "Failed to upload image.";
      }
    } else {
      header('Location: index.php');
      exit;
    }
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = "SELECT * FROM posts WHERE id='$id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $body = $row['body'];
    $category = $row['category'];
    $image = $row['image'];
  } else {
    echo "Post not found.";
  }
}
?>

<div class="container bg-light mt-4 p-4">
  <form method="post" enctype="multipart/form-data" action="">
    <div class="form-group">
      <input type="hidden" name="id" class="form-control" value="<?php echo htmlspecialchars($id); ?>" required>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Post Title</label>
      <input type="text" name="title" class="form-control" id="exampleInputEmail1" value="<?php echo htmlspecialchars($title); ?>" required aria-describedby="emailHelp" placeholder="Enter Post Title">
    </div>
    <div class="form-group">
      <label for="categories">Categories</label>
      <select name="category" class="form-group form-select form-select-lg p-2 shadow-none w-100" style="border:1px solid #cbd5e1" required>
        <option value="" disabled>Open this select menu</option>
        <option value="Technology" <?php echo ($category == 'Technology') ? 'selected' : ''; ?>>Technology</option>
        <option value="Sports" <?php echo ($category == 'Sports') ? 'selected' : ''; ?>>Sports</option>
        <option value="Education" <?php echo ($category == 'Education') ? 'selected' : ''; ?>>Education</option>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Post Body</label>
      <textarea class="form-control" name="body" id="exampleFormControlTextarea1" required><?php echo htmlspecialchars($body); ?></textarea>
    </div>
    <div class="form-group">
      <label for="exampleFormControlFile1">Select Image file</label>
      <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

<?php include_once './include/footer.php'; ?>
