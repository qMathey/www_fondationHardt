// variables globales
var currentSubMenuOpen = '';

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
	$(".main_top_menu").on("mouseenter", function(event) {
	
		if(  $(this).find(".menu-item-has-children").length > 0) {
	
			console.log("mouse enter");
			// stop propagation
			event.isPropagationStopped();
			
				var menuHeight = 0;
				var $subMenu = $(this).find("ul");
				$subMenu.show();
				
				
				var currentMenuOpen = $(this).find("a").html();
				// masque les autres menu
				$(".main_top_menu .menu-item-has-children").each(function() {
					// si ce n'est pas le menu courant
					if(currentMenuOpen != $(this).find("a").html()){
						$(this).find("ul").hide();
						/*
						$(this).find("ul").first().animate({
							height:"0px"
						}, 500);
						*/
					}
				});
				
				menuHeight = $(this).find("ul").height() + 50;
				// animate menu
				animateMenuHeight(menuHeight);
			}
			else {
				// animate menu
				animateMenuHeight(0);
			}
	});
	
	$(".right_top_lang_menu").on("mouse", function() {
		animateMenuHeight(0); // reset menu height
	});
	
	function animateMenuHeight( pixelHeight ) {
		
			// clearQueue
			$(".container, .news fixed ").clearQueue();
	
			// déplace les containers
			$(".container").animate({
				marginTop:pixelHeight+"px"
			}, 500);
			// déplace le logo
			/*
			$(".logo fixed").animate({
				marginTop:(pixelHeight+130)+"px"
			}, 500);
			*/
			// déplace les news fixed 
			$(".news fixed").animate({
				top: (pixelHeight+199)+"px"
			}, 500);
			
	}
	
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