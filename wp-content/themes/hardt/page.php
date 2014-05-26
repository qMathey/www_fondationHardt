<?php
	//Template Name: Page
	get_header(); 

	$i = 0;
	if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		$i++;
		// Verifier si texte sur 2 colonnes
		$blnMultipleCols = has_shortcode( get_the_content(), 'create_second_col' );
?>
	<section class="page" data-stellar-background-ratio="0.5" style="filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>',sizingMethod='scale');-ms-filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>,sizingMethod=scale)';background: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?> ') center center fixed no-repeat; background-size: cover;">
		<div class="wrapper">	
			<article>
			<a href="<?php echo home_url(); ?>" class="logo fixed"></a>
				<div class="page_content_wrap <?php echo ($blnMultipleCols ? 'width_60' : 'width_30'); ?>">
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