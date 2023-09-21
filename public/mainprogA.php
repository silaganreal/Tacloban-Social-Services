<?php

$host = 'localhost';
$user = 'cmiso';
$pass = 'cmiso';
$db = 'tss';

$con = mysqli_connect($host, $user, $pass, $db);
mysqli_select_db($con,$db) or die(mysqli_error());
mysqli_query($con,"SET CHARACTER SET utf8");
mysqli_query($con,"SET NAMES 'utf8'");

$action = $_GET["action"];
switch ($action)

{
    	case "checkServer":
        print json_encode("connected");
    	break;

    	case "CountRecords":
        $q = mysqli_query($con,"SELECT * FROM clients");
        $count = mysqli_num_rows($q);
        print json_encode($count);
        break;


	case "viewclients":
	$q = mysqli_query($con,"SELECT id,fname,mname,lname,barangay, stat FROM clients WHERE stat = 0 ORDER by id LIMIT 50");
        $rows = array();

        while($r = mysqli_fetch_assoc($q))
        {
            $rows[] = $r;
        }
        print json_encode($rows);
	break;

    	case "updateclient":
        $id = $_GET["id"];
        $clientid = $_GET["clientid"];
        $q = mysqli_query($con,"UPDATE clients SET stat = 1, clientid = '$clientid' WHERE id = '$id'");
	break;


	case "sampleAction":
	echo "Hello Sample Action!";

//------------------------------------------------------------------------------------------------------------------------------------

}





?>
