<?php

session_start();
//include database configuration file
include 'config.php';

//get records from database
$query = $mysqli->query('SELECT id,boodschap,email FROM boodschap');

if ($query->num_rows > 0) {
    $delimiter = ',';
    $filename = 'boodschapexport_'.date('Y-m-d').'.csv';

    //create a file pointer
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('id', 'boodschap', 'email');
    fputcsv($f, $fields, $delimiter);

    //output each row of the data, format line as csv and write to file pointer
    while ($row = $query->fetch_assoc()) {
        $lineData = array($row['id'], $row['boodschap'], $row['email']);
        fputcsv($f, $lineData, $delimiter);
    }

    //move back to beginning of file
    fseek($f, 0);

    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;
header('Location: admin.php');
