<?php

// $servername = "192.168.1.201";
$servername = "localhost";
$username = "test_dev";
$db = "test_ims_snapshot_v4";
$password = "iE$1@#dv";

//$db = "test";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//
//if ($_POST['comboBox'] == 'vote_code_ComboBox') {
//    prepareSelectQueryForJSON("SELECT
//groups.`name`,
//groups.id
//FROM
//groups
//WHERE
//groups.is_division = 1");
//}
//
//function prepareSelectQueryForJSON($query)
//{
//    $data = array();
//
//    $result = mysqli_query($query);
//
//    while ($row = mysqli_fetch_assoc($result))
//    {
//        $data[] = $row;
//    }
//    echo json_encode($data);
//}
