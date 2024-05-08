<?php
require 'db_connect_p4.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING);


    if (isset($_SESSION["therapistId"])) {
        $therapistId = $_SESSION["therapistId"];
    } else {
        echo "<script>alert('Therapist ID is not set.');</script>";
        exit();
    }

    $sql_check_client = "SELECT * FROM clients WHERE clientId = ?";
    $stmt = $conn->prepare($sql_check_client);
    $stmt->bind_param("s", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Client already has an account.');</script>";
    } else {

        $sql_insert_client = "INSERT INTO clients (firstName, lastName, clientId, therapist_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_client);
        $stmt->bind_param("sssi", $firstName, $lastName, $clientId, $therapistId);

        if ($stmt->execute() === TRUE) {
            echo "<script>alert('Client Account Created successfully. You will be redirected to a form to enter the personal information for the client.');</script>";
            echo "<script>window.location.href = 'client_info_form_p4.php?clientId=$clientId';</script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Customer Account</title>
    <link rel="stylesheet" href="style_P4.css">
</head>

<body>
    <?php include 'navbar_p4.php'; ?>
    <div class="box">
        <h1>Holistic Hand Healer : Create An Account</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="firstName">Client's First Name:</label>
                <input class="firstName" type="text" id="firstName" name="firstName" placeholder="Example: Jane" oninput="highlightField(this)" required>
                <label for="firstName">REQUIRED</label>
            </div>

            <div class="form-group">
                <label for="lastName">Client's Last Name:</label>
                <input class="lastName" type="text" id="lastName" name="lastName" placeholder="Example: Doe" required>
                <label for="lastName">REQUIRED</label>
            </div>

            <div class="form-group">
                <label for="clientId">Client's ID Number:</label>
                <input class="clientId" type="text" id="clientId" name="clientId" placeholder="Example: 24686" required>
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
