$(document).ready(function(){
	//AJAX -- Vérification du pseudo entré lors de la connexion
	//si le pseudo entré n'existe pas, le bouton de connexion sera désactivé
	//si le pseudo existe mais que le mdp entré ne correspond pas à celui (dans la bdd) associé à l'utilisateur mentionné, le bouton de connexion sera désactivé
	//on prendra soin de prévenir nos chers internautes, c'est bien parce qu'on est des gentils !
	$("#pseudo,#pwd").keyup(function(){
		var pseudo=$("#pseudo").val();
		var mdp=$("#pwd").val();
		//nous utilisons ici le même script php utilisé pour l'inscription
		//ici nous allons nous en servir dans l'autre sens, c'est-à-dire que dans pour l'inscription, nous voulions vérifier si un utilisateur 
		//possédait déjà le pseudo indiqué, si c'était le cas nous disions STOP.
		//Dans le cas présent, nous voulons justement nous assurer qu'un utilisateur possède le pseudo indiqué, du coup si le script nous retroune "OK"
		//nous indiquerons à l'utilisateur qui cherche à se connecter que le pseudo qu'il indique existe bel et bien
		//*ils sont durs à suivre sur Dolby Series...*
		if(pseudo.trim()!="")
		{
			$.post("/php/connexion/ajax_verification_pseudo.php",{p:pseudo},function(response){
				if(response=="OK") //le script retourne "OK" si un utilisateur possède le pseudo indiqué, ce que l'on veut ici
				{
					$("#alert_pseudo_wrong").fadeOut("slow");
					$("#check_pseudo").fadeIn("slow");
					if(mdp.trim()!="")
					{
						$.post("/php/connexion/ajax_verification_pseudo_mdp.php",{p:pseudo,m:mdp},function(response){
							if(response=="OK") //le script retourne "OK" si la correspondance du mdp indiqué avec le pseudo renseigné est correcte et validée sur le serveur
							{
								$("#alert_pwd_wrong").fadeOut("slow");
								$("#check_pwd").fadeIn("slow");
								$("#login_submit_button").attr("disabled",false);
							}
							else
							{
								$("#alert_pwd_wrong").fadeIn("slow");
								$("#check_pwd").fadeOut("slow");
								$("#login_submit_button").attr("disabled",true);
							}
						});
					}
					else
					{
						$("#check_pwd").fadeOut("slow");
						$("#alert_pwd_wrong").fadeOut("slow");
						$("#login_submit_button").attr("disabled",true);
					}
				}
				else
				{
					$("#alert_pseudo_wrong").fadeIn("slow");
					$("#check_pseudo").fadeOut("slow");
					$("#login_submit_button").attr("disabled",true);
				}
			});
		}
		else
		{
			$("#check_pseudo").fadeOut("slow");
			$("#alert_pseudo_wrong").fadeOut("slow");
			$("#login_submit_button").attr("disabled",true);
		}
	});
});