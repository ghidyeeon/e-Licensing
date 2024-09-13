<?php

session_start();


$host = "localhost"; 
$dbname = "users"; 
$db_user = "root"; 
$db_pass = ""; 


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    
    $stmt = $conn->prepare("SELECT id, username, password FROM facility WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $input_username);
    $stmt->execute();

    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if (password_verify($input_password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php"); 
            exit;
        } else {
            
            echo "Invalid password.";
        }
    } else {
        
        echo "No account found with that username.";    
    }
}
?>
