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
					<div style="width: 36%; margin-right: 59%; float: left;">	
						<label for="birthday"><span title="Format: dd/-.mm/-.yyyy"><?php echo rms_translate("Date de naissance"); ?></span></label>
						<input type="text" placeholder="ex: 15.08.1985" name="birthday" value="<?php echo get_user_meta( get_current_user_id(), 'birthday', true ); ?>" style="max-width:110px; min-width:110px;">
					</div>
					
					<div style="width: 5%; float: right;">
						<label for="sex"><?php echo rms_translate("Sexe"); ?></label>
						<input type="text" name="sex" value="<?php echo get_user_meta( get_current_user_id(), 'sex', true ); ?>">
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
							<option value="ch">Switzerland</option>
							<option value="gb">United Kingdom</option>
							<option value="af">Afghanistan</option>
							<option value="ax">Åland Islands</option>
							<option value="al">Albania</option>
							<option value="dz">Algeria</option>
							<option value="as">American Samoa</option>
							<option value="ad">Andorra</option>
							<option value="ao">Angola</option>
							<option value="ai">Anguilla</option>
							<option value="aq">Antarctica</option>
							<option value="ag">Antigua and Barbuda</option>
							<option value="ar">Argentina</option>
							<option value="am">Armenia</option>
							<option value="aw">Aruba</option>
							<option value="au">Australia</option>
							<option value="at">Austria</option>
							<option value="az">Azerbaijan</option>
							<option value="bs">Bahamas</option>
							<option value="bh">Bahrain</option>
							<option value="bd">Bangladesh</option>
							<option value="bb">Barbados</option>
							<option value="by">Belarus</option>
							<option value="be">Belgium</option>
							<option value="bz">Belize</option>
							<option value="bj">Benin</option>
							<option value="bm">Bermuda</option>
							<option value="bt">Bhutan</option>
							<option value="bo">Bolivia</option>
							<option value="ba">Bosnia and Herzegovina</option>
							<option value="bw">Botswana</option>
							<option value="bv">Bouvet Island</option>
							<option value="br">Brazil</option>
							<option value="io">British Indian Ocean Territory</option>
							<option value="bn">Brunei Darussalam</option>
							<option value="bg">Bulgaria</option>
							<option value="bf">Burkina Faso</option>
							<option value="bi">Burundi</option>
							<option value="kh">Cambodia</option>
							<option value="cm">Cameroon</option>
							<option value="ca">Canada</option>
							<option value="cv">Cape Verde</option>
							<option value="ky">Cayman Islands</option>
							<option value="cf">Central African Republic</option>
							<option value="td">Chad</option>
							<option value="cl">Chile</option>
							<option value="cn">China</option>
							<option value="cx">Christmas Island</option>
							<option value="cc">Cocos (Keeling) Islands</option>
							<option value="co">Colombia</option>
							<option value="km">Comoros</option>
							<option value="cg">Congo</option>
							<option value="cd">Congo, The Democratic Republic of The</option>
							<option value="ck">Cook Islands</option>
							<option value="cr">Costa Rica</option>
							<option value="ci">Cote D'ivoire</option>
							<option value="hr">Croatia</option>
							<option value="cu">Cuba</option>
							<option value="cy">Cyprus</option>
							<option value="cz">Czech Republic</option>
							<option value="dk">Denmark</option>
							<option value="dj">Djibouti</option>
							<option value="dm">Dominica</option>
							<option value="do">Dominican Republic</option>
							<option value="ec">Ecuador</option>
							<option value="eg">Egypt</option>
							<option value="sv">El Salvador</option>
							<option value="gq">Equatorial Guinea</option>
							<option value="er">Eritrea</option>
							<option value="ee">Estonia</option>
							<option value="et">Ethiopia</option>
							<option value="fk">Falkland Islands (Malvinas)</option>
							<option value="fo">Faroe Islands</option>
							<option value="fj">Fiji</option>
							<option value="fi">Finland</option>
							<option value="fr">France</option>
							<option value="gf">French Guiana</option>
							<option value="pf">French Polynesia</option>
							<option value="tf">French Southern Territories</option>
							<option value="ga">Gabon</option>
							<option value="gm">Gambia</option>
							<option value="ge">Georgia</option>
							<option value="de">Germany</option>
							<option value="gh">Ghana</option>
							<option value="gi">Gibraltar</option>
							<option value="gr">Greece</option>
							<option value="gl">Greenland</option>
							<option value="gd">Grenada</option>
							<option value="gp">Guadeloupe</option>
							<option value="gu">Guam</option>
							<option value="gt">Guatemala</option>
							<option value="gg">Guernsey</option>
							<option value="gn">Guinea</option>
							<option value="gw">Guinea-bissau</option>
							<option value="gy">Guyana</option>
							<option value="ht">Haiti</option>
							<option value="hm">Heard Island and Mcdonald Islands</option>
							<option value="va">Holy See (Vatican City State)</option>
							<option value="hn">Honduras</option>
							<option value="hk">Hong Kong</option>
							<option value="hu">Hungary</option>
							<option value="is">Iceland</option>
							<option value="in">India</option>
							<option value="id">Indonesia</option>
							<option value="ir">Iran, Islamic Republic of</option>
							<option value="iq">Iraq</option>
							<option value="ie">Ireland</option>
							<option value="im">Isle of Man</option>
							<option value="il">Israel</option>
							<option value="it">Italy</option>
							<option value="jm">Jamaica</option>
							<option value="jp">Japan</option>
							<option value="je">Jersey</option>
							<option value="jo">Jordan</option>
							<option value="kz">Kazakhstan</option>
							<option value="ke">Kenya</option>
							<option value="ki">Kiribati</option>
							<option value="kp">Korea, Democratic People's Republic of</option>
							<option value="kr">Korea, Republic of</option>
							<option value="kw">Kuwait</option>
							<option value="kg">Kyrgyzstan</option>
							<option value="la">Lao People's Democratic Republic</option>
							<option value="lv">Latvia</option>
							<option value="lb">Lebanon</option>
							<option value="ls">Lesotho</option>
							<option value="lr">Liberia</option>
							<option value="ly">Libyan Arab Jamahiriya</option>
							<option value="li">Liechtenstein</option>
							<option value="lt">Lithuania</option>
							<option value="lu">Luxembourg</option>
							<option value="mo">Macao</option>
							<option value="mk">Macedonia, The Former Yugoslav Republic of</option>
							<option value="mg">Madagascar</option>
							<option value="mw">Malawi</option>
							<option value="my">Malaysia</option>
							<option value="mv">Maldives</option>
							<option value="ml">Mali</option>
							<option value="mt">Malta</option>
							<option value="mh">Marshall Islands</option>
							<option value="mq">Martinique</option>
							<option value="mr">Mauritania</option>
							<option value="mu">Mauritius</option>
							<option value="yt">Mayotte</option>
							<option value="mx">Mexico</option>
							<option value="fm">Micronesia, Federated States of</option>
							<option value="md">Moldova, Republic of</option>
							<option value="mc">Monaco</option>
							<option value="mn">Mongolia</option>
							<option value="me">Montenegro</option>
							<option value="ms">Montserrat</option>
							<option value="ma">Morocco</option>
							<option value="mz">Mozambique</option>
							<option value="mm">Myanmar</option>
							<option value="na">Namibia</option>
							<option value="nr">Nauru</option>
							<option value="np">Nepal</option>
							<option value="nl">Netherlands</option>
							<option value="an">Netherlands Antilles</option>
							<option value="nc">New Caledonia</option>
							<option value="nz">New Zealand</option>
							<option value="ni">Nicaragua</option>
							<option value="ne">Niger</option>
							<option value="ng">Nigeria</option>
							<option value="nu">Niue</option>
							<option value="nf">Norfolk Island</option>
							<option value="mp">Northern Mariana Islands</option>
							<option value="no">Norway</option>
							<option value="om">Oman</option>
							<option value="pk">Pakistan</option>
							<option value="pw">Palau</option>
							<option value="ps">Palestinian Territory, Occupied</option>
							<option value="pa">Panama</option>
							<option value="pg">Papua New Guinea</option>
							<option value="py">Paraguay</option>
							<option value="pe">Peru</option>
							<option value="ph">Philippines</option>
							<option value="pn">Pitcairn</option>
							<option value="pl">Poland</option>
							<option value="pt">Portugal</option>
							<option value="pr">Puerto Rico</option>
							<option value="qa">Qatar</option>
							<option value="re">Reunion</option>
							<option value="ro">Romania</option>
							<option value="ru">Russian Federation</option>
							<option value="rw">Rwanda</option>
							<option value="sh">Saint Helena</option>
							<option value="kn">Saint Kitts and Nevis</option>
							<option value="lc">Saint Lucia</option>
							<option value="pm">Saint Pierre and Miquelon</option>
							<option value="vc">Saint Vincent and The Grenadines</option>
							<option value="ws">Samoa</option>
							<option value="sm">San Marino</option>
							<option value="st">Sao Tome and Principe</option>
							<option value="sa">Saudi Arabia</option>
							<option value="sn">Senegal</option>
							<option value="rs">Serbia</option>
							<option value="sc">Seychelles</option>
							<option value="sl">Sierra Leone</option>
							<option value="sg">Singapore</option>
							<option value="sk">Slovakia</option>
							<option value="si">Slovenia</option>
							<option value="sb">Solomon Islands</option>
							<option value="so">Somalia</option>
							<option value="za">South Africa</option>
							<option value="gs">South Georgia and The South Sandwich Islands</option>
							<option value="es">Spain</option>
							<option value="lk">Sri Lanka</option>
							<option value="sd">Sudan</option>
							<option value="sr">Suriname</option>
							<option value="sj">Svalbard and Jan Mayen</option>
							<option value="sz">Swaziland</option>
							<option value="se">Sweden</option>
							<option value="sy">Syrian Arab Republic</option>
							<option value="tw">Taiwan, Province of China</option>
							<option value="tj">Tajikistan</option>
							<option value="tz">Tanzania, United Republic of</option>
							<option value="th">Thailand</option>
							<option value="tl">Timor-leste</option>
							<option value="tg">Togo</option>
							<option value="tk">Tokelau</option>
							<option value="to">Tonga</option>
							<option value="tt">Trinidad and Tobago</option>
							<option value="tn">Tunisia</option>
							<option value="tr">Turkey</option>
							<option value="tm">Turkmenistan</option>
							<option value="tc">Turks and Caicos Islands</option>
							<option value="tv">Tuvalu</option>
							<option value="ug">Uganda</option>
							<option value="ua">Ukraine</option>
							<option value="ae">United Arab Emirates</option>
							<option value="us">United States</option>
							<option value="um">United States Minor Outlying Islands</option>
							<option value="uy">Uruguay</option>
							<option value="uz">Uzbekistan</option>
							<option value="vu">Vanuatu</option>
							<option value="ve">Venezuela</option>
							<option value="vn">Viet Nam</option>
							<option value="vg">Virgin Islands, British</option>
							<option value="vi">Virgin Islands, U.S.</option>
							<option value="wf">Wallis and Futuna</option>
							<option value="eh">Western Sahara</option>
							<option value="ye">Yemen</option>
							<option value="zm">Zambia</option>
							<option value="zw">Zimbabwe</option>
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
								<option value="ch">Switzerland</option>
								<option value="gb">United Kingdom</option>
								<option value="af">Afghanistan</option>
								<option value="ax">Åland Islands</option>
								<option value="al">Albania</option>
								<option value="dz">Algeria</option>
								<option value="as">American Samoa</option>
								<option value="ad">Andorra</option>
								<option value="ao">Angola</option>
								<option value="ai">Anguilla</option>
								<option value="aq">Antarctica</option>
								<option value="ag">Antigua and Barbuda</option>
								<option value="ar">Argentina</option>
								<option value="am">Armenia</option>
								<option value="aw">Aruba</option>
								<option value="au">Australia</option>
								<option value="at">Austria</option>
								<option value="az">Azerbaijan</option>
								<option value="bs">Bahamas</option>
								<option value="bh">Bahrain</option>
								<option value="bd">Bangladesh</option>
								<option value="bb">Barbados</option>
								<option value="by">Belarus</option>
								<option value="be">Belgium</option>
								<option value="bz">Belize</option>
								<option value="bj">Benin</option>
								<option value="bm">Bermuda</option>
								<option value="bt">Bhutan</option>
								<option value="bo">Bolivia</option>
								<option value="ba">Bosnia and Herzegovina</option>
								<option value="bw">Botswana</option>
								<option value="bv">Bouvet Island</option>
								<option value="br">Brazil</option>
								<option value="io">British Indian Ocean Territory</option>
								<option value="bn">Brunei Darussalam</option>
								<option value="bg">Bulgaria</option>
								<option value="bf">Burkina Faso</option>
								<option value="bi">Burundi</option>
								<option value="kh">Cambodia</option>
								<option value="cm">Cameroon</option>
								<option value="ca">Canada</option>
								<option value="cv">Cape Verde</option>
								<option value="ky">Cayman Islands</option>
								<option value="cf">Central African Republic</option>
								<option value="td">Chad</option>
								<option value="cl">Chile</option>
								<option value="cn">China</option>
								<option value="cx">Christmas Island</option>
								<option value="cc">Cocos (Keeling) Islands</option>
								<option value="co">Colombia</option>
								<option value="km">Comoros</option>
								<option value="cg">Congo</option>
								<option value="cd">Congo, The Democratic Republic of The</option>
								<option value="ck">Cook Islands</option>
								<option value="cr">Costa Rica</option>
								<option value="ci">Cote D'ivoire</option>
								<option value="hr">Croatia</option>
								<option value="cu">Cuba</option>
								<option value="cy">Cyprus</option>
								<option value="cz">Czech Republic</option>
								<option value="dk">Denmark</option>
								<option value="dj">Djibouti</option>
								<option value="dm">Dominica</option>
								<option value="do">Dominican Republic</option>
								<option value="ec">Ecuador</option>
								<option value="eg">Egypt</option>
								<option value="sv">El Salvador</option>
								<option value="gq">Equatorial Guinea</option>
								<option value="er">Eritrea</option>
								<option value="ee">Estonia</option>
								<option value="et">Ethiopia</option>
								<option value="fk">Falkland Islands (Malvinas)</option>
								<option value="fo">Faroe Islands</option>
								<option value="fj">Fiji</option>
								<option value="fi">Finland</option>
								<option value="fr">France</option>
								<option value="gf">French Guiana</option>
								<option value="pf">French Polynesia</option>
								<option value="tf">French Southern Territories</option>
								<option value="ga">Gabon</option>
								<option value="gm">Gambia</option>
								<option value="ge">Georgia</option>
								<option value="de">Germany</option>
								<option value="gh">Ghana</option>
								<option value="gi">Gibraltar</option>
								<option value="gr">Greece</option>
								<option value="gl">Greenland</option>
								<option value="gd">Grenada</option>
								<option value="gp">Guadeloupe</option>
								<option value="gu">Guam</option>
								<option value="gt">Guatemala</option>
								<option value="gg">Guernsey</option>
								<option value="gn">Guinea</option>
								<option value="gw">Guinea-bissau</option>
								<option value="gy">Guyana</option>
								<option value="ht">Haiti</option>
								<option value="hm">Heard Island and Mcdonald Islands</option>
								<option value="va">Holy See (Vatican City State)</option>
								<option value="hn">Honduras</option>
								<option value="hk">Hong Kong</option>
								<option value="hu">Hungary</option>
								<option value="is">Iceland</option>
								<option value="in">India</option>
								<option value="id">Indonesia</option>
								<option value="ir">Iran, Islamic Republic of</option>
								<option value="iq">Iraq</option>
								<option value="ie">Ireland</option>
								<option value="im">Isle of Man</option>
								<option value="il">Israel</option>
								<option value="it">Italy</option>
								<option value="jm">Jamaica</option>
								<option value="jp">Japan</option>
								<option value="je">Jersey</option>
								<option value="jo">Jordan</option>
								<option value="kz">Kazakhstan</option>
								<option value="ke">Kenya</option>
								<option value="ki">Kiribati</option>
								<option value="kp">Korea, Democratic People's Republic of</option>
								<option value="kr">Korea, Republic of</option>
								<option value="kw">Kuwait</option>
								<option value="kg">Kyrgyzstan</option>
								<option value="la">Lao People's Democratic Republic</option>
								<option value="lv">Latvia</option>
								<option value="lb">Lebanon</option>
								<option value="ls">Lesotho</option>
								<option value="lr">Liberia</option>
								<option value="ly">Libyan Arab Jamahiriya</option>
								<option value="li">Liechtenstein</option>
								<option value="lt">Lithuania</option>
								<option value="lu">Luxembourg</option>
								<option value="mo">Macao</option>
								<option value="mk">Macedonia, The Former Yugoslav Republic of</option>
								<option value="mg">Madagascar</option>
								<option value="mw">Malawi</option>
								<option value="my">Malaysia</option>
								<option value="mv">Maldives</option>
								<option value="ml">Mali</option>
								<option value="mt">Malta</option>
								<option value="mh">Marshall Islands</option>
								<option value="mq">Martinique</option>
								<option value="mr">Mauritania</option>
								<option value="mu">Mauritius</option>
								<option value="yt">Mayotte</option>
								<option value="mx">Mexico</option>
								<option value="fm">Micronesia, Federated States of</option>
								<option value="md">Moldova, Republic of</option>
								<option value="mc">Monaco</option>
								<option value="mn">Mongolia</option>
								<option value="me">Montenegro</option>
								<option value="ms">Montserrat</option>
								<option value="ma">Morocco</option>
								<option value="mz">Mozambique</option>
								<option value="mm">Myanmar</option>
								<option value="na">Namibia</option>
								<option value="nr">Nauru</option>
								<option value="np">Nepal</option>
								<option value="nl">Netherlands</option>
								<option value="an">Netherlands Antilles</option>
								<option value="nc">New Caledonia</option>
								<option value="nz">New Zealand</option>
								<option value="ni">Nicaragua</option>
								<option value="ne">Niger</option>
								<option value="ng">Nigeria</option>
								<option value="nu">Niue</option>
								<option value="nf">Norfolk Island</option>
								<option value="mp">Northern Mariana Islands</option>
								<option value="no">Norway</option>
								<option value="om">Oman</option>
								<option value="pk">Pakistan</option>
								<option value="pw">Palau</option>
								<option value="ps">Palestinian Territory, Occupied</option>
								<option value="pa">Panama</option>
								<option value="pg">Papua New Guinea</option>
								<option value="py">Paraguay</option>
								<option value="pe">Peru</option>
								<option value="ph">Philippines</option>
								<option value="pn">Pitcairn</option>
								<option value="pl">Poland</option>
								<option value="pt">Portugal</option>
								<option value="pr">Puerto Rico</option>
								<option value="qa">Qatar</option>
								<option value="re">Reunion</option>
								<option value="ro">Romania</option>
								<option value="ru">Russian Federation</option>
								<option value="rw">Rwanda</option>
								<option value="sh">Saint Helena</option>
								<option value="kn">Saint Kitts and Nevis</option>
								<option value="lc">Saint Lucia</option>
								<option value="pm">Saint Pierre and Miquelon</option>
								<option value="vc">Saint Vincent and The Grenadines</option>
								<option value="ws">Samoa</option>
								<option value="sm">San Marino</option>
								<option value="st">Sao Tome and Principe</option>
								<option value="sa">Saudi Arabia</option>
								<option value="sn">Senegal</option>
								<option value="rs">Serbia</option>
								<option value="sc">Seychelles</option>
								<option value="sl">Sierra Leone</option>
								<option value="sg">Singapore</option>
								<option value="sk">Slovakia</option>
								<option value="si">Slovenia</option>
								<option value="sb">Solomon Islands</option>
								<option value="so">Somalia</option>
								<option value="za">South Africa</option>
								<option value="gs">South Georgia and The South Sandwich Islands</option>
								<option value="es">Spain</option>
								<option value="lk">Sri Lanka</option>
								<option value="sd">Sudan</option>
								<option value="sr">Suriname</option>
								<option value="sj">Svalbard and Jan Mayen</option>
								<option value="sz">Swaziland</option>
								<option value="se">Sweden</option>
								<option value="sy">Syrian Arab Republic</option>
								<option value="tw">Taiwan, Province of China</option>
								<option value="tj">Tajikistan</option>
								<option value="tz">Tanzania, United Republic of</option>
								<option value="th">Thailand</option>
								<option value="tl">Timor-leste</option>
								<option value="tg">Togo</option>
								<option value="tk">Tokelau</option>
								<option value="to">Tonga</option>
								<option value="tt">Trinidad and Tobago</option>
								<option value="tn">Tunisia</option>
								<option value="tr">Turkey</option>
								<option value="tm">Turkmenistan</option>
								<option value="tc">Turks and Caicos Islands</option>
								<option value="tv">Tuvalu</option>
								<option value="ug">Uganda</option>
								<option value="ua">Ukraine</option>
								<option value="ae">United Arab Emirates</option>
								<option value="us">United States</option>
								<option value="um">United States Minor Outlying Islands</option>
								<option value="uy">Uruguay</option>
								<option value="uz">Uzbekistan</option>
								<option value="vu">Vanuatu</option>
								<option value="ve">Venezuela</option>
								<option value="vn">Viet Nam</option>
								<option value="vg">Virgin Islands, British</option>
								<option value="vi">Virgin Islands, U.S.</option>
								<option value="wf">Wallis and Futuna</option>
								<option value="eh">Western Sahara</option>
								<option value="ye">Yemen</option>
								<option value="zm">Zambia</option>
								<option value="zw">Zimbabwe</option>
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