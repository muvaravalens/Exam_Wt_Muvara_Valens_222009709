<?php
include('database_connection.php');

// Fetch client information if client_id is provided
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    
    $stmt = $connection->prepare("SELECT * FROM clients WHERE client_id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $client_id = $row['client_id'];
        $client_name = $row['client_name'];
        // Add other client details if needed
    } else {
        echo "Client not found.";
        exit(); // Stop execution if no matching record
    }
} else {
    echo "No client ID specified.";
    exit(); // Stop execution if no client_id is provided
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Client</title>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?'); // Confirmation prompt
        }
    </script>
</head>
<body style="background-color: lightblue;">
    <h2>Update Client Information</h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="client_id">Client Id:</label>
        <input type="number" id="client_id" name="client_id" value="<?php echo htmlspecialchars($client_id); ?>" readonly>
        <br><br>

        <label for="client_name">Client Name:</label>
        <input type="text" id="client_name" name="client_name" value="<?php echo htmlspecialchars($client_name); ?>">
        <br><br>
        
        <!-- Add other client fields here -->
        
        <input type="submit" name="update" value="Update">
        <a href="./client.php">Go Back to Form</a>
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];
    // Add other client fields if needed

    $stmt = $connection->prepare("UPDATE clients SET client_name = ? WHERE client_id = ?");
    $stmt->bind_param("si", $client_name, $client_id);
    $stmt->execute();
    
    header('Location: client.php');
    exit();
}
?>
