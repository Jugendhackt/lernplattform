<!doctype html>

<head>

</head>

<body>

    <?php

# UPLOAD VIDEO
if(isset($_POST["submit"])) {
  $target_dir = "videos/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  $conn = new mysqli("localhost", "root", "", "lernplatform");

  $name = $_POST["name"];
  $category = $_POST["category"];
  $author = $_POST["author"];

  $sql = "INSERT INTO `videos` (`video`, `name`, `id`, `category`, `author`, `time`) VALUES ('', '$name' , '', '$category' , '$author', '1');";

    echo "<p>" . $sql . "</p>";
    
    if (mysqli_query($conn, $sql)) {
      $last_id = mysqli_insert_id($conn);
      echo "<p>Database entry made!</p>";
     } else {
      echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
     }

    $uploadOk = 1;

    if (file_exists($target_file)) {
      echo "<p>Sorry, file already exists.</p>";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1000000000000) {
      echo "<p>File too large!</p>";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    echo "<p>FILE TYPE:" . $imageFileType . "</p>";
    if($imageFileType != "mp4") {
      echo "<p>Sorry, only mp4 files are allowed.</p>";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "<p>Sorry, your file was not uploaded.</p>";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<p>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
      } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
      }
    }
}

// Check if file already exists

?>

    <form method="post" enctype="multipart/form-data">
        <p>Select a video to upload:</p> <br />
        <input type="file" name="fileToUpload" id="fileToUpload" /><br /><br />
        <input type="text" name="name" placeholder="Name" /><br /><br />
        <input type="text" name="author" placeholder="Author" /><br /><br />
        <input type="text" name="category" placeholder="Category" /><br /><br />
        <input type="submit" value="Upload Video" name="submit" /><br /><br />
    </form>

</body>

</html>