<?php
include('database_connection.php');

// Fetch asset information if asset_id is provided
if (isset($_GET['asset_id'])) {
    $asset_id = $_GET['asset_id'];
    
    $stmt = $connection->prepare("SELECT * FROM asset WHERE asset_id = ?");
    $stmt->bind_param("i", $asset_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the data

        $asset_id = $row['asset_id'];
        $asset_name = $row['asset_name'];
        $asset_description = $row['asset_description'];
        $asset_url = $row['asset_url'];
    } else {
        echo "Asset not found."; 
        exit(); // Stop if no matching record
    }
} else {
    echo "No asset ID specified."; // If no `asset_id` is provided
    exit(); // Exit to prevent further code execution
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Asset</title>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?'); // Confirmation prompt
        }
    </script>
</head>
<body style="background-color: lightblue;">
    <h2>Update Asset Information</h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="asset_id">Asset Id:</label>
        <input type="number" id="asset_id" name="asset_id" value="<?php echo htmlspecialchars($asset_id); ?>" readonly>
        <br><br>

        <label for="asset_name">Asset Name:</label>
        <input type="text" id="asset_name" name="asset_name" value="<?php echo htmlspecialchars($asset_name); ?>">
        <br><br>
        
        <label for="asset_description">Asset Description:</label>
        <textarea id="asset_description" name="asset_description"><?php echo htmlspecialchars($asset_description); ?></textarea>
        <br><br>
        
        <label for="asset_url">Asset URL:</label>
        <input type="url" id="asset_url" name="asset_url" value="<?php echo htmlspecialchars($asset_url); ?>">
        <br><br>
        
        <input type="submit" name="update" value="Update">
        <a href="./asset.php">Go Back to Asset Form</a>
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $asset_id = $_POST['asset_id'];
    $asset_name = $_POST['asset_name'];
    $asset_description = $_POST['asset_description'];
    $asset_url = $_POST['asset_url'];

    $stmt = $connection->prepare("UPDATE asset SET asset_name = ?, asset_description = ?, asset_url = ? WHERE asset_id = ?");
    $stmt->bind_param("sssi", $asset_name, $asset_description, $asset_url, $asset_id);
    $stmt->execute();
    
    header('Location: asset.php');
    exit(); 
}
?>
