//AJAX -- Barre de recherche du header
//propose une liste de séries et d'individus correspondant à la suite e caractères (à partir de 5) entrés par l'utilisateur
//il s'agit d'un moteur de recherche fièrement réalisé, (et qui rend plutôt bien je trouve
//voir les script php qui gère la reûête faite en AJAX : /php/ajax_propositions_search.php
function propositions_search()
{
	var json={val:$("#header_search_input").val()};
	if($("#header_search_input").val().length<5)
		$("#list_of_search").slideUp("slow");
	else
	{
		$.get("/php/ajax_propositions_search.php",json,function(response){
			if(response)
			{
				$("#list_of_search > ul").html(response);
				$("#list_of_search").css("width","360px");
				$("#list_of_search").slideDown("slow");
			}
			else
				$("#list_of_search").hide();
		});
	}
}

//JS-jQuery -- Popup footer "développeurs"
//fonction qui ouvre le popup
function open_popup_dev(){
	$("#slideshow_title").css({"z-index":"0"});
	$("#slideshow_blank_space").css({"z-index":"0"});
	$("#popup_dev_bg").show();
	$("#popup_dev").show();
	$("#popup_dev_bg").css("position","fixed");
	$("#popup_dev").css("position","fixed");
}

function close_popup_dev(){
	$("#popup_dev_bg").hide();
	$("#popup_dev").hide();
}

//JS-jQuery -- Popup footer "contact"
//fonction qui ouvre le popup
function open_popup_contact(){
	$(".contact_logo").css("width","25%");
	$("#slideshow_title").css({"z-index":"0"});
	$("#slideshow_blank_space").css({"z-index":"0"});
	$("#popup_contact_bg").show();
	$("#popup_contact").show();
	$("#popup_contact_bg").css("position","fixed");
	$("#popup_contact").css("position","fixed");
}

function close_popup_contact(){
	$("#popup_contact_bg").hide();
	$("#popup_contact").hide();
}

