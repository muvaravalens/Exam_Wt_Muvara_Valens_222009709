<?php
// Include database connection file to establish a connection to the database
include('database_connection.php'); // Modify to match your actual file path

// Check if 'campaign_id' parameter is set in the request
if (isset($_REQUEST['campaign_id'])) {
    $campaign_id = $_REQUEST['campaign_id'];
    
    // Prepare the SQL statement to delete a record from the campaign table
    $stmt = $connection->prepare("DELETE FROM campaign WHERE campaign_id = ?");
    $stmt->bind_param("i", $campaign_id); // 'i' indicates that 'campaign_id' is an integer

    // HTML structure for the page
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Campaign</title>
    <script>
        // Function to confirm the deletion when the form is submitted
        function confirmDelete() {
            return confirm("Are you sure you want to delete this campaign?");
        }
    </script>
</head>
<body bgcolor="pineapple"> <!-- Unique background color as mentioned -->

    <!-- Form to trigger the deletion process upon submission -->
    <form method="post" onsubmit="return confirmDelete();">
        <!-- Hidden field to carry the campaign_id value in POST request -->
        <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
        <!-- Submit button for deleting the campaign record -->
        <input type="submit" value="Delete Campaign">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Execute the delete statement and check for success
        if ($stmt->execute()) {
            echo "Campaign record deleted successfully."; 
        } else {
            echo "Error deleting campaign record: " . $stmt->error; 
        }
    }
    ?>

    <!-- Button to navigate back to the campaign list -->
    <button onclick="window.location.href='./campaign.php'">Back to Campaign List</button>

</body>
</html>
<?php
    // Close the prepared statement after execution
    $stmt->close();
} else {
    echo "Campaign ID is not set.";
}

// Close the database connection
$connection->close();
?>
