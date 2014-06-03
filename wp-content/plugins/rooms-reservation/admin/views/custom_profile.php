<?php

	global $profileuser;
	$user_id = $profileuser -> ID;
	
	//$user_info = get_userdata( $post_author_id );
	// Afficher les customs fields
	$arrUserFields = user_custom_fields();
	
	$arrDemoUserData = array(
		get_user_meta( $user_id, 'first_name', true ),
		get_user_meta( $user_id, 'last_name', true ),
		get_user_meta( $user_id, 'birthday', true ),
		get_user_meta( $user_id, 'sex', true ),
		get_user_meta( $user_id, 'nationality', true ),
		$profileuser -> user_email,
		get_user_meta( $user_id, 'street', true ), 
		get_user_meta( $user_id, 'number', true ),
		get_user_meta( $user_id, 'postal', true ),
		get_user_meta( $user_id, 'city', true ),
		get_user_meta( $user_id, 'iso', true ),
		get_user_meta( $user_id, 'phone_1', true ),
		get_user_meta( $user_id, 'phone_2', true ),
		get_user_meta( $user_id, 'university_title', true ),
		get_user_meta( $user_id, 'affiliation', true ),
		get_user_meta( $user_id, 'function', true ),
		get_user_meta( $user_id, 'references', true ),
		get_user_meta( $user_id, 'theme', true ),
		get_user_meta( $user_id, 'regime', true )
	);
	?>
	<table class="form-table">
		<tbody>
		<?php
		
			$i = 0;
			
			// Parcourir les champs
			foreach ($arrUserFields as $data)
			{
				$actualGroup = $data[1];
				$arrayGroup = array(
						"general",
						"général",
						"contact",
						"etudes",
						"études"
				);
				/* Abondonné !
				// s'il s'agit d'un nouveau titre
				if( in_array( strtolower( $actualGroup ) , $arrayGroup) )
				{
				
					// Afficher titre si groupe different
					if($tmpGroup != $actualGroup)
					{
						echo '<tr>
									<th scope="row">
										<h4><u>' . $data[1] . '</u></h4>
									</th>
									<td></td>
								</tr>';
					}// Fin if()
					*/	
					echo '<tr>';
						echo '<th scope="row">' . $data[0] . '</th>';
					
						echo '<td>';
							// test le type de champ
							switch($data[3]) {
								case "textarea" :
									// Afficher lien
									echo '<textarea name="' . $data[2] . '" cols=5 rows=6>' . $arrDemoUserData[$i] . '</textarea>';
									break;
								case "radio" :
									echo '<label><input type="radio" name="sex" value="0" checked>Male</label> <label><input type="radio" name="sex" value="1">Female</label>';
									break;
								default :
									// Sinon afficher donnees
									echo '<input id="' . $data[2] . '" name="' . $data[2] . '" type="' . $data[3] . '" value="' . $arrDemoUserData[$i] . '" class="regular-text"/>';
									break;
							}
							
							
						echo '</td>';
					echo '</tr>';
				/* Abondonné avec précédent
				}else {
					var_dump($data);
				}
				*/
				$tmpGroup = $data[1];
				$i++;
			}
			
		?>
		<tr>
			<th scope="row">Documents</th>
			<td>
				<input name="upload[]" type="file" multiple="multiple" />
				<div id="documentInfo">
					<?php
						// get all current documents
						$user_doc_list = explode('|', get_option(get_user_meta ( $user_id, 'user_uid',true)));
	
						echo '<ul>';
						$i = 0;
						
						// si l'utilisateur a des documents, alors on affiche une liste
						if( $user_doc_list )
							foreach($user_doc_list  as $data)
							{
								
								if( $data )
								{
									$documentName = explode('/', $data);
									$documentName = $documentName[count($documentName)-1];
									$i++;
									echo '<li>';
									echo '<div style="display:inline-block">
										<a href="' . $data . '" data-docName="'.$documentName.'" class="deleteDocument" style="color:red">Supprimer le document</a>
									</div>';
									echo '<div style="display:inline-block;padding:0px 15px">
											<a href="' . $data . '" target="blank">' . __( 'Voir le document', 'rms_reservation') . ' N&#176;' . $i . '</a>
										</div>';
									echo '<div style="display:inline-block">
										<a href="' . $data . '" target="blank">'.$documentName.'</a>
									</div>';
									echo '</li>';
								
								}
								
							}// Fin foreach
							
						echo "</ul>";
						
					?>
				</div>
			</td>
		</tr>
		</tbody>
	</table>
	
	<script>
	// on document ready 
	jQuery(document).ready(function(){
		// NETTOYAGE DE LA PAGE
		jQuery('#your-profile h3').remove();
		
		jQuery('#url').parents('tr').remove();
		
		jQuery('#first_name').parents('tr').remove();
		
		jQuery('#last_name').parents('tr').remove();
		
		jQuery('#email').parents('tr').remove();
		
		jQuery('form#your-profile table.form-table').first().remove();
		
		jQuery('#nickname').parents('tr').remove();
		
		jQuery('#display_name').parents('tr').remove();
		
		jQuery('#pass1').parents('table').remove();
		
		jQuery('#role').parents('tr').remove();
		
		jQuery('.form-table tbody tr').each(function() {
			var forAttr = jQuery(this).find('th').find('label').first().attr('for');
			if( forAttr == 'googleplus' )
				jQuery(this).remove();
			if( forAttr == 'twitter' )
				jQuery(this).remove();
			if( forAttr == 'facebook' )
				jQuery(this).remove();
			if( forAttr == 'wpseo_author_title' )
				jQuery(this).remove();
			if( forAttr == 'wpseo_author_metadesc' )
				jQuery(this).remove();
		});
		
		// add correct enctype to form
		jQuery("#your-profile").attr("enctype", "multipart/form-data");
		
		
		// ON DELETE DOCUMENT
		jQuery(".deleteDocument").on("click", function(event) {
			// supprime l'action du lien par défaut
			event.preventDefault();
			// l'utilisateur doit confirmer la suppression
			if(confirm('Suppression de '+jQuery(this).attr("data-docName")+" ?")){
				
				jQuery("#documentInfo").html('<div style="color:red"><br />Suppression...</div>');
				
				jQuery.post(ajaxurl, {
					action: "deleteDocument",
					url: jQuery(this).attr("href"),
					"user_id": "<?php echo $user_id; ?>"
				}, function(reponse) {
					// refresh la page (forcé)
					location.reload(true);
				});
				
				
			}// if
			
		});
		
	});
	</script>