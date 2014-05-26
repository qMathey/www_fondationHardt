<?php
	// Vue de la page des export
?>

<div class="wrap">
	<h2><?php _e( 'Exporter des données', 'rms_reservation' ); ?></h2>

	<p><?php _e( 'Vous avez la possibilités de récupérer des données ( chambres, hôtes, réservations) au format Excel (.xlsx)', 'rms_reservation' ); ?></p>

	<h3><?php _e( 'Choisissez ce que vous voulez exporter', 'rms_reservation' ); ?></h3>

	<p>
		<a href="<?php echo plugin_dir_url( __FILE__); ?>../export_liste1.php"><?php _e( 'Réservation par chambre avec informations hôte', 'rms_reservation' ); ?></a>
	</p>
	<p class="description">
		<?php _e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'rms_reservation' ); ?>
	</p>
		
	<p>
		<a href="<?php echo plugin_dir_url( __FILE__); ?>../export_liste2.php"><?php _e( 'Occupation des chambres par semaine', 'rms_reservation' ); ?></a>
	</p>
	
	<p class="description">
		<?php _e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'rms_reservation' ); ?>
	</p>
	
</div>