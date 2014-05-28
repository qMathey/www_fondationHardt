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
		
		$rooms_array -> the_post();
			
		$resOnRoom = $wpdb -> get_results('SELECT * FROM ' . $wpdb->postmeta . ' WHERE meta_value LIKE \'%a:1:{i:0;s:3:"' . get_the_ID() . '";}%\' AND meta_key = \'rms_reservation_room\'');
		
		$i = 0;
		$j = 0;
		
		// Parcourir les réservations
		foreach ( $resOnRoom as $resData )
		{
		
			if ( !get_post_meta(  $resData -> post_id, 'has_conflict', true ) )
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
			
		}// Fin foreach( $resOnRoom as $resData )
		
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
					
					
					$strOutput .= "{title: '" . __( 'Chambre N°', 'rms_reservation') . $rms_room_stocked_meta['rms_room_number'][0] . " - " . get_user_meta( $room_client, 'first_name', true ) . ' ' . get_user_meta( $room_client, 'last_name', true ) . "',start: new Date(" . strtotime('+1 day', $startDate)*1000 ."),";
					
					$j++;
					
				}
				else
				{// Si réservation ouverte

					// Définir couleur de la réservation
					$color = ( $status == 0 ) ? '#D5EAF2' : ( ( $status == 1 ) ? '#D0F3C5' : '#FCBDB1');
					
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
				<div class="allowed"></div> = <?php _e('Réservation acceptée', 'rms_reservation'); ?>
				<div class="pending"></div> = <?php _e('Réservation en attente', 'rms_reservation'); ?>
				
			</div>
		</div>

		<div id="calendar"></div>

		<div class="calendarLegend">

			<div class="label">
			
				<div class="declined"></div> = <?php _e('Réservation refusée', 'rms_reservation'); ?>
				<div class="allowed"></div> = <?php _e('Réservation acceptée', 'rms_reservation'); ?>
				<div class="pending"></div> = <?php _e('Réservation en attente', 'rms_reservation'); ?>
				
			</div>

		</div>
		
	</div>
	
</div>
