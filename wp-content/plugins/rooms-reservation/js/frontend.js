var files, CV, user_age;
var form_submited = false;
jQuery(document).ready(function($){
 
	// Charger les datepickers
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
			'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
		monthNamesShort: ['janv.', 'févr.', 'mars', 'avril', 'mai', 'juin',
			'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'],
		dayNames: ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'],
		dayNamesShort: ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'],
		dayNamesMin: ['D','L','M','M','J','V','S'],
		weekHeader: 'Sem.',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	
    $( ".datepicker" ).datepicker({  showOn: 'both', buttonImage: ajax_object.ajax_url+'/../../css/icons/icon_calendar.jpg', buttonImageOnly: true, minDate: 0, dateFormat: 'dd.mm.yy', "showAnim":'slideDown' });
	
	// Charger traducation française si langue fr
	if( $('.right_top_lang_menu li a.active').text() == 'fr')
		$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
		
	// Supprimer le caractère de fin de texte
	$('.end_glyph').remove();
	
	// Afficher le formulaire de connexion
	$('.show_loginform').click(function(e)
	{
		
		e.preventDefault();
		
		$(this).toggleClass('active');
		
		$('.login_form').slideToggle();
	});
	
	// Afficher le formulaire de récupération du mot de passe
	$('.retrieve_password').click(function(e)
	{
		
		e.preventDefault();
		$('.email_form').slideToggle();
		
	});

	// Charger les datepickers
    $( ".datepicker" ).datepicker({ dateFormat: 'dd.mm.yy' });
		
	// Toggle formulaire d'adresse de facturation
	$('input[type=checkbox].same_addr').change(function()
	{
	
		$('.fact_addr').slideToggle();
		
	});
	
	// Toggle formulaire de demande de bourse
	$('input[type=checkbox].gimme_scolarship').change(function()
	{
	
		$('.scolarship_form').slideToggle();
		
	});
	
	// Afficher iso après sélection pays
	$('select[name=country]').change(function()
	{
	
		$('input[name=iso]').val($(this).val().toUpperCase());
		
	});
	
	// Afficher iso après sélection pays - facturation
	$('select[name=fact_country]').change(function()
	{
	
		$('input[name=fact_iso]').val($(this).val().toUpperCase());
		
	});
	// Action bouton de choix de chambre, etape 3
	$('.res_room_list input[type=submit]').live('click',function(e)
	{
			
			// Vérifier si bouton étape 4
			if( $(this).hasClass('submit_reservation') )
			{
			
				// Vérifier tou acceptés
				if ( $('input[name=tou_agree]').is(':checked') )
				{
				
		if(!form_submited)
		{
			form_submited = true;
					// Récupérer données formulaire
					var formdata = $(".rms_form").serializeArray();
					
					// Ajout des données non incluses dans les formulaires
					formdata.push({name: 'action', value: 'add_reservation_new_user'});
					
					formdata.push({name: 'room_id', value: $('.rms_room_chosen').attr('data-room_id')});
					
					formdata.push({name: 'lang', value: $('.right_top_lang_menu li a.active').text()});
					
					formdata.push({name: 'cost', value: $('.total_cost').text()});
					
					// Appel Ajax
					$("body").css("cursor", "wait");
						
						if( window.FormData !== undefined )
						{
							var data = new FormData();
							
							$.each(CV, function(key, value)
							{
								data.append(key, value);
							});
							data.append('action','add_reservation_scolarship_new_user');
						}
						else
						{
							var data = {};
						}
						
						$.ajax({
							url: ajax_object.ajax_url,
							type: 'POST',
							data: data,
							cache: false,
							dataType: 'html',
							processData: false,
							contentType: false,
							success: function(data, textStatus, jqXHR)
							{
								
								if( !data)
									formdata.push({name: 'unique_user_id', value:'uid_' + Math.round(new Date().getTime() + (Math.random() * 100))});
								else
									formdata.push({name: 'unique_user_id', value: data});
								
								
								jQuery.post(ajax_object.ajax_url, formdata, function(data)
								{
									//$('.page_content_wrap').append(data);
									$('.rms_wrapper.step_4').addClass('hidden_step');
									
									// Masquer step actif
									$(this).parent('.rms_wrapper').addClass('hidden_step');
									
									// Aller jusqu'à l'étape de confirmation
									$("a[href^='step_" + "']").parent('li').addClass('active').addClass('done').prev().removeClass('active').addClass('done');
									$("a[href='step_4" + "']").removeClass('disabled');
								console.log(data);
									// Afficher le message
									if(data == 'user_id_error')
									{
										if( $('.right_top_lang_menu li a.active').text() == 'fr')
											$('p.step_content').html("L'adresse email est déjà utilisée, veuillez la corriger");
										else
											$('p.step_content').html("The email address is already in use, please correct");
											
										$('input[name="email"]').addClass('rms_field_error');
										
									}
									else
									{
									
										// Masquer le menu
										$('.form_step_menu').hide();
									
										if( $('.right_top_lang_menu li a.active').text() == 'fr')
											$('p.step_content').html("Nous vous remercions de votre intérêt pour la Fondation Hardt.<br/>" + 
												"Un accusé de réception vous a été envoyé à l'adresse email entrée lors de l'inscription. <br/>" +
												"Votre demande de réservation pour un séjour scientifique à la Fondation a bien été enregistrée. Veuillez noter que la disponibilité affichée des chambres ne peut être assurée et qu’il ne s’agit pas d’une réservation définitive. <br/>" +
												"Nous vous confirmerons la réservation dès que possible.<br/>" +
												"&nbsp;<br/>" +
												"Pour toute information complémentaire, veuillez vous adresser à admin@fondationhardt.ch<br/>" +
												"Avec nos remerciements et nos salutations les meilleures,<br/>" +
												"Fondation Hardt");
										else
											$('p.step_content').html("Thank you very much for your interest in The Hardt Foundation<br/>" +
												"&nbsp;<br/>" +
												"A return receipt has been sent to your email address.<br/>" +
												"&nbsp;<br/>" +
												"We have received your request for a scientific stay at the Foundation. Please note that room availability cannot be guaranteed and that this is not a final reservation.<br/>" +
												"&nbsp;<br/>" +
												"We will contact you as soon as possible to confirm the reservation.<br/>" +
												"&nbsp;<br/>" +
												"For further information, please contact us at admin@fondationhardt.ch<br/>" +
												"&nbsp;<br/>" +
												"Best wishes,<br/>" +
												"&nbsp;<br/>" +
												"Hardt Foundation");
											
											$('input[name="email"]').removeClass('rms_field_error');
											
										}
										
									$("body").css("cursor", "default");
									
								});
							}
						});
					}
				}
				else
				{
				
					$('input[name=tou_agree]').parent('div').addClass('rms_label_error');
				
				}// Fin if()
				
			}
			else
			{
			
				// Supprimer classe sur précédente chambre choisie
				$('article').removeClass('rms_room_chosen');	
				
				// Mettre en avant la chambre choisie
				$(this).closest('article[data-room='+$(this).attr('data-meta_room')+']').addClass('rms_room_chosen');
				
				// Afficher la chambre dans l'étape 4
				$('.show_room article').empty().append($('article.rms_room_chosen').html());
				
				// Calculer le prix du séjour
				calculatePrice();
				
				// Afficher les données de l'étape 1 dans l'étape 4
				$("fieldset.data_from_step1 div").each(function()
				{
				
					// Vérifier si élément a attribut
					if( $(this).attr('data-input') )
					{
						// Afficher la valeur dans l'étape 4
						$(this).text( $('.step_1 form *[name=' + $(this).attr('data-input') + ']').val() );
					
					}// Fin if( $(this).attr('data-input') )
					
				});
				
			}// Fin if( $(this).hasClass('submit_reservation') )
		
	});
	
	// Traitement de l'envoi d'un formulaire
	$('.rms_form').submit(function(e){
	
		e.preventDefault();
		
		var fwerr = 0;
		
		// Parcourir les champs visibles
		var $inputs = $( '.' + $(this).attr('class') + ' :input:not([type="submit"]):not([type="file"]):not(.not_required)');
		
		// Parcourir les champs
		$inputs.each(function() {
			// Vérifier pas de valeur et champ visible
			if( $(this).is(":visible") )
			{
				// Vérifier champ vide
				if( $(this).val() == '' )
				{
					$(this).prev('label').addClass('rms_label_error');
					$(this).addClass('rms_field_error');
					fwerr++;
					
					// Afficher le label d'erreurs du formulaire
					$('p.rms_form_error_info').show();
				}
				else
				{
					$(this).removeClass('rms_field_error');
					$(this).prev('label').removeClass('rms_label_error');			
				}// Fin if( $(this).val() == '' )
				
			}// Fin if( $(this).is(":visible") )
			
		});// Fin each()
		
		// Vérifier présence fichier CV
		if(!CV)
		{
		
			$('.cv_fake').addClass('rms_field_error');
			fwerr++;
		
		}
		else
		{
		
			$('.cv_fake').removeClass('rms_field_error');
		
		}
		
		if( !isDate($('input[name=birthday]').val()) )
		{
		
			$('input[name=birthday]').prev('label').addClass('rms_label_error');
			$('input[name=birthday]').addClass('rms_field_error');
			fwerr++;

			// Afficher le label d'erreurs du formulaire
			$('p.rms_form_error_info').show();
			
		}
		else
		{
	//	console.log(calculateAge($('input[name=birthday]').val()));
			$(this).removeClass('rms_field_error');
			$(this).prev('label').removeClass('rms_label_error');
			
		}
		
		// Vérifier qu'il n'y a pas d'erreur
		if( ( fwerr <= 0) && ( validateDates($(this)) ) )
		{
			// Masquer label d'erreur
			$('p.rms_form_error_info').hide();
			
			// Si il y a demande de bourse afficher message
			if( $('input[name=gimme_scolarship]').is(':checked') )
			{
				
				if( !files )
				{
					
					if( $('.right_top_lang_menu li a.active').text() == 'fr' )
					{
						alert('Il est nécessaire d\'ajouter les documents demandés')
					}
					else
					{
						alert('It is necessary to add the required documents')
					}
					
					return false;
				}
				else
				{
					$("body").css("cursor", "wait");
					
					var file_key = 0;
					
					var data = new FormData();
					
					$.each(files, function(key, value)
					{
						data.append(key, value);
						file_key = key;
					});
					
					$.each(CV, function(key, value)
					{
						data.append(file_key+1, value);
					});
					
					data.append('action','add_reservation_scolarship_new_user');
					data.append('lang',$('.right_top_lang_menu li a.active').text());
					
					$.ajax({
						url: ajax_object.ajax_url,
						type: 'POST',
						data: data,
						cache: false,
						dataType: 'html',
						processData: false,
						contentType: false,
						success: function(data, textStatus, jqXHR)
						{
						
						
								
							// Serialize the form data
							var formData = $(".rms_form").serializeArray();
							
							formData.push({name: 'action', value: 'add_reservation_new_user'});
							
							formData.push({name: 'lang', value: $('.right_top_lang_menu li a.active').text()});
							formData.push({name: 'unique_user_id', value: data});
							
							if( !data)
								formData.push({name: 'unique_user_id', value:'uid_' + Math.round(new Date().getTime() + (Math.random() * 100))});
							else
								formData.push({name: 'unique_user_id', value: data});
								
							$.ajax({
								url: ajax_object.ajax_url,
								type: 'POST',
								data: formData,
								cache: false,
								dataType: 'html',
								success: function(data, textStatus, jqXHR)
								{
									if( !data )
									{
										$("body").css("cursor", "default");
										// Masquer step actif
										$('.rms_wrapper.step_1').addClass('hidden_step');
										
										// Aller jusqu'à l'étape de confirmation
										$("a[href^='step_" + "']").parent('li').addClass('active').addClass('done').prev().removeClass('active').addClass('done');
										$("a[href='step_4" + "']").removeClass('disabled');
										
										$('.page_content_wrap.width_30').css("width", $('.step_4').attr('data-wrapper_size') + '%' );
										
										// Masquer le menu
										$('.form_step_menu').hide();
										
										// Afficher le message
										
										if( $('.right_top_lang_menu li a.active').text() == 'fr')
											$('p.step_content').html("Nous vous remercions de votre intérêt pour la Fondation Hardt.<br/>" + 
												"&nbsp;<br/>" +
												"Un accusé de réception vous a été envoyé à l'adresse email entrée lors de l'inscription. <br/>" +
												"&nbsp;<br/>" +
												"Votre demande de bourse pour un séjour scientifique à la Fondation a bien été enregistrée. Votre dossier sera examiné dès la fin du délai de candidature (30 novembre/30 avril). Nous vous contacterons dès que le processus d’attribution des bourses sera terminé.<br/>" +
												"Pour toute information complémentaire, veuillez vous adresser à admin@fondationhardt.ch<br/>" +
												"&nbsp;<br/>" +
												"Avec nos remerciements et nos salutations les meilleures,<br/>" +
												"&nbsp;<br/>" +
												"Fondation Hardt");
										else
											$('p.step_content').html("Thank you very much for your interest in The Hardt Foundation." + 
												"&nbsp;<br/>" + 
												"A return receipt has been sent to your email address.<br/>" +
												"&nbsp;<br/>" +
												"We have received your application for a grant for a scientific stay at the Hardt Foundation. All applications will be examined after the submission deadline (30th November/30th April). We will contact you as soon as the selection process is over.<br/>" +
												"&nbsp;<br/>" +
												"For further information, please contact us at admin@fondationhardt.ch<br/>" +
												"&nbsp;<br/>" +
												"Best wishes,<br/>" +
												"&nbsp;<br/>" +
												"Hardt Foundation");
												
										$('input[name="email"]').removeClass('rms_field_error');
										
									}
									else
									{
									console.log(data);
										if( $('.right_top_lang_menu li a.active').text() == 'fr' )
										{
											$('.step_1 .left_col').prepend('<p class="rms_label_error rms_form_error_info" style="display:block;">L\'adresse email saisie est déjà utilisée</p>');
										}
										else
										{
											$('.step_1 .left_col').prepend('<p class="rms_label_error rms_form_error_info" style="display:block;">The email address entered is already in use</p>');
										}
										
										$('input[name="email"]').addClass('rms_field_error');
										$("body").css("cursor", "default");
									
									}// Fin if( data )
								}
							});
						}
					});
				}
			}
			else
			{// Sinon passer à l'étape suivante
			
				$(this).parent('.rms_wrapper').addClass('hidden_step');
				
				if( $(this).attr('data-custom_step') == 'go_step_4' )
				{
					// Afficher les données de l'étape 1 dans l'étape 4
					$("fieldset.data_from_step1 div").each(function()
					{
					
						// Vérifier si élément a attribut
						if( $(this).attr('data-input') )
						{
							// Afficher la valeur dans l'étape 4
							$(this).text( $('.step_1 form *[name=' + $(this).attr('data-input') + ']').val() );
						
						}// Fin if( $(this).attr('data-input') )
						
					});
					
					$('.step_4').removeClass('hidden_step');
					
					$('.page_content_wrap.width_30').css("width", $('.step_4').attr('data-wrapper_size') + '%' );
					
					$("a[href='step_4']").removeClass('disabled').parent('li').addClass('active').addClass('done').prev().removeClass('active').addClass('done');
		
				}
				else
				{
					var step_number = $(this).attr('name').substr($(this).attr('name').length - 1);
					
					$('.step_' + parseInt( parseInt(step_number) + 1 )  ).removeClass('hidden_step');
					
					$('.page_content_wrap.width_30').css("width", $('.step_' + parseInt( parseInt(step_number) + 1 )  ).attr('data-wrapper_size') + '%' );
					
					
					$("a[href='step_" + parseInt( parseInt(step_number) + 1 )  + "']").removeClass('disabled').parent('li').addClass('active').addClass('done').prev().removeClass('active').addClass('done');
				}
				
			}// Fin if( $('input[name=gimme_scolarship]').is(':checked') )
	
		}// Fin if( fwerr <= 0 )
	
	});// Fin submit()
	
	// Navigation dans les étapes du formulaire
	$('.form_step_menu li a').click(function(e){
	
		form_submited = false;
		
		e.preventDefault();
		
		// Vérifier étape pas désactivée
		if( !$(this).hasClass('disabled') )
		{
		
			// Masquer les étapes
			$('div[class*=" step_"]').addClass('hidden_step');
			$('.step_content').empty();
			$('.page_content_wrap.width_30').css("width", $( '.' + $(this).attr('href') ).attr('data-wrapper_size') + '%' );
			$('.form_step_menu li').removeClass('active');
			$(this).parent('li').addClass('active');
			$( '.' + $(this).attr('href') ).removeClass('hidden_step');
			
		}// Fin if( !$(this).hasClass('disabled')
		
	});
	
	// Navigation depuis les boutons de l'étape 4
	$('.rms_edit_go_to_step').live('click',function(e){
		
		e.preventDefault();
		
		$(this).parents('.rms_wrapper').addClass('hidden_step');
		
		$('.page_content_wrap.width_30').css("width", $('.' + $(this).attr('data-step')).attr('data-wrapper_size') + '%' );
			
		$('.form_step_menu li').removeClass('active');
			
		$("a[href='" + $(this).attr('data-step') + "']").removeClass('disabled').parent('li').addClass('active').addClass('done').prev().removeClass('active').addClass('done');
		
		$('.' + $(this).attr('data-step')).removeClass('hidden_step');
		
		if( $(this).attr('data-step') == 'step_1')
		{
			$('form[name=step_1]').attr('data-custom_step', 'go_step_4');
		}
	});
	
	// Valider les dates et lancer un appel ajax pour lister les chambres
	function validateDates(form)
	{
		var is_correct = true;
		
		// Vérifier étape 2
		if( form.attr('name') == 'rms_reservation_step2' )
		{
			// Vérifier 2ème date plus grande que première
			if( $('input[name=end_date]').datepicker("getDate") - $('input[name=start_date]').datepicker("getDate") <= 0 )
			{
				is_correct = false;
				
				// Ajouter visuel au champ
				$('input[name=end_date]').prev('label').addClass('rms_label_error');
				$('input[name=end_date]').addClass('rms_field_error');
			
			}
			else
			{
				// Données pour appel Ajax
				var data = {
					action: 'get_rooms_by_date',
					postData: {
						startDate : $('input[name=end_date]').val(),
						endDate : $('input[name=start_date]').val(),
						lang : $('.right_top_lang_menu li a.active').text()
					},
					user_age : user_age
				};
				
				// Appel Ajax
				jQuery.post(ajax_object.ajax_url, data, function(data)
				{
					if( $('.right_top_lang_menu li a.active').text() == 'fr' )
					{
						if( !data )
							$('.step_3 .res_room_list').html('<p class="rms_wrapper_step_descr">Malheureusement il n\'y a pas de chambres disponibles pour la période du ' + $('#start_date').val() + ' au ' + $('#end_date').val() + '</p><input type="button" data-step="step_2" class="rms_edit_go_to_step" value="Modifier les dates" />');
						else
							$('.step_3 .res_room_list').html('<p class="rms_wrapper_step_descr">Voici la liste des chambres disponibles aux dates souhaitées:</p>' + data);
					}
					else
					{
						if( !data )
							$('.step_3 .res_room_list').html('<p class="rms_wrapper_step_descr">Unfortunately there are no rooms available for the period from ' + $('#start_date').val() + ' to' + $('#end_date').val() + '</p><input type="button" data-step="step_2" class="rms_edit_go_to_step" value="Modifier les dates" />');
						else
							$('.step_3 .res_room_list').html('<p class="rms_wrapper_step_descr">Here is the list of available rooms for the requested dates:</p>' + data);
					}
					
				});
			
			}// Fin if()
			
			// Afficher les dates dans l'étape 4  et calcul de la nuitée
			$('span.start_date').text($('input[name=start_date]').val());
			$('span.end_date').text($('input[name=end_date]').val());
			
			// Calculer le nombre de nuitées
			var start_date   = $('#start_date').datepicker('getDate');
			var end_date = $('#end_date').datepicker('getDate');
			var nights   = ( end_date - start_date )/1000/60/60/24;
			
			// Afficher le nombre de nuit
			$('.nb_nights').text(nights);
			
		}// Fin if( form.attr('name') == 'rms_reservation_step2' )
		
		return is_correct;
	}
	
	// Fonction de calcul du coût du séjour
	function calculatePrice()
	{
	
		// Obtenir le nombre de nuits
		var nights = $('.nb_nights').text();
		
		// Obtenir le prix de la chambre
		var room_price = $('.show_room .rms_room_price').text();
		
		// Calculer et afficher le prix
		$('.total_cost').text(nights*room_price.replace(/[^\d]/g, ""));
	}// Fin calculatePrice()
	
	function showDocs(files) 
	{
		for (var i = 0, f; f = files[i]; i++)
		{
			$('.topto').append(f.name + '<br />');
		}
	}

	$('.file').change(function (evt)
	{
		files = evt.target.files;
		showDocs(evt.target.files);
	});
	
	$('.cv_file').change(function (evt)
	{	
		if( evt.target.files )
		{
			CV = evt.target.files;
			$('.cv_fake').text(evt.target.files[0].name);
		}
		else
		{
			CV = "ie_no_files_support";
		}
	});
	
});

