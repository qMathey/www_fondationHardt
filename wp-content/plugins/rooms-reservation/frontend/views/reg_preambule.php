<?php
	/* Vue formulaire d'enregistrements: Préambule */
?>
<div class="rms_wrapper">
	<p><?php echo rms_translate("Nous vous remercions de votre intérêt pour la Fondation Hardt."); ?></p>
	
	<ul class="premabule_actions">
		<li>
			<a href="<?php echo get_permalink(); ?>&step=1">
				<?php echo rms_translate("Je suis un nouvel hôte"); ?>
			</a>
		</li>
		
		<li>
			<a href="#" class="show_loginform">
				<?php echo rms_translate("J'ai déjà séjourné à la Fondation"); ?>
			</a>
		</li>
	</ul>
	
	<div class="login_form">
	
<?php
	// Vérifier utilisateur déjà visiteur
	if( (!current_user_can('hardt_host')) && (!current_user_can('hardt_admin')) )
	{
?>
		<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
			<p><?php echo rms_translate("Veuillez entrer votre nom d'utilisateur et mot de passe"); ?></p>
				<fieldset>
					<label for="username"><?php echo rms_translate("Nom d'utilisateur"); ?></label>
					<input type="text" name="log" id="log" value="<?php echo $user_login; ?>" size="20" />
					
					<label for="password"><?php echo rms_translate("Mot de passe"); ?></label>
					<input type="password" name="pwd" id="pwd" size="20" />
					
					<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php echo rms_translate("Se souvenir de moi"); ?></label>
					<input type="submit" name="submit" value="<?php echo rms_translate("Connexion"); ?>" class="button" />
					
				</fieldset>

			<p>
				
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			</p>
		</form>
		
		<a href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword" class="toggle_passwordform"><?php echo rms_translate("Mot de passe oublié?"); ?></a>
		<form id="lostpasswordform" action="#" method="post" style="display:none;">
			<fieldset>
				<p class="fields">
					<label for="user_login" ><?php echo rms_translate("Identifiant ou adresse de messagerie"); ?> :<br />
					<input type="text" name="user_login" id="user_login" class="input" value="" size="20" /></label>
				</p>
				
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					
				<p class="submit"><input type="submit" name="wp-submit" id="reset_pwd_submit" class="button button-primary button-large" value="<?php echo rms_translate("Générer un mot de passe"); ?>" /></p>
				
			</fieldset>
		</form>
<?php
	}
	else
	{
?>
		<h2><?php echo rms_translate("Déconnexion"); ?></h2>
		<a href="<?php echo wp_logout_url(urlencode($_SERVER['REQUEST_URI'])); ?>"><?php echo rms_translate("Se déconnecter"); ?></a><br />
<?php
	}// Fin if()
	?>
		
	</div>
	
</div>