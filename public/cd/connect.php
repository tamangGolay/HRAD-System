<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $servername = "172.16.170.25:3306";
    $username = "hris";
    $password = "bpc@Bpc@2022"; //For web server
    //$password = ""; //For local server
    $dbname = "hradsystem";
             //Function for debugging
    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            debug_to_console( "Connection failed");
    } else{
            debug_to_console( "Connected to db");
    }
?>

