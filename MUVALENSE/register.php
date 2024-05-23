<?php
include('database_connection.php');

// Check if the request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Correct the syntax by adding missing closing parentheses
    $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare the SQL query to insert data into users table
    $sql = "INSERT INTO users (user_id, first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $connection->prepare($sql); // Prepare the statement
    $stmt->bind_param("ssssss", $user_id, $first_name, $last_name, $username, $email, $password); // Bind parameters

    // Execute the query and check if it's successful
    if ($stmt->execute()) {
        header("Location: login.html"); // Redirect after successful registration
        exit(); // Ensure no further code is executed
    } else {
        echo "Error: " . $stmt->error; // Display error message if the query fails
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>