$(document).ready(function() 
{
	//JS-jQuery
	//met la valeur du li (nom de la série ou de l'individu) dans l'input
	$("#list_of_search > ul").on("click","#search",function(){
		var series_header=$(this).text(); //Colony, Etats-Unis (2016) :: exemple
		var series_name=series_header.substring(0,series_header.indexOf(",",0)); //on récupère uniquement le nom de la série
		$("#header_search_input").val(series_name);
		$("#list_of_search").slideUp("slow");
	});
	//masque la liste déroulante lorsque l'utilisateur clique en dehors de la zone de la liste des résultats de la recherche (*respire*)
	$(":not(#list_of_search)").on("click",function(){
		$("#list_of_search").slideUp("slow");
	});

	//AJAX -- Sélection de série par critère
	//index.php
	//sélection par genre
	//script php générant la requête AJAX : /php/ajax_propositions_by_genre.php
	$(".div_genre").on("click",function(){ //si on clique sur un genre
		var old_genre=$(".selected").text(); //on récupère le nom de l'ancien genre
		var genre=$(this).text(); //on récupère le nom du genre sur lequel on clique 
		//si la zone d'affichage des séries par genre était déjà affichée, donc si l'utilisateur avait par exemple cliqué sur Action
		//ET que l'on clique sur la même genre
		if($("#div_series_by_genre").css("display")!="none" && genre==old_genre)
		{
			$("#div_series_by_genre").slideUp("slow"); //alors on masque la zone
			$(".close_div_series_button").slideUp("slow"); //on masque également le bouton "Fermer"
			$(this).removeClass("selected"); //on enlève la classe "sélectionné" au genre (enlève le caractère gras au libellé)
		}
		else //si la zone d'affichage de séries par genre n'est pas affichée ou que l'on clique sur un autre genre
		{
			$(".selected").removeClass("selected"); //on déselectionne le critère précédent
			$(this).addClass("selected"); //on ajoute au critère choisi la classe "sélectionné" (qui met le critère en gras et augmente sa taille de police)
			var json={val_genre:genre}; //on crée le fichier JSON contenant le nom de l'genre
			$.get("/php/ajax_propositions_by_genre.php",json,function(response){
				if(response)
				{
					$("#div_series_by_genre").html(response); //on stocke le résultat renvoyé par le serveur dans la zone d'affichage réservée aux séries triées par genre
					$("#div_series_by_genre").hide(); //on enlève la classe "sélectionné" au genre
					//on masque toute zone apparente 
					if($("#div_series_by_genre").css("display")!="none")
						$("#div_series_by_genre").slideUp("slow");
					if($("#div_series_by_year").css("display")!="none")
						$("#div_series_by_year").slideUp("slow");
					if($("#div_series_by_country").css("display")!="none")
						$("#div_series_by_country").slideUp("slow");
					//puis on affiche la nouvelle zone genre
					$("#div_series_by_genre").slideDown("slow");
					$(".close_div_series_button").slideDown("slow");
				}
				else
					$("#div_series_by_genre").hide();
			});
		}
	});

	//AJAX -- Sélection de série par critère
	//index.php
	//sélection par année
	//script php générant la requête AJAX : /php/ajax_propositions_by_year.php
	$(".div_year").on("click",function(){ //si on clique sur une année
		var old_year=$(".selected").text(); //on récupère le nom de l'ancienne année
		var year=$(this).text(); //on récupère le nom l'année sur laquelle on clique 
		//si la zone d'affichage des séries par année était déjà affichée, donc si l'utilisateur avait par exemple cliqué sur 2010
		//ET  que l'on clique sur la même année
		if($("#div_series_by_year").css("display")!="none" && year==old_year)
		{
			$("#div_series_by_year").slideUp("slow"); //alors on masque la zone
			$(".close_div_series_button").slideUp("slow"); //on masque également le bouton "Fermer"
			$(this).removeClass("selected"); //on enlève la classe "sélectionné" à l'année (enlève le caractère gras au libellé)
		}
		else //si la zone d'affichage de séries par année n'est pas affichée ou que l'on clique sur une autre année
		{
			$(".selected").removeClass("selected"); //on déselectionne le critère précédent
			$(this).addClass("selected"); //on ajoute au critère choisi la classe "sélectionné" (qui met le critère en gras et augmente sa taille de police)
			var json={val_year:year}; //on crée le fichier JSON contenant le nom de l'année
			$.get("/php/ajax_propositions_by_year.php",json,function(response){
				if(response)
				{
					$("#div_series_by_year").html(response); //on stocke le résultat renvoyé par le serveur dans la zone d'affichage réservée aux séries triées par année
					$("#div_series_by_year").hide(); //on enlève la classe "sélectionné" à l'année
					//on masque toute zone apparente 
					if($("#div_series_by_genre").css("display")!="none")
						$("#div_series_by_genre").slideUp("slow");
					if($("#div_series_by_year").css("display")!="none")
						$("#div_series_by_year").slideUp("slow");
					if($("#div_series_by_country").css("display")!="none")
						$("#div_series_by_country").slideUp("slow");
					//puis on affiche la nouvelle zone année
					$("#div_series_by_year").slideDown("slow");
					$(".close_div_series_button").slideDown("slow");
				}
				else
					$("#div_series_by_year").hide();
			});
		}
	});

	//AJAX -- Sélection de série par critère
	//index.php
	//sélection par pays
	//script php génrant la requête AJAX : /php/ajax_propositions_by_country.php
	$(".div_country").on("click",function(){ //si on clique sur un pays
		var old_country=$(".selected").text(); //on récupère le nom de l'ancien pays
		var country=$(this).text(); //on récupère le nom du pays sur lequel on clique
		//si la zone d'affichage des séries par pays était déjà affichée, donc si l'utilisateur avait par exemple cliqué sur Etats-Unis
		//ET que l'on clique sur le même pays
		if($("#div_series_by_country").css("display")!="none" && country==old_country) 
		{
			$("#div_series_by_country").slideUp("slow"); //alors on masque la zone
			$(".close_div_series_button").slideUp("slow"); //on masque également le bouton "Fermer"
			$(this).removeClass("selected"); //on enlève la classe "sélectionné" au pays (enlève le caractère gras au libellé)
		}
		else //si la zone d'affichage de séries par pays n'est pas affichée ou que l'on clique sur un autre pays
		{
			$(".selected").removeClass("selected"); //on déselectionne le critère précédent
			$(this).addClass("selected"); //on ajoute au critère choisi la classe "sélectionné" (qui met le critère en gras et augmente sa taille de police)
			var json={val_country:country}; //on crée le fichier JSON contenant le nom du pays
			$.get("/php/ajax_propositions_by_country.php",json,function(response){ //requête GET au serveur
				if(response)
				{
					$("#div_series_by_country").html(response); //on stocke le résultat renvoyé par le serveur dans la zone d'affichage réservée aux séries triées par pays
					$("#div_series_by_country").hide(); //on masque la zone d'affichage de séries par pays
					//on masque toute zone apparente 
					if($("#div_series_by_genre").css("display")!="none")
						$("#div_series_by_genre").slideUp("slow");
					if($("#div_series_by_year").css("display")!="none")
						$("#div_series_by_year").slideUp("slow");
					if($("#div_series_by_country").css("display")!="none")
						$("#div_series_by_country").slideUp("show");
					//puis on affiche la nouvelle zone pays
					$("#div_series_by_country").slideDown("slow");
					$(".close_div_series_button").slideDown("slow");
				}
				else
					$("#div_series_by_country").hide();
			});
		}
	});

	//JS-jQuery -- Yt Video
	//formatage de la vidéo
	$("#yt_video").css("width",(parseInt($("main").css("width"))+1)+"px");
	$("#yt_video").css("margin","0");
	
	//JS-jQuery -- Slideshow
	//index.php
	var largeur=$("main").css("width"); //on récupère la largeur du main
	$("#slideshow_container").css("width",largeur); //on formate la taille du conteneur du slideshow avec la largeur du main
	$(".slideshow_bg_pic").css("width",largeur); //on formate la taille des images du slideshow avec la largeur du main
	var largeur2=$(".sa_right").css("width");
	$(".sa_right").css("left",(parseInt(largeur)-parseInt(largeur2)+1)+"px"); //on place la flèche droite de sélection
	var hauteur=$(".slideshow_bg_pic").css("height"); //on récupère la hauteur d'un slide
	var hauteur2=$(".sa_right").css("height"); //on récupère la hauteur de la flèche
	$(".sa_right, .sa_left").css("top","43%"); //on positionne les flèches à la bonne hauteur
	$(".sa_left").css("left","0px");
	//maintenant, les flèches seront normalement toujours centrées verticalement et aux extrémités du slideshow
	var slide_index=1; //index de départ : slide n°1
	var new_slide_index=slide_index; //par défaut, l'index de départ est le même que le premier index
	show_slide(slide_index);//on affiche le slide correspondant (par défaut: le premier)
	//cf. en dessous : fonction show_slide()
	//fin slideshow
});

