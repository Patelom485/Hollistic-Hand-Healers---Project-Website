<?php
require 'db_connect_p4.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST["clientId"];
    $injury = $_POST["injury"];
    $script = $_POST["script"];
    $devices = $_POST["devices"];
    $changesMade = "";

    $sql_check_client = "SELECT * FROM treatment_plan WHERE clientId = '$clientId'";
    $result = $conn->query($sql_check_client);

    if ($result->num_rows > 0) {
        if (isset($_POST['confirmUpdate']) && $_POST['confirmUpdate'] == 'true') {
            $update_fields = [];

            if (!empty($injury)) {
                $update_fields[] = "injury = '$injury'";
                $changesMade .= "Injury, ";
            }
            if (!empty($script)) {
                $update_fields[] = "script = '$script'";
                $changesMade .= "Script, ";
            }
            if (!empty($devices)) {
                $update_fields[] = "devices = '$devices'";
                $changesMade .= "Devices, ";
            }

            if (!empty($update_fields)) {
                $update_fields_str = implode(", ", $update_fields);
                $sql_update_plan = "UPDATE treatment_plan SET $update_fields_str WHERE clientId = '$clientId'";

                if ($conn->query($sql_update_plan) === TRUE) {
                    $changesMade = rtrim($changesMade, ", ");
                    echo "<script>alert('Client’s treatment plan was updated successfully. Changes made: $changesMade');</script>";
                } else {
                    echo "<script>alert('Error updating client’s treatment plan.');</script>";
                }
            } else {
                echo "<script>alert('No changes were made to the client’s treatment plan.');</script>";
            }
        } else {
            echo "<script>
                    if(confirm('Are you sure you want to update the client’s treatment plan?')) {
                        document.getElementById('confirmUpdate').value = 'true';
                        document.getElementById('treatmentForm').submit();
                    }
                  </script>";
        }
    } else {
        echo "<script>alert('Client does not have a treatment plan.');</script>";
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
    <h1>Holistic Hand Healer : UpDate Client Treatment Plan Form </h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="treatmentForm">
        <input type="hidden" name="confirmUpdate" id="confirmUpdate" value="false">
        
        <div class="form-group"> 
            <label for="injury">Injury:</label>
            <input class="insurance"type="text" name="injury" placeholder="Carpel Tunel Injury">
            <label for="injury">REQUIRED</label>
        </div>
        <div class="form-group"> 
            <label for="script">Script:</label>
            <input class="script"type="text" name="script" placeholder="Example: OT - 4 to 6 weeks Three times a week">
            <label for="script">REQUIRED</label>
        </div>
        <div class="form-group"> 
            <label for="devices">Devices:</label>
            <input class="devices"type="text" name="devices" placeholder="BCBS-208">
            <label for="devices">REQUIRED</label>
        </div>
        <div class="form-group">
            <label for="clientId">Client's ID :</label>
            <input class="clientId" type="text" id="clientId" name="clientId" placeholder="Example: 24686" required>
            <label for="clientId">REQUIRED</label>
        </div>
        <div>
            <button type="button" onclick="checkUpdate()">Submit</button>
        </div>
    </form>

    <div id="popup" style="display: none;">
        <div id="popupContent"></div>
    </div>

    <script>
        function checkUpdate() {
            if (confirm('Are you sure you want to update the client’s treatment plan?')) {
                document.getElementById('confirmUpdate').value = 'true';
                document.getElementById('treatmentForm').submit();
            }
        }
    </script>
</body>
</html>
