<?php
// Include database connection file to establish a connection to the database
include('database_connection.php'); // Modify to match your actual file path

// Check if 'client_id' parameter is set in the request
if (isset($_REQUEST['client_id'])) {
    $client_id = $_REQUEST['client_id'];
    
    // Prepare the SQL statement to delete a record from the clients table
    $stmt = $connection->prepare("DELETE FROM clients WHERE client_id = ?");
    $stmt->bind_param("i", $client_id); // 'i' indicates that 'client_id' is an integer

    // HTML structure for the page
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Client</title>
    <script>
        // Function to confirm the deletion when the form is submitted
        function confirmDelete() {
            return confirm("Are you sure you want to delete this client?");
        }
    </script>
</head>
<body bgcolor="pineapple"> <!-- Unique background color as mentioned -->

    <!-- Form to trigger the deletion process upon submission -->
    <form method="post" onsubmit="return confirmDelete();">
        <!-- Hidden field to carry the client_id value in POST request -->
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
        <!-- Submit button for deleting the client record -->
        <input type="submit" value="Delete Client">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Execute the delete statement and check for success
        if ($stmt->execute()) {
            echo "Client record deleted successfully."; 
        } else {
            echo "Error deleting client record: " . $stmt->error; 
        }
    }
    ?>

    <!-- Button to navigate back to the client list -->
    <button onclick="window.location.href='./client.php'">Back to Client List</button>

</body>
</html>
<?php
    // Close the prepared statement after execution
    $stmt->close();
} else {
    echo "Client ID is not set.";
}

// Close the database connection
$connection->close();
?>
