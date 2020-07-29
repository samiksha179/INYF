<?php
$name = $_POST['name'];
$email = $_POST['email'];
$qualifications = $_POST['qualifications'];
$workexp = $_POST['workexp'];
$hireyou = $_POST['hireyou'];

if(!empty($name) || !empty($email) || !empty($qualifications) || !empty($workexp) || !empty($hireyou)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "inyf";

    //CREATE connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    
    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    }else {
        $SELECT = "SELECT email From feedback Where email = ? Limit 1";
        $INSERT = "INSERT Into feedback (name, email, subject, message) values(?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0){
            $stmt->close();
            
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssss", $name, $email, $qualifications, $workexp, $hireyou);
            $stmt->execute();
            echo "Thank You for your feedback!!";
        }else {
            echo "Email already exists";
        }
        $stmt->close();
        $conn->close();
    }
} 
else{
    echo "All Feilds are Required";
}
?>