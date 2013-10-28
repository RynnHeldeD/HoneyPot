<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>HoneyPot</title>
		<link rel="stylesheet" type="text/css" href="assets/css/foundation.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/foundation-icons/foundation-icons.css">
		<link rel="stylesheet" type="text/css" href="assets/css/login.css">

		<script type="text/javascript" src="../../assets/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript">

			function verif(){
				if($("#form-password").val()!= $("#form-password2").val())	
					$("#verif_password").show();

				else
					$("#verif_password").hide();
				}
	
		</script>


	</head>

	<body>
	<form method="POST" action='index.php?p=user&a=register'>
		<div class="large-12 columns">
			<label for="form-nickname">Pseudonyme</label>
			<input type="text" name="login" id="form-nickname" required>
		</div>

		<div class="row">
			<div class="large-12 columns">
				<label for="form-password">Mot de passe</label>
				<input type="password" name="password" id="form-password" required>
			</div>
		</div>

		<div class="row">
			<div class="large-12 columns">
				<label for="form-password2">Confirmer votre mot de passe</label>
				<input type="password" name="password" id="form-password2" onkeyup="verif()" required>
			</div>
		</div>

		<div id="verif_password" style="display:none;"><p> Les mots de passes sont différents </p></div>

		<div class="row">
			<div class="large-12 columns">
				<label for="form-mail"> Adresse mail </label>
				<input type="email" name="email" id="form-mail" required>
			<div>
		</div>

		<input type="submit" value="S'inscrire">

	</form>

	</body>