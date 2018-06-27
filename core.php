<?php
	session_start();

	$ign = "";
	$email    = "";
	$errors = array();
	$_SESSION['success'] = "";

	$db = mysqli_connect('localhost', 'root', '', 'kingr');

	if (isset($_POST['reg_user'])) {
		$ign = mysqli_real_escape_string($db, $_POST['ign']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		if (empty($ign)) { array_push($errors, "ign is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		if (count($errors) == 0) {
			$password = $password_1;
			$query = "INSERT INTO users (ign, email, password)
					  VALUES('$ign', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['ign'] = $ign;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	if (isset($_POST['login_user'])) {
		$ign = mysqli_real_escape_string($db, $_POST['ign']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($ign)) {
			array_push($errors, "ign is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$query = "SELECT * FROM users WHERE ign='$ign' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['ign'] = $ign;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong ign/password combination");
			}
		}
	}

?>
