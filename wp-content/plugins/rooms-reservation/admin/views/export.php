<?php
	// Vue de la page des export
?>

<div class="wrap">
	<h2><?php _e( 'Exporter des données', 'rms_reservation' ); ?></h2>

	<p><?php _e( 'Vous avez la possibilités de récupérer des données ( chambres, hôtes, réservations) au format Excel (.xlsx)', 'rms_reservation' ); ?></p>

	<h3><?php _e( 'Choisissez ce que vous voulez exporter', 'rms_reservation' ); ?></h3>

	<p>
		<a href="<?php echo plugin_dir_url( __FILE__); ?>export_liste1.php"><?php _e( 'Réservation par chambre avec informations hôte', 'rms_reservation' ); ?></a>
	</p>
	<p class="description">
		<?php _e( '', 'rms_reservation' ); ?>
	</p>
		
	<p>
		<a href="<?php echo plugin_dir_url( __FILE__); ?>export_liste2.php" id="export_list2_link"><?php _e( 'Occupation des chambres par semaine', 'rms_reservation' ); ?></a>
		
		<div class="export_list2_dateselector">
		
			<fieldset>
			
				<legend>Choisissez la période à exporter:</legend>
				
				<div>
					<label for="export_start_date">Du : </label>
					<input class="datepicker" name="export_fromdate" id="export_fromdate" value="<?php echo date('d.m.Y', strtotime("now") ); ?>"/> 
				</div>
				
				<div>
					<label for="export_end_date">Au : </label>
					<input class="datepicker" name="export_todate" id="export_todate" value="<?php echo date('d.m.Y', strtotime("now +1 week") ); ?>"/>
				</div>
				
				<div>
					<input type="submit" id="list2_export_submit" value="Exporter" />
				</div>
				
			</fieldset>
			
		</div>
		
	</p>
	
	<p class="description">
		<?php _e( '', 'rms_reservation' ); ?>
	</p>
	
</div>