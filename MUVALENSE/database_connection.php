
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