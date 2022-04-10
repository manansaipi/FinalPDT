<?php 
$conn = mysqli_connect("localhost","root","","final_pdt");
$checkUsername = false;
$checkPassMatch = false;
$checkPass2 = false;
$checkPass3 = false;
$checkPass4 = false;
$succes = false;
$checkPass = false;
function register($data){
    global $conn;
    global $checkUsername;
    global $checkPassMatch;
    global $checkPass2;
    global $checkPass3;
    global $checkPass4;
    $name = $data["name"];
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $position = mysqli_real_escape_string($conn, $data["position"]);
    $country = mysqli_real_escape_string($conn, $data["country"]);
    $age = mysqli_real_escape_string($conn, $data["age"]);
    $image = mysqli_real_escape_string($conn, $data["image"]);
    //upload profile im1g
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        $checkUsername = true;
        return false;
    } 
    if ($password !== $password2){
        
        $checkPassMatch = true;
        return false;
    } else if (strlen(trim($password)) < 5 && !preg_match("/[A-Z]/", $password)){
        $checkPass2 = true;
        return false;
    } else if (!preg_match("/[A-Z]/", $password)){
        $checkPass3 = true;
        return false;
    } else if (strlen(trim($password)) < 5){
        $checkPass4 = true;
        return false;
    } else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users VALUES('','$name', '$username', '$password', '$position','$country', '$age', '$image')");
    return mysqli_affected_rows($conn);
    }   
    
}

function upload(){
    $fileName = $_FILES['image']['name'];
    $fileSize = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

    if($error === 4){
        echo "<script>alert('Chose a file !')</script>";
        return false;
    }

    $validationImg = ['jpg', 'jpeg', 'png'];
    $ekstensiImage = explode('.', $fileName);
    $ekstensiImage = strtolower(end($ekstensiImage));
    if(!in_array($ekstensiImage, $validationImg)){
        echo "<script>alert('Please upload an image !')</script>";
        return false;
    }
    #cek the file size  
    if($fileSize > 10000000){
        echo "<script>alert('File size is to big !')</script>";
        return false;
    }

    $newFileName = uniqid();
    $newFileName .= '.';
    $newFileName .= $ekstensiImage;
    
    move_uploaded_file($tmpName,'img/'. $newFileName);
    return $newFileName;

}

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;   
}
function insert($data){
        global $conn;
        $title = htmlspecialchars($data["title"]);
        $content = htmlspecialchars($data["content"]);
        $name = htmlspecialchars($data["name"]);
        $image = upload();
        if (!$image){
            return false;
        }
        $query = "INSERT INTO articel 
                    VALUES 
                    ('', '$title', '$content','$name')";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
}

function updateProfile($data){
    global $conn;
    global $checkUsername;
    global $checkPass;
    global $checkPassMatch;
    global $checkPass2;
    global $checkPass3;
    global $checkPass4;
    $sessionUsername = $_SESSION['username'];
    $id = htmlspecialchars($data["id"]);
    $name = htmlspecialchars($data["name"]);
    $username = strtolower(stripslashes($data["username"]));
    $position = ($data["position"]);
    $country = htmlspecialchars($data["country"]);
    $age = htmlspecialchars($data["age"]);
    $oldImage = htmlspecialchars($data["oldImage"]);
    $password = $_POST["password"];  
    $password1 = mysqli_real_escape_string($conn, $data["password1"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    if($_FILES['image']['error'] === 4){
        $image = $oldImage;
    } else {
        $image = upload();
    }
    if (!$image){
        return false;
    }
    if($username != $sessionUsername){
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        $checkUsername = true;
        return false;
    }
}
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1 ){
    while ($row = mysqli_fetch_assoc($result)){
        if( password_verify($password, $row["password"]) ){
    if ($password1 != $password2){
        $checkPassMatch = true;
        return false;
    } else if (strlen(trim($password1)) < 5 && !preg_match("/[A-Z]/", $password1)  || strlen(trim($password2)) < 5 && !preg_match("/[A-Z]/", $password2)){
        $checkPass2 = true;
        return false;
    } else if (!preg_match("/[A-Z]/", $password1) || !preg_match("/[A-Z]/", $password2)){
        $checkPass3 = true;
        return false;
    } else if (strlen(trim($password1)) < 5 || strlen(trim($password2)) < 5){
        $checkPass4 = true;
        return false;
    } else {
    $password1 = password_hash($password1, PASSWORD_DEFAULT);
    $query = "UPDATE users
            SET
            id = '$id',
            name = '$name',
            username = '$username',
            password = '$password1',
            image = '$image',
            position = '$position',
            country = '$country', 
            age = '$age'   
            WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
                    }
                }
    $checkPass = true;
    return false;
        }
    }
}
function delete($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM articel WHERE id = $id");
    return mysqli_affected_rows($conn);
}
function edit($data){
    global $conn;
    $id = $data["id"];
    $title = htmlspecialchars($data["title"]);
    $content = htmlspecialchars($data["content"]);
    $name = htmlspecialchars($data["name"]);

    $query = "UPDATE articel SET 
                title = '$title', 
                content = '$content',
                name = '$name' WHERE id = $id";
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}