<?php
	/* Vue formulaire d'enregistrements: Etape 4 */
?>
<div class="rms_wrapper step_4 hidden_step" data-wrapper_size="60">
		
	<p><?php echo rms_translate("Voici le résumé de votre pré-réservation. Veuillez noter que votre demande de séjour à la Fondation Hardt doit encore faire l'objet d'une validation de notre part."); ?></p>

	<fieldset class="data_from_step1">
	
		<div style="width: 45%; margin-right: 10%; float: left;text-transform:uppercase">
			1.<?php echo rms_translate("Profil"); ?>
		</div>
		<div style="width: 45%; float: right;">
			<input type="button" data-step="step_1" class="rms_edit_go_to_step" value="<?php echo rms_translate("Modifier"); ?>" />
		</div>
		
		<div style="width: 100%;" data-input="last_name"></div>
		
		<div style="width: 100%;" data-input="first_name"></div>
		
		<div style="width: 45%; margin-right: 10%; float: left;" data-input="birthday"></div>
		
		<div style="width: 45%; float: right;" data-input="civil"></div>
		
		<div style="width: 100%;" data-input="nationality"></div>
		
		<div style="width: 100%;" data-input="university_title"></div>
		
		<div style="width: 100%;" data-input="affiliation"></div>
		
		<div style="width: 100%;" data-input="function"></div>
		
		<div style="width: 100%;" data-input="street"></div>
		
		<div style="width: 45%; margin-right: 10%; float: left;" data-input="city"></div>
		
		<div style="width: 45%; float: right;" data-input="country"></div>
		
		<div style="width: 45%; margin-right: 10%; float: left;" data-input="phone_1"></div>
		
		<div style="width: 45%; float: right;" data-input="phone_2"></div>
		
		<div style="width: 100%;" data-input="email"></div>

	</fieldset>
	
	<fieldset style="text-transform:uppercase;">
	
		<div style="width: 45%; margin-right: 10%; float: left;">
			2.<?php echo rms_translate("Dates"); ?>
		</div>
		
		<div style="width: 45%; float: right;">
			<input type="button" data-step="step_2" class="rms_edit_go_to_step" value="<?php echo rms_translate("Modifier"); ?>" />
		</div>
		
		<div style="width: 100%;">
			<?php echo rms_translate("Date d'arrivée"); ?> : <span class="start_date"></span>
		</div>	
		
		<div style="width: 100%;">
			<?php echo rms_translate("Date de départ"); ?> : <span class="end_date"></span>
		</div>	
		
		<div style="width: 100%; font-family: HelveticaLT-Bold; color: #003366; text-align: right;text-transform:uppercase">
			<?php echo rms_translate("Nombre de nuits"); ?> : <span class="nb_nights"></span>
		</div>	
	</fieldset>
	
	<fieldset class="res_room_list">
	
		<div style="width: 45%; margin-right: 10%; float: left;text-transform:uppercase;">
			3.<?php echo rms_translate("Chambre"); ?>
		</div>
		
		<div style="width: 45%; float: right;">
			<input type="button" data-step="step_3" class="rms_edit_go_to_step" value="<?php echo rms_translate("Modifier"); ?>" />
		</div>
		
		<div class="show_room" style="width: 100%;">
			<article></article>
		</div>	
		
		<div style="width: 100%; font-family: HelveticaLT-Bold; color: #003366; text-align:right;">
			TOTAL : <span class="total_cost"></span> CHF
		</div>	
	<?php
		// Obtenir l'id des cg selon la langue
		$cgFileID = ( ICL_LANGUAGE_CODE == 'fr' ? 1729 : 1730 );
	?>
		<div class="" style="text-align:right;">
			<input type="checkbox" name="tou_agree" /><?php echo rms_translate("J'ai lu et j'accepte"); echo ' <a href="' . wp_get_attachment_url( $cgFileID ) . '" target="_blank">';echo rms_translate("les conditions générales"); echo '</a>'; ?>
		</div>
		<input type="submit" class="submit_reservation" value="<?php echo rms_translate("Confirmer"); ?>" />
	</fieldset>
	
</div>