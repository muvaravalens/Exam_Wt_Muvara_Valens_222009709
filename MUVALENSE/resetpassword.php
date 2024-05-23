<?php
$host = "localhost";
$user = "valens";
$pass = "222009709";
$database = "business";

$connection = new mysqli($host, $user, $pass, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

function sanitize_input($connection, $input) {
    return mysqli_real_escape_string($connection, $input);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email address entered by the user
    $email = $_POST['email'];
    // 1. Generate a unique token for password reset
    // 2. Store the token in the database along with the user's email and a timestamp
    // 3. Send an email to the user with a link to the password reset page containing the token

    // After completing the password reset process, you can redirect the user to a confirmation page
    header("Location: Password_reset_confirmation.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body style="background-image: url('./Images/c.jpeg'); background-size: cover;">

    <h2>Forgot Password</h2>
    <form action="resetpassword.php" method="post">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
