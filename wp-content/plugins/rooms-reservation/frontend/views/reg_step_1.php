<?php
	/* Vue formulaire d'enregistrements: Etape 1 */
	global $current_user;
	get_currentuserinfo();
?>
<style>
	.page_content_wrap.width_30 {
		width: 70%;
	}
</style>

<div class="rms_wrapper step_1" data-wrapper_size="70">

	<form name="step_1" id="preview_form" class="rms_form" action="#" enctype="multipart/form-data" method="GET">
	
		<div class="left_col">
			
			<p><?php echo rms_translate("L'inscription de demande de séjour à la Fondation Hardt se déroule en 4 étapes, merci de compléter les champs suivants"); ?> :</p>
			<p class="rms_label_error rms_form_error_info"><?php echo rms_translate("Merci de compéter l'ensemble des champs correctement"); ?></p>
			<fieldset>
			
				<label for="civil"><?php echo rms_translate("Civilité"); ?></label>
				<select name="civil">
					<option value="">Choisissez</option>
					<option value="Dr">Docteur</option>
					<option value="Prof">Professeur</option>
					<option> - </option>
				</select>
				
				<label for="nom"><?php echo rms_translate("Nom"); ?></label>
				<input type="text" name="last_name" value="<?php echo get_user_meta( get_current_user_id(), 'last_name', true ); ?>">
				
				<label for="prenom"><?php echo rms_translate("Prénom"); ?></label>
				<input type="text" name="first_name" value="<?php echo get_user_meta( get_current_user_id(), 'first_name', true ); ?>">
				
				<div>
					<div style="width: 36%; margin-right: 49%; float: left;">	
						<label for="birthday"><span title="Format: dd/-.mm/-.yyyy"><?php echo rms_translate("Date de naissance"); ?></span></label>
						<input type="text" placeholder="ex: 15.08.1985" name="birthday" value="<?php echo get_user_meta( get_current_user_id(), 'birthday', true ); ?>" style="max-width:110px; min-width:110px;">
					</div>
					
					<div style="width: 15%; float: right;">
						<label for="sex"><?php echo rms_translate("Sexe"); ?></label>
						<select name="sex" style="min-width:85px; width:85px;">
							<option value="M"><?php echo rms_translate("Homme"); ?></option>
							<option value="F"><?php echo rms_translate("Femme"); ?></option>
							<option value="O"><?php echo rms_translate("Autre"); ?></option>
						</select>
					</div>
				</div>
				
				<div>
					<div style="width: 70%; margin-right: 30%; float: left;">	
						<label for="nationality"><?php echo rms_translate("Nationalité"); ?></label>
						<input type="text" name="nationality" value="<?php echo get_user_meta( get_current_user_id(), 'nationality', true ); ?>">
					</div>
				</div>
				
				<label for="university_title"><?php echo rms_translate("Titre(s) universitaire(s)"); ?></label>
				<input type="text" name="university_title" value="<?php echo get_user_meta( get_current_user_id(), 'university_title', true ); ?>">
				
				<label for="affiliation"><?php echo rms_translate("Affilitation institutionnelle"); ?></label>
				<input type="text" name="affiliation" value="<?php echo get_user_meta( get_current_user_id(), 'affiliation', true ); ?>">
				
				<label for="function"><?php echo rms_translate("Fonction actuelle"); ?></label>
				<input type="text" name="function" value="<?php echo get_user_meta( get_current_user_id(), 'function', true ); ?>">
				
				<label for="references"><?php echo rms_translate("Références"); ?></label>
				<textarea name="references" rows="5"><?php echo get_user_meta( get_current_user_id(), 'references', true ); ?></textarea>
				
				
				<div class="fileinputs">
					<input type="file" class="cv_file" style="width: 344px; height: 21px; ">
					
					<div class="fakefile cv_fake" style="line-height:30px;width: 80%;">
						Ajouter le CV
					</div>
				</div>
					
				<h3><?php echo rms_translate("Adresse de contact"); ?></h3>
				<div>
					<div style="width: 60%; margin-right: 10%; float: left;">
						<label for="street"><?php echo rms_translate("Rue"); ?></label>
						<input type="text" name="street" value="<?php echo get_user_meta( get_current_user_id(), 'street', true ); ?>">
					</div>
					<div style="width: 30%; float: right;">
						<label for="number"><?php echo rms_translate("N°"); ?></label>
						<input type="text" name="number" value="<?php echo get_user_meta( get_current_user_id(), 'number', true ); ?>" style="width: 70px;">
					</div>
				</div>
				
				<div>
					<div style="width: 60%; margin-right: 10%; float: left;">	
						<label for="city"><?php echo rms_translate("Ville"); ?></label>
						<input type="text" name="city" value="<?php echo get_user_meta( get_current_user_id(), 'city', true ); ?>">
					</div>
					<div style="width: 30%; float: right;">
						<label for="postal"><?php echo rms_translate("Code postal"); ?></label>
						<input type="text" name="postal" value="<?php echo get_user_meta( get_current_user_id(), 'postal', true ); ?>" style="width: 70px;">
					</div>
				</div>
				
				<div>
					<div style="width: 70%; margin-right: 20%; float: left;">	
						<label for="country"><?php echo rms_translate("Pays"); ?></label>
						<select name="country" style="width: 287px; margin: 0;">
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
							<option data-iso-value="ci">Cote D'ivoire</option>
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
							<option data-iso-value="kp">Korea, Democratic People's Republic of</option>
							<option data-iso-value="kr">Korea, Republic of</option>
							<option data-iso-value="kw">Kuwait</option>
							<option data-iso-value="kg">Kyrgyzstan</option>
							<option data-iso-value="la">Lao People's Democratic Republic</option>
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
						</select>
					</div>
					<div style="width: 10%; float: right;">
						<label for="iso">ISO</label>
						<input type="text" name="iso" value="<?php echo (get_user_meta( get_current_user_id(), 'iso', true ) ? get_user_meta( get_current_user_id(), 'iso', true ) : 'CH'); ?>" style="width: 20px;">
					</div>
				</div>
				
				<div>
					<div style="width: 45%; margin-right:10%; float: left; margin-top: 10px;">	
						<label for="phone_1"><?php echo rms_translate("Tél. 1"); ?></label>
						<input type="text" name="phone_1" value="<?php echo get_user_meta( get_current_user_id(), 'phone_1', true ); ?>">
					</div>
				</div>
				
				<div>
					<div style="width: 45%; float: right;">	
						<label for="phone_2"><?php echo rms_translate("Tél. 2"); ?></label>
						<input type="text" name="phone_2" class="not_required" value="<?php echo get_user_meta( get_current_user_id(), 'phone_2', true ); ?>">
					</div>
				</div>
				
				<div>
					<div style="width: 100%;float: left;">	
						<label for="email"><?php echo rms_translate("Email"); ?></label>
						<input type="text" name="email" value="<?php echo $current_user->user_email; ?>">
					</div>
				</div>
				
				<div style="clear:both;"></div>
				
				<h3><?php echo rms_translate("Adresse de facturation"); ?></h3>
				
				<label><input type="checkbox" class="same_addr" name="same_addr" checked=""><?php echo rms_translate("Identique à mon adresse de contact"); ?></label>
				
				<div class="fact_addr">
					
					<div>
						<div style="width: 60%; margin-right: 10%; float: left;">
							<label for="fact_street"><?php echo rms_translate("Rue"); ?></label>
							<input type="text" name="fact_street">
						</div>
						<div style="width: 30%; float: right;">
							<label for="fact_number"><?php echo rms_translate("N°"); ?></label>
							<input type="text" name="fact_number" value="<?php echo get_user_meta( get_current_user_id(), 'fact_number', true ); ?>" style="width: 70px;">
						</div>
					</div>
					
					<div>
						<div style="width: 60%; margin-right: 10%; float: left;">	
							<label for="fact_city"><?php echo rms_translate("Ville"); ?></label>
							<input type="text" name="fact_city">
						</div>
						<div style="width: 30%; float: right;">
							<label for="fact_postal"><?php echo rms_translate("Code postal"); ?></label>
							<input type="text" name="fact_postal" value="<?php echo get_user_meta( get_current_user_id(), 'fact_postal', true ); ?>" style="width: 70px;">
						</div>
					</div>
					
					<div>
						<div style="width: 53%; margin-right: 10%; float: left;">	
							<label for="fact_country"><?php echo rms_translate("Pays"); ?></label>
							<select name="fact_country" style="width: 210px; margin: 0;">
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
								<option data-iso-value="ci">Cote D'ivoire</option>
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
								<option data-iso-value="kp">Korea, Democratic People's Republic of</option>
								<option data-iso-value="kr">Korea, Republic of</option>
								<option data-iso-value="kw">Kuwait</option>
								<option data-iso-value="kg">Kyrgyzstan</option>
								<option data-iso-value="la">Lao People's Democratic Republic</option>
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
							</select>
						</div>
						<div style="width: 30%; float: right;">
							<label for="fact_iso">ISO</label>
							<input type="text" name="fact_iso" value="<?php echo (get_user_meta( get_current_user_id(), 'fact_iso', true ) ? get_user_meta( get_current_user_id(), 'fact_iso', true ) : 'CH'); ?>" style="width: 20px;">
						</div>
					</div>
					
					<div>
						<div style="width: 45%;margin-right:10%;float: left; margin-top: 10px;">	
							<label for="fact_phone_1"><?php echo rms_translate("Tél. 1"); ?></label>
							<input type="text" name="fact_phone_1" value="<?php echo get_user_meta( get_current_user_id(), 'fact_phone_1', true ); ?>">
						</div>
					</div>
					
					<div>
						<div style="width: 45%;float: right;">	
							<label for="fact_phone_2"><?php echo rms_translate("Tél. 2"); ?></label>
							<input type="text" name="fact_phone_2" class="not_required" value="<?php echo get_user_meta( get_current_user_id(), 'fact_phone_2', true ); ?>">
						</div>
					</div>
					
					<div>
						<div style="width: 100%;float: left;">	
							<label for="fact_email"><?php echo rms_translate("Email"); ?></label>
							<input type="text" name="fact_email" value="<?php echo get_user_meta( get_current_user_id(), 'fact_email', true ); ?>">
						</div>
					</div>
				</div>
				
			</fieldset>
		
		</div>

		<div class="right_col">
			
			<fieldset>
				<label for="theme"><?php echo rms_translate("Thème de la recherche durant votre séjour"); ?></label>
				<textarea name="theme" rows="5" style="width: 345px; min-width: 0px;"></textarea>
				
				<label for="regime"><?php echo rms_translate("Régime/Allergies"); ?></label>
				<textarea name="regime" rows="5" style="width: 345px; min-width: 0px;"></textarea>
				
				<label for="remarks"><?php echo rms_translate("Remarques"); ?></label>
				<textarea name="remarks" rows="5" class="not_required" style="width: 345px; min-width: 0px;"></textarea>
				
				
				<label><input type="checkbox" name="gimme_scolarship" class="gimme_scolarship"><?php echo rms_translate("Je souhaite faire une demande de bourse"); ?></label>
				
				<div class="scolarship_form" style="font-size: 13px;margin-top:15px;line-height:30px;">
					<?php
						$icl_condBours_id = icl_object_id(954, 'page', true);
					?>
					<a href="<?php echo get_permalink($icl_condBours_id); ?>" target="_blank"><?php echo rms_translate("Conditions d'obtention d'une bourse"); ?></a>
					
					<p><?php echo rms_translate("Veuillez choisir deux périodes de séjour souhaitées"); ?> :</p>
					
					<div>
						<div style="width: 20%;float: left;"><?php echo rms_translate("Période 1"); ?></div>
						<div>
						
							<div style="width: 35%; margin-right:10%; float: left;">	
								<label for="start_1" style="font-size: 14px; display: inline-block;"><?php echo rms_translate("Date d'arrivée"); ?></label>
								<input type="text" name="start_1" class="datepicker" style="display: inline-block; width: 77px; min-width: 77px;">
							</div>
						</div>
						
						<div>
							<div style="width: 35%; float: right;">	
								<label for="end_1" style="font-size: 14px; display: inline-block;"><?php echo rms_translate("Date de départ"); ?></label>
								<input type="text" name="end_1" class="datepicker" style="display: inline-block; width: 77px; min-width: 77px;">
							</div>
						</div>
					</div>
					
					<div>
						<div style="width: 20%;float: left;"><?php echo rms_translate("Période 2"); ?></div>
						<div>
							<div style="width: 35%;margin-right:10%;float: left;">	
								<label for="start_2" style="font-size: 14px; display: inline-block;"><?php echo rms_translate("Date d'arrivée"); ?></label>
								<input type="text" name="start_2" class="datepicker" style="display: inline-block; width: 77px; min-width: 77px;">
							</div>
						</div>
						
						<div>
							<div style="width: 35%;float: right;">	
								<label for="end_2" style="font-size: 14px; display: inline-block;"><?php echo rms_translate("Date de départ"); ?></label>
								<input type="text" name="end_2" class="datepicker" style="display: inline-block; width: 77px; min-width: 77px;">
							</div>
						</div>
					</div>
					<div class="fileinputs">
						<input type="file" class="file" multiple />
						<div class="fakefile">
							<?php echo rms_translate("Joindre les documents demandés"); ?>
						</div>
					</div>
					<div class="topto"></div>
				</div>
				
				<input type="submit" value="<?php echo rms_translate("Continuer"); ?>" />
			</fieldset>
			
		</div>

	</form>
</div>