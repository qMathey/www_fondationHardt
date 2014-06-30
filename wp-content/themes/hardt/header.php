<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<title>Fondation Hardt</title>
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri();?>/js/html5shiv.min.js"></script>
		<![endif]-->
		<?php
			wp_head();
		?>
	</head>

	<body>

	
		<div class="navigation menu_fixed" <?php if ( is_admin_bar_showing() ) { echo 'style="top:32px;"'; } ?>>
			<div class="fix_width_menu">
				<?php 
					// Afficher menu principal
					$args = array(
						'theme_location'  => 'header',
						'container' => false,
						'menu_class' => 'main_top_menu',
						'walker' => new custom_walker_menu()
					);
				
					wp_nav_menu($args);
				?>
				<div class="menu_float_right">
					<?php
						// Afficher menu secondaire
						$args = array(
							'theme_location'  => 'header_right',
							'container' => false,
							'menu_class' => 'right_top_menu',
							'walker' => new custom_walker_menu()
						);
					
						wp_nav_menu($args);
					?>
					
					<ul class="right_top_lang_menu">
						<?php
							icl_post_languages();
						?>
					</ul>
				</div>
			</div>
			
			<div class="submenu_wrapper"></div>
		</div><!-- # .navigation -->
		<div class="container">
			<div id="mobileLogoContainer"></div>