<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>HoneyPot</title>
		<link rel="stylesheet" type="text/css" href="assets/css/foundation.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/foundation-icons/foundation-icons.css">
		<link rel="stylesheet" type="text/css" href="assets/css/app.css">
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.nouislider.min.css">
	</head>
	<body>
		<div class="row content">
			<div class="large-12 columns app-header">
				<div class="large-3 columns app-header-logo">
					<img src="http://placehold.it/290x110&text=Logo" alt="Logo HoneyPot">
				</div>
				<div class="large-1 columns app-header-picture">
					<i class="fi-torso"></i>
				</div>
				<div class="large-8 columns app-header-infos">
					<a class="large-4 columns" href="#">MON COMPTE</a>
					<a class="large-4 columns" href="#">PARAMÈTRES</a>
					<a class="large-4 columns" href="index.php?p=logout">DÉCONNEXION</a>
				</div>
			</div>
			<div class="large-12 columns app-content">
				<!-- <hr> -->
				<div class="large-12 columns app-content-title">
					<h1>Mes comptes</h1>
					<button id="add-account">Ajouter un compte</button>
				</div>
				<div class="large-12 columns app-content-data">
					<?php if(isset($accounts)) {
						foreach ($accounts as $counter => $account) {
							echo '<div class="large-3 columns app-content-account">
								<div class="large-12 columns account" data-account-id="'.$account->id.'">
									<h2 class="account-label">'.$account->label.'</h2>
									<span class="account-amount">'.$account->getAvailable().'€ / '.$account->getAmount().'€</span>
								</div>
							</div>';
						}		
					} ?>
				</div>
				<!-- <hr> -->
				<div class="large-12 columns app-content-title">
					<h1>Mes objectifs</h1>
					<button id="add-objective">Ajouter un objectif</button>
				</div>
				<div class="large-12 columns app-content-data" id="nonCompletedObjectives">
					<?php if(isset($nonCompletedObjectives)) {
						foreach ($nonCompletedObjectives as $counter => $objective) {
							echo '<div class="large-12 columns app-content-objective">
								<div class="large-12 columns objective">
									<div class="large-11 columns objective-header">
										<h2 class="large-10 columns objective-label">'.$objective->label.'</h2>';
                            if($objective->goal > 0) {
                                echo '<h3 class="large-2 columns objective-percent">'.(($objective->amount / $objective->goal) * 100).'%</h3>';
                            }
                            echo '
									</div>
									<div class="large-11 columns progress objective-progress">';
							
							if($objective->allocations) {
								foreach($objective->allocations as $account => $amount) {
									echo '<span id="meter1" class="meter columns objective-meter" data-account-id="'.$account.'">'.$amount.'</span>';
								}
							}
							echo '</div>
									<div class="large-1 columns objective-postfix">
										<span class="postfix objective-amount">'.$objective->goal.'€</span>
									</div>
								</div>
							</div>';
						}
					} ?>
				</div>
				
				<div class="large-12 columns app-content-title">
					<h1>Objectifs terminés</h1>
					<button type='button' id='completedObjectivesBtn'>Show/Hide</button>
				</div>
				<div class="large-12 columns app-content-data" id='completedObjectives'>
					<?php if(isset($completedObjectives)) {
						foreach ($completedObjectives as $counter => $objective) {
							echo '<div class="large-12 columns app-content-objective">
								<div class="large-12 columns objective">
									<div class="large-11 columns objective-header">
										<h2 class="large-10 columns objective-label">'.$objective->label.'</h2>
										<h3 class="large-2 columns objective-percent">'.(($objective->amount / $objective->goal) * 100).'%</h3>
									</div>
									<div class="large-11 columns progress objective-progress">';
							
							if($objective->allocations) {
								foreach($objective->allocations as $account => $amount) {
									echo '<span id="meter1" class="meter columns objective-meter" data-account-id="'.$account.'">'.$amount.'</span>';
								}
							}
							echo '</div>
									<div class="large-1 columns objective-postfix">
										<span class="postfix objective-amount">'.$objective->goal.'€</span>
									</div>
								</div>
							</div>';
						}
					} ?>
				</div>
			</div>
		</div>
		
		<div id="account-modal" class="reveal-modal medium">
			<div class="large-12 columns account-modal-title">
				<h2 class="large-8 columns">Gestion du compte</h2>
				<h4 class="large-4 columns"></h4>
			</div>
			<div class="large-12 columns account-modal-balance">
				<h5 class="large-8 columns">Solde</h5>
				<span class="large-4 columns"></span>
				<hr>
			</div>
			<div class="large-12 columns account-modal-split">
				<h5 class="large-12 columns">Répartition</h5>
				<hr>
			</div>
			<div class="large-12 columns account-modal-balance">
				<hr>
				<button type="button" id="save-account-confirm">Enregistrer</button>
				<button type="button" class="close-window">Annuler et fermer</button>
			</div>
		</div>
		
		<div id="new-account-modal" class="reveal-modal medium">
			<div class="large-12 columns account-modal-title">
				<h2 class="large-8 columns">Nouveau compte</h2>
				<h4 class="large-4 columns"></h4>
			</div>
			<div class="large-12 columns account-modal-split">
				<h5 class="large-8 columns">Libellé</h5>
				<span class="large-4 columns"><input type="text" name="new-account-label" value="Nouveau compte" placeholder="Nouveau compte" required /></span>
				<hr>
			</div>
			<div class="large-12 columns account-modal-balance">
				<h5 class="large-8 columns">Solde de départ</h5>
				<span class="large-4 columns"><input type="number" name="new-account-amount" value="0" min="0"></span>
				<hr>
			</div>
			<div class="large-12 columns account-modal-balance">
				<button type="button" id="new-account-confirm">Créer</button>
				<button type="button" class="close-window">Annuler et fermer</button>
			</div>
		</div>

		<div id="new-objective-modal" class="reveal-modal medium">
			<div class="large-12 columns account-modal-title">
				<h2 class="large-8 columns">Nouvel objectif</h2>
				<h4 class="large-4 columns"></h4>
			</div>
			<div class="large-12 columns account-modal-split">
				<h5 class="large-8 columns">Libellé</h5>
				<span class="large-4 columns"><input type="text" name="new-objective-label" value="Nouvel objectif" placeholder="Nouvel objectif" required /></span>
				<hr>
			</div>
			<div class="large-12 columns account-modal-balance">
				<h5 class="large-8 columns">Solde à atteindre</h5>
				<span class="large-4 columns"><input type="number" name="new-objective-goal" value="0" min="0"></span>
				<hr>
			</div>
			<div class="large-12 columns account-modal-balance">
				<button type="button" id="new-objective-confirm">Créer</button>
				<button type="button" class="close-window">Annuler et fermer</button>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.nouislider.min.js"></script>
	<script type="text/javascript" src="assets/js/foundation.min.js"></script>
	<script type="text/javascript" src="assets/js/foundation.reveal.js"></script>

	<script type="text/javascript" src="assets/js/app.js"></script>
	<script>$(document).foundation();</script>
</html>