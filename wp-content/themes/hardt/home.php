<?php
	//Template Name: Homepage
	get_header(); 
			
	// Afficher les actualites
	$category_query_args1 = array(
		'cat' => 1,
		'post_status' => 'publish'
	);

	$category_query1 = new WP_Query( $category_query_args1 );
	
	$admin_bar_news_hack =  ( is_admin_bar_showing() ? ' style="top:283px;"' : '' );
	
	if($category_query1->have_posts())
	{

		$strNewsData = '<div class="news fixed"' . $admin_bar_news_hack . '>';
	
			while($category_query1->have_posts()) 
			{
				$category_query1->the_post();

				$strNewsData .= '<div class="separator"><hr/></div>';

				$strNewsData .= '<span class="title">' . get_the_title() . '</span>';
				
				$news_content = apply_filters( 'the_content', get_the_content() );
				$news_content = str_replace( ']]>', ']]&gt;', $news_content );
				
				$strNewsData .= $news_content;

			}
		
		$strNewsData .= '</div>

		<div class="open_news fixed"' . $admin_bar_news_hack . '>
			<a href="#" class="open_square square_img" title="' . __("Ouvrir les actualités", "hardtheme") . '"></a>
			<h1 class="no_margin">' . __("Actualités", "hardtheme") . '</h1>
		</div>';

	}
	
	$i = 0;
	$args = array( 'post_type' => 'home_post', 'posts_per_page' => 10 );
	$loop = new WP_Query( $args );
	?>
	
<div class="bounce_arrow" title="<?php _e("Utilisez la barre de défilement pour découvrir la Fondation"); ?>"></div>
<?php
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
?>
<?php
	get_footer();
?>