<?php
	/* Vue formulaire d'enregistrements: Etape 2 */
?>
<div class="rms_wrapper step_2 hidden_step" data-wrapper_size="60">

	<form name="rms_reservation_step2" class="rms_form" action="#" method="GET">
				
		<p><?php echo rms_translate("Veuillez entrer les dates souhaitées"); ?> :</p>
	
		<fieldset>
		
			<div>

				<div style="width: 45%; margin-right: 10%; float: left;">
					<label for="start_date" style="display: inline-block;"><?php echo rms_translate("Date d'arrivée"); ?></label>
					<input type="text" name="start_date" class="datepicker" id="start_date" style="display: inline-block; min-width: 84%; width: 84%;">
				</div>
				
				<div style="width: 45%; float: right;">
					<label for="end_date" style="display: inline-block;"><?php echo rms_translate("Date de départ"); ?></label>
					<input type="text" name="end_date" class="datepicker" id="end_date" style="display: inline-block; min-width: 84%; width: 84%;">
				</div>
				
			</div>		
			
			<input type="submit" value="<?php echo rms_translate("Vérifier les disponibilités"); ?>" />
			
		</fieldset>
	
	</form>
	
</div>