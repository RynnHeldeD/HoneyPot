<?php
	require("app/splAutoload.php");

	$user = null;
	if(isset($_SESSION['user'])) {
		$user = unserialize($_SESSION['user']);
	}

	if(!$user) {
		// display login/registration page
		echo "<h1>registration</h1>";
		echo "<form method='post' action='index.php'>
			Login : <input type='string' name='login'><br />
			Email : <input type='string' name='email'><br />
			Passw : <input type='string' name='password'><br />
			<input type='submit' value='Register'>
		</form>";

		if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])) {
			$user = new User($_POST['login'], $_POST['email'], $_POST['password']);
			// UserDAL::create($user);
			
			$user2 = UserDAL::authenticate($_POST['email'], $_POST['password']);
			if(!empty($user2) && $user2 instanceOf User) {
				echo "Connecté en tant que : " . $user2->name;
			}
		}

	}
	else {
		// display frontApp page

		// frontController for disconnection / account param.
	}
?>