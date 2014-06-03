<?php
		
	// Fichier de fonction de l'administration du plugin
	add_action( 'edit_user_profile', 'custom_user_fields', 10);
	add_action( 'show_user_profile', 'custom_user_fields', 10);
	
	// enqueue custom scripts/styles
	add_action( 'admin_enqueue_scripts', 'rooms_reservations_scripts' );
	
	// enqueue scripts and styles
	function rooms_reservations_scripts() {
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		
		// Ajouter custom style
		wp_enqueue_style('rms_admin_css', plugins_url('/rooms-reservation/css/admin.css'));
		
		//wp_register_script( 'rms_admin_js',  plugins_url( '/../js/admin.js', __FILE__ ) );
		wp_enqueue_script('rms_admin_js', plugins_url( '/../js/admin.js', __FILE__ ),'','',true);
		wp_enqueue_script('jquery-ui-datepicker');
		// Propriétés Ajax
		wp_localize_script( 'rms_admin_js', 'rms_reservation_data',
			array( 'ajax_url' => plugins_url('/rooms-reservation/frontend/frontend_ajax.php'))
		);
		
	}
	
	// Custom post status, état archivé pour les réservations
	function rms_res_archived_post_status()
	{
		register_post_status( 'rms_res_archived', array(
			'label'                     => _x( 'Archivé', 'post' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Archivé <span class="count">(%s)</span>', 'Archivé <span class="count">(%s)</span>' ),
		) );
	}// Fin rms_res_archived_post_status()
	
	add_action( 'init', 'rms_res_archived_post_status' );
	
	add_action('admin_footer-post.php', 'rms_append_post_status_list');
	
	// Faire apparaître notre statut
	function rms_append_post_status_list()
	{
		global $post;
		$complete = '';
		$label = '';
		
		// Vérifier si réservation
		if( $post->post_type == 'rms_reservation' )
		{
			$selectText = __('Archiver', 'rms_reservation');
			
			// Vérifier si déjà archivé
			if( $post->post_status == 'rms_res_archived' )
			{	
				$selectText = __('Désarchiver', 'rms_reservation');
				$complete = ' selected=\"selected\"';
				$label = '<span id=\"post-status-display\"> ' . __('Archivé', 'rms_reservation') . '</span>';
			}
			echo '
				<script>
					jQuery(document).ready(function($){
						$("select#post_status").append("<option value=\"rms_res_archived\" ' . $complete . '>' . $selectText . '</option>");
						$(".misc-pub-section label").append("' . $label . '");
					});
				</script>
			';
		}// Fin if()
		
	}// Fin rms_append_post_status_list()
	
	function custom_user_fields( $user )
	{
	
		// Si il s'agit d'un hote
		if(user_can($user, 'hardt_host'))
		{
			// Afficher page profil specifique 
			require_once(dirname(__FILE__) .'/views/custom_profile.php');
			
		}
		elseif(user_can($user, 'hardt_admin'))
		{// Epurer user panel
		
		    echo "<script>jQuery(document).ready(function(){
					jQuery('#rich_editing').parents('table').remove();
					jQuery('#display_name').parents('tr').remove();
					jQuery('#url').parents('tr').remove();
					jQuery('#description').parents('tr').remove();
				});</script>";
		
		}
	}
	// Register Custom Taxonomy
	function rms_room_type() {

		$labels = array(
			'name'                       => _x( 'Room types', 'Taxonomy General Name', 'rms_reservation' ),
			'singular_name'              => _x( 'Room type', 'Taxonomy Singular Name', 'rms_reservation' ),
			'menu_name'                  => __( 'Taxonomy', 'rms_reservation' ),
			'all_items'                  => __( 'All Items', 'rms_reservation' ),
			'parent_item'                => __( 'Parent Item', 'rms_reservation' ),
			'parent_item_colon'          => __( 'Parent Item:', 'rms_reservation' ),
			'new_item_name'              => __( 'New Item Name', 'rms_reservation' ),
			'add_new_item'               => __( 'Add New Item', 'rms_reservation' ),
			'edit_item'                  => __( 'Edit Item', 'rms_reservation' ),
			'update_item'                => __( 'Update Item', 'rms_reservation' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'rms_reservation' ),
			'search_items'               => __( 'Search Items', 'rms_reservation' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'rms_reservation' ),
			'choose_from_most_used'      => __( 'Choose from the most used items', 'rms_reservation' ),
			'not_found'                  => __( 'Not Found', 'rms_reservation' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => false,
			'show_admin_column'          => false,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'room_type', array( 'rms_room' ), $args );

	}

	// Hook into the 'init' action
	add_action( 'init', 'rms_room_type', 0 );

	// Enregistrer custom post type chambres
	function rms_room_custom_post_type() {
        register_post_type( 'rms_room', array(
                'labels' => array(
                        'name' => __( 'Chambres', 'rms_reservation' ),
                        'singular_name' => __( 'Chambre', 'rms_reservation' ),
						'menu_name'           => __( 'Post Type', 'rms_reservation' ),
						'parent_item_colon'   => __( 'Parent Item:', 'rms_reservation' ),
						'all_items'           => __( 'Chambres', 'rms_reservation' ),
						'view_item'           => __( 'Voir la chambre', 'rms_reservation' ),
						'add_new_item'        => __( 'Ajouter une nouvelle chambre', 'rms_reservation' ),
						'add_new'             => __( 'Ajouter une chambre', 'rms_reservation' ),
						'edit_item'           => __( 'Editer la chambre', 'rms_reservation' ),
						'update_item'         => __( 'Update Item', 'rms_reservation' ),
						'search_items'        => __( 'Rechercher', 'rms_reservation' ),
						'not_found'           => __( 'Not found', 'rms_reservation' ),
						'not_found_in_trash'  => __( 'Not found in Trash', 'rms_reservation' ),
                ),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => 'rooms-reservation',
                'supports' => array( 'title' ,'thumbnail', 'editor' ),
        ) );
	}// Fin rms_room_custom_post_type()
	
	add_action( 'init', 'rms_room_custom_post_type' );

	add_filter( 'manage_edit-rms_room_columns', 'rms_room_list_columns' );

	// Modification structure table de listing des chambres
	function rms_room_list_columns( $columns )
	{

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Chambre', 'rms_reservation'),
			'price' => __('Prix (CHF/nuit)', 'rms_reservation'),
			'type' => __('Type', 'rms_reservation')
		);

		return $columns;
		
	}// Fin rms_room_list_columns()
	
	add_action( 'manage_rms_room_posts_custom_column', 'custom_room_columns', 10, 2 );

	// Ajouter colonnes custom
	function custom_room_columns($column, $post_id)
	{
		global $post;

		switch($column)
		{

			// Affichage colonne du prix
			case 'price' :

				// Obtenir le prix
				$price = get_post_meta( $post_id, 'rms_room_price', true );

				// Prix non-défini
				if( empty($price) )
					echo __('Non défini', 'rms_reservation');
				else
					echo $price;

				break;

			// Affichage colonne du type
			case 'type' :

				// Obtenir le type
				$type = get_post_meta( $post_id, 'rms_room_type', true );

				// Type non-défini
				if( empty($type) )
					echo __('Non défini', 'rms_reservation');
				else
					echo $type;

				break;

			// Sortir du switch pour les autres colonnes
			default :
				break;
		}// Fin switch()
		
	}// Fin custom_room_columns()

	add_filter('manage_edit-rms_room_sortable_columns', 'rms_room_sortable_columns');

	// Ajout tri sur colonnes custom
	function rms_room_sortable_columns( $columns ) {

		$columns['price'] = 'price';
		$columns['type'] = 'type';

		return $columns;
	}// Fin rms_room_sortable_columns()
	
	// Appel custom metaboe, prix des chambres
	function rms_room_price_meta()
	{
	
		add_meta_box( 'rms_meta', __( 'Informations obligatoires', 'rms_reservation' ), 'rms_room_meta_callback', 'rms_room', 'side' );
		
	}// Fin rms_room_price_meta()
	
	add_action('add_meta_boxes', 'rms_room_price_meta');
	
	// Contenu metabox prix des chambres
	function rms_room_meta_callback($post)
	{

		wp_nonce_field( basename( __FILE__ ), 'rms_room_nonce' );
		$rms_room_stocked_meta = get_post_meta( $post->ID );
?>

		<p id="post-status-display">
			<label for="rms_room_number" class="prfx-row-title"><?php _e('Numéro de chambre:', 'rms_reservation'); ?></label>
			<input type="text" name="rms_room_number" id="rms_room_number" value="<?php if( isset($rms_room_stocked_meta['rms_room_number']) ) echo $rms_room_stocked_meta['rms_room_number'][0]; ?>" />
		</p>
		
		<p id="post-status-display">
			<label for="rms_room_price" class="prfx-row-title"><?php _e('Coût de la nuit:', 'rms_reservation'); ?></label>
			<input type="number" name="rms_room_price" id="rms_room_price" value="<?php if( isset($rms_room_stocked_meta['rms_room_price']) ) echo $rms_room_stocked_meta['rms_room_price'][0]; ?>" />
		</p>
		
		<p id="post-status-display">
			<label for="rms_room_type" class="prfx-row-title"><?php _e('Catégorie de la chambre:', 'rms_reservation'); ?></label>
			<?php
				$taxonomies = array('room_type');
				
				$args = array(
					'orderby'=>'count',
					'hide_empty' => false
				);
				
				$terms = get_terms($taxonomies, $args);
				$strOutput = "<select name=\"rms_room_type\" id=\"rms_room_type\">
					<option value=''";
					
					if( !isset($rms_room_stocked_meta['rms_room_type']) ) $strOutput .= "selected";
					$strOutput .= ">" . __('Sélectionner une catégorie', 'rms_reservation') . "</option>";
					
				foreach($terms as $term)
				{
					$term_slug = $term->slug;
					$term_name = $term->name;
					
					$strOutput .= '<option value="'.$term_slug.'"';
						if( $rms_room_stocked_meta['rms_room_type'][0] == $term_slug)
							$strOutput .= " selected";
					$strOutput .= ">".$term_name."</option>";
				}// Fin foreach()
				
				$strOutput .="</select>";
				
				echo $strOutput;
			?>
		</p>

<?php

	}// Fin rms_room_meta_callback()
	
	// Fonction de sauvegarde des custom post types
	function rms_room_meta_save($post_id)
	{
	
		// Controler le status d'envoi
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = (isset($_POST['rms_room_nonce']) && wp_verify_nonce($_POST['rms_room_nonce'], basename(__FILE__))) ? 'true' : 'false';

		// Abandonner suivant le status
		if( $is_autosave || $is_revision || !$is_valid_nonce )
		{
			return;
		}


		// Controler l'input
		if( isset($_POST['rms_room_number']) )
		{
			update_post_meta($post_id, 'rms_room_number', sanitize_text_field($_POST[ 'rms_room_number' ]));
		}
		
		// Controler l'input
		if( isset($_POST['rms_room_price']) )
		{
			update_post_meta($post_id, 'rms_room_price', sanitize_text_field($_POST[ 'rms_room_price' ]));
		}
		
		// Controler l'input
		if( isset($_POST['rms_room_type']) )
		{
			update_post_meta($post_id, 'rms_room_type', $_POST[ 'rms_room_type' ]);
		}
	 
	}// Fin rms_room_meta_save()
	
	add_action('save_post', 'rms_room_meta_save');

	// Enregistrer custom post type réservations
	function rms_reservation_custom_post_type()
	{
	
		$args = array(
		
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'labels' => array(
                        'name' => __( 'Réservations', 'rms_reservation' ),
                        'singular_name' => __( 'Réservation', 'rms_reservation' ),
						'menu_name'           => __( 'Post Type', 'rms_reservation' ),
						'parent_item_colon'   => __( 'Parent Item:', 'rms_reservation' ),
						'all_items'           => __( 'Chambres', 'rms_reservation' ),
						'view_item'           => __( 'Voir la réservation', 'rms_reservation' ),
						'add_new_item'        => __( 'Ajouter une nouvelle réservation', 'rms_reservation' ),
						'add_new'             => __( 'Ajouter une réservation', 'rms_reservation' ),
						'edit_item'           => __( 'Editer la réservation', 'rms_reservation' ),
						'update_item'         => __( 'Update Item', 'rms_reservation' ),
						'search_items'        => __( 'Rechercher', 'rms_reservation' ),
						'not_found'           => __( 'Not found', 'rms_reservation' ),
						'not_found_in_trash'  => __( 'Not found in Trash', 'rms_reservation' ),
                ),
		);
                
	
		register_post_type( 'rms_reservation', $args );
		
	}// Fin rms_reservation_custom_post_type()
	
	add_action( 'init', 'rms_reservation_custom_post_type' );
	
	// rms_reservation_activation(),
	function rms_reservation_activation()
	{
	
		// Ajouter le role hardt_admin
		add_role(
			'hardt_admin',
			__( 'Hardt Administrator' ),
				array(
					'delete_others_posts' => true,
					'delete_private_posts' => true,
					'delete_published_pages' => true,
					'edit_others_posts' => true,
					'manage_links' => true,
					'unfiltered_html' => true,

					'delete_posts' => true,
					'delete_published_posts' => true,
					'edit_posts' => true,
					'edit_published_posts' => true,
					'publish_posts' => true,
					'read' => true,
					'upload_files' => true,
					'edit_pages' => true,
					'list_users' => true,
					'edit_users' => true
				)
		);
		
		// Ajouter role hôte
		add_role('hardt_host', __('Hôte'),
		array(
			'read'         => true,  
			'edit_posts'   => false,
			'delete_posts' => false
		));
		
		// Role hardt_admin
		$role = get_role( 'hardt_admin' );
		// Ajouter la capacite
		$role->add_cap( 'hardt_access' ); 

		// Role administrator
		$role = get_role( 'administrator' );
		// Ajouter la capacite
		$role->add_cap( 'hardt_access' ); 
		
	}// Fin rms_reservation_activation()
	
	// Appel custom metaboe, prix des chambres
	function rms_reservation_meta()
	{
		
		add_meta_box( 'rms_meta_2', __( 'Paramètres complémentaires', 'rms_reservation' ), 'rms_reservation_meta_opts_callback', 'rms_reservation', 'side');
		
		add_meta_box( 'rms_meta', __( 'Coût du séjour', 'rms_reservation' ), 'rms_reservation_meta_callback', 'rms_reservation', 'side');
		
	}// Fin rms_reservation_meta()
	add_action('add_meta_boxes', 'rms_reservation_meta');

	// Contenu metabox des réservations
	function rms_reservation_meta_callback($post, $metabox)
	{
		$status = get_post_meta( get_the_ID(), 'rms_reservation_status', true );
		$email = get_post_meta( get_the_ID(), 'rms_reservation_email', true );
		$cost = get_post_meta( get_the_ID(), 'rms_reservation_cost', true );
		$startDate = strtotime(get_post_meta( get_the_ID(), 'rms_reservation_start', true ));
		$endDate = strtotime(get_post_meta( get_the_ID(), 'rms_reservation_end', true ));
		$rms_reservation_sale = get_post_meta( get_the_ID(), 'rms_reservation_sale', true );
		
		$difference = abs($endDate - $startDate);
				$dataPrice_nbNight = $difference/(60*60*24);
		
		if( !$status )
			echo '<div class="error" style="padding:15px">Cette réservation n\'a pas été confirmée</div>';
		elseif( ($status) && (!$email) )
			echo '<div class="error" style="padding:15px">L\'email de confirmation n\'a pas été envoyé</div>'; 
		elseif( $status && $email )
			echo '<div id="message" class="updated"><p>Cette réservation a été confirmée et le visiteur a déjà été recontacté</p></div>';
			
		wp_localize_script( 'rms_admin_js', 'rms_reservation_cost_data',
			array(
				'room_id' => get_post_meta( get_the_ID(), 'rms_reservation_room', true ))	
			);
	
		wp_nonce_field( basename( __FILE__ ), 'rms_res_cost_nonce' );
		
		$rms_room_stocked_meta = get_post_meta( $post->ID );
?>
		<p id="post-status-display">
			<label for="rms_reservation_nigths" class="prfx-row-title"><?php _e('Nombre de nuitées:', 'rms_reservation'); ?></label>
			<input type="text" name="rms_reservation_nigths" id="rms_reservation_nigths" value="<?php echo $dataPrice_nbNight; ?> " disabled="true">
		</p>
		<!-- Supprimé à la demande de Agencies 
		<p id="post-status-display">
			<label for="rms_reservation_end" class="prfx-row-title"><?php _e('Rabais (-50, /2 ,%50, +50):', 'rms_reservation'); ?></label>
			<input type="text" name="rms_reservation_sale" id="rms_reservation_sale" class="datepicker" value="<?php echo $rms_reservation_sale; ?>">
		</p>
		-->
		<p id="post-status-display">
			<label for="rms_room_price" class="prfx-row-title"><?php _e('Coût total (CHF):', 'rms_reservation'); ?></label>
			<input type="text" name="rms_reservation_cost" id="rms_reservation_cost" value="<?php echo $cost; ?>" readonly="true"/>
		</p>
		<?php echo get_submit_button("Calculer le prix total", "primary large get_res_price"); ?>
		
		<script>
			jQuery(document).ready(function()
			{
				jQuery('ul#adminmenu > li.wp-first-item').removeClass('wp-not-current-submenu').addClass('wp-has-current-submenu');
				jQuery('ul#adminmenu > li.wp-first-item>a').addClass('wp-has-current-submenu');
				jQuery('a[href="admin.php?page=rooms-reservation"]').parent('li').addClass('current');
			});
		</script>
		<?php
			if( $status && $email ):
		?>
			<script>
				jQuery(document).ready(function()
				{
					jQuery('#acf_753').remove();
				});
			</script>
<?php
		endif;
	}// Fin rms_reservation_meta_callback()
	
	function prfx_meta_save( $post_id ) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
	 
		// Enregistrer les mets
		if( isset( $_POST[ 'rms_reservation_sale' ] ) )
		{
			update_post_meta( $post_id, 'rms_reservation_sale', $_POST[ 'rms_reservation_sale' ] );
		}
		
		if( isset( $_POST[ 'rms_reservation_cost' ] ) )
		{
			update_post_meta( $post_id, 'rms_reservation_cost', sanitize_text_field( $_POST[ 'rms_reservation_cost' ] ) );
		}
	 
	}
