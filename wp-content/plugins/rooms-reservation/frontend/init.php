<?php
	// Init du frontend
	function rms_reservation_frontend()
	{
		
		// Ajouter custom style
		wp_enqueue_style('rms_frontend_css', plugins_url('/rooms-reservation/css/frontend.css'));
		wp_enqueue_script('jquery-ui-datepicker');
		
        wp_register_script( 'rms_frontend_js',  plugins_url( '/../js/frontend.js', __FILE__ ) );
		wp_enqueue_script('rms_frontend_js');
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		
		// Propriétés Ajax
		wp_localize_script( 'rms_frontend_js', 'ajax_object',
			array( 'ajax_url' => plugins_url('/rooms-reservation/frontend/frontend_ajax.php'),
					'ajax_url_admin' => admin_url('admin-ajax.php'))
		);
		
	}// Fin rms_reservation_frontend()
	
	// Fonction de traduction
	function rms_translate( $originString, $empty = null )
	{
		// Variable du texte à afficher
		$outputString = $originString;
		
		// Tableau des textes anglais
		$en_array = array(
			"Profil" => "Profile",
			"Dates" => "Dates",
			"Réserver" => "Reservation",
			"Confirmation" => "Confirmation",
			"Nous vous remercions de votre intérêt pour la Fondation Hardt." => "Thank you for your interest in the Hardt Foundation.",
			"Je souhaite créer un compte" => "I wish to create an online account",
			"J'ai déjà un compte" => "I already have an online account",
			"Veuillez entrer votre nom d'utilisateur et mot de passe" => "",
			"Nom d'utilisateur" => "Username",
			"Mot de passe" => "Password",
			"Se souvenir de moi" => "Remember me",
			"Mot de passe oublié?" => "Forgotten password?",
			"Déconnexion" => "Sign out",
			"Se déconnecter" => "Sign out",
			"Connexion" => "Sign in",
			"L'inscription de demande de séjour à la Fondation Hardt se déroule en 4 étapes, merci de compléter les champs suivants" => "Registration request to stay the Hardt Foundation in 4 steps, thank you complete the following fields",
			"Merci de compléter l'ensemble des champs correctement" => "Please fill all the fields correctly",
			"Civilité" => "Civility",
			"Nom" => "Last name",
			"Prénom" => "First name",
			"Date de naissance" => "Date of birth",
			"Nationalité" => "Nationality",
			"Sexe" => "Sex",
			"Titre(s) universitaire(s)" => "University degrees",
			"Affiliation institutionnelle" => "Institution affiliation",
			"Fonction actuelle" => "Current position held",
			"Rue" => "Address",
			"N°" => "N°",
			"Ville" => "City",
			"Code postal" => "Zip Code",
			"Pays" => "Country",
			"Tél. 1" => "Phone 1",
			"Tél. 2" => "Phone 2",
			"Email" => "Mail",
			"Adresse de facturation" => "Billing address",
			"Identique à mon adresse de contact" => "Same as my contact address",
			"Adresse de contact" => "Contact adress",
			"Thème de la recherche durant votre séjour" => "Research theme during your stay",
			"Régime/Allergies" => "Diet / Allergies",
			"Remarques" => "Remarks",
			"Je souhaite faire une demande de bourse" => "I wish to apply for a scholarship",
			"Conditions d'obtention d'une bourse" => "Conditions for obtaining a scholarship",
			"Veuillez choisir deux périodes de séjour souhaitées" => "Please select two periods you wish",
			"Période 1" => "Period 1",
			"Période 2" => "Period 2",
			"Date d'arrivée (en principe le lundi)" => "Arrival Day (in principle on a Monday)",
			"Date de départ (en principe le samedi)" => "Departure Day (in principle on a Saturday)",
			"Date d'arrivée" => "Arrival Day",
			"Date de départ" => "Departure Day",
			"Joindre les documents demandés" => "Attach the requested documents",
			"Continuer" => "Continue",
			"Veuillez entrer les dates souhaitées" => "Please enter your desired dates",
			"Vérifier les disponibilités" => "Check availability",
			"Voici la liste des chambres disponibles aux dates souhaitées:" => "Here is the list of rooms available on the dates you want:",
			"Nombre de nuits" => "Number of nights",
			"Modifier" => "Edit",
			"Chambre" => "Room",
			"Voici le résumé de votre pré-réservation. Veuillez noter que votre demande de séjour à la Fondation Hardt doit encore faire l'objet d'une validation de notre part." => "Here is a summary of your pre-booking. Please note that your request need to be valided by the Foundation.",
			"Confirmer" => "Confirm",
			"J'ai lu et j'accepte" => "I have read and agree",
			"les conditions générales" => "the terms and conditions",
			"Monsieur" => "Mr.",
			"Madame" => "Mrs.",
			"Mademoiselle" => "Ms.",
			"Autre" => "Other",
			"Générer un mot de passe" => "Get New Password",
			"Identifiant ou adresse de messagerie" => "Username or E-mail"
			
		);
		
		// Vérifier si langue différent de français
		if( ICL_LANGUAGE_CODE != 'fr' )
		{
		
			// Traduire le texte
			$outputString = $en_array[$originString];
			
		}// Fin if( ICL_LANGUAGE_CODE != 'fr' )
		
		// Retourner le texte
		return $outputString;
	
	}// function rms_translate( $str_to_translate )
	add_filter( 'wp_mail_content_type', 'set_content_type' );
	function set_content_type( $content_type )
	{
		return 'text/html';
	}

?>