//JS-jQuery -- Popup de modification des informations du compte utilisateur
//fonction qui ouvre le popup
//appelé par un clique sur le bouton "Modifier ses informations" sur la page personnelle du compte utilisateur (compte.php)
function open_popup_infos_compte(){
	$("#popup_infos_compte_bg").show();
	$("#popup_infos_compte").show();
	$("#popup_infos_compte_bg").css("position","fixed");
}

function close_popup_infos_compte(){
	$("#popup_infos_compte_bg").hide();
	$("#popup_infos_compte").hide();
}

//JS-jQuery -- Popup des préférences
//fonction qui ouvre le popup
//appelé par un clique sur le bouton "Choisir ses préférences" sur la page personnelle du compte utilisateur (compte.php)
function open_popup_preferences(){
	$("#popup_preferences_bg").show();
	$("#popup_preferences").show();
	$("#popup_preferences_bg").css("position","fixed");
	$("#popup_preferences").css("position","fixed");
}

function close_popup_preferences(){
	$("#popup_preferences_bg").hide();
	$("#popup_preferences").hide();
}

$(document).ready(function(){
	//AJAX -- Contrôle des mots de passe entrés lors de la modification des informations compte
	//Initialement, rien n'est entré lorsque l'utilisateur ouvre la popup
	//Les champs sont indépendants les uns des autres : l'utilisateur peut soit modifier juste son avatar, soit juste son mail, soit juste sa date d'anniversaire, soit juste son sexe soit son mdp
	//s'il commence à entrer un nouveau mot de passe, le bouton de validation est désactivé tant que :
	//l'utilisateur n'a pas confirmé son mot de passe courant et que celui-ci a été validé
	//l'utilisateur n'a pas renseigné son nouveau mot de passe 
	//l'utilisateur n'a pas confirmé son mot de passe et que la correpsondance a été vérifiée
	//le code suivant gère tout ce contrôle au niveau des mots de passe
	$("#pwd,#mail,#new_pwd,#new_pwd_cfd").keyup(function(){
		var avatar=$("#infos_compte_avatar").val();
		var mail=$("#mail").val();
		var sexe1=$("#sexe1").val();
		var sexe2=$("#sexe2").val();
		var anniv=$("#anniv").val();
		var pseudo=$("#user_u").val();
		var pwd=$("#pwd").val(); //mdp en clair à crypter et à vérifier en php
		var new_pwd=$("#new_pwd").val();
		var new_pwd_cfd=$("#new_pwd_cfd").val();
		//on regarde coté serveur si le nouveau mail entré n'est pas déjà pris par un utilisateur existant
		if(mail.trim()!="" && mail.length!=0) //si champ mail rempli par autre chose que du vide
			$.post("/php/compte/ajax_verification_mail.php",{m:mail},function(response){
				if(response)
				{
					if(response=="OK")
					{
						$("#alert_mail_wrong").fadeOut("slow");
						$("#check_mail").fadeIn("slow");
					}
					else
					{
						$("#check_mail").fadeOut("slow");
						$("#alert_mail_wrong").fadeIn("slow");
					}
				}
			});
		else //si l'utilisateur efface toute sa sélection
		{
			$("#check_mail").fadeOut("slow");
			$("#alert_mail_wrong").fadeOut("slow");
			$("#infos_compte_submit_button").attr("disabled",true);
		}
		//on appelle le script php qui prend le mot de passe entré, l'encrypte, regarde s'il correspond ou pas au mot de passe actuel de l'user dans la bdd
		//renvoie OK si c'est bon, autre chose sinon
		if(pwd.trim()!="" && pwd.length!=0)
		{
			$.post("/php/compte/ajax_mdp_encryption.php",{psd:pseudo,mdp:pwd},function(response){
				if(response)
				{
					if(response=="OK")
					{
						$("#check").fadeIn("slow");
						if(new_pwd.trim()!="" && new_pwd_cfd.trim()!="")
						{
							if(new_pwd==new_pwd_cfd)
								$("#infos_compte_submit_button").attr("disabled",false);
							else
								$("#infos_compte_submit_button").attr("disabled",true);
						}
						else
							$("#infos_compte_submit_button").attr("disabled",true);
					}
					else
					{
						$("#check").fadeOut("slow");
						$("#infos_compte_submit_button").attr("disabled",true);
					}
				}
			});
		}
		else
			$("#infos_compte_submit_button").attr("disabled",true);
		//on regarde les nouveaux mots de passe entrés si au moins un caractère a été saisi (autre que le caractère " ")
		if(new_pwd.trim()!="" && new_pwd_cfd.trim()!="") 
		{
			if(new_pwd==new_pwd_cfd) //on les compare en clair, on aurait pu également comparer leur valeurs encryptées
			{
				$("#alert_new_pwd_wrong").fadeOut("slow");	
				$("#alert_new_pwd_right").fadeIn("slow");
			}
			else
			{
				$("#alert_new_pwd_right").fadeOut("slow");
				$("#alert_new_pwd_wrong").fadeIn("slow");
				$("#infos_compte_submit_button").attr("disabled",true);
			}
		}
		else //si un des deux champs du nouveau mdp n'est pas encore complété
		{
			$("#alert_new_pwd_right,#alert_new_pwd_wrong").fadeOut("slow");
			$("#infos_compte_submit_button").attr("disabled",true);
		}
		//si plus rien n'est entré dans les champs des mdp, on revient au stade initial
		if(new_pwd.trim()=="" && new_pwd_cfd.trim()=="" && pwd.trim()=="") 
		{
			$("#check").fadeOut("slow");
			$("alert_new_pwd_right,#alert_new_pwd_wrong").fadeOut("slow");
			$("#infos_compte_submit_button").attr("disabled",true);
		}
		//si l'utilisateur entre autre chose sauf mdp // on notera que la valeur de son sexe, si définie lors de son inscription, sera ici cochée par défaut...)
		if((avatar.trim()!="" || mail.trim()!="" || sexe1.trim()!="" || sexe2.trim()!="" || anniv.trim()!="") && (new_pwd.trim()=="" && new_pwd_cfd.trim()=="" && pwd.trim()==""))
			$("#infos_compte_submit_button").attr("disabled",false);
		else
			$("#infos_compte_submit_button").attr("disabled",true);
	});

	//JS-jQuery -- Changement des préférences
	//modification instantanée des exemples de couleur et de polices
	$("#select_color,#select_typo").change(function(){
		var color=$("#select_color option:selected").val();
		var police=$("#select_typo option:selected").val();
		if(color=="Rouge")
			$("#ex_color").css({"background-color":"#BC0404","color":"#fff"});
		if(color=="Bleu")
			$("#ex_color").css({"background-color":"#00073a","color":"#fff"});
		if(color=="Vert")
			$("#ex_color").css({"background-color":"#266d1f","color":"#fff"});
		if(police=="Trebuchet")
			$("#ex_typo").css("font-family","Trebuchet MS, sans-serif");
		if(police=="Arial")
			$("#ex_typo").css("font-family","Arial");
		if(police=="Calibri")
			$("#ex_typo").css("font-family","Calibri");
	});
});