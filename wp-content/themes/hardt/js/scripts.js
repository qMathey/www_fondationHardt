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
	/*
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
	*/
	
	// Position contenu principal
	var backgroundOffset, backgroundOffsetY = null;
	backgroundOffsetY = 25;
	
	// Menu deroulant
	$(".main_top_menu > li, #menu-menu-secondaire > li").on("mouseenter", function(event) {
	
			// stop propagation
			event.stopPropagation();
			
			if( $(this).find("ul").length > 0 ) {
				var menuHeight = 0;
				var $subMenu = $(this).find("ul");
				$subMenu.show();
				
				var currentMenuOpen = $(this).find("a").first().html();
				console.log("current menu open : "+currentMenuOpen);
				// masque les autres menu
				$(".main_top_menu > li, #menu-menu-secondaire > li").each(function() {
					// si ce n'est pas le menu courant
					if(currentMenuOpen != $(this).find("a").first().html()){
						$(this).find(".submenu").hide();
					}
				});
				
				menuHeight = $(this).find(".submenu").height() + 50;
				// animate menu
				animateMenuHeight(menuHeight);
				console.log("animate menu " + menuHeight);
			}
			else  {
			
				console.log("no submenu found");
				// animate menu
				animateMenuHeight(52);
				// hide all others menu
				$(".submenu").hide();
			}
	});
	
	$(".navigation.menu_fixed").on("mouseleave", function() {
		console.log("mouse leave");
		animateMenuHeight(52); // reset menu height
	});
	
	function animateMenuHeight( pixelHeight ) {
		
			// clearQueue
			$(".navigation.menu_fixed, .container, .open_news.fixed, .news.fixed").clearQueue();
			
			var heightMin = 15;
			if(pixelHeight-40 > 15)
				heightMin = pixelHeight-40;
			
			// aggrandis le container
			$(".navigation.menu_fixed").animate({
				height:heightMin+"px"
			}, 500);
			// déplace les containers
			$(".container").animate({
				marginTop:pixelHeight+"px"
			}, 500);
			
			// déplace les news fixed 
			$(".open_news.fixed").animate({
				top: (pixelHeight+199)+"px"
			}, 500);
			$(".news.fixed").animate({
				top: (pixelHeight+199)+"px"
			}, 500);
			
			// si plus petit que 52 alors on masque tous les sous menu
			if(pixelHeight <= 52 ) {
				$(".submenu").hide();
				console.log("close menu...");
			}
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
	
	
	// GESTION MOBILE
	
	/* GESTION MOBILE */
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ){
		
		console.log("mobile!!!");
		
		/*
		// Gestion menu pour mobile : Permet de dérouler sous menu au premier click
		// si clique sur menu niveau 1
		$(".menu-item-has-children").click(function(event){
		
			// retire l'événement
			event.stopPropagation();
			event.preventDefault();
			
			$linkMenu = $(this).find("a").first();
			
			if($linkMenu.data("alreadyCliqued") == "cliquedOnce") {
				// move to link
				 document.location.href = $linkMenu.attr("href");
			}
			else { // he never cliqued
				// retire l'info aux autres liens
				$(".menu-item-has-children").data("alreadyCliqued", "");
				// ajoute l'info cliquedOnce
				$linkMenu.data("alreadyCliqued", "cliquedOnce");
			}
		}); // click
		*/
		
		// desactive Paralax
		$.stellar({
			horizontalScrolling: false,
			//positionProperty: 'limit'
		});
		
		// Zoom sur la page 
		var zoomToScale = parseInt ((($(window).width() * 1 ) / 1500 ) * 100 ) / 100;
		$('head').append('<meta name="viewport" content="width=device-width; initial-scale='+zoomToScale+'; maximum-scale=1.0; user-scalable=1;">');
		
	}// if
});