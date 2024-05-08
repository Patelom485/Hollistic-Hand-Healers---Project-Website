<?php
require 'db_connect_p4.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST["clientId"];
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $insurance = $_POST["insurance"];

    // Insert client information
    $sql_insert_info = "INSERT INTO client_info (clientId, address, phoneNumber, dateOfBirth, insurance) VALUES ('$clientId', '$address', '$phoneNumber', '$dateOfBirth', '$insurance')";

    if ($conn->query($sql_insert_info) === TRUE) {
        echo "<script>alert('Record for personal information was created successfully.');</script>";

        echo "<script>window.location.href = 'treatment_plan_form_p4.php?clientId=$clientId';</script>";
    } else {
        echo "Error: " . $sql_insert_info . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Information Form</title>
    <link rel="stylesheet" href="style_P4.css">
</head>
<body>
<?php include 'navbar_p4.php'; ?>
<div class="box">
    <h1>Holistic Hand Healer : Client Personal Information Record</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
    
        <div class="form-group"> 
        <label for="address">Client Address:</label>
        <input class="address" name="address" type="text" placeholder="45 Newark Ave, Summit, NJ 00000"  required>
        <label for="address">REQUIRED</label>
        </div>
        <div class="form-group">
        <label for="phoneNumber">Client's Phone Number:</label>
        <input class="phoneNumber" type="tel" id="phoneNumber" name="phoneNumber" placeholder="Example: 555-555-5555  "required>
        <label for="phoneNumber">REQUIRED</label>
      </div>
        <div class="form-group"> 
        <label for="date">Date of Birth:</label>
        <input class="date" type="date" name="dateOfBirth"placeholder="February 04, 2024" required>
        <label for="date">REQUIRED</label>
        </div>
        <div class="form-group"> 
        <label for="insurance">Insurance:</label>
        <input class="insurance"type="text" name="insurance" placeholder="Aetna"required>
        <label for="insurance">REQUIRED</label>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const phoneNumberInput = document.getElementById("phoneNumber");

        phoneNumberInput.addEventListener("input", function() {
            const phoneNumber = phoneNumberInput.value.replace(/-/g, ''); 
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