//JS-jQuery -- Ferme les zones oé sont affichées les séries affichées par critères : genre/année/pays
//fonction déclecnhée par le clique du bouton "Fermer"
function close_div_series_zone(){
	$("#div_series_by_genre").slideUp("slow");
	$(".close_div_series_button").slideUp("slow");
	$("#div_series_by_year").slideUp("slow");
	$(".close_div_series_button").slideUp("slow");
	$("#div_series_by_country").slideUp("slow");
	$(".close_div_series_button").slideUp("slow");
	$(".selected").removeClass("selected");
}

//JS-jQuery -- Indique à la fonction d'affichage de slides (show_slide()) qu'il faut modifier le slide à afficher
//shift_slide() prend en paramètre 1 (si clique sur flèche droite) ou -1 (si clique su flèche gauche)
//il met à jour le index du slide à afficher et demande à la fonction show_slide() d'afficher le slide correspondant
function shift_slide(new_index)
{
	var old_slide_index=$(".shown").attr("id"); //on récupère l''id du slide courant (classe "shown")
	//l'id est le suivant : "slide_x" où x est l'index du slide affiché
	//old_slide_index.lastIndexOf("_")+1 indique la position du numéro du slide dans la chaine "slide_x" (on aurait évidemment pu utiliser indexOf() vu qu'il n'y a qu'un "_" dans le nom de la classe)
	//la ségmentation sera faite, par défaut, jusqu'à la fin de la chaine
	//les id étant précisément définis, on peut omettre de préciser la position de fin de segmentation dans la chaine
	//nous savons qu'il ne restera que le numéro, que l'on souhaite récupéré, à lire dans celle-ci
	//par exemple : dans "slide_x"
	//old_slide_index.indexOf("_")+1 renverra 6 (le +1 nécessaire car premier index de chaine à 0 !)
	console.log(old_slide_index); //débug :: affiche la CHAINE "3"
	old_slide_index=parseInt(old_slide_index.substring(old_slide_index.indexOf("_")+1)); //convertit la chaine "x" en entier x, où x est l'index que l'on souhaite récupérer !
	console.log(old_slide_index); //débug :: affiche l'ENTIER 3
	var new_slide_index=old_slide_index+new_index; //on calcule l'index du nouveau slide (+1 ou -1, flèche droite/flèche gauche)
	show_slide(new_slide_index); //on demande à la vue de se mettre à jour (OK on n'est pas en MVC mais le principe est (presque) le même !)
}

