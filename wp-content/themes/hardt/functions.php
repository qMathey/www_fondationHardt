<?php
	add_theme_support( 'post-thumbnails' );
	add_filter( 'gettext', 'wpse22764_gettext', 10, 2 );

	// Label custom pour traduction des citations
	function wpse22764_gettext( $translation, $original )
	{
		$post = get_post($post_id);
		
		if ( 'Excerpt' == $original )
		{
			if($post -> post_type == 'home_post')
				return 'Traduction de la citation';
		}
		else
		{
			if($post -> post_type == 'home_post')
			{
				$pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
				
				if ($pos !== false)
					return  '';
			}
		}
		return $translation;
		
	}// Fin wpse22764_gettext
	
	function icl_post_languages()
	{
		$languages = icl_get_languages('skip_missing=0');

		if(1 < count($languages))
		{
			foreach($languages as $l)
			{
				echo '<li>
					<a href="' . $l['url'] . '" ';
					
				if($l['active'])
					echo 'class="active"';
					
				echo '>' . $l['language_code'] . '</a></li>';

			}

		}
	  
	}	
	// Ajout du bouton dans l'editeur tinymce
	if(current_user_can('edit_posts') &&  current_user_can('edit_pages'))
	{
		add_filter('mce_external_plugins', 'load_text_separator_js_into_mce_editor');
		add_filter('mce_buttons', 'load_text_separator_button_into_mce_editor');
	}
	
	function load_text_separator_js_into_mce_editor($plugin_array)
	{
		$plugin_array['custom_text_separator'] = get_template_directory_uri().'/js/tinymce-plugin.js';
		return $plugin_array;
	}
	
	function load_text_separator_button_into_mce_editor($buttons)
	{
		array_push($buttons, "custom_text_separator");
		return $buttons;
	}
	
	/**
	* Enregistrer les scripts
	*/
	function hardt_custom_scripts() 
	{
		// Enregistrer css
		wp_enqueue_style('hardt_main', get_template_directory_uri() . '/css/styles.css');
		
		// Enregistrer js
		wp_enqueue_script('jquery');		
		wp_enqueue_script('hardt_stellar', get_template_directory_uri() . '/js/stellar.js', '', '', true);
		wp_enqueue_script('bgpos', get_template_directory_uri() . '/js/bgpos.js', '', '', true);
		wp_enqueue_script('hoverintent', get_template_directory_uri() . '/js/hoverIntent.js', '', '', true);
		
		wp_enqueue_script('hardt_scripts', get_template_directory_uri() . '/js/scripts.js', '', '', true);
		
	}// Fin hardt_custom_scripts()
	
	add_action( 'wp_enqueue_scripts', 'hardt_custom_scripts' );
	
	
	// Creer menu
	function custom_nav_menu() 
	{
		$locations = array(
			'header' => 'Menu Principal',
			'header_right' =>  'Menu Secondaire Droite',
		);
		
		register_nav_menus( $locations );
	}

	// Hook into the 'init' action
	add_action( 'init', 'custom_nav_menu' );
	
	// Modifier la structure de base du top_menu
	class custom_walker_menu extends Walker_Nav_Menu 
	{
		function start_lvl(&$output, $depth) 
		{
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"submenu\">\n";
			$output .= "\n$indent<li class=\"separator\" style=\"height:5px;\"></li>\n";
		}
	}// Fin class
	
	// Separer le texte en 2 cololnnes (shortcode)
	function create_second_col( $atts )
	{	
		// Terminer la colonne 1 et demarrer la deuxieme
		return "</div><div class=\"right_col\">";
	}
	
	add_shortcode( 'create_second_col', 'create_second_col' );
	
	// Register Custom Post Type
	function home_post() {

		$labels = array(
			'name'                => 'Page d\'accueil',
			'singular_name'       => 'Home Post',
			'menu_name'           => 'Page d\'accueil',
			'all_items'           => 'Tout afficher',
		);
		$args = array(
			'label'               => 'home_post',
			'labels'              => $labels,
			'supports'            =>  array( 'title', 'excerpt', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-feedback',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'home_post', $args );

	}

// Hook into the 'init' action
add_action( 'init', 'home_post', 0 );

	// Separer le texte en 2 cololnnes (shortcode)
	function create_static_search_form( $atts )
	{	
		$strSearch = "";
		
		if( ICL_LANGUAGE_CODE == 'fr') 
			$strSearch = 'Rechercher';
		else
			$strSearch = 'Search';
		
		// Terminer la colonne 1 et demarrer la deuxieme
		$strOutput ='<form action="http://opac.rero.ch/gateway" name="quick_search" id="chronoform_quick_search" method="post" class="Chronoform" target="_blank">

        <div class="search_title" style="margin: 10px 0 10px;">
			<font face="Arial, Helvetica, sans-serif"><span>' . $strSearch . ' :</span></font>
        </div>

        <input type="hidden" name="skin" value="ge">
        <input type="hidden" name="inst" value="61">
        <input type="hidden" name="submittheform" value="">
        <input type="hidden" name="usersrch" value="1">

        <input type="hidden" name="beginsrch" value="1">
        <input type="hidden" name="elementcount" value="3">
        <input type="hidden" name="function" value="INITREQ">
        <input type="hidden" name="search" value="KEYWORD">
        <input type="hidden" name="rootsearch" value="KEYWORD">
        <input type="hidden" name="lng" value="fr-ch">
        <input type="hidden" name="pos" value="1">
              
        <input type="hidden" name="fltset" value="submsn">

        <input type="hidden" name="u1" value="1035">
        <input type="hidden" name="host" value="virtua.rero.ch+8801+DEFAULT">
        <input type="hidden" name="floc" value="610490000">

        <input id="quickSearch" type="button_submit_browse" name="t1" size="24" maxlength="150">
        <input type="submit" id="button_submit_quick" value="Go" onclick="this.form.submittheform.value = \'Search\';">
	</form>';
	return $strOutput;
	}
	
	add_shortcode( 'create_static_search_form', 'create_static_search_form' );
	
?>