// Fonction de validation de date
function isDate(txtDate)
{

	var currVal = txtDate;
	
	if(currVal == '')
		return false;

	var rxDatePattern = /^(\d{1,2})(\/|-|.)(\d{1,2})(\/|-|.)(\d{4})$/; 
	
	var dtArray = currVal.match(rxDatePattern); 

	if (dtArray == null)
	return false;

	// Format dd/-.mm/-.yyyy
	dtMonth = dtArray[3];
	dtDay= dtArray[1];
	dtYear = dtArray[5];

	// Vérifier validité date
	if (dtMonth < 1 || dtMonth > 12)
		return false;
	else if (dtDay < 1 || dtDay> 31)
		return false;
	else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
		return false;
	else if ( dtMonth == 2 )
	{
		var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		if ( dtDay> 29 || (dtDay ==29 && !isleap) )
			return false;
			
	}
	
	var now = new Date();
	var born = new Date(dtArray[5], dtArray[3]-1, dtArray[1]);
	user_age=get_age(born,now);
	
	return true;
	
}

function get_age(born, now)
{
	var birthday = new Date(now.getFullYear(), born.getMonth(), born.getDate());
	
	if (now >= birthday) 
		return now.getFullYear() - born.getFullYear();
	else
		return now.getFullYear() - born.getFullYear() - 1;
}