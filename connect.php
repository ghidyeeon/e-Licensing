<?php
// Start the session
session_start();

// Database connection parameters
$host = "localhost"; // MySQL server (usually localhost)
$dbname = "users"; // Replace with your database name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password

// Create a new PDO instance to connect to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Prepare a statement to find the user by username
    $stmt = $conn->prepare("SELECT id, username, password FROM facility WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $input_username);
    $stmt->execute();

    // Check if a user is found
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if (password_verify($input_password, $user['password'])) {
            // Password is correct, start the session
            //$_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php"); // Redirect to a dashboard or home page
            exit;
        } else {
            // Password is incorrect
            echo "Invalid password.";
        }
    } else {
        // No user found with the provided username
        echo "No account found with that username.";
    }
}
?>
