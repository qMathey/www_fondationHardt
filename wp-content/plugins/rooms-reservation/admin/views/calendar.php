<?php
	// Vue de la page du calendrier

	// Fonction de recherche dans un tableau (multidimentionnel ou pas)
	function search_array($needle, $haystack)
	{

		if(in_array($needle, $haystack))
		{
		
			return true;
		
		}
		
		foreach($haystack as $element)
		{
		
			if(is_array($element) && search_array($needle, $element))
				return true;
		
		}
		
		return false;
	}// Fin function search_array()
	
	global $wpdb;

	$args = array( 'post_type' => 'rms_room' );
		
	$rooms_array = new WP_Query( $args );

	$strOutput = "";
	
	// Parcourir les chambres
	while ( $rooms_array -> have_posts() )
	{	
		$blnTest = false;
		$startDate = strtotime('20140101');
		$endDate = strtotime('next year', time());
		$arrReservation = array();
		$arrReservationWithConflict = array();
		
		$rooms_array -> the_post();
			
		$resOnRoom = $wpdb -> get_results('SELECT * FROM ' . $wpdb->postmeta . ' WHERE meta_value LIKE \'%a:1:{i:0;s:3:"' . get_the_ID() . '";}%\' AND meta_key = \'rms_reservation_room\'');
		
		$i = 0;
		$j = 0;
		
		// Parcourir les réservations
		foreach ( $resOnRoom as $resData )
		{
		
			$hasConflict = get_post_meta(  $resData -> post_id, 'has_conflict', true );
			if($hasConflict == "")
				$hasConflict = false;
			
			$gotConflict = get_post_meta(  $resData -> post_id, 'got_conflict', true );
			if($gotConflict == "")
				$gotConflict = false;
		
			if ( !$hasConflict  )
			{
				array_push( $arrReservation, $i );
				
				$localPost = get_post( $resData -> post_id );
				
				$room_client = get_post_meta(  $resData -> post_id, 'rms_reservation_client', true );
				
				
				$arrReservation[$i] = array(
					get_field('rms_reservation_start', $resData -> post_id),
					get_field('rms_reservation_end', $resData -> post_id),
					get_user_meta( $room_client, 'first_name', true ) . ' ' . get_user_meta( $room_client, 'last_name', true ),
					$resData -> post_id
				);
				
				$i++;
			}
			else { // sinon il s'agit d'un conflit qu'on stock pour être 
				
				$arrReservationWithConflict[] = array (
					"date_start" 		=> get_field('rms_reservation_start', $resData -> post_id),
					"date_end" 			=> get_field('rms_reservation_end', $resData -> post_id),
					"date_clientName" 	=> get_user_meta( $room_client, 'first_name', true ) . ' ' . get_user_meta( $room_client, 'last_name', true ),
					"post_id" 			=> $resData -> post_id
				);
				
				
			}
			
		}// Fin foreach( $resOnRoom as $resData )
		
		// Crée de nouvelles réservations sur celles en conflits
		$arrayReservationFromConflict = array();
		$currentConflictStart = "";
		$currentConflitEnd = "";
		foreach($arrReservationWithConflict as $conflict){
		
			// on regarde si on peut mettre le conflit dans une "réservation en conflit"
			$isPlacedInArrayFromConflict = false;
			foreach($arrayReservationFromConflict as  $key => $tmpConflict) {
				
				// si le conflit possède des dates à l'intérieur du conflit déjà mis en array,
				// si date début dans l'intervale || ou si date de fin dans l'intervale				
				if( ($conflict["date_start"] >= $tmpConflict[0] && $conflict["date_start"] <= $tmpConflict[1]) || ($conflict["date_end"] >= $tmpConflict[0] && $conflict["date_end"] <= $tmpConflict[1] ) ) {
					// Elargis les dates de la "réservation en conflit" avec ce conflit
					$newDateDebut = $tmpConflict[0];
					if ( $conflict["date_start"] <= $newDateDebut) {
						$newDateDebut = $conflict["date_start"];
					}
					
					$newDateFin = $tmpConflict[1];
					if ( $conflict["date_end"] >= $newDateFin) {
						$newDateFin = $conflict["date_end"];
					}
					
					// met à jour la réservation avec les dates élargies
					$arrayReservationFromConflict[$key][0] = $newDateDebut;
					$arrayReservationFromConflict[$key][1] = $newDateFin;
					
					// indique qu'un  conflit a été placé dans une "réservation en conflit"
					$isPlacedInArrayFromConflict = true;
					
				}// if
			
			}// foreach
			
			// si on n'a pas pu la placer dans l'array des réservation en conflit alors on fait une nouvelle entrée
			if ( ! $isPlacedInArrayFromConflict ) {
				
				$arrayReservationFromConflict[] = array(
					$conflict["date_start"],
					$conflict["date_end"],
					"CONFLITS DE DATES",
					$resData -> post_id
				);
			}// if
		} // foreach
		
		// ajoute les réservation en conflit 
		$arrReservation = array_merge ($arrReservation, $arrayReservationFromConflict);
		
		sort($arrReservation);
		
		$rms_room_stocked_meta = get_post_meta( get_the_ID() );
		
		$strOutput .= "{title: '" . __( 'Chambre N°', 'rms_reservation') . $rms_room_stocked_meta['rms_room_number'][0] . "',start: new Date(" . $startDate*1000 . "),";
		
		$blnStatement = 1;
		// Parcourir les dates
		while ( $startDate < $endDate )
		{
			// Vérifier date suivante a une réservation
			if( search_array(date('Ymd', strtotime('+1 day', $startDate)), $arrReservation) )
			{
				if( isset( $arrReservation[$j-1] ) )
					$status = get_post_meta( $arrReservation[$j-1][3], 'rms_reservation_status', true );
					
				if( isset( $arrReservation[$j] ) )
				$room_client = get_post_meta( $arrReservation[$j][3], 'rms_reservation_client', true );
				// Obtenir état réservation (ouvert/fermé)
				if(!$blnTest)
				{// Si réservation fermée
					
					if( $blnStatement != 3 )
						$strOutput .= "end: new Date(" . $startDate*1000 . "),url: './post.php?post=" . get_the_ID() . "&action=edit&lang=fr',backgroundColor: '#FDFDFD',borderColor: '#D8D8D8'},";
					
					$blnStatement = 2;
					
					// Différenciation entre conflit et non conflits
					if($arrReservation[$j][2] == "CONFLITS DE DATES") {
						$strOutput .= "{title: '" . __( 'Chambre N°', 'rms_reservation') . $rms_room_stocked_meta['rms_room_number'][0] . " - DATES EN CONFLITS" . "',start: new Date(" . strtotime('+1 day', $startDate)*1000 ."),";
						
					} else { // cas standard
						$strOutput .= "{title: '" . __( 'Chambre N°', 'rms_reservation') . $rms_room_stocked_meta['rms_room_number'][0] . " - " . get_user_meta( $room_client, 'first_name', true ) . ' ' . get_user_meta( $room_client, 'last_name', true ) . "',start: new Date(" . strtotime('+1 day', $startDate)*1000 ."),";
					}// else
					
					
					$j++;
					
				}
				else
				{// Si réservation ouverte

					// Définir couleur de la réservation
					$color = ( $status == 0 ) ? '#D5EAF2' : ( ( $status == 1 ) ? '#D0F3C5' : (( $status == 2 ) ? '#FCBDB1' : '#F8FA92'));
					
					// si conflit spécifié, alors on le met en jaune
					if($arrReservation[$j-1][2] == "CONFLITS DE DATES") 
						$color = '#F8FA92';
					
					$strOutput .= "end: new Date(" . strtotime('+1 day', $startDate)*1000 . "),url: './admin.php?page=rooms-reservation&view_res=" . $arrReservation[$j-1][3] . "',backgroundColor: '" . $color . "',borderColor: '#C2C2C2'},";
					
					if( search_array(date('Ymd', strtotime('+2 day', $startDate)), $arrReservation) )
					{
						$blnStatement = 3;
					}
					else
						$strOutput .= "{title: '" . __( 'Chambre N°', 'rms_reservation') . $rms_room_stocked_meta['rms_room_number'][0] . "',start: new Date(" . strtotime('+2 day', $startDate)*1000 . "),";
				
				}
				
				$blnTest = !$blnTest;
				
			}// Fin if( search_array(date('Ymd', strtotime('+1 day', $startDate)), $arrReservation) )
			
			$startDate = strtotime('+1 day', $startDate);
		}// Fin while ( $startDate < $endDate )
		
		$strOutput .= "end: new Date(" . $startDate*1000 . "),url: './post.php?post=" . get_the_ID() . "&action=edit&lang=fr',backgroundColor: '#FDFDFD',borderColor: '#D8D8D8'},";
		
	}// Fin while ( $rooms_array->have_posts() )
	

	$strOutput = substr_replace($strOutput ,"",-1);
