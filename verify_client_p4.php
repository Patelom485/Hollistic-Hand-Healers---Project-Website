<?php
require 'db_connect_p4.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $clientId = $_POST["clientId"];

    $sql_check_client = "SELECT * FROM clients WHERE firstName = '$firstName' AND lastName = '$lastName' AND clientId = '$clientId'";
    $result = $conn->query($sql_check_client);

    if ($result->num_rows > 0) {
        header("Location: schedule_session_p4.php?clientId=$clientId");
        exit();
    } else {
        echo "<script>alert('Client does not exist. Please create an account.');</script>";
        echo "<script>window.location.href = 'create_client_p4.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Client</title>
    <link rel="stylesheet" href="style_P4.css">
</head>
<body>
<?php include 'navbar_p4.php'; ?>
<div class="box">
    <h1>Holistic Hand Healer : Verify Client</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
        <label for="firstName">Client's First Name:</label>
        <input class="firstName" type="text" id="firstName" name="firstName" placeholder="Example: Jane" oninput="highlightField(this)"required>
        <label for="firstName">REQUIRED</label>
      </div>

      <div class="form-group">
        <label for="lastName">Client's Last Name:</label>
        <input class="lastName" type="text" id="lastName" name="lastName" placeholder="Example: Doe"required>
        <label for="lastName">REQUIRED</label>
      </div>


      <div class="form-group">
        <label for="clientId">Client's ID Number:</label>
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
</div>
</body>
</html>
