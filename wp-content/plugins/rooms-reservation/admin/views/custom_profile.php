<?php

	global $profileuser;
	$user_id = $profileuser -> ID;
	
	$user_info = get_userdata( $post_author_id );
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
					
				if( ($actualGroup == "General" ) || ($actualGroup == "Contact" )  || ($actualGroup == "Etudes" ) )
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
						
					echo '<tr>';
						echo '<th scope="row">' . $data[0] . '</th>';
					
						echo '<td>';
						
							//echo $data[1];
							// Verifier si fichier
							if($data[3] == "textarea")
							{
								// Afficher lien
								echo '<textarea name="' . $data[2] . '" cols=5 rows=6>' . $arrDemoUserData[$i] . '</textarea>';
							}
							elseif($data[3] == "radio")
							{
								echo '<label><input type="radio" name="test" value="0" checked>Male</label> <label><input type="radio" name="test" value="1">Female</label>';
							}
							else
							{
								// Sinon afficher donnees
								echo '<input id="' . $data[2] . '" name="' . $data[2] . '" type="' . $data[3] . '" value="' . $arrDemoUserData[$i] . '" class="regular-text"/>';
							}// Fin if($data[2] == "file")
							
						echo '</td>';
					echo '</tr>';
				}
				
				$tmpGroup = $data[1];
				$i++;
			}
		?>
		</tbody>
	</table>
	
	<?php
	// Nettoyer les champs inutiles
	echo "<script>jQuery(document).ready(function(){
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
		
		});
	</script>";
?>