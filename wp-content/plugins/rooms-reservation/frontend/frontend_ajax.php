<?php
	// Fichier pour requête ajax
	require_once( '../../../../wp-blog-header.php' );
	// Vérifier présence donnée POST
	if( isset( $_POST ) )
	{
		// Appeler core wordpress
		
		if( !defined('SHORTINIT') )
			define( 'SHORTINIT', true );
		
		require_once( '../../../../wp-load.php' );

		global $wpdb;
		
		// Vérifier présence paramètre action
		if( isset($_POST['action']) )
		{
			// Fichiers requis pour insertions données
			require_once( '../../../../wp-includes/l10n.php' );
			require_once( '../../../../wp-includes/capabilities.php' );
			require_once( '../../../../wp-includes/pluggable.php' );
			require_once( '../../../../wp-includes/cron.php' );
			require_once( '../../../../wp-includes/revision.php' );
			require_once( '../../../../wp-includes/meta.php' );
			require_once( '../../../../wp-includes/link-template.php' );
			require_once( '../../../../wp-includes/class-wp-walker.php' );
			require_once( '../../../../wp-includes/user.php' );
			
			require_once( '../../../../wp-includes/post-template.php' );
			require_once( '../../../../wp-includes/formatting.php' );
			require_once( '../../../../wp-includes/taxonomy.php' );
		
			require_once( '../../../../wp-includes/post.php' );
			
			// Parcourir les actions
			switch ($_POST['action'])
			{
			
				// Lister les chambres
				case "get_rooms_by_date":
				
					$startDate = $_POST['postData']['endDate'];
					$endDate = $_POST['postData']['startDate'];
					
					// Récupérer toutes les chambres
					$rooms_list = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'rms_room' AND post_status = 'publish'");
					
					// Récupérer les données des séjours ayant lieu durant notre durée choisie
					$reservations_list = $wpdb->get_results("
						SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'rms_reservation_room' AND post_id IN (
						SELECT post_id
						FROM  $wpdb->postmeta
							WHERE (
							(
								meta_key =  'rms_reservation_start'
								AND meta_value >=" . date( 'Ymd', strtotime($startDate) ) . "
								AND meta_value <=" . date( 'Ymd', strtotime($endDate) ) . "
							)
							OR (
								meta_key =  'rms_reservation_end'
								AND meta_value >=" . date( 'Ymd', strtotime($startDate) ) . "
								AND meta_value <=" . date( 'Ymd', strtotime($endDate) ) . "
							)
							OR (
								(
									meta_key =  'rms_reservation_start'
									AND meta_value <=" . date( 'Ymd', strtotime($startDate) ) . "
								)
									AND (
									meta_key =  'rms_reservation_end'
									AND meta_value >=" . date( 'Ymd', strtotime($endDate) ) . "
								)
							)
						)
						)"
					);
					
					
					$clean_array = array();
					
					// Enregistrer les données concernant la chambre de la réservation
					foreach ( $reservations_list as $res_data )
					{
						$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->postmeta WHERE post_id = " . $res_data -> post_id . " AND meta_key = 'rms_reservation_status' AND meta_value != 1");
						
						if( $count == 0)
						{
							array_push( $clean_array, $res_data -> meta_value );
						}
					
					}// Fin foreach()
					// Parcourir la liste des chambres
					foreach ( $rooms_list as $rooms_data )
					{
						// Vérifier correspondance résultats
						$arrMatches  = preg_grep ('#'.$rooms_data -> ID.'#', $clean_array);

						// Afficher chambres libres
						if( !$arrMatches )
						{
						
							$rms_room_stocked_meta = get_post_meta( $rooms_data->ID );
							$room_type = $rms_room_stocked_meta['rms_room_type'][0];
							$get_room_price = $rms_room_stocked_meta['rms_room_price'][0];
							
							if( ($room_type == 'classic') && ($_POST['user_age'] <= 35) )
								$get_room_price -= 20;
							
							echo '<article data-room="room_' . $rooms_data -> ID . '" data-room_id="' . $rooms_data -> ID . '">
									<div class="rms_room_header">
										<div class="rms_room_title">';
										
											if( $_POST['postData']['lang'] == 'fr' )
												echo $rooms_data -> post_title;
											else
												echo get_field('room_eng_title', $rooms_data -> ID);
									echo '</div>
										<div class="rms_room_price">' . $get_room_price . ' CHF</div>
									</div>
									
									<div class="rms_room_descriptif">
										' . __( 'DESCRIPTIF', 'rms_reservation') . ': ';
										
										if( $_POST['postData']['lang'] == 'fr' )
											echo $rooms_data -> post_content;
										else
											echo get_field('room_eng_descr', $rooms_data -> ID);
								echo '			
									</div>
									
									<input type="submit" value="' . __( 'CHOISIR', 'rms_reservation') . '" data-meta_room="room_' . $rooms_data -> ID . '" />
								</article>';
						}
					
					}// Fin foreach()
					
				break;
				
				// Cas d'ajout d'une réservation
				case "add_reservation_new_user":
				
					// Appeler fonction de création de l'hôte
					if ( !is_user_logged_in() )
					{
						$user_id = createUser($_POST['gimme_scolarship']);
					}
					else
					{
						$user_id = get_current_user_id();
							// Vérifier si cas de bourse
		if( $_POST['gimme_scolarship'] )
		{
			
			// Parcourir langue
			switch ($_POST['lang'])
			{
			
				case "fr":
				$mail_title = "Fondation Hardt / Accusé de réception";
			$message = "Nous vous remercions de votre intérêt pour la Fondation Hardt.<br/>
			<br/>
			Votre demande de bourse pour un séjour scientifique à la Fondation a bien été enregistrée. Votre dossier sera examiné dès la fin du délai de candidature (30 novembre/30 avril). Nous vous contacterons dès que le processus d’attribution des bourses sera terminé.
			<br/>
			Veuillez trouver ci-après vos paramètres d'accès à votre compte sur notre site internet :<br/>
			<br/>
			Pour toute information complémentaire, veuillez vous adresser à admin@fondationhardt.ch<br/>
			Avec nos remerciements et nos salutations les meilleures,<br/>
			<br/>
			Fondation Hardt";

							break;
							
							default:
							$mail_title = "Hardt Foundation / Return receipt";
			$message = "Thank you very much for your interest in The Hardt Foundation. We have received your application for a grant for a scientific stay at the Hardt Foundation.<br/>
			<br/>
			All applications will be examined after the submission deadline (30th November/30th April). We will contact you as soon as the selection process is over.<br/>
			<br/>
			Please find below your login details for your account on our website :<br/>
			<br/>
			For further information, please contact us at admin@fondationhardt.ch<br/>
			<br/>
			Best wishes,<br/>
			<br/>
			Hardt Foundation";

							break;
							
						}// Fin switch ($_POST['lang'])
					}
					else
					{
						// Parcourir langue
						switch ($_POST['lang'])
						{
						
							case "fr":
							$mail_title = "Fondation Hardt / Accusé de réception";
			$message = "Nous vous remercions de votre intérêt pour la Fondation Hardt.<br/>
			<br/>
			Votre demande de réservation pour un séjour scientifique à la Fondation a bien été enregistrée. Veuillez noter que la disponibilité affichée des chambres ne peut être assurée et qu’il ne s’agit pas d’une réservation définitive.<br/>
			Nous vous confirmerons la réservation dès que possible.<br/>
			 <br/>
			Veuillez trouver ci-après vos paramètres d'accès à votre compte sur notre site internet :<br/>
			<br/>
			Pour toute information complémentaire, veuillez vous adresser à admin@fondationhardt.ch<br/>
			Avec nos remerciements et nos salutations les meilleures,<br/>
			<br/>
			Fondation Hardt";

							break;
							
							default:
							$mail_title = "Hardt Foundation / Return receipt";
							
			$message = "Thank you very much for your interest in The Hardt Foundation<br/>
			<br/>
			We have received your request for a scientific stay at the Foundation. Please note that room availability cannot be guaranteed and that this is not a final reservation.<br/>
			<br/>
			We will contact you as soon as possible to confirm the reservation.<br/>
			<br/>
			Please find below your login details for your account on our website :<br/>
			<br/>
			For further information, please contact us at admin@fondationhardt.ch<br/>
			<br/>
			Best wishes,<br/>
			<br/>
			Hardt Foundation";

							break;
							
						}// Fin switch ($_POST['lang'])
					
					}// Fin if( $scolarship )
					
					

					wp_mail( $user_email, $mail_title, $message, $headers);
					}
						
					// Ajout usermeta
					$arrBasicUserMeta = array(
						"civil",
						"last_name",
						"first_name",
						"birthday",
						"sex",
						"nationality",
						"university_title",
						"affiliation",
						"function",
						"street",
						"number",
						"city",
						"postal",
						"country",
						"iso",
						"phone_1",
						"phone_2",
						"references",
						"remarks",
						"theme",
						"regime"
					);
					
					// Parcourir les colonnes à ajouter
					foreach( $arrBasicUserMeta as $metaData )
					{
					
						// Vérifier présence donnée
						if( $_POST[$metaData] != '' )
						{
							// Ajouter méta
							update_user_meta( $user_id, $metaData, $_POST[$metaData] );
						}
						
					}// Fin foreach()
					
					// Ajouter méta adresse facturation, si nécessaire
					if( !$_POST['same_addr'] )
					{
						// Ajout usermeta, facturation
						$arrFactUserMeta = array(
							"fact_street",
							"fact_number",
							"fact_city",
							"fact_postal",
							"fact_country",
							"fact_iso",
							"fact_phone_1", 
							"fact_phone_2", 
							"fact_email"
						);
						
						// Parcourir les colonnes à ajouter
						foreach( $arrFactUserMeta as $metaData )
						{
						
							// Vérifier présence donnée
							if( $_POST[$metaData] != '' )
							{
								// Ajouter méta
								update_user_meta( $user_id, $metaData, $_POST[$metaData] );
							}
							
						}// Fin foreach()
					
					}// Fin if( !$_POST['same_addr'] )
					
					// Objet des posts
					class cls_custompost
					{
					
						var $post_title;
						var $post_content;
						var $post_status;
						var $post_author; /* author user id (optional) */
						var $post_name; /* slug (optional) */
						var $post_type; /* 'page' or 'post' (optional, defaults to 'post') */
						var $comment_status; /* open or closed for commenting (optional) */
						
					}// Fin class cls_custompost

					if( $user_id )
					{
						if( !$_POST['gimme_scolarship'] )
						{
							// Initialiser
							$cls_custompost = new cls_custompost();
							// Ajouter réservations
							$cls_custompost -> post_title = 'Sej'. date( "dm", strtotime( $_POST['start_date'] ) ) . substr( chr( mt_rand( 97 ,122 ) ) .substr( md5( time( ) ) ,1 ), 0, 3);
							$cls_custompost -> post_type = 'rms_reservation';
							$cls_custompost -> post_content = '';
							$cls_custompost -> post_status = 'publish';
							$cls_custompost -> post_author = $user_id;
							$wp_rewrite -> feeds = 'no';
						
							// Créer le post
							$post_id = wp_insert_post($cls_custompost);

							// Ajouter postmeta à la réservation
							add_post_meta( $post_id, 'rms_reservation_room', 'a:1:{i:0;s:3:"' . $_POST['room_id'] . '";}' );
							add_post_meta( $post_id, 'rms_reservation_start', date( "Ymd", strtotime( $_POST['start_date'] ) ) ); 
							add_post_meta( $post_id, 'rms_reservation_end', date( "Ymd", strtotime( $_POST['end_date'] ) ) ); 
							add_post_meta( $post_id, 'rms_reservation_client', $user_id );
							add_post_meta( $post_id, 'rms_reservation_status', 0 );
							add_post_meta( $post_id, 'rms_reservation_cost', $_POST['cost'] );
							
						}
						
						// Envoyer mail à l'administrateur
						$headers_admin = 'From: Fondation Hardt <admin@extranet.ch>' . "\r\n";
						$message_admin = "
				Bonjour,<br/>
				<br/>
				Un nouveau séjour a été enregistré, voici les données reçues :<br>";
				$message_admin .= "<h4>Informations de l'hôte</h4>";
				// Ajout usermeta
						$arrBasicUserMeta = array(
							"lang" => "<b>Langue</b>",
							"civil" => "Civilité",
							"last_name" => "Nom",
							"first_name" => "Prénom",
							"email" => "Adresse mail",
							"birthday" => "Date de naissance",
							"sex" => "Sexe",
							"nationality" => "Nationalité",
							"university_title" => "Titre(s) universitaire(s)",
							"affiliation" => "Affiliation",
							"function" => "Fonction actuelle",
							"street" => "Adresse",
							"number" => "N°",
							"city" => "Ville",
							"postal" => "Code postal",
							"country" => "Pays",
							"iso" => "Code ISO",
							"phone_1" => "Téléphone 1",
							"phone_2" => "Téléphone 2",
							"references" => "Références",
							"remarks" => "Remarques",
							"theme" => "Sujet de la recherche",
							"regime" => "Régime/allergies"
						);
						
						// Parcourir les colonnes à ajouter
						foreach( $arrBasicUserMeta as $metaData => $fr_name )
						{
						
							// Vérifier présence donnée
							if( $_POST[$metaData] != '' )
							{
								// Ajouter méta
								$message_admin .= $fr_name . " : " . $_POST[$metaData] ."<br/>";
							}
							
						}// Fin foreach()
						
							// Ajouter méta adresse facturation, si nécessaire
						if( !$_POST['same_addr'] )
						{
							$message_admin .= "<br><h4>Adresse de facturation</h4><br/>";
							// Ajout usermeta, facturation
							$arrFactUserMeta = array(
								"fact_street" => "Adresse de facturation",
								"fact_number" => "N°",
								"fact_city" => "Ville",
								"fact_postal" => "Code postal",
								"fact_country" => "Pays",
								"fact_iso" => "ISO",
								"fact_phone_1" => "Téléphone 1", 
								"fact_phone_2" => "Téléphone 2", 
								"fact_email" => "Email"
							);
							
							// Parcourir les colonnes à ajouter
							foreach( $arrFactUserMeta as $metaData => $fr_name )
							{
							
								// Vérifier présence donnée
								if( $_POST[$metaData] != '' )
								{
									// Ajouter méta
									$message_admin .= $fr_name . " : " . $_POST[$metaData] . "<br/>";
								}
								
							}// Fin foreach()
						
						}// Fin if( !$_POST['same_addr'] )
						
						$message_admin .= "<br><h4>Informations concernant le séjour</h4>";
						
						if( !$_POST['gimme_scolarship'] )
						{
							$message_admin .= "Réservation N°" . get_the_title( $post_id ) . "<br/>";
							
							$message_admin .= "Le séjour a lieu du " . $_POST['start_date'] . " au " . $_POST['end_date'] . "<br/>";
							
							$message_admin .= "La chambre souhaitée est la N°" .  get_post_meta(  $_POST['room_id'], 'rms_room_number', true ) . " <i>" . get_the_title( $_POST['room_id'] ) . "</i><br/>";
							
						}
						else
						{
							$message_admin .= "<u>Il y a une demande de bourse pour ce séjour</u><br/>";
							
							$message_admin .= "Souhait des dates:<br/>";
							
							$message_admin .= "Période 1 :     du " . $_POST['start_1'] . " au " . $_POST['end_1'] . "<br/>";
							
							$message_admin .= "Période 2 :     du " . $_POST['start_2'] . " au " . $_POST['end_2'] . "<br/>";
						}
						//wp_mail( "info@the-agencies.ch", "Demande pour un séjour", $message_admin, $headers_admin);
						wp_mail( "info@the-agencies.ch", "Demande pour un séjour", $message_admin, $headers_admin);
		
					}
					else
					{
						echo "user_id_error";
					}
					
				break;
				
				// Nouvelle réservation avec demande de bourse
				case "add_reservation_scolarship_new_user":	
		
					$unique_user_id = 'uid_' . sha1(time());
					
					if( $unique_user_id )
					{
					
						$outputFileData = "";
						foreach($_FILES as $file)
						{
							$upld_file = wp_upload_bits( $file['name'], null, @file_get_contents( $file['tmp_name'] ) );
							
							if ( FALSE === $upld_file['error'] )
							{	
								// Ajouter meta du document à l'utilisateur
								$outputFileData .= $upld_file['url'] . "|";
							}
							
						}
						
						add_option( $unique_user_id, $outputFileData);

					}
					else
					{
						echo "user_id_error_2";
					}
					
					echo $unique_user_id;
					
				break;
				
				case "admin_get_single_room_data":
				
						//  Meta de la chambre
						$rms_room_stocked_meta = get_post_meta( $_POST['room_id'][0] );
						// si la chambre n'est pas trouvée, on essaie une autre méthode sans découper le tableau
						if($rms_room_stocked_meta == array()) {
							$rms_room_stocked_meta = get_post_meta( $_POST['room_id'] );
						}
						
						$room_type = $rms_room_stocked_meta['rms_room_type'][0];
						$room_price = $rms_room_stocked_meta['rms_room_price'][0];
						
						// Obtenir l'age de l'utilisateur
						$user_age = floor( (time() - strtotime( get_user_meta( $_POST['user_id'], 'birthday', true) ) ) / 31556926 );
						
						// Rabais automatique si <35ans sur classic
						if( ($room_type == 'classic') && ($user_age <= 35) )
									$room_price -= 20;
									
						$total_price =  $room_price * $_POST['nights'];
						
						echo $total_price;
					
				break;
			}// Fin switch()
			
			
		}
		else
		{
		
			// Quitter le script
			die();
			
		}
		
	}
	else
	{
	
		// Quitter le script
		die();
		
	}// Fin if( isset( $_POST ) )
	
	// Créer le nouvel utilisateur
	function createUser($scolarship=null)
	{
		// Récupérer les champs
		$user_name = sanitize_text_field( strtolower($_POST['last_name']) . '_' . strtolower($_POST['first_name']) );
		$user_email = sanitize_email( $_POST['email'] );
		$user_id = username_exists( $user_name );
		$i = 0;
		
		do
		{
			if($i > 0)
				$user_name = $user_name . '_' . $i;
			
			$i++;
			
		}while(username_exists( $user_name ));
		
		// Vérifier utilisateur et email disponible
		if ( !$user_id and !email_exists($user_email)) 
		{

			$random_password = wp_generate_password( $length=8, $include_standard_special_chars=false );
			$user_id = wp_create_user( $user_name, $random_password, $user_email );
			
			wp_update_user(
				array(
					'ID' => $user_id,
					'user_email' => $user_email
				)
			);
			
			// Charger utilisateur
			$user = new WP_User( $user_id );

			// Supprimer ancien rôle
			$user->remove_role( 'subscriber' );
			
			// Ajouter rôle d'hôte
			$user->add_role( 'hardt_host' );
	
		
		$headers = 'From: Fondation Hardt <admin@extranet.ch>' . "\r\n";
		$message = "";
		$mail_title = "";
		update_user_meta( $user_id, 'user_lang', $_POST['lang'] );
		update_user_meta( $user_id, 'user_uid', $_POST['unique_user_id'] );
		
		// Vérifier si cas de bourse
		if( $scolarship )
		{
			
			// Parcourir langue
			switch ($_POST['lang'])
			{
			
				case "fr":
				$mail_title = "Fondation Hardt / Accusé de réception";
$message = "Nous vous remercions de votre intérêt pour la Fondation Hardt.<br/>
<br/>
Votre demande de bourse pour un séjour scientifique à la Fondation a bien été enregistrée. Votre dossier sera examiné dès la fin du délai de candidature (30 novembre/30 avril). Nous vous contacterons dès que le processus d’attribution des bourses sera terminé.
<br/>
Veuillez trouver ci-après vos paramètres d'accès à votre compte sur notre site internet :<br/>
Nom d'utilisateur : " . $user_name . "<br/>
Mot de Passe : " . $random_password . "<br/>
<br/>
Pour toute information complémentaire, veuillez vous adresser à admin@fondationhardt.ch<br/>
Avec nos remerciements et nos salutations les meilleures,<br/>
<br/>
Fondation Hardt";

				break;
				
				default:
				$mail_title = "Hardt Foundation / Return receipt";
$message = "Thank you very much for your interest in The Hardt Foundation. We have received your application for a grant for a scientific stay at the Hardt Foundation.<br/>
<br/>
All applications will be examined after the submission deadline (30th November/30th April). We will contact you as soon as the selection process is over.<br/>
<br/>
Please find below your login details for your account on our website :<br/>
<br/>
Username : " . $user_name . "<br/>
Password : " . $random_password . "<br/>
<br/>
For further information, please contact us at admin@fondationhardt.ch<br/>
<br/>
Best wishes,<br/>
<br/>
Hardt Foundation";

				break;
				
			}// Fin switch ($_POST['lang'])
		}
		else
		{
			// Parcourir langue
			switch ($_POST['lang'])
			{
			
				case "fr":
				$mail_title = "Fondation Hardt / Accusé de réception";
$message = "Nous vous remercions de votre intérêt pour la Fondation Hardt.<br/>
<br/>
Votre demande de réservation pour un séjour scientifique à la Fondation a bien été enregistrée. Veuillez noter que la disponibilité affichée des chambres ne peut être assurée et qu’il ne s’agit pas d’une réservation définitive.<br/>
Nous vous confirmerons la réservation dès que possible.<br/>
 <br/>
Veuillez trouver ci-après vos paramètres d'accès à votre compte sur notre site internet :<br/>
<br/>
Nom d'utilisateur : " . $user_name . "<br/>
Mot de Passe : " . $random_password . "<br/>
<br/>
Pour toute information complémentaire, veuillez vous adresser à admin@fondationhardt.ch<br/>
Avec nos remerciements et nos salutations les meilleures,<br/>
<br/>
Fondation Hardt";

				break;
				
				default:
				$mail_title = "Hardt Foundation / Return receipt";
				
$message = "Thank you very much for your interest in The Hardt Foundation<br/>
<br/>
We have received your request for a scientific stay at the Foundation. Please note that room availability cannot be guaranteed and that this is not a final reservation.<br/>
<br/>
We will contact you as soon as possible to confirm the reservation.<br/>
<br/>
Please find below your login details for your account on our website :<br/>
<br/>
Username : " . $user_name . "<br/>
<br/>
Password : " . $random_password . "<br/>
<br/>
For further information, please contact us at admin@fondationhardt.ch<br/>
<br/>
Best wishes,<br/>
<br/>
Hardt Foundation";

				break;
				
			}// Fin switch ($_POST['lang'])
		
		}// Fin if( $scolarship )
		
		

		wp_mail( $user_email, $mail_title, $message, $headers);
			
			return $user_id;
		}
		else
		{}// Fin if()
		
	}// Fin function createUser()
?>