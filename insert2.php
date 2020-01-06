

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
            $sql = "SELECT * FROM coins_value";
            $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $myArray[] = $row['amount'];
            }
            $maxAmount = max($myArray);
            echo json_encode(array('maxamount' => $maxAmount));
        } 
        else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }

    // Close connection
    mysqli_close($conn);
    
?>