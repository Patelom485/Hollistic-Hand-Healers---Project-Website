<?php
session_start();
require 'db_connect_p4.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $password = $_POST["password"];
    $therapistId = $_POST["therapistId"];
    $phoneNumber = $_POST["phoneNumber"];
    $emailAddress = $_POST["emailAddress"];
    $emailConfirmation = isset($_POST["emailconfirmation"]) ? 1 : 0;

    $sql_validate_therapist = "SELECT * FROM therapists WHERE therapist_id_number='$therapistId'";
    $result = $conn->query($sql_validate_therapist);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['therapist_password'] == $password && 
            $row['therapist_first_name'] == $firstName &&
            $row['therapist_last_name'] == $lastName &&
            $row['therapist_phone_number'] == $phoneNumber &&
            ($row['therapist_email'] == $emailAddress || !$emailConfirmation)) {

            $_SESSION["therapistId"] = $row['therapist_id'];

            $transactionType = $_POST["transactionType"];
            switch ($transactionType) {
                case "therapists":
                    header("Location: therapists_p4.php");
                    break;
                case "update":
                    header("Location: client_update_info_p4.php");
                    break;
                case "cancel":
                    header("Location: cancel_session_p4.php");
                    break;
                case "treatment_update":
                    header("Location: treatment_update_p4.php");
                    break;
                case "new-patients":
                    header("Location: create_client_p4.php");
                    break;
                case "session-client":
                    header("Location: verify_client_p4.php");
                    break;
                default:
                    echo "<script>alert('Invalid transaction type');</script>";
            }
        } else {
            echo "<script>alert('Validation failed. Please check your details');</script>";
        }
    } else {
        echo "<script>alert('No therapist found with this ID');</script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="style_P4.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="project4js.js"> </script>
   
  <title>Form</title>
</head>
<body>
  <div class="box">
    <h1>Holistic Hand Healers : Login</h1>

    <form id="validationForm" autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
        <label for="firstName">Therapist's First Name:</label>
        <input class="firstName" type="text" id="firstName" name="firstName" placeholder="Example: Jane" oninput="highlightField(this)">
        <label for="firstName">REQUIRED</label>
      </div>

      <div class="form-group">
        <label for="lastName">Therapist's Last Name:</label>
        <input class="lastName" type="text" id="lastName" name="lastName" placeholder="Example: Doe">
        <label for="lastName">REQUIRED</label>
      </div>

      <div class="form-group">
        <label for="password">Therapist's Password:</label>
        <div class="password-container">
          <input class="password" type="password" name="password" id="password" placeholder="Example: OT@1">
          <i class="fa-solid fa-eye" id="show-password"></i>
        </div>
        <label for="password">REQUIRED</label>
      </div>

      <div class="form-group">
        <label for="therapistId">Therapist's ID #:</label>
        <input class="therapistId" type="text" id="therapistId" name="therapistId" placeholder="Example: 24686">
        <label for="therapistId">REQUIRED</label>
      </div>

      <div class="form-group">
        <label for="phoneNumber">Therapist's Phone #:</label>
        <input class="phoneNumber" type="tel" id="phoneNumber" name="phoneNumber" placeholder="Example: 555-555-5555  ">
        <label for="phoneNumber">REQUIRED</label>
      </div>

      <div class="form-group">
        <label for="emailAddress">Therapist's Email:</label>
        <input class="emailAddress" type="email" id="emailAddress" name="emailAddress" placeholder="Example: HH@example">
        <label for="emailAddress" id="emailRequiredLabel"> </label>
      </div>

      <div class="form-group">
        <input class="email-label" type="checkbox" id="emailconfirmation" name="emailconfirmation">
        <label class="email-region" for="emailconfirmation"> Check the box to request an email confirmation:</label><br>
      </div>

      <div class="form-group1">
        <label for="transactionType">Select a Transaction:</label>
        <select class="form-width" id="transactionType" name="transactionType">
          <option value="therapists">Search A Therapist's Accounts</option>
          <option value="update">Update a Client's Personal Record</option>
          <option value="treatement_update">Update a Client’s Treatment Record</option>
          <option value="session-client">Schedule A Client’s Session</option>
          <option value="cancel">Cancel a Client’s Session(s)</option>
          <option value="new-patients">Create A New Patient Account</option>
        </select>
      </div>

      <div class="button-cl">
        <button type="reset">Reset</button>
        <button type="submit">Submit</button>
      </div>

      <div id="popup" class="popup">
        <div class="popup-content" id="popupContent"></div>
        <span class="close-icon" onclick="closePopup()">Close</span>
      </div>
    </form>
  </div>
</body>
</html>
