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
    $bio = strtolower(stripslashes($data["bio"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $position = mysqli_real_escape_string($conn, $data["position"]);
    $instagram = mysqli_real_escape_string($conn, $data["instagram"]);
    $github = mysqli_real_escape_string($conn, $data["github"]);
    $country = mysqli_real_escape_string($conn, $data["country"]);
    $birthday = mysqli_real_escape_string($conn, $data["birthday"]);
    $age = mysqli_real_escape_string($conn, $data["age"]);
    $image = mysqli_real_escape_string($conn, $data["image"]);

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
    mysqli_query($conn, "INSERT INTO users VALUES('','$name', '$username','$bio', '$password', '$position','$instagram','$github','$country','$birthday', '$age', '$image')");
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
    $instagram = stripslashes(strtolower(htmlspecialchars($data["instagram"])));
    $github = stripslashes(strtolower(htmlspecialchars($data["github"])));
    $bio = htmlspecialchars($data["bio"]);
    $birthday = ($data["birthday"]);
    $position = ($data["position"]);
    $country = ($data["country"]);
    $age = ($data["age"]);
    $oldImage = ($data["oldImage"]);
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
            bio = '$bio',
            password = '$password1',
            image = '$image',
            position = '$position',
            instagram = '$instagram',
            github = '$github',
            birthday = '$birthday',
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
function clean($string) {
    $string = str_replace(' ', '-', $string); 
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
 }
function updateProfile2($data){
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
    $username2 = strtolower(stripslashes($data["username2"]));
    $instagram = stripslashes(strtolower(htmlspecialchars($data["instagram"])));
    $github = stripslashes(strtolower(htmlspecialchars($data["github"])));
    $bio = htmlspecialchars($data["bio"]);
    $birthday = ($data["birthday"]);
    $position = ($data["position"]);
    $country = ($data["country"]);
    $age = ($data["age"]);
    $oldImage = ($data["oldImage"]);
    if($_FILES['image']['error'] === 4){
        $image = $oldImage;
    } else {
        $image = upload();
    }
    if (!$image){
        return false;
    }
    if($username != $username2){
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        $checkUsername = true;
        return false;
        }
    }
    $query = "UPDATE users
            SET
            id = '$id',
            name = '$name',
            username = '$username',
            bio = '$bio',
            image = '$image',
            position = '$position',
            instagram = '$instagram',
            github = '$github',
            country = '$country',
            birthday = '$birthday', 
            age = '$age'   
            WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn); 
    
}
function deleteUser($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
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
function addTicket($data){
    global $conn;
    $ticket_title = stripslashes($data["ticket_title"]);
    $date_ticket = $data["date_ticket"];
    $creator = mysqli_real_escape_string($conn, $data["creator"]);
    $desc_ticket = mysqli_real_escape_string($conn, $data["desc_ticket"]);
    $status_ticket = mysqli_real_escape_string($conn, $data["status_ticket"]);
    $id_user = mysqli_real_escape_string($conn, $data["id_user"]);
    $solved_by = $data["solved_by"];
    $feedback = $data['feedback'];
    $image = upload();
    mysqli_query($conn, "INSERT INTO ticket VALUES('','$ticket_title','$date_ticket', '$creator','$desc_ticket', '$status_ticket', '$image', '$id_user','$solved_by','$feedback')");

    return mysqli_affected_rows($conn);
    
}
function confirmTicket($data){
    global $conn;
    $id = htmlspecialchars($data["idtiket"]);
    $statusTciket = $data["status_ticket"];
    mysqli_query($conn, "UPDATE ticket SET status_ticket = '$statusTciket' WHERE id = '$id'");
    return mysqli_affected_rows($conn);
}
function solvedTicket($data){
    global $conn;
    $id = htmlspecialchars($data["idtiket2"]);
    $statusTciket = $data["status_ticket"];
    $solved_by = $data["solved_by"];
    $feedback = $data["feedback"];
    mysqli_query($conn, "UPDATE ticket SET 
                    status_ticket = '$statusTciket',
                    solved_by = '$solved_by',
                    feedback = '$feedback'   
                    WHERE id = '$id'");
    return mysqli_affected_rows($conn);
}
function cancelTicket($data){
    global $conn;
    $id = htmlspecialchars($data["idtiket"]);
    $statusTciket = $data["status_ticket"];
    mysqli_query($conn, "UPDATE ticket SET 
                    status_ticket = '$statusTciket'   
                    WHERE id = '$id'");
    return mysqli_affected_rows($conn);
}