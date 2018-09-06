<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Connexion</title>
		<meta name="author" content="Maxime Vernusset"/>
		<meta name="language" content="fr"/>
		<meta name="copyright" content="Maxime Vernusset"/>
		<meta name="robots" content="index,follow"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta charset="utf-8"/>

		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<link rel="stylesheet" href="./public/css/aslan.css"/>
		<link rel="stylesheet" href="./public/css/connection.css"/>
		<link rel="icon" type="image/png" href="public/img/aslan.png"/>
	</head>

	<body>

		<div class="container text-center ">
			<main>
				<h1>Aslan</h1>
				<form method="post" action="./">
					<fieldset>
						<legend>Connexion</legend>
						<input type="hidden" name="nextAction" value="<?= $nextAction ?>"/>
						<div class="form-group">
							<input type="email" name="email" placeholder="Email" class="form-control" />
						</div>
						<div class="form-group">
							<input type="password" name="password" placeholder="Mot de passe" class="form-control" />
						</div>
						<div class="checkbox">
							<label><input type="checkbox" name="<?= STAY_CONNECTED ?>"/> Rester connecté</label>
						</div>
						<input type="submit" name="connect" value="Entrer" class="btn btn-aslan"/>
					</fieldset>
				</form>
				<img src="public/img/aslan.png" width="500"/>
			</main>

			<div id="warning-message">
				<p><?= isset($warningMessage) ? $warningMessage : '' ?></p>
			</div>

			<?php include 'view/footer.php'; ?>
		</div>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	</body>

</html>
