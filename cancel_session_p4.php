<?php
require 'db_connect_p4.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionId = $_POST["sessionId"];

    $sql_check_session = "SELECT * FROM sessions WHERE sessionId = ?";
    $stmt = $conn->prepare($sql_check_session);
    $stmt->bind_param("s", $sessionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                if (confirm('Are you sure you want to cancel this session?')) {
                    window.location.href = 'cancel_session_p4.php?confirm=true&sessionId=$sessionId';
                } else {
                    alert('Session cancellation cancelled.');
                }
              </script>";
    } else {
        echo "<script>
                alert('Session does not exist. Please check the information and re-enter valid data.');
                window.location.href = 'cancel_session_p4.php';
              </script>";
    }
}

if (isset($_GET['confirm']) && $_GET['confirm'] == "true") {
    $sessionId = $_GET["sessionId"];

    $sql_delete_session = "DELETE FROM sessions WHERE sessionId = ?";
    $stmt = $conn->prepare($sql_delete_session);
    $stmt->bind_param("s", $sessionId);

    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Session cancelled successfully.');</script>";
    } else {
        echo "Error: " . $sql_delete_session . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cancel Client’s Session(s)</title>
    <link rel="stylesheet" href="style_P4.css">
</head>

<body>
    <?php include 'navbar_p4.php'; ?>
    <div class="box">
        <h1>Holistic Hand Healer : Cancel Client’s Session(s)</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="sessionId">Session ID:</label>
                <input type="text" id="sessionId" name="sessionId" placeholder="Enter Session ID" required>
                <label for="sessionId">REQUIRED</label>
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
