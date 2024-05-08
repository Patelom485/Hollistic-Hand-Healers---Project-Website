<?php
require 'db_connect_p4.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST["clientId"];
    $injury = $_POST["injury"];
    $script = $_POST["script"];
    $devices = $_POST["devices"];

    $sql_insert_plan = "INSERT INTO treatment_plan (clientId, injury, script, devices) VALUES ('$clientId', '$injury', '$script', '$devices')";

    if ($conn->query($sql_insert_plan) === TRUE) {
        echo "<script>alert('Client\'s treatment plan record created successfully.');</script>"; // Corrected the single quote issue here
        
    } else {
        echo "Error: " . $sql_insert_plan . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Client Treatment Plan Form</title>
    <link rel="stylesheet" href="style_P4.css">
</head>
<body>
<?php include 'navbar_p4.php'; ?>
<div class="box">
    <h1>Holistic Hand Healer : Enter Client Treatment Plan Form </h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        
    <div class="form-group"> 
        <label for="injury">Injury:</label>
        <input class="insurance"type="text" name="injury" placeholder="Carpel Tunel Injury"required>
        <label for="injury">REQUIRED</label>
        </div>
        <div class="form-group"> 
        <label for="script">Script:</label>
        <input class="script"type="text" name="script" placeholder="Example: OT - 4 to 6 weeks Three times a week"required>
        <label for="script">REQUIRED</label>
        </div>
        <div class="form-group"> 
        <label for="devices">Devices:</label>
        <input class="devices"type="text" name="devices" placeholder="BCBS-208"required>
        <label for="devices">REQUIRED</label>
        </div>
        <div class="form-group">
        <label for="clientId">Client's ID :</label>
        <input class="clientId" type="text" id="clientId" name="clientId" placeholder="Example: 24686"required>
        <label for="clientId">REQUIRED</label>
      </div>
      <div>
            <button type="submit">Submit</button>
        </div>
    </form>

    <div id="popup" style="display: none;">
        <div id="popupContent"></div>
    </div>
</body>
</html>

