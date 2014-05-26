<?php
	// Vue de la page des archives
	class rmsReservation_datatable extends WP_List_Table 
	{

		// Fonction de remplacemenent à WP_List_Table::single_row
		function single_row($data)
		{
			global $post, $comment;

			$comment = $data;
			$the_comment_class = join( ' ', get_comment_class( wp_get_comment_status( $comment->comment_ID ) ) );

			$post = get_post($comment->comment_post_ID);
			
			// Ajouter classe statut réservation
			$rowClass = ( $data['state'] == 0 ) ? 'pending' : ( ( $data['state'] == 1 ) ? 'allowed' : 'declined') ;

			echo "<tr id='comment1-$comment->comment_ID' class='$rowClass'>";
			echo $this->single_row_columns( $comment );
			echo "</tr>\n";
		}
		
		// Init
		function __construct(){
			global $status, $page;
					
			// Constructeur
			parent::__construct( array(
				'singular'  => 'slider', 
				'plural'    => 'sliders', 
				'ajax'      => false 
			));
		}
		
		// Fonction de tri
		function sort_data( $a, $b )
		{
			// Set defaut
			$orderby = 'state';
			$order = 'asc';

			// Si orderby defini l'utiliser pour trier
			if( !empty( $_GET['orderby'] ) )
			{
				$orderby = $_GET['orderby'];
			}

			// Si order est defini l'utiliser
			if( !empty( $_GET['order'] ) )
			{
				$order = $_GET['order'];
			}

			$result = strcmp( $a[$orderby], $b[$orderby] );

			if( $order === 'asc' )
			{
				return $result;
			}

			return -$result;
		}// Fin sort_data
		
		// Appelé quand classe parent ne trouve pas de methode pour la colonne
		function column_default($item, $column_name)
		{
			switch($column_name){
				case 'hote': case 'dates': case 'room': case 'state':
					return $item[$column_name];
				default:
					return print_r($item,true);// debug
			}
		}

		// Afficher la colonne des titres
		function column_title($data)
		{
			// Action de ligne
			$actions = array(
				'rms_detail_reservation' => '<a href="admin.php?page=rooms-reservation&view_res=' . $data['id'] . '">' . __('Voir le détail', 'rms_reservation') . '</a>',
			);
			
			// Retourner le titre
			return sprintf('<a href="admin.php?page=rooms-reservation&view_res=%2$s">%1$s</a>',
				/*$1%s*/ $data['title'],
				/*$2%s*/ $data['id']
			);
		}// Fin column_title()
		
		// Afficher colonne statut
		function column_state($data)
		{
			$strOutput =  ( $data['state'] == 0 ) ? 'En attente' : ( ( $data['state'] == 1 ) ? __('Accepté', 'rms_reservation') : __('Refusé', 'rms_reservation'));
			
			// Verifier email de confirmation envoyé
			if(!$data['email'])
				$strOutput .= __(' - Aucun email n\'a été envoyé', 'rms_reservation');
				
			return $strOutput;
			
		}// Fin column_state()
		
		// Afficher colonne hôte
		function column_hote ($data)
		{
			$user_info = get_userdata($data['hote']);
			$username = $user_info->user_nicename;
			
			return '<a href="' . get_edit_user_link($data['hote']) . '">' . $username . '</a>';
		
		}// Fin column_hote()
		
		// Obtenir les colonnes
		function get_columns(){
			$columns = array(
				'title'     => __('Séjour N°', 'rms_reservation'),
				'hote'    => __('Hôte', 'rms_reservation'),
				'dates'    => __('Dates', 'rms_reservation'),
				'room'    => __('Chambre', 'rms_reservation'),
				'state' => __( 'Etat', 'rms_reservation')
			);
			return $columns;
		}


		// Rend les colones triables
		function get_sortable_columns() 
		{
			$sortable_columns = array(
				'title'     => array('title',false),//true = deja trié
				'hote'     => array('hote',false),
				'dates'     => array('dates',false),
				'room'     => array('room',false),
				'state'     => array('state',false),
			);
			
			return $sortable_columns;

		}// Fin get_sortable_columns()


		// Preparer les donnees
		function prepare_items() 
		{
			global $wpdb;
			global $post;

			// Nombre d'enregistrements par page
			$per_page = 10;
			
			
			// Init les entetes de colonnes
			$columns = $this->get_columns();
			$hidden = array();
			$sortable = $this->get_sortable_columns();
			
			
			// Generer les headers
			$this->_column_headers = array($columns, $hidden, $sortable);
			
			$data = array();
			
			// Obtenir la liste des réservations
			$args = array( 'post_type' => 'rms_reservation', 'posts_per_page' => 10, 'post_status' => 'rms_res_archived' );
			$loop = new WP_Query( $args );
			
			while ( $loop->have_posts() )
			{			
				$loop->the_post();
				
				$post_author_id = get_post_field( 'post_author', get_the_ID() );
				
				$dates = date( "d.m.Y", strtotime( get_field('rms_reservation_start') ) ) . ' - ' . date( "d.m.Y", strtotime( get_field('rms_reservation_end') ) );
				
				$status = get_post_meta( get_the_ID(), 'rms_reservation_status', true );
				
				$email = get_post_meta( get_the_ID(), 'rms_reservation_email', true );
				
				$roomArrayId = get_field('rms_reservation_room');
				
				$roomData = get_post($roomArrayId[0]);
				
				$roomNumber = get_post_meta( $roomData -> ID, 'rms_room_number', true );
				
				$roomLink = '<a href="' . get_edit_post_link($roomData -> ID) . '">' . $roomNumber . ' / ' . $roomData -> post_title . '</a>';
				
				$data[] = array('id' => get_the_ID(), 'title' => get_the_title(), 'hote' =>  $post_author_id, 'dates' => $dates, 'room' => $roomLink , 'state'=> $status, 'email' => $email);
				

			}// Fin while()

			// Charger données triées
			usort( $data, array( &$this, 'sort_data' ) );
			
			$this->items = $data;
					
			$current_page = $this->get_pagenum();
			
			$total_items = count($this->items);

			// only ncessary because we have sample data
			$this->found_data = array_slice( $this->items,( ($current_page-1)*$per_page ), $per_page );

			$this->set_pagination_args(
				array(
					'total_items' => $total_items,
					'per_page'    => $per_page
				)
			);
			
			$this->items = $this->found_data;
			
			// Creer la pagination
			$this->set_pagination_args( array(
				'total_items' => $total_items, 
				'per_page'    => $per_page,
				'total_pages' => ceil($total_items/$per_page)
			) );
		}


	}// Fin classe rmsReservation_datatable

    // Charger la table de donnees
    $rmsTable = new rmsReservation_datatable();
    $rmsTable->prepare_items();
    
