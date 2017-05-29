//AJAX -- Barre de recherche de la page séries
//propose une liste de séries (series.php) après 5 caractères entrés dans la barre de recherche du main_content
function propositions_series()
{
	var json={series_name:$('#series_search_input').val()};
	if($('#series_search_input').val().length<5)
		$('#list_of_series').slideUp("slow");
	else
	{
		$.get('/php/series/ajax_propositions_series.php',json,function(response){
			if(response)
			{
				$('#list_of_series > ul').html(response);
				$('#list_of_series').slideDown("slow");
			}
			else
				$('#list_of_series').hide();
		});
	}
}

//JS-jQuery -- Popup de notation de série
//fonction qui ouvre le popup de notation de série
//appelé par un clique sur le bouton "Noter la série" (/series/fiche_serie_critiques.php)
function open_popup_review(){
	$("#popup_review_bg").show();
	$("#popup_review").show();
	$("#popup_review_bg").css("position","fixed");
}

function close_popup_review(){
	$("#popup_review_bg").hide();
	$("#popup_review").hide();
	$("#popup_review_bg").css("position","fixed");
	$("#popup_review").css("position","fixed");
	$("#alert_note").fadeOut("slow");
	$("#alert_review").fadeOut("slow");
}

//JS-jQuery -- Popup d'avertissement
//lorsque l'utilisateur souhaite noter une série mais qu'il n'est pas authentifié
//il est averti par le popup qui lui propose de s'identifier
//la page courante de la série est automatiquement enregistrée
//de cette façon, une fois connecté, l'uitilisateur sera directement renvoyé à cette page
function open_popup_review_connection_required(){
	$("#popup_review_bg").show();
	$("#popup_review_connection_required").show();
	$("#popup_review_bg").css("position","fixed");
	$("#popup_review_connection_required").css("position","fixed");
}

function close_popup_review_connection_required(){
	$("#popup_review_bg").hide();
	$("#popup_review_connection_required").hide();
}

