<?php
	//Template Name: Page Google Map
	get_header(); 

	$i = 0;
	if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		$i++;
		// Verifier si texte sur 2 colonnes
		$blnMultipleCols = has_shortcode( get_the_content(), 'create_second_col' );
?>


  
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
   <section class="page" id="map"></section>	
			
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script> 
  
	<script type="text/javascript"> 
	
		jQuery(document).ready(function() {
			// laisse le temps au script principal de s'éxécuter (500ms)
			// ainsi la variable "isMobile" est disponible avec la bonne indication
			jQuery("body").delay(500).queue(function(next) { 

				var address = 'Chemin Vert 2, Vandoeuvres, CH';

				var map = new google.maps.Map(document.getElementById('map'), { 
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					zoom: 15,
					disableDefaultUI: true,
					panControl: false, // desactiver si mobile
					zoomControl: false, 
					mapTypeControl: false, 
					scaleControl: false, 
					streetViewControl: false, 
					overviewMapControl: (!isMobile),
					draggable:  (!isMobile || isIpad),
					scrollwheel:  (!isMobile || isIpad),
					

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
				
				// si il s'agit d'un mobile on met le container contenant l'adresse -775px plus haut
				if(isMobile) {
					jQuery("#mobileLogoContainer").css("margin-top", "75px");
					// on descend la map plus bas pour laisser afficher le menu
					jQuery("#map").css("margin-top", "0px");
					
					// correction mobile pour le placement
					jQuery("div.page_content_wrap").css("margin-top", "165px");
					jQuery("div.container").css("margin-top", "0px");
					
					// spécificité Android 
					if( isAndroid ) {
						jQuery("#map").css("top", "-385px");
						jQuery("#map").css("position", "absolute");
					}
					
				}
				else { // desktop
				
					// correction placement info google map
					jQuery("div.page_content_wrap").css("right","115px")
						.css("position","absolute");
						// placement logo et contenu page à 10%
					jQuery(".logo").css("margin-top", "7%");
					jQuery("div.page_content_wrap").css("margin-top", "5%");
				}
				
				
			});
		
		
	}); // doc ready
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