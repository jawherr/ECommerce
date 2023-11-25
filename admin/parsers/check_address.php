<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/PhpProject1/ECommerce/core/init.php';
	$name = sanitize($_POST['full_name']);
	$email = sanitize($_POST['email']);
	$street = sanitize($_POST['street']);
	$street2 = sanitize($_POST['street2']);
	$city = sanitize($_POST['city']);
	$state = sanitize($_POST['state']);
	$zip_code = sanitize($_POST['zip_code']);
	$country = sanitize($_POST['country']);
	$errors = array();
	$required = array(
		'full_name' => 'Full_name',
		'email' 	=> 'Email',
		'street' 	=> 'Street address',
		'city' 		=> 'City',
		'state' 	=> 'State',
		'zip_code' 	=> 'Zip_code',
		'country' 	=> 'Country',
	);

	//check if all reuired dields are filled out
	foreach ($required as $f => $d){
		if (empty($_POST[$f]) || $_POST[$f] == ''){
			$errors[] = $d.' is required.';
		}
	}
//check if valide email address
	if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$errors[] = 'Please enter a valide email.';
	}
	if (!empty($errors)) {
		echo display_errors($errors);
	}else{
		echo "passed";
	}
?>