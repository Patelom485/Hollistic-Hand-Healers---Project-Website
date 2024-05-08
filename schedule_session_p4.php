<?php
require 'db_connect_p4.php';

session_start();

$clientId = $_GET['clientId'];

if (isset($_SESSION["therapistId"])) {
    $therapistId = $_SESSION["therapistId"];
} else {
    echo "<script>alert('Therapist ID is not set.');</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionDay = $_POST["sessionDay"];
    $sessionTime = $_POST["sessionTime"];

    if (empty($sessionDay) || empty($sessionTime)) {
        echo "<script>alert('Session Day and Time cannot be empty. Please enter valid values.');</script>";
    } else {
        $sql_check_client = "SELECT * FROM clients WHERE clientId = ?";
        $stmt = $conn->prepare($sql_check_client);
        $stmt->bind_param("s", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows <= 0) {
            echo "<script>alert('Invalid Client ID. Please correct before scheduling session(s).');</script>";
        } else {
        
            $sessionId = generateSessionId();


            echo "<script>
                    if (confirm('Message to Confirm Scheduling Session(s) When Valid Data Entered. Click OK to continue.')) {
                        window.location.href = 'schedule_session_p4.php?confirm=true&clientId=$clientId&sessionDay=$sessionDay&sessionTime=$sessionTime&sessionId=$sessionId';
                    } else {
                        alert('Session request cancelled.');
                    }
                  </script>";
        }
    }
}

if (isset($_GET['confirm']) && $_GET['confirm'] == "true") {
    $sessionDay = $_GET["sessionDay"];
    $sessionTime = $_GET["sessionTime"];
    $sessionId = $_GET["sessionId"];

    $sql_insert_session = "INSERT INTO sessions (clientId, sessionDay, sessionTime, sessionId, therapistId) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert_session);

    if ($stmt) {
        $bind_result = $stmt->bind_param("ssssi", $clientId, $sessionDay, $sessionTime, $sessionId, $therapistId);
        
        if ($bind_result && $stmt->execute() === TRUE) {
            echo "<script>alert('Session Requested Successfully. Session ID: $sessionId');</script>";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

function generateSessionId() {

    return mt_rand(100000, 999999);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Session</title>
    <link rel="stylesheet" href="style_P4.css">
</head>

<body>
    <?php include 'navbar_p4.php'; ?>
    <div class="box">
        <h1>Holistic Hand Healer : Request Session</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?clientId=$clientId"; ?>">
            <div class="form-group">
                <label for="sessionDay">Session Day:</label>
                <input type="text" id="sessionDay" name="sessionDay" placeholder="Example: Monday and Wednesday" required>
                <label for="sessionDay">REQUIRED</label>
            </div>

            <div class="form-group">
                <label for="sessionTime">Session Time:</label>
                <input type="text" id="sessionTime" name="sessionTime" placeholder="Example: 10:00 AM" required>
                <label for="sessionTime">REQUIRED</label>
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
