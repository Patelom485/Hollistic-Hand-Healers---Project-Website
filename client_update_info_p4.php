<?php
require 'db_connect_p4.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST["clientId"];
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $insurance = $_POST["insurance"];
    $changesMade = "";

    $sql_check_client = "SELECT * FROM client_info WHERE clientId = '$clientId'";
    $result = $conn->query($sql_check_client);

    if ($result->num_rows > 0) {
        if (isset($_POST['confirmUpdate']) && $_POST['confirmUpdate'] == 'true') {
            $update_fields = [];

            if (!empty($address)) {
                $update_fields[] = "address = '$address'";
                $changesMade .= "Address, ";
            }
            if (!empty($phoneNumber)) {
                $update_fields[] = "phoneNumber = '$phoneNumber'";
                $changesMade .= "Phone Number, ";
            }
            if (!empty($dateOfBirth)) {
                $update_fields[] = "dateOfBirth = '$dateOfBirth'";
                $changesMade .= "Date of Birth, ";
            }
            if (!empty($insurance)) {
                $update_fields[] = "insurance = '$insurance'";
                $changesMade .= "Insurance, ";
            }

            if (!empty($update_fields)) {
                $update_fields_str = implode(", ", $update_fields);
                $sql_update_info = "UPDATE client_info SET $update_fields_str WHERE clientId = '$clientId'";

                if ($conn->query($sql_update_info) === TRUE) {
                    $changesMade = rtrim($changesMade, ", ");
                    echo "<script>alert('Client’s  $changesMade updated ');</script>";
                } else {
                    echo "<script>alert('Error updating client’s personal record.');</script>";
                }
            } else {
                echo "<script>alert('No changes were made to the client’s personal record.');</script>";
            }
        } else {
            echo "<script>
                    if(confirm('Are you sure you want to update the  client’s personal record?')) {
                        document.getElementById('confirmUpdate').value = 'true';
                        document.getElementById('updateForm').submit();
                    }
                  </script>";
        }
    } 
    
    else {
        echo "<script>
    alert('Client does not exist. Redirecting to Create A Client Account Form.');
    window.location.href = 'create_client_p4.php';
</script>";
exit();
    }
    
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update Client's Personal Record</title>
    <link rel="stylesheet" href="style_P4.css">
</head>
<body>
<?php include 'navbar_p4.php'; ?>
<div class="box">
    <h1>Holistic Hand Healer : Update Client's Personal Information Record Form</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="updateForm">
    <input type="hidden" name="confirmUpdate" id="confirmUpdate" value="false">
        <div class="form-group"> 
            <label for="address">Client Address:</label>
            <input class="address" name="address" type="text" placeholder="45 Diegel Valley Nova" required>
            <label for="address">REQUIRED</label>
        </div>
        <div class="form-group">
            <label for="phoneNumber">Client's Phone Number:</label>
            <input class="phoneNumber" type="tel" id="phoneNumber" name="phoneNumber" placeholder="Example: 555-555-5555" required>
            <label for="phoneNumber">REQUIRED</label>
        </div>
        <div class="form-group"> 
            <label for="date">Date of Birth:</label>
            <input class="date" type="date" name="dateOfBirth" required>
            <label for="date">REQUIRED</label>
        </div>
        <div class="form-group"> 
        <label for="insurance">Insurance:</label>
        <input class="insurance"type="text" name="insurance" placeholder="BCBS-208"required>
        <label for="insurance">REQUIRED</label>
        </div>
        
        <div class="form-group"> 
            <label for="clientId">Client's ID:</label>
            <input class="clientId" type="text" id="clientId" name="clientId" placeholder="Example: 24686" required>
            <label for="clientId">REQUIRED</label>
        </div>
        <div>
            <button type="button" onclick="checkUpdate()">Update</button>
        </div>
    </form>
    <div id="popup" style="display: none;">
        <div id="popupContent"></div>
    </div>
</div>
<script>
    function checkUpdate() {
        if (confirm('Are you sure you want to update the client’s personal record?')) {
            document.getElementById('confirmUpdate').value = 'true';
            document.getElementById('updateForm').submit();
        }
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        const phoneNumberInput = document.getElementById("phoneNumber");

        phoneNumberInput.addEventListener("input", function() {
            const phoneNumber = phoneNumberInput.value.replace(/-/g, ''); /
            const isValid = /^\d{10}$/.test(phoneNumber); 

            if (isValid || /^\d{3}-\d{3}-\d{4}$/.test(phoneNumberInput.value)) { 
                phoneNumberInput.setCustomValidity(''); 
            } else {
                phoneNumberInput.setCustomValidity('Please enter a valid 10-digit phone number or a phone number with hyphens.');
            }
        });
    });

</script>


</body>
</html>