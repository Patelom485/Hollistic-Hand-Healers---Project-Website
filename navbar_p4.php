<!DOCTYPE html>
<html>
<head>
    <style>

.navbar {
    overflow: hidden;
    background-color: #333;
    position: fixed;
    top: 0; 
    width: 100%;
    z-index: 1000; 
}

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .navbar a.active {
  background-color: red; 
  color: #fff; 
 
  padding: 14px 14px; 
}
    </style>
</head>
<body>

<div class="navbar">
                <a href="project4.php" class="active">Home</a>
                <a href="therapists_p4.php">Search A Therapist's Account</a>
                <a href="client_update_info_p4.php">Update a Client's Personal Record</a>
                <a href="treatment_update_p4.php">Update a Client's Treatment Record</a>
                <a href="verify_client_p4.php">Schedule A Client's Session</a>
                <a href="cancel_session_p4.php">Cancel a Client's Session</a>
                <a href="create_client_p4.php ">Create A New Client Account</a>
</div>

</body>
</html>
