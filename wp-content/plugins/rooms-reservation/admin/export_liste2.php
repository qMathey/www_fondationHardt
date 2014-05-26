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
	header("Content-Disposition: attachment; filename=\"exportlst2_".date("Y-m-d")."_" . mb_substr(sha1(time()), 0, 5) .".xls\"");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");

	// Démarrer l'export
	xlsBOF();

	// Meta colonnes
	xlsWriteLabel( 0, 0, utf8_decode('Nom') );
	xlsWriteLabel( 0, 1, utf8_decode('Prénom') );
	xlsWriteLabel( 0, 2, utf8_decode('Affiliation institutionnelle') );
	xlsWriteLabel( 0, 3, utf8_decode('Thème de recherche') );
	xlsWriteLabel( 0, 4, utf8_decode('Date d\'arrivée') );
	xlsWriteLabel( 0, 5, utf8_decode('Date de départ') );
	xlsWriteLabel( 0, 6, utf8_decode('Numéro de chambre') );

	// Inclure fichier wp requis
	require_once('../../../../wp-load.php');

	global $post;

	// Obtenir la liste des réservations
	$args = array( 'post_type' => 'rms_reservation');
	
	$loop = new WP_Query( $args );
	$i = 0;
	
	while ( $loop->have_posts() )
	{
		$i++;
		
		$loop->the_post();
		
		// Données de l'utilisateur (TODO)
		$post_author_id = get_post_field( 'post_author', get_the_ID() );
		
		$usr_lastname = get_user_meta( $post_author_id, 'last_name', true ); 
		$usr_firstname = get_user_meta( $post_author_id, 'first_name', true ); 
		$ins_affiliation = get_user_meta( $post_author_id, 'affiliation', true ); 
		$ins_subject = get_user_meta( $post_author_id, 'theme', true );
		
		// Données de la chambre
		$roomArrayId = get_field('rms_reservation_room');

		$roomData = get_post($roomArrayId[0]);
		$roomNumber = get_post_meta( $roomData -> ID, 'rms_room_number', true );
		
		// Données de la réservation
		
		// Insérer les données dans le fichier Excel
		xlsWriteLabel($i, 0, excel_encode( $usr_lastname, 'Windows-1252') );
		xlsWriteLabel($i, 1, excel_encode( $usr_firstname, 'Windows-1252') );
		xlsWriteLabel($i, 2, excel_encode( $ins_affiliation, 'Windows-1252') );
		xlsWriteLabel($i, 3, excel_encode( $ins_subject, 'Windows-1252') );
		xlsWriteLabel($i, 4, excel_encode( date( "d.m.Y", strtotime( get_field('rms_reservation_start') ) ), 'Windows-1252') );
		xlsWriteLabel($i, 5, excel_encode( date( "d.m.Y", strtotime( get_field('rms_reservation_end') ) ), 'Windows-1252') );
		xlsWriteLabel($i, 6, excel_encode( $roomNumber, 'Windows-1252') );

		
	}// Fin while() 

	// Terminer l'export
	xlsEOF();
?>