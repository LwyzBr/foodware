<?php

//DB info
$servername = "localhost";
$username = "root";
$password = "";

//Email validation API

function validateEmail($emailSignup) {

	$key = "2c020803967353f74f3c41aae1aca8e2";

	// Get cURL resource
    $curl = curl_init();
    $url = 'http://apilayer.net/api/check?access_key='.$key.'&email='.$emailSignup.'&smtp=1&format=1';
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'FOODWARE'
    ));
    

    // Send the request & save response to $resp
    
    $json = curl_exec($curl);
    $resp = json_decode($json, true);
    $valid = $resp["format_valid"];

    echo $valid;
}

//Signin function

function SigninValidation($servername, $username, $password, $email, $pwd) {

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
		echo "Email or password are incorect.";
	}


}

mysqli_close($conn);

}

//Signup function
function SignupValidation($servername, $username, $password, $emailSignup, $psw1, $psw2) {

$valid = validateEmail($emailSignup);

	if ($valid == "0") {
		echo "Invalid email!";
	}

	else {

		if ($psw1 != $psw2) {
			echo "Password confirmation doesn't match!";
		}

		else {

// Create connection
$conn = mysqli_connect($servername, $username, $password, "foodware");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

$query = "INSERT INTO login (email, psw) VALUES ('".$emailSignup."', '".$psw1."')";

$result = mysqli_query($conn, $query);

if ( false===$result ) {
  printf("error: %s\n", mysqli_error($conn));
}
else {

	if ($result == "1") {
		header('Location: http://www.youtube.com/');
	}

	else {
		echo "Failed to register new user.";
	}


}

mysqli_close($conn);

}

}

}

//Check for which method the request calls for

$originId = $_POST['identity'];

if ($originId == "up") {

	//Signup variables
	$emailSignup = $_POST['emailSignup'];
	$psw1 = $_POST['psw1'];
	$psw2 = $_POST['psw2'];

	SignupValidation($servername, $username, $password, $emailSignup, $psw1, $psw2);
}

elseif ($originId == "in") {

	//Signin variables
	$email = $_POST['email'];
	$pwd = $_POST['psw'];

 	SigninValidation($servername, $username, $password, $email, $pwd);
 }

?>
