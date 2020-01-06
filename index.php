<!DOCTYPE html>
<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
    
    $(".boxed").attr('style','display: none');
    $(".footer").attr('style','display: none');
    // Ring when hits highest rate
    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', 'http://www.soundjay.com/misc/sounds/bell-ringing-02.mp3');
    
    audioElement.addEventListener('ended', function() {
        this.play();
    }, false);
     $("#timerange-select").attr('style','display: none');  
     $("#chart_container").attr('style','display: none');
     console.log($($($("#quote_string").children()[1]).children()[1]).text());
    //  var amount = $($($("#daily-price-overview").children()[0]).children()[1]).text();
    var amount = $($($("#quote_string").children()[1]).children()[1]).text();
    console.log(amount);
     var amountSplit = amount.toString().split(' ')[0];
    //  var amountCurl = [1,2,3];
     var amountCurl = parseFloat(amountSplit.split(',')[0]+amountSplit.split(',')[1]);
     $("#coinsValue").val(amountCurl);
    var maxAmount = parseFloat($("#maxAmountDisplay").text());
     if ( amountCurl > maxAmount) {
        $("#valueIndication").text("Last Amount is High, Going Up");
        $("#valueIndication").attr("style","background-color: blue;color: white;padding: 5px;");
        audioElement.play();
     } else if ( amountCurl == maxAmount ) {
        $("#valueIndication").text("Same. Stay.");
         $("#valueIndication").attr("style","background-color: red;color: white;padding: 5px;");
         audioElement.pause();
     } else {
         $("#valueIndication").text("Last Amount is Low. Going Down");
         $("#valueIndication").attr("style","background-color: red;color: white;padding: 5px;");
        //  audioElement.pause();
        audioElement.pause();
        //  audioElement.play();
     }
     
    $("#lastPrice").text(formatNumber(amountCurl));
    $("#lastPrice").attr('style','font-size: 70px;font-weight: bold;');
    $("#maxAmountDisplay").html(formatNumber($("#maxAmountDisplay").text()));
    // setTimeout(
    //     function() {
    //         alert(1);
    //         // $("#submitCoinsValue").click();
    //     },
    // 10000);
    // setInterval(function(){ 
    //         $("body").fadeOut();
    // }, 10000);
    setInterval(function(){ 
        //  console.log(1);
            // $("#submitCoinsValue").click();
            $("#submitCoinsValue").click();
            // $("body").fadeIn();
    }, 10000);
    // $("body").fadeIn();
    // $('#coinsForm').submit(function(e) {
    //             e.preventDefault();
    //             $.ajax({
    //                 type: "POST",
    //                 url: 'insert2.php',
    //                 data: $(this).serialize(),
    //                 success: function(response)
    //                 {
    //                     console.log(response);
    //                     // var jsonData = JSON.parse(response);
    //                     // console.log(jsonData);
        
    //                     // user is logged in successfully in the back-end
    //                     // let's redirect
    //                     // if (jsonData.success == "1")
    //                     // {
    //                     //     location.href = 'my_profile.php';
    //                     // }
    //                     // else
    //                     // {
    //                     //     alert('Invalid Credentials!');
    //                     // }
    //                 }
    //             });
    // });
    // setTimeout(
    //     function() {
    //          $('#coinsForm').submit(function(e) {
    //             e.preventDefault();
    //             console.log($(this).serialize());
    //             $.ajax({
    //                 type: "POST",
    //                 url: 'insert2.php',
    //                 data: $(this).serialize(),
    //                 success: function(response)
    //                 {
    //                     console.log(response);
    //                     // var jsonData = JSON.parse(response);
    //                     // console.log(jsonData);
        
    //                     // user is logged in successfully in the back-end
    //                     // let's redirect
    //                     // if (jsonData.success == "1")
    //                     // {
    //                     //     location.href = 'my_profile.php';
    //                     // }
    //                     // else
    //                     // {
    //                     //     alert('Invalid Credentials!');
    //                     // }
    //                 }
    //             });
    //         });
    //     },
    // 10000);

   
});
function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
</script>
</head>
<body>

<br><br><br>
<?php
include 'connection.php';

$conn = OpenCon();

$sql = "SELECT * FROM coins_value";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $myArray[] = $row['amount'];
    }
    $maxAmount = max($myArray);
    echo '<center>
                <div style="margin-top: 44px; margin-bottom: -72px;">
                Max Amount SELL Amount<hr><span style="font-size: 70px;font-weight: bold;" id="maxAmountDisplay">
                '.$maxAmount.'
                </span><br>
                <br><br>
                Last Price History
                <hr>
                <span id="lastPrice"></span><br>
                <span id="valueIndication"></span>
                </div>
        </center>';
} else {
    echo "0 results";
}

CloseCon($conn);

?>

<br><br><br>
<form action="insert.php" method="post" id="coinsForm">
    <p>
        <!-- <label for="firstName">Mone Value:</label> -->
        <input type="hidden" name="coins" id="coinsValue">
    </p>
    <input type="submit" value="Submit" id="submitCoinsValue" style="display: none">
</form>
<?php
// Step 1
$cSession = curl_init(); 
// Step 2
curl_setopt($cSession,CURLOPT_URL,"https://coins.ph/charts");
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false); 
// Step 3
$result=curl_exec($cSession);
// Step 4
curl_close($cSession);
// Step 5
echo $result;
echo json_encode($result);
?> 


</body>
</html>