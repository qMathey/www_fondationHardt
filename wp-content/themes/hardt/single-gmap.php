<?php
	//Template Name: Page Google Map
	get_header(); 

	$i = 0;
	if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		$i++;
		// Verifier si texte sur 2 colonnes
		$blnMultipleCols = has_shortcode( get_the_content(), 'create_second_col' );
?>


  

   <section class="page" id="map"></section>	
			<article>
			<a href="<?php echo home_url(); ?>" class="logo fixed"></a>
				<div class="page_content_wrap" style="z-index:6000; position: relative; width: 400px; margin: 10% 10% 0 0; background-color: #ffffff;">
					<a href="#" class="close_cross close_all_text cross_img" title="Fermer les textes"></a>

					<div class="page_content<?php echo (get_field('indenter_texte') ? ' auto_indent': ''); ?>">

						<h1><?php the_title(); ?></h1>

						<div class="separator"><hr/></div>

						<p>
							<?php
								// Verifier si texte sur 2 colonnes
								if( $blnMultipleCols ) 
								{
									echo '<div class="left_col">';

									the_content();

									echo'<div class="end_glyph"></div>';

									echo '</div>';
								}
								else
								{
									the_content();

									echo'<div class="end_glyph"></div>';
								}// Fin if( $blnMultipleCols ) 
							?>
						</p>
					</div>
				</div>

			</article>
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script> 
  
	<script type="text/javascript"> 

		var address = 'Chemin Vert 2, Vandoeuvres, CH';

		var map = new google.maps.Map(document.getElementById('map'), { 
			mapTypeId: google.maps.MapTypeId.TERRAIN,
			zoom: 15,
			disableDefaultUI: true
		});

		var geocoder = new google.maps.Geocoder();

		geocoder.geocode({
			'address': address
		}, 
		function(results, status) {
			if(status == google.maps.GeocoderStatus.OK) {
				new google.maps.Marker({
				position: results[0].geometry.location,
				map: map
				});
				map.setCenter(results[0].geometry.location);
			}
			else {
			// Google couldn't geocode this request. Handle appropriately.
			}
		});

	</script>
	
	<style>
		.footer_container {
			display: none;
		}
	</style>
			<?php
	endwhile; 
	
	endif;
	
	get_footer();
?>