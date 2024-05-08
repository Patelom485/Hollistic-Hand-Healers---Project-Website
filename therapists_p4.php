<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect_p4.php';

session_start();

if (isset($_SESSION["therapistId"])) {
    $therapist_id = $_SESSION["therapistId"];
} else {
    echo "<script>alert('Therapist ID is not set.');</script>";
    exit();
}
$sql = "SELECT 
T.therapist_first_name AS TherapistFirstName,
T.therapist_last_name AS TherapistLastName,
T.therapist_id_number AS TherapistID,
T.therapist_phone_number AS TherapistPhoneNumber,
T.therapist_email AS TherapistEmail,
C.firstName AS ClientFirstName,
C.lastName AS ClientLastName,
C.clientId AS ClientID,
CI.address AS ClientAddress,
CI.phoneNumber AS ClientPhoneNumber,
CI.dateOfBirth AS DateOfBirth,
CI.insurance AS InsuranceInformation,
TP.injury AS Injury,
TP.script AS Script,
TP.devices AS TreatmentDevicesSupplies,
S.sessionDay AS SessionDate,
S.sessionTime AS SessionTime
FROM 
therapists T
JOIN 
sessions S ON T.therapist_id = S.therapistId
JOIN 
clients C ON S.clientId = C.clientId
JOIN 
client_info CI ON C.clientId = CI.clientId
JOIN 
treatment_plan TP ON C.clientId = TP.clientId
WHERE 
T.therapist_id = ?";  

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmt->bind_param("i", $therapist_id);
if (!$stmt->execute()) {
    echo "Error executing statement: " . $stmt->error;
    exit();
}

$stmt->bind_result(
    $therapistFirstName,
    $therapistLastName,
    $therapistID,
    $therapistPhoneNumber,
    $therapistEmail,
    $clientFirstName,
    $clientLastName,
    $clientID,
    $clientAddress,
    $clientPhoneNumber,
    $dateOfBirth,
    $insuranceInformation,
    $injury,
    $script,
    $treatmentDevicesSupplies,
    $sessionDate,
    $sessionTime
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_P4.css">
    <title>Therapists and Clients Table</title>
</head>
<body>
    <?php include 'navbar_p4.php'; ?>
    <div class="box-data">
        <h1>Holistic Hand Healers </h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>Therapist Name</th>
                <th>Therapist ID Number</th>
                <th>Therapist Phone Number</th>
                <th>Therapist Email</th>
                <th>Client Name</th>
                <th>Client ID</th>
                <th>Client Address</th>
                <th>Client Phone Number</th>
                <th>Client DOB</th>
                <th>Client Insurance Info</th>
                <th>Injury</th>
                <th>Script</th>
                <th>Treatment Devices/Supplies</th>
                <th>Session Date</th>
                <th>Session Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>$therapistFirstName $therapistLastName</td>";
                echo "<td>$therapistID</td>";
                echo "<td>$therapistPhoneNumber</td>";
                echo "<td>$therapistEmail</td>";
                echo "<td>$clientFirstName $clientLastName</td>";
                echo "<td>$clientID</td>";
                echo "<td>$clientAddress</td>";
                echo "<td>$clientPhoneNumber</td>";
                echo "<td>$dateOfBirth</td>";
                echo "<td>$insuranceInformation</td>";
                echo "<td>$injury</td>";
                echo "<td>$script</td>";
                echo "<td>$treatmentDevicesSupplies</td>";
                echo "<td>$sessionDate</td>";
                echo "<td>$sessionTime</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    mysqli_close($conn);
    ?>
</body>
</html>
