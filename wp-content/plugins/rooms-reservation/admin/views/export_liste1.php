<?php 
	function xlsBOF()
	{
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	}

	function xlsEOF()
	{
		echo pack("ss", 0x0A, 0x00);
	}

	function xlsWriteNumber($row, $col, $value)
	{
		echo pack("sssss", 0x203, 14, $row, $col, 0x0);
		echo pack("d", $value);
	}

	function xlsWriteLabel($row, $col, $value)
	{
		$l = strlen($value);
		echo pack("ssssss", 0x204, 8 + $l, $row, $col, 0x0, $l);
		echo $value;
	}

	// Fonction pour le réencoding
	function excel_encode($data, $enc='Windows-1252')
	{
		$data = htmlentities($data, ENT_QUOTES, 'utf-8');
		
		$data = html_entity_decode($data, ENT_QUOTES , $enc);
		
		return $data;

	}// Fin excel_encode()
	
	// Headers
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"exportlst1_".date("Y-m-d")."_" . mb_substr(sha1(time()), 0, 5) .".xls\"");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");

	// Démarrer l'export
	xlsBOF();

	// Meta colonnes
	$arrBasicUserMeta = array(
		"civil" => "Civilité",
		"last_name" => "Nom",
		"first_name" => "Prénom",
		"birthday" => "Date de naissance",
		"nationality" => "Nationalité",
		"university_title" => "Titre(s) universitaire(s)",
		"affiliation" => "Affiliation",
		"street" => "Adresse",
		"number" => "N°",
		"postal" => "Code postal",
		"city" => "Ville",
		"country" => "Pays",
		"iso" => "Code ISO",
		"email" => "Adresse mail",
		"theme" => "Sujet de la recherche",
		"regime" => "Régime/allergies",
		"remarks" => "Remarques",
		"fact_street" => "Adresse de facturation",
		"fact_number" => "N°",
		"fact_city" => "Ville",
		"fact_postal" => "Code postal",
		"fact_country" => "Pays",
		"fact_iso" => "ISO", 
		"fact_email" => "Email de facturation"
	);
	
	$i = 0;
	
	// Parcourir labels
	foreach( $arrBasicUserMeta as $meta=>$label )
	{
	
		xlsWriteLabel( 0, $i, utf8_decode($label) );
		
		$i++;
	}
	
	xlsWriteLabel( 0, $i, utf8_decode('Chambre') );
	xlsWriteLabel( 0, $i+1, utf8_decode('Tarif/nuitée') );
	xlsWriteLabel( 0, $i+2, utf8_decode('Date d\'arrivée') );
	xlsWriteLabel( 0, $i+3, utf8_decode('Date de départ') );
	xlsWriteLabel( 0, $i+4, utf8_decode('Nombre de nuitées') );
	xlsWriteLabel( 0, $i+5, utf8_decode('Montant total') );
	
	// Inclure fichier wp requis
	require_once('../../../../../wp-load.php');

	global $post;
	
	$data = array();
	
	// Obtenir la liste des réservations
	$args = array( 'post_type' => 'rms_reservation');
	
	$loop = new WP_Query( $args );
	
	$i = 0;
	
	while ( $loop->have_posts() )
	{		
		$i++;
		
		$loop->the_post();
		
		// Données de l'utilisateur
		$post_author_id = get_post_meta(get_the_ID(), 'rms_reservation_client', true );
		
		$j = 0;
	
		// Parcourir données réservations
		foreach( $arrBasicUserMeta as $meta=>$label )
		{
		
			xlsWriteLabel( $i, $j, utf8_decode( get_user_meta($post_author_id, $meta, true) ) );
			
			$j++;
		}
		
		$usr_last_name = get_user_meta( $post_author_id, 'last_name', true );
		
		$usr_first_name = get_user_meta( $post_author_id, 'first_name', true );
		
		// Données de la chambre
		$roomArrayId = get_field('rms_reservation_room');

		$roomData = get_post($roomArrayId[0]);
		$roomNumber = get_post_meta( $roomData -> ID, 'rms_room_number', true );
		$room = $roomNumber . ' / ' . $roomData -> post_title;
		$roomPrice = get_post_meta( $roomData -> ID, 'rms_room_price', true );
		
		// Données de la réservation
		$resStart = date( "d.m.Y", strtotime( get_field('rms_reservation_start') ) );
		$resEnd = date( "d.m.Y", strtotime( get_field('rms_reservation_end') ) );
		$resNight = floor( abs( strtotime($resStart) - strtotime($resEnd) ) / (60*60*24) );
		$resFullCost = get_post_meta( get_the_ID(), 'rms_reservation_cost', true );
		
		
		// Insérer les données dans le fichier Excel
		xlsWriteLabel($i, $j, excel_encode( $room, 'Windows-1252') );
		xlsWriteLabel($i, $j+1, excel_encode( $roomPrice, 'Windows-1252') );
		xlsWriteLabel($i, $j+2, excel_encode( $resStart, 'Windows-1252') );
		xlsWriteLabel($i, $j+3, excel_encode( $resEnd, 'Windows-1252') );
		xlsWriteLabel($i, $j+4, excel_encode( $resNight, 'Windows-1252') );
		xlsWriteLabel($i, $j+5, excel_encode( $resFullCost, 'Windows-1252') );	

	}// Fin while()
	
	// Terminer l'export
	xlsEOF();
?>