//JS-jQuery -- Indique à la fonction d'affichage de slide le slide à afficher, correspondant à l'indicateur sur lequel on clique (disques présents sous le slideshow)
//évent onclick associé aux indicateurs
//les paramètres sont prédéfinis : en cliquant sur le premier, la fonction select_slide() sera appelée avec en paramètre 1
//								   en cliquant sur le deuxième, la fonction select_slide() sera appelée avec en paramètre 2 
function select_slide(new_index)
{
	show_slide(new_index);
}

//JS-jQuery -- Affiche le slide correspondant à l'indicateur sur lequel on clique (disques présents sous le slideshow)
function show_slide(new_slide_index)
{
	var old_slide_index=$(".shown").attr("id"); //recupère l'id "slide_x" ou x est le numéro du slide courant qui va etre switché
	if(typeof old_slide_index!="undefined") //si on vient de charger la page d'accueil seulement
	{
		old_slide_index=parseInt(old_slide_index.substring(old_slide_index.lastIndexOf("_")+1)); //recupère l"index de l'ancien slide
		var old_slide_id="#slide_"+old_slide_index; //récupère l'id de l'ancien slide
		var old_slide_bs="#slideshow_blank_space_"+old_slide_index; //récupère l'id du blank space 
		var old_slide_title="#slideshow_title_"+old_slide_index; //récupère le titre associé au slide (titre de la série en l'occurrence)
		$(old_slide_id).removeClass("shown"); //on enlève au slide enlève sa classe "montré"
		$(old_slide_bs).removeClass("shown");  //de même pour son blank space
		$(old_slide_title).removeClass("shown"); //de même pour son titre
		var id_index="#id_"+old_slide_index; //récupère l'id de son indentificateur
		$(id_index).removeClass("active"); //le désactive
	}	
	var new_slide_id="#slide_"+new_slide_index; //récupère l'id du nouveau
	var new_slide_bs="#slideshow_blank_space_"+new_slide_index; //récupère l'id de son blank space
	var new_slide_title="#slideshow_title_"+new_slide_index; // récupère l'id de son titre
	$(new_slide_id).addClass("shown"); //on lui ajoute la classe "montré"
	$(new_slide_bs).addClass("shown"); //de même pour son blank space
	$(new_slide_title).addClass("shown"); //de même pour son titre
	var id_index="#id_"+new_slide_index; //on récupère l'id de son identificateur
	$(id_index).addClass("active"); //on l'acitve
	//animations (pour une prochaine fois sûrement... snif)
	/*if(old_slide_index<new_slide_index)//
	{	
		/*$("#slide_1").animate({right: largeur});
		$("#slide_2").animate({right: largeur});
		$("#slide_3").animate({right: largeur});
		$("#slide_4").animate({right: largeur});
		$("#slide_5").animate({right: largeur});
		console.log("aaa");
		//$("#slideshow").animate({right: largeur},"slow");
		//toggle
	}
	if(old_slide_index>new_slide_index)
	{
		$("#slide_1").animate({left: largeur});
		$("#slide_2").animate({left: largeur});
		$("#slide_3").animate({left: largeur});
		$("#slide_4").animate({left: largeur});
		$("#slide_5").animate({left: largeur});
		console.log("bbb");
		$(new_slide_id).animate({left: largeur});
		$(old_slide_id).animate({left: largeur});
		//$("#slideshow").animate({left: largeur},"slow");
	}*/
	$("#slideshow > img").not(".shown").hide(); //on cache les autres slides
	$("#slideshow > div").not(".shown").hide();
	$(".shown").fadeIn(500); //on fait pop le nouveau sélectionné
	if(new_slide_index==1) //si on est sur premier slide, on fait disparaitre la flèche de gauche
		$(".sa_left").hide();
	else
		$(".sa_left").show(); //parce que oui, par défaut, elles sont absentes, on pourrait très bien enlever ce else et les mettre en visible par défaut (.. au choix !)
	if(new_slide_index==5) //si on est sur le dernier slide, on fait disparaitre la flèche de droite
		$(".sa_right").hide();
	else
		$(".sa_right").show();
}

