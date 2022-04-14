<?php 
require 'functions.php';
if( isset($_POST["register"]) ){
    if( register($_POST) > 0){
      echo "<script>alert('You are member now!');</script>";
      echo '<script>window.location.href = "login.php"</script>';
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
      <meta charset="utf-8">
      <title>Animated Login Form</title>
      <link rel="stylesheet" href="./style/styleRegister.css">
   <body>
      
      <div class="container">
         <header>Sign up</header>
         <form action="" method = "post" enctype="multipart/form-data">
            <div class="input-field">
               <input type="text" name="name" id="name" required>
               <label>Name</label>
            </div>
            <div class="input-field">
               <input type="text" name="username" id="username" required>
               <label>Username</label>
            </div>
            <div class="input-field">
               <input class="pswrd" type="password" name="password" id="password" required>
               <span class="show"></span>
               <label>Password</label>
               <span id="pass"></span>
               <div class="input-field">
               <input class="pswrd" type="password" name="password2" id="password2" required>
               <input class="pswrd" type="hidden" name="bio" id="id" value="">
               <input class="pswrd" type="hidden" name="position" id="position" value="Employee">
               <input class="pswrd" type="hidden" name="instagram" id="instagram" value="">
               <input class="pswrd" type="hidden" name="github" id="github" value="">
               <input class="pswrd" type="hidden" name="country" id="country" value=" ">
               <input class="pswrd" type="hidden" name="birthday" id="birthday" value="">
               <input class="pswrd" type="hidden" name="age" id="age" value=" ">
               <input class="pswrd" type="hidden" name="image" id="image" value="profileimage.jpg">
               <span class="show"></span>
               <label>Confirm Password</label>
            </div>
            <?php if($checkUsername) : ?>
               <p style="color: red; font-style: italic;">Username already taken !</p>
               <?php endif; ?>
            <?php if($checkPassMatch) : ?>
               <p style="color: red; font-style: italic;">Password not match !</p>
               <?php endif; ?>
            <?php if($checkPass2) : ?>
               <p style="color: red; font-style: italic;">Minimum 5 characters and 1 uppercase</p>
               <?php endif; ?>
            <?php if($checkPass3) : ?>
               <p style="color: red; font-style: italic;">Minimum 1 uppercase</p>
               <?php endif; ?>
            <?php if($checkPass4) : ?>
               <p style="color: red; font-style: italic;">Minimum 5 characters</p>
               <?php endif; ?>
            <div class="button">
               <div class="inner"></div>
               <button type="submit" name="register" id="register">CREATE ACCOUNT</button>
               
            </div>
            <div class="signup">
            Have already an account ? <a href="login.php">Login now</a>
         </div>
         
         </form>    
      </div>
   </body>
</html>