?>
<style type="text/css" media="print">
  @page {
	size: landscape;
  }
  
</style>
<script>
	jQuery(document).ready(function($) {
		  w = $('#calendar').css('width');
		  h = $('#calendar').css('height');
		var beforePrint = function() {
			// prepare calendar for printing
			$('#calendar').css('width', '10.5in');
			$('#calendar').css('min-height', '1.1in');
			$('#calendar').fullCalendar('render');
		};
		var afterPrint = function() {
			$('#calendar').css('width', w);
			$('#calendar').css('height', h);
			$('#calendar').fullCalendar('render');
		};
		if (window.matchMedia) {
			var mediaQueryList = window.matchMedia('print');
			mediaQueryList.addListener(function(mql) {
				if (mql.matches) {
					beforePrint();
				} else {
					afterPrint();
				}
			});
		}
		window.onbeforeprint = beforePrint;
		window.onafterprint = afterPrint;
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			sortEvents: false,
			editable: false,
			events: [
				<?php
					echo $strOutput;
				?>
			]
		});
		
	});
</script>
	
<div class="wrap">

	<div class="calendar_wrapper">
	
		<h2>
			<?php _e( 'Planning des réservations' ); ?>
		</h2>
				
		<div class="calendarLegend">

			<div class="label">
			
				<div class="declined"></div> = <?php _e('Réservation refusée', 'rms_reservation'); ?>
				<div class="pending"></div> = <?php _e('Réservation en attente', 'rms_reservation'); ?>
			<div class="date_conflict"></div> = <?php _e('Conflit de dates', 'rms_reservation'); ?>
				<div class="allowed"></div> = <?php _e('Réservation acceptée', 'rms_reservation'); ?>
				
			</div>
		</div>

		<div id="calendar"></div>

		<div class="calendarLegend">

			<div class="label">
			
				<div class="declined"></div> = <?php _e('Réservation refusée', 'rms_reservation'); ?>
				<div class="pending"></div> = <?php _e('Réservation en attente', 'rms_reservation'); ?>
			<div class="date_conflict"></div> = <?php _e('Conflit de dates', 'rms_reservation'); ?>
				<div class="allowed"></div> = <?php _e('Réservation acceptée', 'rms_reservation'); ?>
				
			</div>

		</div>
		
	</div>
	
</div>
