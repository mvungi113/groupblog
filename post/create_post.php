<?php
include_once './include/header.php';
include_once '../database/config.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Collect and sanitize form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $created_at = date('Y-m-d H:i:s'); // Correct date format for timestamp
    $image = $_FILES['image']['name'];
    $target = './uploads/images/' . basename($image);

    // SQL query to insert data into the posts table
    $query = "INSERT INTO posts (title, category, body, image, created_at) VALUES ('$title', '$category', '$body', '$image', '$created_at')";

    // Execute the query and check for errors
    if (mysqli_query($conn, $query)) {
        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Redirect to index.php if successful
            header('Location: index.php');
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Display SQL error
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    $conn->close();
}
?>

<div class="container bg-light p-4 mt-4">
  <form method="post" enctype="multipart/form-data" action="">
    <div class="form-group">
      <label for="exampleInputEmail1">Post Title</label>
      <input type="text" name="title" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp" placeholder="Enter Post Title">
    </div>
    <div class="form-group">
      <label for="categories">Categories</label>
      <select name="category" class="form-group form-select form-select-lg p-2 shadow-none w-100" style="border:1px solid #cbd5e1" required>
        <option value="" selected disabled>Open this select menu</option>
        <option value="Technology">Technology</option>
        <option value="Sports">Sports</option>
        <option value="Education">Education</option>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Post Body</label>
      <textarea class="form-control" name="body" id="exampleFormControlTextarea1" required></textarea>
    </div>
    <div class="form-group">
      <label for="exampleFormControlFile1">Select Image file</label>
      <input type="file" name="image" class="form-control-file" required id="exampleFormControlFile1">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Create Post</button>
  </form>
</div>

<?php include_once './include/footer.php'; ?>
