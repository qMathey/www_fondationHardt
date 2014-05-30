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

var array_fr = ["La Fondation Hardt pour l’étude de l’Antiquité classique a le plaisir de confirmer votre inscription à un séjour d’étude scientifique.<br/>"+
	"Vous trouverez en pièces jointes la lettre de confirmation et le décompte de votre participation aux frais de séjour.<br/>"+
	"Des informations pratiques sur la Fondation et sur votre voyage jusqu’à Vandœuvres sont disponibles ici : http://www.fondationhardt.ch/?page_id=1166 .<br/>"+
	"Afin que nous puissions vous accueillir dans les meilleures conditions, nous vous prions de bien vouloir nous communiquer en temps voulu votre heure approximative d’arrivée et le moyen de transport prévu pour atteindre la Fondation à admin@fondationhardt.ch<br/>"+
	"Si vous avez des questions concernant votre prochain séjour, n’hésitez pas à nous contacter.<br/>"+
	"Nous vous remercions de votre intérêt pour la Fondation Hardt et nous réjouissons de vous accueillir prochainement.<br/>"+
"<br/>"+
	"Avec nos remerciements et nos salutations les meilleures,<br/>"+
	"Fondation Hardt",
	"Nous avons le plaisir de vous annoncer qu’une bourse vous a été attribuée pour un séjour d’étude scientifique à la Fondation Hardt.<br/>"+
	"Vous trouverez en pièce jointe votre lettre d’invitation.<br/>"+
	"Des informations pratiques sur la Fondation et sur votre voyage jusqu’à Vandœuvres sont disponibles ici : http://www.fondationhardt.ch/?page_id=1166 .<br/>"+
	"Afin que nous puissions vous accueillir dans les meilleures conditions, nous vous prions de bien vouloir nous communiquer en temps voulu votre heure approximative d’arrivée et le moyen de transport prévu pour atteindre la Fondation à admin@fondationhardt.ch<br/>"+
	"Si vous avez des questions concernant votre prochain séjour, n’hésitez pas à nous contacter.<br/>"+
	"Nous vous remercions de votre intérêt pour la Fondation Hardt et nous réjouissons de vous accueillir prochainement.<br/>"+
"<br/>"+
	"Avec nos remerciements et nos salutations les meilleures,<br/>"+
	"Fondation Hardt"];
