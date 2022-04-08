<?php
session_start();
if (!isset($_SESSION["login"])){
  header("location: login.php");
  exit;
}
require 'functions.php';
$id = ($_GET["id"]);
$image = $_SESSION['image'];
$data = query("SELECT id, name, username, image FROM users WHERE id = $id")[0];
if(isset($_POST["submit"])){

    if(updateProfile($_POST) > 0 ){
        echo "  <script>
                    alert('Your articel has been saved!')document.location.href = 'index.php'
                </script>";
    } else {
        echo "<script>alert('erorr!') document.location.href = 'index.php'</script>";
    }
}


?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Page</title>
    <!-- <link rel="stylesheet" href="styleDetail.css"> -->

  </head>
  <body>
    <div class="container">
      <div class="wrapper">
        <section class="post">
          <header>Detail Post</header>
          <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?= $data["id"] ?>">
            <div class="content">
            </div>
            <div class="input-container">
		<input type="text" name="name" id="name" value="<?= $data["name"] ?>" readonly="readonly"/>
		<p>Name</p>
            <div class="input-container">
		<input type="text" name="username" id="username" value="<?= $data["username"] ?>" readonly="readonly"/>
		<p>tittle</p>
	</div>
    <img class="img-profile rounded-circle"
                                    src="img/<?php echo $_SESSION['image']; ?>" title="<?php echo $image; ?>"
            <input type="text"><br>
            <input type = "hidden" type="file" name="oldImage" id="oldImage" value="<?= $data["image"]?>"><br>
            <input type="file" name="image" id="image"><br>
            <button type="submit" name="submit">edit</button>
          </form>
    
    </div>
  </body>
</html>