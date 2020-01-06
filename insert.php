

<?php
include 'connection.php';

$conn = OpenCon();

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$coins = mysqli_real_escape_string($conn, $_REQUEST['coins']);
 
// Attempt insert query execution
$sql = "INSERT INTO coins_value (amount) VALUES ('$coins')";
if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
    header("Location: index.php");
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
 
// Close connection
mysqli_close($conn);
?>