$(document).ready(function(){
	//AJAX -- calcul de la moyenne d'une série
	//aucun rafraichissement nécessaire après votre ajout de note
	//vous entrer votre note et votre critique dans la popup review (code juste au dessus)
	//lorsque vous cliquez sur "valider la critique", vos entrées sont vérifiées, si remplies, evoyées au serveur (/php/series/ajax_calcul_moyenne.php)
	//celui-ci calcul la moyenne, met à jour celle-ci sur la page de la série
	//votre popup est désactivé (hide()) et...
	//MAGIE ! La moyenne est mise à jour !
	var s_id=$('#series_id').val(); //on récupère l'id de la série située dans un input masqué
	var json={series_id:s_id}; //on crée le fichier JSON
	console.log(s_id); //débug
	$.get('/php/series/ajax_calcul_moyenne.php',json,function(response){
			if(response)
			{
				$('#series_average').html(response); //on place dans la div (préparée dans le php) le contenu renvoyé par le serveur
				$('#series_average').fadeIn("slow");
			}
			else
				$('#series_average').hide();
		});
	close_popup_review();

	//JS-jQuery -- Système de vérification note série
	//Si la note n'est pas comprise entre 0 et 10, si elle est vide ou si la critique est vide, une alerte apparait, le bouton de soumission est désactivé
	$("#note,#review").keyup(function(){
		var s_id=$('#series_id').val();
		var user_note=parseInt($("#note").val());
		console.log(user_note);
		var user_review=$("#review").val();
		if(user_note>10 || user_note<0 || isNaN(user_note)) //si la note entrée par l'utilisateur n'est pas dans cet interval ou n'est pas renseignée, une alerte d'erreur est générée, le bouton de validation est désactivé
		{
			$("#alert_note").fadeIn("slow");
			$("#review_submit_button").attr("disabled",true);
		}
		else
			$("#alert_note").fadeOut("slow");
		if(user_review.trim()=='' && user_review.length!=0) //si le commentaire entré par l'utilisateur n'est pas dans cet interval, une alerte d'erreur est générée, le bouton de validation est désactivé
		{
			$("#alert_review").fadeIn("slow");
			$("#review_submit_button").attr("disabled",true);	
		}
		else
			$("#alert_review").fadeOut("slow");
		if(user_note<=10 && user_note>=0 && !isNaN(user_note) && user_review.trim()!='' && user_review.length!=0) //si les deux champs sont remplis dûment, expréssément, correctement... bon stop maintenant
		{
			$("#alert_review").fadeOut("slow");
			$("#review_submit_button").attr("disabled",false);
			$("#alert_note").fadeOut("slow");
			$("#review_submit_button").attr("disabled",false);
		}
	});

	//AJAX -- Ajout de critique
	//page: /php/fiche_serie.critiques.php
	//lorsque l'utilisateur est authentifié, il peut noter une série
	//une popup lui propose d'entrer une note et une critique
	//lorsqu'il clique sur "Valider", nous récupérons ce qu'il a entré dans ses champs et l'envoyons au serveur php (/php/series/ajax_noter_serie.php)
	//le serveur ajoute les données à la base de données et renvoie du html correspondant à la critique de l'utilisateur
	//celle-ci est incluse dans la page de critiques
	//on termine en faisant disparaitre la pop-up, l'utiliateur voit sa critique
	$("#review_submit_button").on("click",function(){
		var attr=$(this).attr("disabled");
		var s_id=$('#series_id').val();
		var user_note=parseInt($("#note").val());
		var user_review=$("#review").val();
		if(!attr)
		{			
			var s_id=$('#series_id').val();
			var user_note=parseInt($("#note").val());
			var user_review=$("#review").val();
			var json={id:s_id,note:user_note,review:user_review};
			$.post("/php/series/ajax_noter_serie.php",json,function(response){
				if(response)
				{
					$('#reviews_zone').html(response); //on place dans la div de critique utilisateur (préparée dans le php) le contenu renvoyé par le serveur
					$('#popup_review').html(""); //on enlève le contenu de la popup review
					$('#success').fadeIn("slow"); //on fait apparaitre le message de succès à la place
					sleep(5000);
				}
				else
					$('#popup_review').hide();
			});
			$('#popup_review').fadeOut("slow"); //on masque la popup
			$('#popup_review_bg').fadeOut("slow"); //et le fond de la popup
			$('#success').fadeOut("slow"); //on fait disparaitre également le message de succès
		}
		else
			return;
	});
	//l'utilisateur est de retour à la fiche de la série avec son commentaire ajouté !

	//JS-jQuery -- Onglet "SAISONS", page : fiche_serie.php
	//affiche/masque la liste des épisodes lorsque l'on clique/re-clique sur l'une des saisons
	$(".season_title").on("click",function(){
		var id=$(this).text(); //on récupère la chaine "Saison x" où x est le numéro de la saison
		id=id.substring(7,8); //on récupère de cette chaine uniquement le numéro
		var select="#zone_ep_"+id; //zone d'affichage des épisodes de la saison numéro x
		if($(select).css("display")=="none") //si cette zone n'est pas affichée, on l'affiche
		{	
			$(select).slideDown("slow");
			$(".close_div_series_button").slideDown("slow");
		}
		else //($(select).css("display")!="none") //sinon on la masque
			$(select).slideUp("slow");
	});

	//AJAX -- Vérification série déjà notée ou non
	//Si l'utilisateur a déjà noté la série
	var pseudo=$("#pseudo_u").val();
	var id_serie=$("#id_s").val();
	console.log(pseudo);
	$.post("/php/series/ajax_verification_notation_serie.php",{psd:pseudo,id:id_serie},function(response){
		if(response=="reviewed")
		{
			$("#review_desc").html("<p>Vous avez déjà noté cette série ! :)</p>");
			$("#review_desc > p").css({"color":"#BC0404","font-size":"18px"});
			$("#review_action").hide();
		}
	});

	//JS-jQuery -- input de recherche séries
	//met la valeur du li dans le input
	$('#list_of_series > ul').on('click','li#series',function(){
		$('#series_search_input').val($(this).text());
		$('#list_of_series').slideUp("slow");
	});
	//cache la liste quand défocus
	$(':not(#list_of_series)').on('click',function(){ //quand je clique sur qqch qui est hors de la zone de la liste des séries
		$('#list_of_series').slideUp("slow");
	});
});