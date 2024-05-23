<?php
// Include database connection file to establish a connection to the database
include('database_connection.php'); // Modify to match your actual file path

// Check if 'asset_id' parameter is set in the request
if (isset($_REQUEST['asset_id'])) {
    $asset_id = $_REQUEST['asset_id'];
    
    // Prepare the SQL statement to delete a record from the asset table
    $stmt = $connection->prepare("DELETE FROM asset WHERE asset_id = ?");
    $stmt->bind_param("i", $asset_id); // 'i' indicates that 'asset_id' is an integer

    // HTML structure for the page
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Asset</title>
    <script>
        // Function to confirm the deletion when the form is submitted
        function confirmDelete() {
            return confirm("Are you sure you want to delete this asset?");
        }
    </script>
</head>
<body bgcolor="pineapplesky"> <!-- Unique background color as mentioned -->

    <!-- Form to trigger the deletion process upon submission -->
    <form method="post" onsubmit="return confirmDelete();">
        <!-- Hidden field to carry the asset_id value in POST request -->
        <input type="hidden" name="asset_id" value="<?php echo $asset_id; ?>">
        <!-- Submit button for deleting the asset record -->
        <input type="submit" value="Delete Asset">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Execute the delete statement and check for success
        if ($stmt->execute()) {
            echo "Asset record deleted successfully."; 
        } else {
            echo "Error deleting asset record: " . $stmt->error; 
        }
    }
    ?>

    <!-- Button to navigate back to the asset list -->
    <button onclick="window.location.href='./asset.php'">Back to Asset List</button>

</body>
</html>
<?php
    // Close the prepared statement after execution
    $stmt->close();
} else {
    echo "Asset ID is not set.";
}

// Close the database connection
$connection->close();
?>