add_action( 'save_post', 'prfx_meta_save' );
	
	// Contenu metabox des réservations
	function rms_reservation_meta_opts_callback($post)
	{
		$status = get_post_meta( get_the_ID(), 'rms_reservation_status', true );
		$email = get_post_meta( get_the_ID(), 'rms_reservation_email', true );
		
		wp_nonce_field( basename( __FILE__ ), 'rms_room_nonce' );
		$rms_room_stocked_meta = get_post_meta( $post->ID );
		
		$user_lang = get_user_meta(get_post_meta($post -> ID, 'rms_reservation_client', true), 'user_lang',true);
		
		wp_localize_script( 'rms_admin_js', 'local_text',
			array( 'lang' => $user_lang, 'bourse' => get_post_meta($post -> ID, 'has_bourse', true) ? 1 : 0)
		);
?>
		<p id="post-status-display">
			<label for="lang" class="prfx-row-title"><?php _e('Langue de contact:', 'rms_reservation'); ?></label>
			<select name="lang" id="rms_user_lang">
				<option value="fr"<?php if( $user_lang == 'fr') echo " selected"; ?>>Français</option>
				<option value="en" <?php if( $user_lang != 'fr') echo " selected"; ?>>Anglais</option>
			</select>
		</p>
		
		<p id="post-status-display">
			<label for="rms_reservation_has_bourse" class="prfx-row-title">
				<input type="checkbox" name="rms_reservation_has_bourse" id="rms_reservation_has_bourse" value="1" <?php if( get_post_meta($post -> ID, 'has_bourse', true) == 1 ) echo " checked"; ?>>
				<?php _e('Il y a une bourse pour ce séjour', 'rms_reservation'); ?>
			</label>
		</p>
		
<?php
		
	}// Fin rms_reservation_meta_opts_callback()

	function my_admin_notice()
	{
		//print the message
		global $post;
		
		if( $post != null )
		{
		
			$got_conflict = get_post_meta( $post -> ID, 'got_conflict', true );
			
			
			if ( !$got_conflict )
				return '';
			else
			{
				echo '<div id="message" class="error"><p><strong style="color:red">' . __('ATTENTION : conflit de dates !', 'rms_reservation') . '</strong></p></div>';
					
				delete_post_meta($post -> ID, 'got_conflict');
				
			}
		}
	}

	add_action('admin_notices', 'my_admin_notice',0);
	
	// Fonction appelée lors de la màj d'une réservation
	function pre_update_hook($id)
	{
		// Obtenir le post
		global $wpdb;
		$post = get_post($id);

		// Vérifier si il s'agit d'une réservation
		if( $post -> post_type == 'rms_reservation' )
		{
			//if( empty($_POST['fields']['field_536c862253a43']) )
		/*	//	update_post_meta($id, 'rms_reservation_status', 0);
					
			$startDate = $_POST['fields']['field_533d686591a5e'];// Date début
			$endDate = $_POST['fields']['field_533d68b31f200'];// Date fin
			
			// Vérifier conflit
			delete_post_meta($id, 'has_conflict');
			delete_post_meta($id, 'got_conflict');
		
			$blnConflict = false;
		
			$reservations_list = $wpdb->get_results("
				SELECT post_id FROM $wpdb->postmeta WHERE meta_key =  'rms_reservation_room' AND meta_value LIKE '%a:1:{i:0;s:3:\"" . $_POST['fields']['field_533d6bd3d9cc4'][0] . "\";}%' AND post_id != " . $id . " AND post_id IN (
				SELECT post_id
					FROM  $wpdb->postmeta
					WHERE (
						(
							meta_key =  'rms_reservation_start'
							AND meta_value >= " . $_POST['fields']['field_533d686591a5e'] . "
							AND meta_value <= " . $_POST['fields']['field_533d68b31f200'] . "
						)
						OR (
							meta_key =  'rms_reservation_end'
							AND meta_value >= " . $_POST['fields']['field_533d686591a5e'] . "
							AND meta_value <= " . $_POST['fields']['field_533d68b31f200'] . "
						)
						OR (
							(
								meta_key =  'rms_reservation_start'
								AND meta_value <= " . $_POST['fields']['field_533d686591a5e'] . "
							)
								AND (
								meta_key =  'rms_reservation_end'
								AND meta_value >= " . $_POST['fields']['field_533d68b31f200'] . "
							)
						)
					) GROUP BY post_id
					)
			");
				
			// Parcourir les réservations ayant des conflits
			foreach ( $reservations_list as $res_data )
			{
				// Vérifier que la réservation n'a pas été validée
				$res_status =  get_post_meta($res_data->post_id, 'rms_reservation_status', true);
				if( ( $res_status == 0 ) || ($res_status == 3) )
				{
					$blnConflict = true;
					
					update_post_meta($res_data->post_id, 'rms_reservation_status', 3);
					
					if( $res_data->post_id != $id )
						update_post_meta($res_data->post_id, 'has_conflict', true);
						
						//check_conflicts($res_data->post_id, $id);
						
				}// Finf()
				
			}// Fin foreach ( $reservations_list as $res_data )
			
			// Si il y a eu un conflit
			if($blnConflict)
			{
				$res_status =  get_post_meta($res_data->post_id, 'rms_reservation_status', true);
				
				if( ( $res_status == 0 ) || ($res_status == 3) )
					update_post_meta($id, 'rms_reservation_status', 3);
					
				update_post_meta($id, 'got_conflict', true);
				
				// Vérifier présence méta
				if( !get_post_meta($id, 'got_conflict', true))
				{
					$wpdb->insert( 
						$wpdb->postmeta, 
						array( 
							'post_id' => $id,
							'meta_key' => 'got_conflict', 
							'meta_value' => true 
						) 
					);
					
					if( ( $res_status == 0 ) || ($res_status == 3) )
					{
						$wpdb->insert( 
							$wpdb->postmeta, 
							array( 
								'post_id' => $id,
								'meta_key' => 'rms_reservation_status', 
								'meta_value' => 3 
							) 
						);
					}
				}// Fin if()
				
			}// Fin if( $blnConflict)
			*/
			
			update_user_meta($_POST['fields']['field_533d6b7fffca0'], 'user_lang', $_POST['lang']);
			update_post_meta($id, 'has_bourse', $_POST['rms_reservation_has_bourse']);
			update_post_meta($id, 'rms_reservation_start', $_POST['fields']['field_533d686591a5e']);
			update_post_meta($id, 'rms_reservation_end', $_POST['fields']['field_533d68b31f200']);
			
			// Vérifier email déjà envoyé
			if( !get_post_meta( $post -> ID, 'rms_reservation_email', true ) )
			{
				// Vérifier adresse email saisie
				if( $_POST['fields']['field_536c934dc6538'] != "")
				{
					
					$headers = 'From: Fondation Hardt <admin@extranet.ch>' . "\r\n";
					$attachments = array();
					
					// Parcourir les documents joints
					foreach ( $_POST['fields']['field_536c8ffa2490c'] as $name => $data)
					{
					
						foreach($data as $field => $file_id)
						{
						
							// Vérifier existence lien fichier
							if(  wp_get_attachment_url( $file_id ) )
								array_push($attachments,  WP_CONTENT_DIR . '/uploads/' . get_post_meta($file_id,'_wp_attached_file',true) );
						//	field_536cbf51bc36c
						}// Fin foreach()
						
					}// Fin foreach()
		
					$message = "";
					$mail_title = "";
					
					$user_lang = get_the_author_meta( 'user_lang', $_POST['fields']['field_533d6b7fffca0'] );
					
					if( !get_post_meta( $post -> ID, 'has_bourse', true ) )
					{
						// Parcourir langue
						switch ($user_lang)
						{

						case "fr":
							$mail_title = "Fondation Hardt /  Validation de votre séjour scientifique";
						break;

						default:
							$mail_title = "Hardt Fondation  / Confirmation of your research stay";
						break;

						}// Fin switch ($_POST['lang'])
					}
					else
					{
						// Parcourir langue
						switch ($user_lang)
						{

							case "fr":
								$mail_title = "Fondation Hardt / Confirmation d’attribution de bourse";
							break;

							default:
								$mail_title = "Hardt Foundation / Confirmation of bursary for a research stay";
							break;

						}// Fin switch ($_POST['lang'])
					}
					
				}
				$mail = get_the_author_meta( 'user_email', $_POST['fields']['field_533d6b7fffca0'] );
				
				$message = $_POST['fields']['field_536c86cc29766'];
				
				// parse message remove les slashes /
				$message = stripslashes_deep ( $message );
				
				// Mettre à jour le meta d'envoi d'email
				if( wp_mail( $mail, $mail_title, $message, $headers, $attachments) )
					update_post_meta( $post -> ID, 'rms_reservation_email', 1 );
				
			}// Fin if( !get_post_meta( $post -> ID, 'rms_reservation_email', true ) )
			
		}// Fin if( $post -> post_type == 'rms_reservation' )
	
	}

	add_action('pre_post_update', 'pre_update_hook');
	
	// Vérifier conflit sur réservation
	function check_conflicts($post_id)
	{
		global $wpdb;
		
		$start_date  = "";
		$end_date  = "";
		$room_id  = "";
		
		
		if( (isset($_POST['action'])) && ($_POST['action'] == 'add_reservation_new_user') )
		{// Accès depuis frontend
			$start_date = $wpdb->get_row("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key =  'rms_reservation_start' AND post_id = " . $post_id);
			$start_date = $start_date -> meta_value;
			
			$end_date = $wpdb->get_row("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key =  'rms_reservation_end' AND post_id = " . $post_id);
			$end_date = $end_date -> meta_value;
			
			$room_id = $_POST['room_id'];
		}
		elseif( ( isset($_POST) ) && ( $_POST['ID'] == $post_id) )
		{
		// Vérifier si données post sont pour la réservation courante
			
			// Utiliser données $_POST
			
			$start_date = $_POST['fields']['field_533d686591a5e'];
			
			$end_date = $_POST['fields']['field_533d68b31f200'];
			
			$arrRoom = $_POST['fields']['field_533d6bd3d9cc4'];
			
			$room_id = $arrRoom[0];
			
			update_post_meta($post_id, 'rms_reservation_start', $_POST['fields']['field_533d686591a5e']);
			update_post_meta($post_id, 'rms_reservation_end',  $_POST['fields']['field_533d68b31f200']);
			update_post_meta($post_id, 'rms_reservation_room', "a:1:{i:0;s:3:\"" . $_POST['fields']['field_533d6bd3d9cc4'][0] . "\";}");
		}
		else
		{
		
			$start_date = $wpdb->get_row("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key =  'rms_reservation_start' AND post_id = " . $post_id);
			$start_date = $start_date -> meta_value;
			
			$end_date = $wpdb->get_row("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key =  'rms_reservation_end' AND post_id = " . $post_id);
			$end_date = $end_date -> meta_value;
			
			$arrRoom = get_post_meta($post_id, 'rms_reservation_room', true);
			
			$room_id = $arrRoom[0];
			
		}
		
		$blnConflict = false;
		// Utiliser data post
		
		// Récupérer  toutes réservations aux mêmes données, sauf la courante pour éviter conflit sur elle-même
		$reservations_list = $wpdb->get_results("
		SELECT post_id FROM $wpdb->postmeta WHERE meta_key =  'rms_reservation_room' AND meta_value LIKE '%a:1:{i:0;s:3:\"" . $room_id . "\";}%' AND post_id != " . $post_id . " AND post_id IN (
			SELECT post_id
				FROM  $wpdb->postmeta
				WHERE (
					(
						meta_key =  'rms_reservation_start'
						AND meta_value >= " . $start_date . "
						AND meta_value <= " . $end_date . "
					)
					OR (
						meta_key =  'rms_reservation_end'
						AND meta_value >= " . $start_date . "
						AND meta_value <= " . $end_date . "
					)
					OR (
						(
							meta_key =  'rms_reservation_start'
							AND meta_value <= " . $start_date . "
						)
							AND (
							meta_key =  'rms_reservation_end'
							AND meta_value >= " . $end_date . "
						)
					)
				) GROUP BY post_id
				)
		");
		
		// Parcourir les réservations ayant des conflits
		foreach ( $reservations_list as $res_data )
		{
			$blnConflict = true;
			
			update_post_meta($res_data->post_id, 'got_conflict', true);
			
			// Vérifier que la réservation n'a pas été validée
			if( get_post_meta($res_data->post_id, 'rms_reservation_status', true) == 0 )
			{
				// Statuts de conflit
				update_post_meta($res_data->post_id, 'rms_reservation_status', 3);
				update_post_meta($res_data->post_id, 'has_conflict', true);
				delete_post_meta($res_data->post_id, 'got_conflict');
				
			}// Fin if()
			
		}// Fin foreach ( $reservations_list as $res_data )
		
		$currentReservationStatus = get_post_meta($post_id, 'rms_reservation_status', true);
		
		// si il n'y a pas eu de conflit
		if ( (!$blnConflict) ) {
			switch( intval($currentReservationStatus) ) {
				case 0 : // statut "en attente"
					// rien
					break;
				
				case 1 : // statut "refusé"
					// rien
					break;
				
				case 2 : // statut "accepté"
					// rien
					break;
				
				case 3 : // statut en "en attente conflit"
					// remise à "en attente"
					update_post_meta($post_id, 'rms_reservation_status', 0); 
					break;
				
				default : // par défaut, c'est une réservation en attente
					update_post_meta($post_id, 'rms_reservation_status', 0);
					break;
			}
			
			// supprime les infos de conflits si existant
			delete_post_meta($post_id, 'got_conflict');
			delete_post_meta($post_id, 'has_conflict');
		
		}// if
		else { // sinon il y a eu un conflit
			
			switch( intval($currentReservationStatus) ) {
				case 0 : // statut "en attente"
					// Statuts de conflit
					update_post_meta($post_id, 'rms_reservation_status', 3);
					break;
				
				case 1 : // statut "refusé"
					// rien
					break;
					
				case 2 : // statut "accepté"
					// rien
					break;
				
				case 3 : // statut en "en attente conflit"
					// rien
					break;
				
				default : // par défaut, c'est une réservation "en attente conflit"
					update_post_meta($post_id, 'rms_reservation_status', 3);
					break;
			}
			
			// indique l'état de conflit
			update_post_meta($post_id, 'has_conflict', true);
			update_post_meta($post_id, 'got_conflict', true);
		
		
			if( ($blnConflict) && ( get_post_meta($post_id, 'rms_reservation_status', true) == 0 ) )
			{// Cas post courant
			
					
			}// Fin if()
		} // else
	}// Fin check_conflicts()
	
	// Fonction appelée lors de la màj d'une réservation
	function post_update_hook($id)
	{
		// Obtenir le post
		global $wpdb;
		$post = get_post($id);
		// Vérifier si il s'agit d'une réservation
		if( $post -> post_type == 'rms_reservation' )
		{
			$myposts = get_posts('post_type=rms_reservation&posts_per_page=-1');
			foreach ( $myposts as $check_post )
			{
				
				check_conflicts($check_post -> ID);
			}
			
			$myposts2 = get_posts('post_type=rms_reservation&posts_per_page=-1');
			foreach ( $myposts2 as $check_post1 )
			{
				
				check_conflicts($check_post1 -> ID);
			}
		//	die();
		}
	}
	
	add_action('post_updated', 'post_update_hook');
	// Filtre avant la mise à la corbeille d'un poste
	function pre_trash_hook ($post_id)
	{
		$post_type = get_post_type( $post_id );
		
		// Vérifier post_type
		if( $post_type == 'rms_reservation' )
		{
			
			global $wpdb;
			
			$delete_postmeta = $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE post_id = %d", $post_id ) );
			
			wp_delete_post( $post_id, true );
			
		
		}// Fin if( $post_type == 'rms_reservation' )
		
	}// Fin pre_trash_hook()
	
	add_action('wp_trash_post', 'pre_trash_hook');
	
	// Filtre de supression des utilisateurs
	function pre_delete_user_hook( $user_id )
	{
	
		// Vérifier utilisateur hôte
		if( user_can($user_id, 'hardt_host') )
		{

			global $wpdb;
				
			$res_from_user_list = $wpdb -> get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key =  'rms_reservation_client' AND meta_value = " . $user_id);

			// Parcourir les réservations ayant des conflits
			foreach( $res_from_user_list as $res_data )
			{
			
				$delete_postmeta = $wpdb -> query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE post_id = %d", $res_data -> post_id ) );
				
				wp_delete_post( $res_data -> post_id, true );
			
			}// Fin foreach( $res_from_user_list as $res_data )
		
		}// if( user_can($user_id, 'hardt_host') )
		
	}// pre_delete_user_hook()
	
	add_action( 'delete_user', 'pre_delete_user_hook' );

	// rms_reservation_deactivation(),
	function rms_reservation_deactivation()
	{
		// Supprimer le rôle
		remove_role('hardt_admin');
		
		// Supprimer le rôle
		remove_role('hardt_host');
		
		// Role administrator
		$role = get_role( 'administrator' );
		// Supprimer la capacite
		$role->remove_cap( 'hardt_access' ); 
		
	}// Fin rms_reservation_deactivation()
	
	// Reordonner le menu
	function custom_admin_menu_order() 
	{
		// Retourner le menu
		return array(
			'rooms-reservation',
			'users.php',
			'index.php',
			'edit.php?post_type=page',
			'upload.php'
		);
	}// Fin custom_admin_menu_order()
	
	// Alléger le menu de navigation de l'admin
	function custom_admin_menus()
	{
		// Controler admin hardt
		if ( current_user_can('hardt_admin') ) 
		{
			// Supprimer les pages non désirées
			remove_menu_page( 'index.php' ); 
			//remove_menu_page( 'edit.php' );
			remove_menu_page( 'edit-comments.php' );
			remove_menu_page( 'themes.php' );
			remove_menu_page( 'plugins.php' );
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'options-general.php' );
			
		}// Fin if(current_user_can)
		
		// Afficher le plugin dans le menu, 1st position
		add_menu_page('Rooms Reservation', 'Réservation des chambres', 'hardt_access', 'rooms-reservation', 'rms_reservations', 'dashicons-admin-home', 1);
		add_submenu_page('rooms-reservation', __("Réservation des chambres", "rooms_reservation"), __("Réservation des chambres", "rooms_reservation"), 'hardt_access', 'rooms-reservation');
		add_submenu_page('rooms-reservation', __("Calendrier", "rooms_reservation"), __('Calendrier'), 'hardt_access', 'rooms-reservation-calendar', 'rms_calendar'); 
		add_submenu_page('rooms-reservation', __("Archives", "rooms_reservation"), __('Archives'), 'hardt_access', 'rooms-reservation-archives', 'rms_archives'); 
		add_submenu_page('rooms-reservation', __('Exporter'), __('Exporter'), 'hardt_access', 'rooms-reservation-export', 'rms_export'); 
		
	}// Fin custom_admin_menus()

	// Afficher le menu
	add_action( 'admin_menu', 'custom_admin_menus' );
	add_filter( 'custom_menu_order', '__return_true' );
	add_filter( 'menu_order', 'custom_admin_menu_order' );
	
	
	// Liste des champs de formulaire
	function user_custom_fields()
	{
		// tableau des champs
		$arrFields = array(
			// General user infos
			array(__("Prénom", "rms_reservation") ,  __("General"), "first_name","text"),
			array(__("Nom", "rms_reservation"),  __("General"), "last_name","text"),
			array(__("Date de naissance", "rms_reservation"), __("General"), "birthday","text"),
			array(__("Sexe", "rms_reservation"),  __("General"), "sex","radio"),
			array(__("Nationalité", "rms_reservation"), __("Contact"), "nationality","text"),
			array(__("Adresse mail", "rms_reservation"), __("Contact"), "email","text"),
			array(__("Adresse postale", "rms_reservation"),  __("Contact"), "street","text"),
			array(__("Numéro de rue", "rms_reservation"),  __("Contact"), "number","text"),
			array(__("Code postal", "rms_reservation"),  __("Contact"), "postal","text"),
			array(__("Ville", "rms_reservation"),  __("Contact"), "city","text"),
			array(__("Code ISO", "rms_reservation"), __("Contact"), "iso","text"),
			array(__("Téléphone 1", "rms_reservation"), __("Contact"), "phone_1","text"),
			array(__("Téléphone 2", "rms_reservation"),  __("Contact"), "phone_2","text"),
			array(__("Titre(s) universitaire(s)", "rms_reservation"), __("Etudes"), "university_title", "text"),
			array(__("Affiliation Institutionnelle", "rms_reservation"), __("Etudes"), "affiliation", "text"),
			array(__("Fonction actuelle", "rms_reservation"), __("Etudes"), "function", "text"),
			array(__("Références", "rms_reservation"), __("Etudes"), "references", "text"),
			array(__("Thème de la recherche durant le séjour", "rms_reservation"),__("Etudes"), "theme", "textarea"),
			array(__("Régimes/allergies", "rms_reservation"),__("General"), "regime","textarea")
		);
		
		// Retourner le tableau
		return $arrFields;
	}// Fin user_custom_fields()
	
	// Liste des champs de l'inscription
	function reservation_custom_fields()
	{
		// tableau des champs
		$arrFields = array(
			// General reservation infos
			array("Numéro de réservation", "General", "text"),
			array("Date de l'arrivée", "General", "text"),
			array("Date de départ",  "General", "text"),
			array("Chambre",  "General", "text"),
			array("Type",  "General", "radio"),
			array("Adresse mail de facturation",  "Facturation", "text"),
			array("Adresse de facturation",  "Facturation", "text"),
			array("Numéro de rue",  "Facturation", "text"),
			array("Ville",  "Facturation", "text"),
			array("Code postal",  "Facturation", "text"),
			array("Code ISO",  "Facturation", "text"),
			array("Téléphone 1",  "Facturation", "text"),
			array("Téléphone 2",  "Facturation", "text"),
			// Fields for the files
			array(__("Conditions", "rms_reservation"),  __("Documents"), "file"),
			array(__("Cover Letter", "rms_reservation"),  __("Documents"), "file"),
			array(__("Curriculum Vitae", "rms_reservation"),  __("Documents"), "file"),
			array(__("Research Proposal", "rms_reservation"),  __("Documents"), "file"),
			array(__("Recommandation Letter 1", "rms_reservation"),  __("Documents"), "file"),
			array(__("Recommandation Letter 2", "rms_reservation"), __("Documents"), "file"),
			array(__("Copy of passport / ID Card", "rms_reservation"),  __("Documents"), "file"),
			array(__("Carreer plans", "rms_reservation"), __("Documents"), "textarea")
		);
		
		// Retourner le tableau
		return $arrFields;
	}// Fin reservation_custom_fields()
	
	// Afficher page de reservation
	function rms_reservations()
	{
	
		// Appeler la vue
		// Verifier si chambre choisie
		if(isset($_GET['view_res']))
		{
		
			// Afficher réservation complète (+document)
			require_once(dirname(__FILE__) . '/views/res-details.php');
		
		}
		else
		{
			// Afficher page generale
			require_once(dirname(__FILE__) . '/views/reservation.php');
		}
		
		
	}// Fin rms_reservations()
	
	// Afficher page calendrier
	function rms_calendar()
	{
	
		// Charger styles et scripts specifiques
		wp_enqueue_style('rms_fullcalendar_css', plugins_url('/rooms-reservation/css/fullcalendar.css'),'','','all');
		wp_enqueue_style('rms_fullcalendar_print_css', plugins_url('/rooms-reservation/css/fullcalendar.print.css'),'','','print');
		
		wp_enqueue_script('rms_fullcalendar_js', plugins_url('/rooms-reservation/js/fullcalendar.min.js'));
		
		// Appeler vue
		require_once(dirname(__FILE__) . '/views/calendar.php');
		
	}// Fin rms_calendar()
	
	// Afficher page archive
	function rms_archives()
	{
		
		// Appeler la vue
		require_once(dirname(__FILE__) . '/views/archives.php');
		
	}// Fin rms_archive()
	
	
	// Afficher page export
	function rms_export()
	{
		
		// Appeler la vue
		require_once(dirname(__FILE__) . '/views/export.php');
		
	}// Fin rms_export()
	
	add_action( 'profile_update', 'my_profile_update', 10, 2 );

    function my_profile_update( $user_id, $old_user_data )
	{
		
		$userFieldArray = array(
			"first_name",
			"last_name",
			"birthday",
			"nationality",
			"email",
			"street",
			"number",
			"postal",
			"city",
			"iso",
			"phone_1",
			"phone_2",
			"university_title",
			"affiliation",
			"function",
			"references",
			"theme",
			"regime"
		);	
		
		/*
		$userFieldArray = array(
			"first_name",
			"last_name",
			"birthday",
			"sex",
			"nationality",
			"email",
			"street",
			"number",
			"postal",
			"city",
			"iso",
			"phone_1",
			"phone_2",
			"university_title",
			"affiliation",
			"function",
			"references",
			"theme",
			"regime"
		);
		*/
		
		
		// Parcourir les champs à mettre à jour
		foreach($userFieldArray as $field_name)
		{
			// Mettre à jour les metas de l'utilisateur
			update_user_meta( $user_id, $field_name, $_POST[$field_name] );
		}
		
		// cas particulier pour sex
		
		// Si il y a des documents à uploader
		$user_uid = get_user_meta ( $user_id, 'user_uid',true);
		// si le $user_uid est vide, on en crée un
		if($user_uid == '') {
			$user_uid = 'uid_' . sha1(time());
			// update user uid
			update_user_meta( $user_id, "user_uid", $user_uid );
		}
			
			
		$outputFileData = get_option($user_uid);
		
		
		if($outputFileData == false)
			$outputFileData = '';
		foreach($_FILES["upload"]["name"] as $key => $filename)
		{
			//var_dump($file);
			$upld_file = wp_upload_bits( clean_string2($filename), null, @file_get_contents( $_FILES["upload"]['tmp_name'][$key] ) );
			
			if ( FALSE === $upld_file['error'] )
			{	
				// Ajouter meta du document à l'utilisateur
				$outputFileData .= $upld_file['url'] . "|";
			}
			
		}
		// met à jour l'option avec les files
		update_option($user_uid , $outputFileData);
		
    }
	
	function my_acf_load_field( $field )
	{
		global $post;
		
		$user_data = get_field('rms_reservation_client', $post -> ID);
		 
		// Correction Bug offset 'ID' undefined
		$user_data_id = 0;
		if(isset($user_data['ID']))
			$user_data_id = $user_data['ID'];
		else
			$user_data_id = $user_data;
						
		$user_lang = get_user_meta( $user_data_id,'user_lang', true);
			
		if( !get_post_meta( $post -> ID, 'has_bourse', true ) )
						{
							// Parcourir langue
							switch ($user_lang)
							{
						
						case "fr":
	$field['default_value']  = "La Fondation Hardt pour l’étude de l’Antiquité classique a le plaisir de confirmer votre inscription à un séjour d’étude scientifique.
	Vous trouverez en pièces jointes la lettre de confirmation et le décompte de votre participation aux frais de séjour.
	Des informations pratiques sur la Fondation et sur votre voyage jusqu’à Vandœuvres sont disponibles ici : ".get_bloginfo("wpurl")."?page_id=1166 .
	Afin que nous puissions vous accueillir dans les meilleures conditions, nous vous prions de bien vouloir nous communiquer en temps voulu votre heure approximative d’arrivée et le moyen de transport prévu pour atteindre la Fondation à admin@fondationhardt.ch
	Si vous avez des questions concernant votre prochain séjour, n’hésitez pas à nous contacter.
	Nous vous remercions de votre intérêt pour la Fondation Hardt et nous réjouissons de vous accueillir prochainement.

	Avec nos remerciements et nos salutations les meilleures,
	Fondation Hardt
	";
							break;
							
							default:
	$field['default_value']  = "We are pleased to confirm your registration for a research stay at the Hardt Foundation.
	Please find here attached your letter of confirmation and invoice.
	Practical information about the Hardt Foundation as well as travelling to Vandœuvres is available here: ".get_bloginfo("wpurl")."?page_id=1166 .
	In order for us to welcome you as well as possible, please let us know the scheduled date and time of your arrival and the means of transport you will use to get to the Foundation at admin@fondationhardt.ch
	Do not hesitate to contact us if you have any inquiry concerning your future stay.
	We thank you very much for your interest in the Hardt Foundation and look forward to welcoming you soon.

	Best wishes,

	Hardt Foundation
	";
								break;
								
							}// Fin switch ($_POST['lang'])
						}
						else
						{
							// Parcourir langue
							switch ($user_lang)
							{
						
						case "fr":
	$field['default_value']  = "Nous avons le plaisir de vous annoncer qu’une bourse vous a été attribuée pour un séjour d’étude scientifique à la Fondation Hardt.
	Vous trouverez en pièce jointe votre lettre d’invitation.
	Des informations pratiques sur la Fondation et sur votre voyage jusqu’à Vandœuvres sont disponibles ici : ".get_bloginfo("wpurl")."?page_id=1166 .
	Afin que nous puissions vous accueillir dans les meilleures conditions, nous vous prions de bien vouloir nous communiquer en temps voulu votre heure approximative d’arrivée et le moyen de transport prévu pour atteindre la Fondation à admin@fondationhardt.ch
	Si vous avez des questions concernant votre prochain séjour, n’hésitez pas à nous contacter.
	Nous vous remercions de votre intérêt pour la Fondation Hardt et nous réjouissons de vous accueillir prochainement.

	Avec nos remerciements et nos salutations les meilleures,
	Fondation Hardt
	";
							break;
							
						default:
	$field['default_value']  = "We are pleased to inform you that you have been granted a bursary for a research stay at the Hardt Foundation.
	Please find here attached your letter of confirmation.
	Practical information about the Hardt Foundation as well as travelling to Vandœuvres is available here: ".get_bloginfo("wpurl")."?page_id=1166 .
	In order for us to welcome you as well as possible, please let us know the scheduled date and time of your arrival and the means of transport you will use to get to the Foundation at admin@fondationhardt.ch
	Do not hesitate to contact us if you have any inquiry concerning your future stay.
	We thank you very much for your interest in the Hardt Foundation and look forward to welcoming you soon.

	Best wishes,

	Hardt Foundation
	";
							break;
							
							}// Fin switch ($_POST['lang'])
						}
		// Important: return the field
		return $field;
	}
 
 
	// v4.0.0 and above
	add_filter('acf/load_field/name=custom_text', 'my_acf_load_field');

	// Modifier titre par défaut post type custom
	function my_default_title_filter()
	{
	
		if( $_GET['post_type'] == 'rms_reservation' )
		{
		
			return 'Sej'. date( "dm", time() ) . substr( chr( mt_rand( 97 ,122 ) ) .substr( md5( time( ) ) ,1 ), 0, 3);
			
		}
		
	}

	add_filter('default_title', 'my_default_title_filter');
	
	// requête Ajax pour supprimer un document depuis le backend
	add_action( 'wp_ajax_deleteDocument', 'rms_deleteDocument' );
	function rms_deleteDocument() {
		$deletedDocumentUrl = $_POST["url"];
		$user_id = $_POST["user_id"];
		
		// Delte from bibliotheque
		$documentID = pn_get_attachment_id_from_url( $deletedDocumentUrl );
		if($documentID != null)
			wp_delete_attachment( $attachmentid, true );
			
			
		// delete from user attachement
		$user_uid = get_user_meta ( $user_id, 'user_uid',true);
		$outputFileData = get_option($user_uid);
		$documents = explode("|", $outputFileData);
		$savedFiles = '';
		
		foreach($documents as $document) {
			// si le document n'est pas vide
			if($document != '') {
				// on ne sauve que les documents qui ne correspondent pas à l'url transmises
				if( $document != $deletedDocumentUrl) {
					$savedFiles .= $document.'|';
				}// if
			}// if
			
		}// foreach
		// met à jour l'option avec les files
		update_option($user_uid , $savedFiles);
		
		die();
	}// function
	
	// Permet de récupérer l'id de l'attachement par son url
	function pn_get_attachment_id_from_url( $attachment_url = '' ) {
 
		global $wpdb;
		$attachment_id = false;
	 
		// If there is no url, return.
		if ( '' == $attachment_url )
			return;
	 
		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();
	 
		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
	 
			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
	 
			// Remove the upload path base directory from the attachment URL
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
	 
			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	 
		}
	 
		return $attachment_id;
	}
	
	// supprime les caractères spéciaux
	function clean_string2($string)
	{
		$string = htmlentities($string, ENT_QUOTES, 'UTF-8');
		$string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$string = preg_replace(array('~[^0-9a-z.]~i', '~[ -]+~'), '_', $string);

		return trim($string, ' -');
	}
?>