?>

<div class="wrap rms_reservation">
	<h2>
		<?php _e( 'Archives des réservations', 'rms_reservation' ); ?>
	</h2>
	
	<div class="rms_page_descr">
		<?php _e( 'Consulter la liste des réservations archivées', 'rms_reservation' ); ?>
	</div>
	
	<div class="tableLegend">
		<div class="label">
			<div class="declined"></div> = <?php _e('Réservation refusée', 'rms_reservation'); ?>
			<div class="pending"></div> = <?php _e('Réservation en attente', 'rms_reservation'); ?>
			<div class="allowed"></div> = <?php _e('Réservation acceptée', 'rms_reservation'); ?>
		</div>
	</div>
	
	<form method="post">
		<input type="hidden" name="page" value="my_list_test" />
		<p class="search-box" style="margin-bottom:5px;">
			<label class="screen-reader-text" for="search_id-search-input">
				search:
			</label> 
			
			<input id="search_id-search-input" type="text" name="s" value="" /> 
			<input id="search-submit" class="button" type="submit" name="" value="<?php _e('Rechercher', 'rms_reservation'); ?>" />
		</p>
	</form>
	
	<form id="reservation-list" method="get">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<?php $rmsTable->display();?>
	</form>	
	
	<div class="tableLegend">
		<div class="label">
			<div class="declined"></div> = <?php _e('Réservation refusée', 'rms_reservation'); ?>
			<div class="allowed"></div> = <?php _e('Réservation acceptée', 'rms_reservation'); ?>
			<div class="pending"></div> = <?php _e('Réservation en attente', 'rms_reservation'); ?>
		</div>
	</div>
</div>