<?php
	//Template Name: rms_Reservation Form
	get_header(); 

	// Initialiser le frontend
	rms_reservation_frontend();
		
	
	$i = 0;
	if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		$i++;
?>
		<section class="page" data-stellar-background-ratio="0.5" style="filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>',sizingMethod='scale');-ms-filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>,sizingMethod=scale)';background: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?> ') center center fixed no-repeat; background-size: cover;">
	<div class="wrapper">	
			<article>
			<a href="<?php echo home_url(); ?>" class="logo fixed"></a>
				<div class="page_content_wrap <?php echo ($blnMultipleCols ? 'width_60' : 'width_30'); ?>">
					<a href="#" class="close_cross close_all_text cross_img" title="Fermer les textes"></a>
	
				<?php
					
					if( ( isset( $_GET['step'] ) ) || ( current_user_can('hardt_host') ) )
					{
				?>
					<div class="form_step_menu">
						<ul>
							<li class="active done">
								<a href="step_1">1.<?php echo rms_translate("Profil"); ?></a>
							</li>
							
							<li>
								<a href="step_2" class="disabled">2.<?php echo rms_translate("Dates"); ?></a>
							</li>
							
							<li>
								<a href="step_3" class="disabled">3.<?php echo rms_translate("Réserver"); ?></a>
							</li>
							
							<li>
								<a href="step_4" class="disabled">4.<?php echo rms_translate("Confirmation"); ?></a>
							</li>
						</ul>
					</div>
				<?php
					}
				?>
					
					<div class="page_content">

						<h1><?php the_title(); ?></h1>

						<div class="separator"><hr/></div>

						<p class="step_content">
							<?php
							
							// Vérifier présence étape ou visiteur connecté
							if( ( empty( $_GET['step'] ) ) && ( ( !current_user_can('hardt_host') ) && ( !current_user_can('hardt_admin') ) ) )
							
								require_once ABSPATH . 'wp-content/plugins/rooms-reservation/frontend/views/reg_preambule.php';
							else
							{
								for( $i = 1; $i <= 4; $i++)
								{
									
									require_once ABSPATH . 'wp-content/plugins/rooms-reservation/frontend/views/reg_step_' . $i . '.php';
									
								}
							}// Fin if()
		
							?>
						</p>
					</div>
				</div>

			</article>
			<?php
				
				// Verifier qu'il s'agisse pas du dernier post
				if ($i != sizeof($posts)) 
				{
					echo '</section>';
				}

	endwhile; 
	
	endif;
?>
<style>
	body {
		overflow-y: scroll;
	}
</style>
<?php
	get_footer();
?>