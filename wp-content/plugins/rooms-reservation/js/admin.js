(function($) {	
//$('input#publish').hide();
if( typeof local_text != 'undefined')
{

	var lang_index = local_text.lang;
	var bourse_index = local_text.bourse;
	
}
else
{

	var lang_index, bourse_index = null;
	
}

	// Fonction d'affichage du nombre de nuitées
	jQuery('#acf-rms_reservation_start input[type=text], #acf-rms_reservation_end input[type=text]').change(function(){

		// Afficher le nombre de nuitées
		getnights();
		
	});

	// Fonction pouer afficher le nombre de nuitées
	function getnights()
	{
		// Vérifier présence 2 valeurs
		if( (jQuery("#acf-rms_reservation_start input").val() != "") && ( jQuery("#acf-rms_reservation_end input").val() != "") )
		{
			
			var arrStartDate = jQuery("#acf-rms_reservation_end input[type=text]").val().split('/');
			var arrEndDate = jQuery("#acf-rms_reservation_start input[type=text]").val().split('/');
		
			// Afficher la valeur dans le champs prévu
			jQuery("#rms_reservation_nigths").val( ( new Date(arrStartDate[2], arrStartDate[1]-1, arrStartDate[0] ) - new Date( arrEndDate[2], arrEndDate[1]-1, arrEndDate[0]) ) / 1000 / (60 * 60 * 24) );
			
		}// Fin if()
			
	}// Fin getnights()

	// Fonction de calcul du coût total du séjour
	jQuery('.get_res_price').click(function(e){
		e.preventDefault();
		
		// Vérifier id chambre
		if ( jQuery.isNumeric( jQuery('.relationship_right li a').attr('data-post_id') ) )
		{
			// Vérifier nombre nuit numérique
			if ( jQuery.isNumeric( jQuery("#rms_reservation_nigths").val() ) )
			{
				
				var selectedRoomId = rms_reservation_cost_data.room_id;
				if(selectedRoomId == '' || selectedRoomId == undefined || isNaN(selectedRoomId)){
					selectedRoomId = jQuery("#acf-rms_reservation_room")
						.find(".relationship_right").first()
						.find("a").first()
						.data("post_id");
				}
								
				var data ={ action: "admin_get_single_room_data", room_id: selectedRoomId, user_id: jQuery('#acf-field-rms_reservation_client').val(), nights:jQuery("#rms_reservation_nigths").val(), sale: jQuery('#rms_reservation_sale').val()};
				
				jQuery.post(rms_reservation_data.ajax_url, data, function(data)
				{
					
					jQuery('#rms_reservation_cost').val(data);
					
					jQuery('input#publish').show();
				});
			}
			else
			{	
			
				// Afficher prix 0
				jQuery("#rms_reservation_cost").val("0");
				
			}// Fin if()
			
		}
		else
			alert('Wrong room id');
	
	});// Fin function()
	
	// Action checkbox bourse edition reservations
	jQuery("#rms_reservation_has_bourse").click(function()
	{
		bourse_index = (jQuery(this).is(':checked') ? 1 : 0);
		
		// Mettre à jour le texte de l'email
		get_mailText();
		
		// Modifier le titre si boursier
		if(bourse_index)
		{
		
			jQuery('input#title').val('B_' + jQuery('input#title').val());
			
		}
		else
		{
			jQuery('input#title').val(jQuery('input#title').val().slice(2));
		}

	});
	
	// Action liste déroulante langue utilisateur edition reservation
	jQuery("#rms_user_lang").change(function(){
	
		lang_index = jQuery(this).val();
		
		// Mettre à jour le texte de l'email
		get_mailText();
		
	});
	
	// Changement de l'hôte
	$("#acf-field-rms_reservation_client").change(function(){
		
		// Mettre à jour le texte de l'email
		get_mailText();
		
	});
	
	// Mettre à jour le texte de l'email de confirmation
	function get_mailText()
	{
	
		jQuery.post(ajaxurl, {
			action: "user_get_mail",
			"has_bourse": bourse_index,
			"mail_lang": lang_index,
			"user_id": $("#acf-field-rms_reservation_client").val()
		}, function( data ) {
			// Mettre à jour le message
			
			tinyMCE.activeEditor.setContent( data );
		});
		
	}// Fin get_mailText()
	
	// Changer texte lien suppression
	if( jQuery('.post-type-rms_reservation a.submitdelete').text() == "Move to Trash" )
	{
	
		jQuery('.post-type-rms_reservation a.submitdelete').text('Delete permanently');
		
	}
	else
	{
	
		jQuery('.post-type-rms_reservation a.submitdelete').text('Supprimer le séjour');
		
	}
	
	// Datepicker pour export
	jQuery( "#export_fromdate, #export_todate" ).datepicker({
		changeMonth: true,
		dateFormat: 'dd.mm.yy',
		onSelect: function( selectedDate ) {
		
			if( this.id == 'export_fromdate' ){
			
				var dateMin = jQuery('#export_fromdate').datepicker("getDate");
				var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 1); 
				jQuery('#export_todate').datepicker("option","minDate",rMin);
			
			}
		
		}
	});
	
	// Action au clic sur lien d'export de la liste 2
	jQuery('#export_list2_link').click(function(e){
	
		e.preventDefault();
		
		jQuery('.export_list2_dateselector').slideToggle();
		
	});
	
	// Action au clic sur le bouton d'export de la liste 2
	jQuery('#list2_export_submit').click(function(e){
	
		e.preventDefault();
		
		var fromDate = jQuery('#export_fromdate').val();
		var toDate = jQuery('#export_todate').val();
		
		window.location.href = jQuery('#export_list2_link').attr('href') +'?from=' + fromDate + '&to=' + toDate;
	
	});
	
	// Reformater date tableau liste réservations
	jQuery('td.date_res.column-date_res').each(function(){
		var data_date = new Date(jQuery(this).text()*1000);
		
		var year = data_date.getFullYear();
		var month = data_date.getMonth() + 1;
		var day = data_date.getDate();
		var hours = data_date.getHours();
		var minutes = data_date.getMinutes();
		
		jQuery(this).text(("0" + day).slice(-2) + "." + ("0" + month).slice(-2) + "." + year + " à " + ("0" + hours).slice(-2) + "h" + ("0" + minutes).slice(-2));
	});
	
	jQuery('span.timestamp_date_jq').each(function(){
		var data_date = new Date(jQuery(this).text()*1000);
		
		var year = data_date.getFullYear();
		var month = data_date.getMonth() + 1;
		var day = data_date.getDate();
		
		jQuery(this).text(("0" + day).slice(-2) + "." + ("0" + month).slice(-2) + "." + year);
	});
	
	
})(jQuery);	


