<?php

	global $profileuser;
	$user_id = $profileuser -> ID;
	
	//$user_info = get_userdata( $post_author_id );
	// Afficher les customs fields
	$arrUserFields = user_custom_fields();
	
	$arrDemoUserData = array(
		get_user_meta( $user_id, 'civil', true ),
		get_user_meta( $user_id, 'first_name', true ),
		get_user_meta( $user_id, 'last_name', true ),
		get_user_meta( $user_id, 'birthday', true ),
		get_user_meta( $user_id, 'nationality', true ),
		$profileuser -> user_email,
		get_user_meta( $user_id, 'street', true ), 
		get_user_meta( $user_id, 'number', true ),
		get_user_meta( $user_id, 'postal', true ),
		get_user_meta( $user_id, 'city', true ),
		get_user_meta( $user_id, 'country', true ),
		get_user_meta( $user_id, 'iso', true ),
		get_user_meta( $user_id, 'phone_1', true ),
		get_user_meta( $user_id, 'phone_2', true ),
		get_user_meta( $user_id, 'university_title', true ),
		get_user_meta( $user_id, 'affiliation', true ),
		get_user_meta( $user_id, 'function', true ),
		get_user_meta( $user_id, 'theme', true ),
		get_user_meta( $user_id, 'regime', true ),
		get_user_meta( $user_id, 'remarks', true ),
		get_user_meta( $user_id, 'fact_street', true ),
		get_user_meta( $user_id, 'fact_number', true ),
		get_user_meta( $user_id, 'fact_city', true ),
		get_user_meta( $user_id, 'fact_postal', true ),
		get_user_meta( $user_id, 'fact_country', true ),
		get_user_meta( $user_id, 'fact_iso', true ),
		get_user_meta( $user_id, 'fact_phone_1', true ),
		get_user_meta( $user_id, 'fact_phone_2', true ),
		get_user_meta( $user_id, 'fact_email', true )
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
							if($data[2] == 'fact_street')
							{
								
								echo '<label><input type="checkbox" name="is_same_fact" class="show_fact" checked>L\'adresse de facturation est identique à celle de contact</label></td></th></tr>';
								echo '<tr>';
						echo '<th scope="row">' . $data[0] . '</th>';
					
						echo '<td>';
							}
							// test le type de champ
							switch($data[3]) {
								case "textarea" :
									// Afficher lien
									echo '<textarea name="' . $data[2] . '" cols=5 rows=6>' . $arrDemoUserData[$i] . '</textarea>';
									break;
								case "country_select" :
									echo '
									<select name="' . $data[2] . '">
										<option data-iso-value="ch">Switzerland</option>
										<option data-iso-value="gb">United Kingdom</option>
										<option data-iso-value="af">Afghanistan</option>
										<option data-iso-value="ax">Åland Islands</option>
										<option data-iso-value="al">Albania</option>
										<option data-iso-value="dz">Algeria</option>
										<option data-iso-value="as">American Samoa</option>
										<option data-iso-value="ad">Andorra</option>
										<option data-iso-value="ao">Angola</option>
										<option data-iso-value="ai">Anguilla</option>
										<option data-iso-value="aq">Antarctica</option>
										<option data-iso-value="ag">Antigua and Barbuda</option>
										<option data-iso-value="ar">Argentina</option>
										<option data-iso-value="am">Armenia</option>
										<option data-iso-value="aw">Aruba</option>
										<option data-iso-value="au">Australia</option>
										<option data-iso-value="at">Austria</option>
										<option data-iso-value="az">Azerbaijan</option>
										<option data-iso-value="bs">Bahamas</option>
										<option data-iso-value="bh">Bahrain</option>
										<option data-iso-value="bd">Bangladesh</option>
										<option data-iso-value="bb">Barbados</option>
										<option data-iso-value="by">Belarus</option>
										<option data-iso-value="be">Belgium</option>
										<option data-iso-value="bz">Belize</option>
										<option data-iso-value="bj">Benin</option>
										<option data-iso-value="bm">Bermuda</option>
										<option data-iso-value="bt">Bhutan</option>
										<option data-iso-value="bo">Bolivia</option>
										<option data-iso-value="ba">Bosnia and Herzegovina</option>
										<option data-iso-value="bw">Botswana</option>
										<option data-iso-value="bv">Bouvet Island</option>
										<option data-iso-value="br">Brazil</option>
										<option data-iso-value="io">British Indian Ocean Territory</option>
										<option data-iso-value="bn">Brunei Darussalam</option>
										<option data-iso-value="bg">Bulgaria</option>
										<option data-iso-value="bf">Burkina Faso</option>
										<option data-iso-value="bi">Burundi</option>
										<option data-iso-value="kh">Cambodia</option>
										<option data-iso-value="cm">Cameroon</option>
										<option data-iso-value="ca">Canada</option>
										<option data-iso-value="cv">Cape Verde</option>
										<option data-iso-value="ky">Cayman Islands</option>
										<option data-iso-value="cf">Central African Republic</option>
										<option data-iso-value="td">Chad</option>
										<option data-iso-value="cl">Chile</option>
										<option data-iso-value="cn">China</option>
										<option data-iso-value="cx">Christmas Island</option>
										<option data-iso-value="cc">Cocos (Keeling) Islands</option>
										<option data-iso-value="co">Colombia</option>
										<option data-iso-value="km">Comoros</option>
										<option data-iso-value="cg">Congo</option>
										<option data-iso-value="cd">Congo, The Democratic Republic of The</option>
										<option data-iso-value="ck">Cook Islands</option>
										<option data-iso-value="cr">Costa Rica</option>
										<option data-iso-value="ci">Cote D\'ivoire</option>
										<option data-iso-value="hr">Croatia</option>
										<option data-iso-value="cu">Cuba</option>
										<option data-iso-value="cy">Cyprus</option>
										<option data-iso-value="cz">Czech Republic</option>
										<option data-iso-value="dk">Denmark</option>
										<option data-iso-value="dj">Djibouti</option>
										<option data-iso-value="dm">Dominica</option>
										<option data-iso-value="do">Dominican Republic</option>
										<option data-iso-value="ec">Ecuador</option>
										<option data-iso-value="eg">Egypt</option>
										<option data-iso-value="sv">El Salvador</option>
										<option data-iso-value="gq">Equatorial Guinea</option>
										<option data-iso-value="er">Eritrea</option>
										<option data-iso-value="ee">Estonia</option>
										<option data-iso-value="et">Ethiopia</option>
										<option data-iso-value="fk">Falkland Islands (Malvinas)</option>
										<option data-iso-value="fo">Faroe Islands</option>
										<option data-iso-value="fj">Fiji</option>
										<option data-iso-value="fi">Finland</option>
										<option data-iso-value="fr">France</option>
										<option data-iso-value="gf">French Guiana</option>
										<option data-iso-value="pf">French Polynesia</option>
										<option data-iso-value="tf">French Southern Territories</option>
										<option data-iso-value="ga">Gabon</option>
										<option data-iso-value="gm">Gambia</option>
										<option data-iso-value="ge">Georgia</option>
										<option data-iso-value="de">Germany</option>
										<option data-iso-value="gh">Ghana</option>
										<option data-iso-value="gi">Gibraltar</option>
										<option data-iso-value="gr">Greece</option>
										<option data-iso-value="gl">Greenland</option>
										<option data-iso-value="gd">Grenada</option>
										<option data-iso-value="gp">Guadeloupe</option>
										<option data-iso-value="gu">Guam</option>
										<option data-iso-value="gt">Guatemala</option>
										<option data-iso-value="gg">Guernsey</option>
										<option data-iso-value="gn">Guinea</option>
										<option data-iso-value="gw">Guinea-bissau</option>
										<option data-iso-value="gy">Guyana</option>
										<option data-iso-value="ht">Haiti</option>
										<option data-iso-value="hm">Heard Island and Mcdonald Islands</option>
										<option data-iso-value="va">Holy See (Vatican City State)</option>
										<option data-iso-value="hn">Honduras</option>
										<option data-iso-value="hk">Hong Kong</option>
										<option data-iso-value="hu">Hungary</option>
										<option data-iso-value="is">Iceland</option>
										<option data-iso-value="in">India</option>
										<option data-iso-value="id">Indonesia</option>
										<option data-iso-value="ir">Iran, Islamic Republic of</option>
										<option data-iso-value="iq">Iraq</option>
										<option data-iso-value="ie">Ireland</option>
										<option data-iso-value="im">Isle of Man</option>
										<option data-iso-value="il">Israel</option>
										<option data-iso-value="it">Italy</option>
										<option data-iso-value="jm">Jamaica</option>
										<option data-iso-value="jp">Japan</option>
										<option data-iso-value="je">Jersey</option>
										<option data-iso-value="jo">Jordan</option>
										<option data-iso-value="kz">Kazakhstan</option>
										<option data-iso-value="ke">Kenya</option>
										<option data-iso-value="ki">Kiribati</option>
										<option data-iso-value="kp">Korea, Democratic People\'s Republic of</option>
										<option data-iso-value="kr">Korea, Republic of</option>
										<option data-iso-value="kw">Kuwait</option>
										<option data-iso-value="kg">Kyrgyzstan</option>
										<option data-iso-value="la">Lao People\'s Democratic Republic</option>
										<option data-iso-value="lv">Latvia</option>
										<option data-iso-value="lb">Lebanon</option>
										<option data-iso-value="ls">Lesotho</option>
										<option data-iso-value="lr">Liberia</option>
										<option data-iso-value="ly">Libyan Arab Jamahiriya</option>
										<option data-iso-value="li">Liechtenstein</option>
										<option data-iso-value="lt">Lithuania</option>
										<option data-iso-value="lu">Luxembourg</option>
										<option data-iso-value="mo">Macao</option>
										<option data-iso-value="mk">Macedonia, The Former Yugoslav Republic of</option>
										<option data-iso-value="mg">Madagascar</option>
										<option data-iso-value="mw">Malawi</option>
										<option data-iso-value="my">Malaysia</option>
										<option data-iso-value="mv">Maldives</option>
										<option data-iso-value="ml">Mali</option>
										<option data-iso-value="mt">Malta</option>
										<option data-iso-value="mh">Marshall Islands</option>
										<option data-iso-value="mq">Martinique</option>
										<option data-iso-value="mr">Mauritania</option>
										<option data-iso-value="mu">Mauritius</option>
										<option data-iso-value="yt">Mayotte</option>
										<option data-iso-value="mx">Mexico</option>
										<option data-iso-value="fm">Micronesia, Federated States of</option>
										<option data-iso-value="md">Moldova, Republic of</option>
										<option data-iso-value="mc">Monaco</option>
										<option data-iso-value="mn">Mongolia</option>
										<option data-iso-value="me">Montenegro</option>
										<option data-iso-value="ms">Montserrat</option>
										<option data-iso-value="ma">Morocco</option>
										<option data-iso-value="mz">Mozambique</option>
										<option data-iso-value="mm">Myanmar</option>
										<option data-iso-value="na">Namibia</option>
										<option data-iso-value="nr">Nauru</option>
										<option data-iso-value="np">Nepal</option>
										<option data-iso-value="nl">Netherlands</option>
										<option data-iso-value="an">Netherlands Antilles</option>
										<option data-iso-value="nc">New Caledonia</option>
										<option data-iso-value="nz">New Zealand</option>
										<option data-iso-value="ni">Nicaragua</option>
										<option data-iso-value="ne">Niger</option>
										<option data-iso-value="ng">Nigeria</option>
										<option data-iso-value="nu">Niue</option>
										<option data-iso-value="nf">Norfolk Island</option>
										<option data-iso-value="mp">Northern Mariana Islands</option>
										<option data-iso-value="no">Norway</option>
										<option data-iso-value="om">Oman</option>
										<option data-iso-value="pk">Pakistan</option>
										<option data-iso-value="pw">Palau</option>
										<option data-iso-value="ps">Palestinian Territory, Occupied</option>
										<option data-iso-value="pa">Panama</option>
										<option data-iso-value="pg">Papua New Guinea</option>
										<option data-iso-value="py">Paraguay</option>
										<option data-iso-value="pe">Peru</option>
										<option data-iso-value="ph">Philippines</option>
										<option data-iso-value="pn">Pitcairn</option>
										<option data-iso-value="pl">Poland</option>
										<option data-iso-value="pt">Portugal</option>
										<option data-iso-value="pr">Puerto Rico</option>
										<option data-iso-value="qa">Qatar</option>
										<option data-iso-value="re">Reunion</option>
										<option data-iso-value="ro">Romania</option>
										<option data-iso-value="ru">Russian Federation</option>
										<option data-iso-value="rw">Rwanda</option>
										<option data-iso-value="sh">Saint Helena</option>
										<option data-iso-value="kn">Saint Kitts and Nevis</option>
										<option data-iso-value="lc">Saint Lucia</option>
										<option data-iso-value="pm">Saint Pierre and Miquelon</option>
										<option data-iso-value="vc">Saint Vincent and The Grenadines</option>
										<option data-iso-value="ws">Samoa</option>
										<option data-iso-value="sm">San Marino</option>
										<option data-iso-value="st">Sao Tome and Principe</option>
										<option data-iso-value="sa">Saudi Arabia</option>
										<option data-iso-value="sn">Senegal</option>
										<option data-iso-value="rs">Serbia</option>
										<option data-iso-value="sc">Seychelles</option>
										<option data-iso-value="sl">Sierra Leone</option>
										<option data-iso-value="sg">Singapore</option>
										<option data-iso-value="sk">Slovakia</option>
										<option data-iso-value="si">Slovenia</option>
										<option data-iso-value="sb">Solomon Islands</option>
										<option data-iso-value="so">Somalia</option>
										<option data-iso-value="za">South Africa</option>
										<option data-iso-value="gs">South Georgia and The South Sandwich Islands</option>
										<option data-iso-value="es">Spain</option>
										<option data-iso-value="lk">Sri Lanka</option>
										<option data-iso-value="sd">Sudan</option>
										<option data-iso-value="sr">Suriname</option>
										<option data-iso-value="sj">Svalbard and Jan Mayen</option>
										<option data-iso-value="sz">Swaziland</option>
										<option data-iso-value="se">Sweden</option>
										<option data-iso-value="sy">Syrian Arab Republic</option>
										<option data-iso-value="tw">Taiwan, Province of China</option>
										<option data-iso-value="tj">Tajikistan</option>
										<option data-iso-value="tz">Tanzania, United Republic of</option>
										<option data-iso-value="th">Thailand</option>
										<option data-iso-value="tl">Timor-leste</option>
										<option data-iso-value="tg">Togo</option>
										<option data-iso-value="tk">Tokelau</option>
										<option data-iso-value="to">Tonga</option>
										<option data-iso-value="tt">Trinidad and Tobago</option>
										<option data-iso-value="tn">Tunisia</option>
										<option data-iso-value="tr">Turkey</option>
										<option data-iso-value="tm">Turkmenistan</option>
										<option data-iso-value="tc">Turks and Caicos Islands</option>
										<option data-iso-value="tv">Tuvalu</option>
										<option data-iso-value="ug">Uganda</option>
										<option data-iso-value="ua">Ukraine</option>
										<option data-iso-value="ae">United Arab Emirates</option>
										<option data-iso-value="us">United States</option>
										<option data-iso-value="um">United States Minor Outlying Islands</option>
										<option data-iso-value="uy">Uruguay</option>
										<option data-iso-value="uz">Uzbekistan</option>
										<option data-iso-value="vu">Vanuatu</option>
										<option data-iso-value="ve">Venezuela</option>
										<option data-iso-value="vn">Viet Nam</option>
										<option data-iso-value="vg">Virgin Islands, British</option>
										<option data-iso-value="vi">Virgin Islands, U.S.</option>
										<option data-iso-value="wf">Wallis and Futuna</option>
										<option data-iso-value="eh">Western Sahara</option>
										<option data-iso-value="ye">Yemen</option>
										<option data-iso-value="zm">Zambia</option>
										<option data-iso-value="zw">Zimbabwe</option>
									</select>';
								break;
								case "civil_select":
									echo'<select name="' . $data[2] . '">
										<option value="Monsieur"' . ( ($arrDemoUserData[$i] == "Monsieur") || ($arrDemoUserData[$i] == "M") ? ' selected' : '') . '>Monsieur</option>
										<option value="Madame"' . ( ($arrDemoUserData[$i] == "Madame") || ($arrDemoUserData[$i] == "F") ? ' selected' : '') . '>Madame</option>
										<option value="Mademoiselle"' . ( ($arrDemoUserData[$i] == "Mademoiselle") || ($arrDemoUserData[$i] == "O") ? ' selected' : '') . '>Mademoiselle</option>
									</select>';
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
										'.$documentName.'
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
		
		// Sélectionner pays actif
		jQuery('select[name=country] option[data-iso-value="' + jQuery('input[name=iso]').val().toLowerCase() + '"]').attr("selected","selected");
		
		// Liste déroulante des pays
		jQuery('select[name=country]').change(function()
		{
		
			jQuery('input[name=iso]').val(jQuery(this).find(":selected").attr('data-iso-value').toUpperCase());
		});
		
		// Sélectionner pays de facturation actif
		jQuery('select[name=fact_country] option[data-iso-value="' + jQuery('input[name=fact_iso]').val().toLowerCase() + '"]').attr("selected","selected");
		
		// Liste déroulante des pays
		jQuery('select[name=fact_country]').change(function()
		{
			jQuery('input[name=fact_iso]').val(jQuery(this).find(":selected").attr('data-iso-value').toUpperCase());
		});
		
		jQuery('.show_fact').parent().parent().parent().find('th').text('Adresse de facturation');
		
		// Masquer champs de facturation, par défaut
		<?php
		
			if( get_user_meta( $user_id, 'fact_street', true ) != "")
				echo 'jQuery(".show_fact").removeAttr("checked");';
			else
				echo
				'jQuery( "*[name^=\'fact_\']" ).parent().parent().hide();';
		?>
		
		// Action lors du changement de checkbox show_fact
		jQuery('.show_fact').on('click', function(){
		
			jQuery( "*[name^='fact_']" ).parent().parent().toggle();
			
		});
		
		// Remplir par défaut les 2 champs iso
		jQuery("#iso").val(jQuery('select[name=country]').find(":selected").attr('data-iso-value').toUpperCase());
		jQuery("#fact_iso").val(jQuery('select[name=fact_country]').find(":selected").attr('data-iso-value').toUpperCase());
		
	});
	</script>