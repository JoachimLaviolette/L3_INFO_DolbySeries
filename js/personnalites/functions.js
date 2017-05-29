//AJAX -- Barre de recherche de la page personnalités
//propose une liste de personnalités (personnalites.php) après 5 caractères entrés dans la barre de recherche du main_content
function propositions_perso()
{
	var json={perso_name:$('#perso_search_input').val()};
	if($('#perso_search_input').val().length<5)
		$('#list_of_perso').slideUp("slow");
	else
	{
		$.get('/php/personnalites/ajax_propositions_perso.php',json,function(response){
			if(response)
			{
				$('#list_of_perso > ul').html(response);
				$('#list_of_perso').slideDown("slow");
			}
			else
				$('#list_of_perso').hide();
		});
	}
}

$(document).ready(function(){
	//JS-jQuery -- input de recherche personnalités
	//met la valeur du li dans le input
	$('#list_of_perso > ul').on('click','li#perso',function(){
		$('#perso_search_input').val($(this).text());
		$('#list_of_perso').slideUp("slow");
	});
	//cache la liste quand défocus
	$(':not(#list_of_perso)').on('click',function(){ //quand je clique sur qqch qui est hors de la zone de la liste des persos
		$('#list_of_perso').slideUp("slow");
	});
});