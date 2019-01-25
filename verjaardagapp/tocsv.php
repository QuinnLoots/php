<?php

session_start();
//include database configuration file
include 'config.php';

//get records from database
$query = $mysqli->query('SELECT id,song,artist,email FROM songs');

if ($query->num_rows > 0) {
    $delimiter = ',';
    $filename = 'songexport_'.date('Y-m-d').'.csv';

    //create a file pointer
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('id', 'song', 'artist', 'email');
    fputcsv($f, $fields, $delimiter);

    //output each row of the data, format line as csv and write to file pointer
    while ($row = $query->fetch_assoc()) {
        $lineData = array($row['id'], $row['song'], $row['artist'], $row['email']);
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
