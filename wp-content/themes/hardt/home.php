<?php
	//Template Name: Homepage
	get_header(); 
			
	// Afficher les actualites
	$category_query_args1 = array(
		'cat' => 1,
		'post_status' => 'publish'
	);

	$category_query1 = new WP_Query( $category_query_args1 );
	$admin_bar_news_hack = "";
if ( is_admin_bar_showing() )
	$admin_bar_news_hack = ' style="top:229px;"';
	
	if($category_query1->have_posts())
	{

		$strNewsData = '<div class="news fixed"' . $admin_bar_news_hack . '>';
	
			while($category_query1->have_posts()) 
			{
				$category_query1->the_post();

				$strNewsData .= '<div class="separator"><hr/></div>';

				$strNewsData .= '<a>' . get_the_title() . '</a>';

				$strNewsData .= '<p>' . get_the_content() . '</p>';

			}
		
		$strNewsData .= '</div>

		<div class="open_news fixed"' . $admin_bar_news_hack . '>
			<a href="#" class="open_square square_img" title="Ouvrir les actualités"></a>
			<h1 class="no_margin">Actualités</h1>
		</div>';

	}
	
	$i = 0;
	$args = array( 'post_type' => 'home_post', 'posts_per_page' => 10 );
	$loop = new WP_Query( $args );
	
	while ( $loop->have_posts() ) : $loop->the_post();
	
?>

	<section class="home" data-stellar-background-ratio="0.5" style="filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>',sizingMethod='scale');-ms-filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>,sizingMethod=scale)';background: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?> ') center center fixed no-repeat; background-size: cover;">
	  <article>
		<?php
			// Afficher elements 1er slide
			if($i == 0)
			{
				echo '<a href="' . home_url() . '" class="logo fixed"></a>';
				echo $strNewsData;
			
			}
		?>
			<div class="citation_original shadow" <?php /*data-stellar-ratio="-0.5"*/ ?>><?php the_title(); ?></div>
		
			<div class="citation_traduction shadow" <?php /*data-stellar-ratio="0.5"*/ ?>>
				<?php 
					echo get_the_excerpt();
					// Element de legende de l'image (copyright)
					if(get_field('citation_author'))
					{
						echo '<span class="citation_author">, ' . get_field('citation_author') . '</span>';
					}// Afficher auteur citation
				?>
			</div>
			
		</article>
	</section>

<?php
	$i++;
	
	endwhile;

	get_footer();
?>