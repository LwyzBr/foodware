<?php

$servername = "localhost";
$username = "root";
$password = "";

$email = $_POST['email'];
$pwd = $_POST['psw'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, "foodware");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

$query = "SELECT UserId FROM login WHERE (email ='".$email."' AND psw = '".$pwd."')";

$result = mysqli_query($conn, $query);

if ( false===$result ) {
  printf("error: %s\n", mysqli_error($conn));
}
else {

	$resp = mysqli_fetch_assoc($result);
	//print_r($resp);

	if (!empty($resp)) {
		header('Location: http://www.youtube.com/');
	}

	else {
		echo "Login ou senha incorretos.";
	}


}


mysqli_close($conn);


?>