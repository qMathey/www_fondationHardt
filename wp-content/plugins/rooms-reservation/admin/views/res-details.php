<?php
	// Vue du détail des réservations
	$userFieldsData = user_custom_fields();
	
	$reservationData = reservation_custom_fields();
	
	if( get_post_meta($_GET['view_res'], 'rms_reservation_client', true) )
	{
		$post_author_id = get_post_meta( $_GET['view_res'], 'rms_reservation_client', true );
	}
	else
	{
		$post_author_id = get_post_field( 'post_author', $_GET['view_res'] );
	}
	
	$user_info = get_userdata( $post_author_id );
	
	// Récupérer les séjours du même hôte
	$args = array(
		'post__not_in'  =>  array($_GET['view_res']),
		'author'        =>  $post_author_id,
		'post_type'     =>  'rms_reservation',
		'orderby'       =>  'post_date',
		'order'         =>  'ASC'
    );
	
	$the_query = new WP_Query( $args );
	
	if ( $the_query->have_posts() )
	{
	
		$prev_stay_output = '';
		
		while ( $the_query->have_posts() )
		{
		
			$the_query->the_post();
			$prev_stay_output .= '<a href="./admin.php?page=rooms-reservation&view_res=' . get_the_ID() . '" target="_blank" title="Voir le détail">Séjour N°' . get_the_title() . '</a><br/>';
		
		}

	}
	else
	{
	
		$prev_stay_output = "Aucun";
	
	}
	
	// Donnees fictives pour demo
	$arrUserData = array(
		get_user_meta( $post_author_id, 'first_name', true ),
		get_user_meta( $post_author_id, 'last_name', true ),
		get_user_meta( $post_author_id, 'birthday', true ),
		get_user_meta( $post_author_id, 'sex', true ),
		get_user_meta( $post_author_id, 'regime', true ),
		get_user_meta( $post_author_id, 'remarks', true ),
		get_user_meta( $post_author_id, 'nationality', true ),
		$user_info -> user_email,
		get_user_meta( $post_author_id, 'street', true ),
		get_user_meta( $post_author_id, 'number', true ),
		get_user_meta( $post_author_id, 'postal', true ),
		get_user_meta( $post_author_id, 'city', true ),
		get_user_meta( $post_author_id, 'iso', true ),
		get_user_meta( $post_author_id, 'phone_1', true ),
		get_user_meta( $post_author_id, 'phone_2', true ),
		get_user_meta( $post_author_id, 'university_title', true ),
		get_user_meta( $post_author_id, 'affiliation', true ),
		get_user_meta( $post_author_id, 'function', true ),
		get_user_meta( $post_author_id, 'references', true ),
		get_user_meta( $post_author_id, 'theme', true )
	);
	
	$reservationData = reservation_custom_fields();
	
	$user_doc_list = explode('|', get_option(get_user_meta ( $post_author_id, 'user_uid',true)));
	
	$strDocsListOutput = '<ul style="width:200%;">';
	$i = 0;
	
	if( $user_doc_list )
		foreach($user_doc_list  as $data)
		{
			
			if( $data )
			{
			
				$i++;
				$strDocsListOutput .= '<li><a href="' . $data . '" target="blank">' . __( 'Voir le document', 'rms_reservation') . ' N°' . $i . '</a></li>';
			
			}
			
		}// Fin foreach
		
	$strDocsListOutput .= "</ul>";
		
	
	// Requête sur la réservation
	$res_query = new WP_Query(array(
		'p' => $_GET['view_res'],
		'post_type' => 'rms_reservation',
		)
	);
	
	while ($res_query->have_posts())
	{
		$res_query->the_post();
		
		$roomArrayId = get_field('rms_reservation_room');

		$roomData = get_post($roomArrayId[0]);
		
		$scolarship = get_field('has_bourse');
		
		// Obetnir l'adresse mail de facturation
		if( get_user_meta( $post_author_id, 'fact_email', true ) )
		{
			$fact_email = get_user_meta( $post_author_id, 'fact_email', true );
		}
		else
		{
			$fact_email = $user_info -> user_email;
		}
		
		$arrResData = array(
			get_the_title(),
			date( "d.m.Y", strtotime( get_field('rms_reservation_start') ) ),
			date( "d.m.Y", strtotime( get_field('rms_reservation_end') ) ),
			$roomData -> post_title,
			$scolarship[0],
			get_user_meta( $post_author_id, 'fact_email', true ),
			get_user_meta( $post_author_id, 'fact_street', true ),
			get_user_meta( $post_author_id, 'fact_number', true ),
			get_user_meta( $post_author_id, 'fact_city', true ),
			get_user_meta( $post_author_id, 'fact_postal', true ),
			get_user_meta( $post_author_id, 'fact_iso', true ),
			get_user_meta( $post_author_id, 'fact_phone_1', true ),
			get_user_meta( $post_author_id, 'fact_phone_2', true )
		);
	
?>

		<div class="wrap">

			<h2>
				<?php echo __("Détail de la réservation N°", "rms_reservation") . " " . get_the_title(); ?>
				<a href="<?php echo get_edit_post_link(get_the_ID()); ?>" class="add-new-h2"><?php _e("Editer la réservation", "rms_reservation"); ?></a>
			</h2>
			
			<div class="res_details">
				<div class="right_col">
					<h2><?php _e("Informations concernant le séjour", "rms_reservation"); ?></h2>
					<table class="form-table">
						<tbody>
							<?php
								$tmpGroup = "";
								$i = 0;
							$blnFactShowed = false;
									$j = 0;
								// Parcourir les informations concernant l'hôte
								foreach($reservationData  as $data)
								{
									$actualGroup = $data[1];
									
									// Afficher titre si groupe different
									if($tmpGroup != $actualGroup)
									{
										echo '<tr>
													<th scope="row">
														<h3>' . $data[1] . '</h3>
													</th>
													<td></td>
												</tr>';
												
												if($data[1] == "Documents")
													echo '<td style="margin:0;padding:0;display:inline";>'. $strDocsListOutput . '</td>';
												
									}// Fin if()
									
									if( ( $arrResData[$i] == "") && ($data[1] == "Facturation") )
									{
									
										echo "<tr class=\"fact_empty_data\"><th>" . $data[0] . ":</th><td></td></tr>";
											
									}
									else
									{
										if($data[1] != "Documents")
										{
											echo '<tr>';
												echo '<th scope="row">' . $data[0] . '</th>';
											
												echo '<td>';
												
													//echo $data[1];
													// Verifier si fichier
													if($data[2] == "file")
													{
														// Afficher lien
														echo '<a href="#" target="_blank">' . __( 'Voir le document', 'rms_reservation') . ' <i>' . $arrResData[$i] . '</i></a>';
													}
													else
													{
														// Sinon afficher donnees
														echo $arrResData[$i];
													}// Fin if($data[2] == "file")
													
												echo '</td>';
											echo '</tr>';
										}
									}
									
									$tmpGroup = $data[1];
									$i++;
								}// Fin foreach
								?>
						</tbody>
					</table>
				</div>
				
				<div class="left_col">
					<h2><?php _e("Information concernant l'hôte", "rms_reservation"); ?></h2>
					<table class="form-table">
						<tbody>
							<?php
								$tmpGroup = "";
								$i = 0;
								
								// Parcourir les informations concernant l'hôte
								foreach($userFieldsData  as $data)
								{
									$actualGroup = $data[1];
									
									// Afficher titre si groupe different
									if($tmpGroup != $actualGroup)
									{
										echo '<tr>
													<th scope="row">
														<h3>' . $data[1] . '</h3>
													</th>
													<td></td>
												</tr>';
									}// Fin if()
										
									echo '<tr>';
										echo '<th scope="row">' . $data[0] . '</th>';
									
										echo '<td>';
										
											//echo $data[1];
											echo $arrUserData[$i];
										echo '</td>';
									echo '</tr>';
									
									$tmpGroup = $data[1];
									$i ++;
								}// Fin foreach
								echo '<tr>';
										echo '<th scope="row">Séjours précédents</th>';
									
										echo '<td>';
										
											//echo $data[1];
											echo $prev_stay_output;
										echo '</td>';
									echo '</tr>';
								?>
							
						</tbody>
					</table>
				
							
				</div>
			</div>
		</div>
<?php
	} // end while()
?>
<script>
jQuery('tr:contains(General)').remove();
</script>