var array_en = [	
	"We are pleased to confirm your registration for a research stay at the Hardt Foundation.<br/>"+
	"Please find here attached your letter of confirmation and invoice.<br/>"+
	"Practical information about the Hardt Foundation as well as travelling to Vandœuvres is available here: http://www.fondationhardt.ch/?page_id=1166 .<br/>"+
	"In order for us to welcome you as well as possible, please let us know the scheduled date and time of your arrival and the means of transport you will use to get to the Foundation at admin@fondationhardt.ch<br/>"+
	"Do not hesitate to contact us if you have any inquiry concerning your future stay.<br/>"+
	"We thank you very much for your interest in the Hardt Foundation and look forward to welcoming you soon.<br/>"+
"<br/>"+
	"Best wishes,<br/>"+

	"Hardt Foundation",
	"We are pleased to inform you that you have been granted a bursary for a research stay at the Hardt Foundation.<br/>"+
	"Please find here attached your letter of confirmation.<br/>"+
	"Practical information about the Hardt Foundation as well as travelling to Vandœuvres is available here: http://www.fondationhardt.ch/?page_id=1166 .<br/>"+
	"In order for us to welcome you as well as possible, please let us know the scheduled date and time of your arrival and the means of transport you will use to get to the Foundation at admin@fondationhardt.ch<br/>"+
	"Do not hesitate to contact us if you have any inquiry concerning your future stay.<br/>"+
	"We thank you very much for your interest in the Hardt Foundation and look forward to welcoming you soon.<br/>"+
"<br/>"+
	"Best wishes,<br/>"+
"<br/>"+
	"Hardt Foundation"];
	// Fonction d'affichage du nombre de nuitées
	$('#acf-rms_reservation_start input[type=text], #acf-rms_reservation_end input[type=text]').change(function(){

		// Afficher le nombre de nuitées
		getnights();
		
	});

	// Fonction pouer afficher le nombre de nuitées
	function getnights()
	{
		// Vérifier présence 2 valeurs
		if( ($("#acf-rms_reservation_start input").val() != "") && ( $("#acf-rms_reservation_end input").val() != "") )
		{
			
			var arrStartDate = $("#acf-rms_reservation_end input[type=text]").val().split('/');
			var arrEndDate = $("#acf-rms_reservation_start input[type=text]").val().split('/');
		
			// Afficher la valeur dans le champs prévu
			$("#rms_reservation_nigths").val( ( new Date(arrStartDate[2], arrStartDate[1]-1, arrStartDate[0] ) - new Date( arrEndDate[2], arrEndDate[1]-1, arrEndDate[0]) ) / 1000 / (60 * 60 * 24) );
			
		}// Fin if()
			
	}// Fin getnights()

	// Fonction de calcul du coût total du séjour
	$('.get_res_price').click(function(e){
		e.preventDefault();
		
		// Vérifier id chambre
		if ( $.isNumeric( $('.relationship_right li a').attr('data-post_id') ) )
		{
			// Vérifier nombre nuit numérique
			if ( $.isNumeric( $("#rms_reservation_nigths").val() ) )
			{
				
				var selectedRoomId = rms_reservation_cost_data.room_id;
				if(selectedRoomId == '' || selectedRoomId == undefined){
					selectedRoomId = $("#acf-rms_reservation_room")
						.find(".relationship_right").first()
						.find("a").first()
						.data("post_id");
				}
								
				var data ={ action: "admin_get_single_room_data", room_id: selectedRoomId, user_id: $('#acf-field-rms_reservation_client').val(), nights:$("#rms_reservation_nigths").val(), sale: $('#rms_reservation_sale').val()};
				
				jQuery.post(rms_reservation_data.ajax_url, data, function(data)
				{
					
					$('#rms_reservation_cost').val(data);
					
					$('input#publish').show();
				});
			}
			else
			{	
			
				// Afficher prix 0
				$("#rms_reservation_cost").val("0");
				
			}// Fin if()
			
		}
		else
			alert('Wrong room id');
	
	});// Fin function()
	
	// Action checkbox bourse edition reservations
	$("#rms_reservation_has_bourse").click(function()
	{
		
		bourse_index = ($(this).is(':checked') ? 1 : 0);
		tinyMCE.activeEditor.setContent(lang_index[bourse_index]);
		
		if(bourse_index)
		{
		
			$('input#title').val($('input#title').val()+'_b');
			
		}
		else
		{
			$('input#title').val($('input#title').val().slice(0,-2));
		}

	});
	
	// Action liste déroulante langue utilisateur edition reservation
	$("#rms_user_lang").change(function(){
		lang_index = "array_" + $(this).val();
		
		tinyMCE.activeEditor.setContent(eval(lang_index)[bourse_index]);
	});
	
	// Changer texte lien suppression
	if( $('.post-type-rms_reservation a.submitdelete').text() == "Move to Trash" )
	{
	
		$('.post-type-rms_reservation a.submitdelete').text('Delete permanently');
		
	}
	else
	{
	
		$('.post-type-rms_reservation a.submitdelete').text('Supprimer le séjour');
		
	}
	
	// Datepicker pour export
	$( "#export_fromdate, #export_todate" ).datepicker({
		changeMonth: true,
		dateFormat: 'dd.mm.yy',
		onSelect: function( selectedDate ) {
		
			if( this.id == 'export_fromdate' ){
			
				var dateMin = $('#export_fromdate').datepicker("getDate");
				var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 1); 
				$('#export_todate').datepicker("option","minDate",rMin);
			
			}
		
		}
	});
	
	// Action au clic sur lien d'export de la liste 2
	$('#export_list2_link').click(function(e){
	
		e.preventDefault();
		
		$('.export_list2_dateselector').slideToggle();
		
	});
	
	// Action au clic sur le bouton d'export de la liste 2
	$('#list2_export_submit').click(function(e){
	
		e.preventDefault();
		
		var fromDate = $('#export_fromdate').val();
		var toDate = $('#export_todate').val();
		
		window.location.href = $('#export_list2_link').attr('href') +'?from=' + fromDate + '&to=' + toDate;
	
	});
	
	// Reformater date tableau liste réservations
	$('td.date_res.column-date_res').each(function(){
		var data_date = new Date($(this).text()*1000);
		
		var year = data_date.getFullYear();
		var month = data_date.getMonth() + 1;
		var day = data_date.getDate();
		var hours = data_date.getHours();
		var minutes = data_date.getMinutes();
		
		$(this).text(("0" + day).slice(-2) + "." + ("0" + month).slice(-2) + "." + year + " à " + ("0" + hours).slice(-2) + "h" + ("0" + minutes).slice(-2));
	});
	
	$('span.timestamp_date_jq').each(function(){
		var data_date = new Date($(this).text()*1000);
		
		var year = data_date.getFullYear();
		var month = data_date.getMonth() + 1;
		var day = data_date.getDate();
		
		$(this).text(("0" + day).slice(-2) + "." + ("0" + month).slice(-2) + "." + year);
	});
	
	
})(jQuery);	


