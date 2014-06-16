// variables globales
var currentSubMenuOpen = '';
var isMobile = false;
var isAndroid = false;
var isIpad = false;
var isIphone = false;

jQuery(document).ready(function($){

	// Afficher-masquer overflow selon taille fenêtre
	$( window ).resize(function()
	{
		if( $( window ).width() < 1325)
		{
			$('body').css('overflowX', 'visible'); 
		}
		else
			$('body').css('overflowX', 'hidden');
		
	});
	
	isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
	isAndroid = /Android|webOS|BlackBerry/i.test(navigator.userAgent);
	isIpad = /iPad/i.test(navigator.userAgent);
	isIphone = /iPhone/i.test(navigator.userAgent);
	
	// Position contenu principal
	var backgroundOffset, backgroundOffsetY = null;
	backgroundOffsetY = 25;
	
	// Hack Safari : changer de police pour la Homepage
	if ( $.browser.safari ) {
		$(".citation_original, .citation_author").css("font-family", "ACaslon-Semibold");
		//alert($(".citation_original").css("font-family"));
	}
	
	// correction sur les autres pages que la HP
	
	
	// Menu deroulant
	$(".main_top_menu > li, #menu-menu-secondaire > li").on("mouseenter", function(event) {
	
			// stop propagation
			event.stopPropagation();
			
			if( $(this).find("ul").length > 0 ) {
				var menuHeight = 0;
				var $subMenu = $(this).find("ul");
				$subMenu.show();
				
				var currentMenuOpen = $(this).find("a").first().html();
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
			}
			else  {
				// animate menu
				animateMenuHeight(52);
				// hide all others menu
				$(".submenu").hide();
			}
	});
	
	// quand la souris quitte le menu 
	$(".navigation.menu_fixed").on("mouseleave", function() {
		animateMenuHeight(52); // reset menu height
	});
	
	function animateMenuHeight( pixelHeight ) {
	
		// si version desktop
		if( ! isMobile ) {
		
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
		}
		} // if
		
		// si version mobile
		if ( isMobile ) {
			// correction pour mobile 
			pixelHeight -=  40;
			
			// aggrandis le container
			$(".navigation").animate({
				height:pixelHeight+"px"
			}, 500);
			
			
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
	

	
	/* GESTION MOBILE */
	if( isMobile ){
		
		// On défixe les éléments fixed
		// navigation
		$("div.navigation.menu_fixed").removeClass("menu_fixed")
			.css("position", "inherit !important")
			.css("display", "block");
			
			
		// place le container (contenu) sans margin top
		$("div.container").css("margin-top", "0px");
		
		// si ce n'est pas la home page et qu'on est sur android, il faut corrigé le marginTop de -81px
		if( ! isHomepage($) && isAndroid ){	
			$(".container").css("margin-top", "-81px");
		}
		
		// masque les actualités
		$("div.open_news.fixed").css("display", "none");
		$("div.news.fixed").css("display", "none");
		
		// place le logo dans un autre div et le defixed
		$logo = $("a.logo.fixed");
		$logo.removeClass("fixed");
		$logo.remove();
		$logo.appendTo("#mobileLogoContainer");
		$logo.css("display", "block");
		
		// n'affiche que le premier visuel
		$("section.home:not(:first)").hide();
		
		// place les contenus avec une marge supplémentaires pour Android uniquement
		if( isAndroid ) {
			$("div.page_content_wrap").css("margin-top", "100px");
			$("a.close_cross.close_all_text.cross_img").css("display", "none");
		}
		// Spécificité iPad : Les citations se placent trop haut! 
		if(/iPad/i.test(navigator.userAgent) ){
			// replace les citations correctements
			$(".home").each(function() {
				$citation = $(this).find("article").first();
				
				$citation.find(".citation_traduction.shadow").first().css("margin-top", "-30px");
				
			});
			$(".page").css("min-height", "100%"); 
		}
		
		
		// spécificité Android : menu cliquable + aggrandissement du sous-menu
		if ( isAndroid ) {
			gestionMenuMobile($);
			
			$(".main_top_menu li ul, menu-menu-secondaire li ul").css("width", "400px");
			
			// Spécificité Android : Les citations se placent trop haut! 
			// replace les citations correctements
			$(".home").each(function() {
				$citation = $(this).find("article").first();
				
				$citation.css("top", "0px");
				$citation.css("top", "450px");
				$citation.find(".citation_traduction.shadow").first().css("margin-top", "70px");
				
			});
			
			// content des pages a baisser de 60px
			$(".page_content_wrap").css("margin-top", "60px");
			
		}
		
		
		
		
		// retravaille les images de la homepage
		$(".home, .page").css("background-position", "100% 100%"); 
		$(".home, .page").css("background-attachment", "scroll"); 
		$(".home").css("min-height", "850px"); 
		$(".page").css("min-height", "850px"); 
		
		// Zoom sur la page 
		var zoomToScale = parseInt ((($(window).width() * 1 ) / 1500 ) * 100 ) / 100;
		$('head').append('<meta name="viewport" content="width=device-width; initial-scale='+zoomToScale+'; maximum-scale=1.0; user-scalable=1;">');
		
		// cas spécifique pour iPad, l'image de fond est trop petite
		if ( isIpad) {
			$("section.page, #map").css("height", (window.screen.height+180) + "px");
			$("section.page .footer_container").css("bottom", "-5px");
		}// if
		// cas spécifique pour iPhone, l'image de fond est trop petite
		if ( isIphone ) {
			$("section.page, #map").css("height", ((window.screen.height / zoomToScale) - 1350) + "px");
			$("section.page .footer_container").css("bottom", "-5px");
		}// if
	}// if
	else { // SI PAS MOBILE ALORS STELLAR JS POUR EFFET PARALAX
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
	}
});

function gestionMenuMobile($) {
	// Gestion menu pour mobile : Permet de dérouler sous menu au premier click
	// si clique sur menu niveau 1
	$(".menu-item-has-children").find("a:first").on("click", function(event){
	
		// retire l'événement
		event.stopPropagation();
		event.preventDefault();
		
		$linkMenu = $(this);
		
		if($linkMenu.data("alreadyCliqued") == "cliquedOnce") {
			// move to link
			 document.location.href = $linkMenu.attr("href");
		}
		else { // he never cliqued
			// retire l'info aux autres liens
			$(".menu-item-has-children a").data("alreadyCliqued", "");
			// ajoute l'info cliquedOnce
			$linkMenu.data("alreadyCliqued", "cliquedOnce");
		}
	}); // click
}

// Permet de déterminer s'il s'agit de la homepage
function isHomepage($) {
	
	var htmlCurrentMenuItem = $(".current-menu-item").first().find("a").first().html();
	
	if( htmlCurrentMenuItem == 'Home' || htmlCurrentMenuItem == 'Accueil')
		return true;
	else
		return false;
}