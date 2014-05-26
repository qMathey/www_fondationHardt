jQuery(document).ready(function($){
	
	$.stellar.positionProperty.limit = {

	  setTop: function($element, newTop, originalTop) {
		
		if(newTop>300)
		{
			var limit = 0;
			
			// Controler si depassement limite
			if(newTop - originalTop > limit)
			{
			
				// Appeler position par defaut avec notre limite
				$.stellar.positionProperty.position.setTop.call(null, $element, originalTop - limit, originalTop);
			
			}
			else
			{ 
			
				//$element.css("opacity","1");
				$.stellar.positionProperty.position.setTop.apply(null, arguments);

			}
		}
	  },

	  // Constuire dans l'adaptateur:
	  setLeft: $.stellar.positionProperty.position.setLeft

	}// Fin $.stellar.positionProperty.limit
	
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};
	
	// Effet parallax
	if( !isMobile.any() )
	$.stellar({
		horizontalScrolling: false,
		//positionProperty: 'limit'
	});
	
	
	// Position contenu principal
	var backgroundOffset, backgroundOffsetY = null;
	backgroundOffsetY = 25;
	
	// Menu deroulant
	$('ul.main_top_menu > li, ul.right_top_menu > li').hoverIntent( submenu_getin, submenu_getout_empty );
	
	function submenu_getout_empty(){}
	
	// Affichage des sous-menus
	function submenu_getin()
	{
		// Masquer les sous-menus
		$('.submenu').hide();
		
		// Assigner valeur background-position
		if( !backgroundOffset )
			backgroundOffset = $('.container section').first().css("background-position").split(" ");
		
		if( !backgroundOffsetY )
			backgroundOffsetY = backgroundOffset[1];

		// Si il y a un sous-menu
		if( $(this).find('.submenu').length > 0 )
		{
			var height = $(this).children('ul.submenu').height();
				
			// Afficher le sous-menu et ajuster la marge
			
			$('.container').animate({marginTop: ( height + 50 )},500);
			$('.menu_fixed').animate({height: ( height + 50 )},500);
			$('.container section').first().animate({backgroundPositionY:( height + 50 )},500);	
			
			$(this).children('.submenu').slideDown(500);
			
			//$('.submenu_wrapper').css('height', height).slideDown();
			
			
			// Reajuster les elements fixes
			$('.fixed').each(function()
			{
				// Verifier position top declare
				if($(this).css('top') != 'auto')
				{
					// Verifier presence attribute de backup
					if(!($(this).attr('data-top')) )
						$(this).attr('data-top', $(this).css('top'));
						
						$(this).animate({'top': (height + parseInt($(this).attr('data-top'), 10)+52) + 'px'},500);
				}
				else if($(this).css('bottom') != 'auto')
				{// Verifier position top declare
					// Verifier presence attribute de backup
					if(!($(this).attr('data-bottom')) )
						$(this).attr('data-bottom', $(this).css('bottom'));
						
					$(this).animate({'bottom': (parseInt($(this).attr('data-bottom'), 10) - height) + 'px'},500);
				}// Fin if()
			});
		}
		else
		{
			// Masquer le sous-menu et ajuster la marge
			$('.container').animate({'marginTop': '0'},500);
			
			$('.menu_fixed').animate({'height': '16'},500);
			$('.container section').first().animate({backgroundPositionY: backgroundOffsetY},500);	
			
			$('.submenu_wrapper').hide();
			
			// Reajuster les elements fixes
			$('.fixed').each(function(){
			
				if($(this).attr('data-top'))
					$(this).animate({'top':$(this).attr('data-top')});
					
				else if($(this).attr('data-bottom'))
					$(this).animate({'bottom':$(this).attr('data-bottom')});
			});
		}// Fin if($(this).find('.submenu').length > 0)
	
	};// Fin $('.topnavigation li').mouseover()

	// Masquer les sous-menus
	function submenu_getout()
	{
		// Reajuster la marge
		$('.container').animate({'marginTop': '0'},500);
		$('.menu_fixed').animate({'height': '16'},500);
		$('.navigation').css('margin-top', 'initial');
	
		$('.container section').first().animate({backgroundPositionY:backgroundOffsetY},500);	
		
		$('.submenu_wrapper').slideUp();
			
		// Reajuster les elements fixes
		$('.fixed').each(function(){
			
			if($(this).attr('data-top'))
				$(this).animate({'top':$(this).attr('data-top')},500);
					
			else if($(this).attr('data-bottom'))
				$(this).animate({'bottom':$(this).attr('data-bottom')},500);
		});
		
		// Masquer le sous-menu
		$('.submenu').slideUp();
	};
	
	$('.menu_fixed').mouseleave(function()
	{
		submenu_getout();
	});
	
	$('.close_all_text').toggle(function(e){
		// Abandonner l'action par defaut
		e.preventDefault();
		
		// Changer le lien d'affichage
		$(this).removeClass('cross_img').addClass('square_img').attr('title', 'Ouvrir les textes');
		
		// Masquer les textes
		$('.logo').animate({left:'-=50%'});
		$('.page_content_wrap').animate({marginRight:'-=' + ( ($('html').width() - $('.page_content_wrap').offset().left) - 25 ) + 'px'});
		$('.close_all_text').animate({marginRight:'-=' + ( ($('html').width() - $('.close_all_text').offset().left) - 16 ) + 'px'});
		
	}, function(e) {
		// Abandonner l'action par defaut
		e.preventDefault();
		
		// Changer le lien d'affichage
		$(this).removeClass('square_img').addClass('cross_img').attr('title', 'Fermer les textes');
		
		// Reafficher les textes
		$('.close_all_text').animate({marginRight:'0'});
		$('.logo').animate({left:'+=50%'});
		$('.page_content_wrap').animate({marginRight:'0'});
	});
	
	// Afficher actualites au survol
	$('.open_news').mouseenter(function(){
	
		$('.open_news .open_square').removeClass('open_square square_img').addClass('close_cross close_news cross_img');
		
		$('.open_news').animate( {width: parseInt($('.news').css('width'))+8}, function()
			{
				$('.news').slideDown();
			}
		);
	});
	
	// Masquer actualites
	$('.close_news').live('click',function(e){
		e.preventDefault();
		
		$('.news').slideUp(function(){
			$('.open_news').animate({width:'125'}, function(){
				$('.close_news').removeClass('close_cross close_news cross_img');
			});
			
			$('.close_news').addClass('open_square square_img');
		});
	});
});