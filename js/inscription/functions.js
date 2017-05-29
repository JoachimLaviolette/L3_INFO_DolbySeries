$(document).ready(function(){
	//AJAX -- Contrôle des informations lors d'une inscription
	//l'utilisateur qui souhaite s'inscrire doit entrer un mail (optionnel), un pseudo (obligatoire) un mdp et confirmer celui-ci
	//l'utilisateur peut également sélectionner son sexe mais cette information est optionnelle pour s'inscrire, il pourra la modifer depuis sa page perso
	//l'utilisateur se voit automatique et par défaut administrer l'avatar de base de DOLBY-SERIES, EH OUI !
	//il pourra modifier son avatar depuis sa page personnelle également.. bien évidemment.. on pense au plaisir de chacun !
	$("#mail,#pseudo,#pwd,#pwd_cfd").keyup(function(){
		var mail=$("#mail").val();
		var pseudo=$("#pseudo").val();
		var pwd=$("#pwd").val();
		var pwd_cfd=$("#pwd_cfd").val();
		if(mail.trim()!="" && mail.length!=0) //si champ mail rempli par autre chose que du vide
			$.post("/php/inscription/ajax_verification_mail.php",{m:mail},function(response){
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
			$("#sign_up_submit_button").attr("disabled",true);
		}
		if(pseudo.trim()!="") //si champs pseudo rempli par autre chose que du vide
			$.post("/php/inscription/ajax_verification_pseudo.php",{p:pseudo},function(response){
				if(response)
				{
					if(response=="OK")
					{
						$("#alert_pseudo_wrong").fadeOut("slow");
						$("#check_pseudo").fadeIn("slow");
						if(pseudo.trim()!="" && pwd.trim()!="" && pwd_cfd.trim()!="")
							if(pwd==pwd_cfd)
								$("#sign_up_submit_button").attr("disabled",false);
					}
					else
					{
						$("#check_pseudo").fadeOut("slow");
						$("#alert_pseudo_wrong").fadeIn("slow");
						$("#sign_up_submit_button").attr("disabled",true);
					}
				}
			});
		else //si l'utilisateur efface toute sa sélection
		{
			$("#check_pseudo").fadeOut("slow");
			$("#alert_pseudo_wrong").fadeOut("slow");
			$("#sign_up_submit_button").attr("disabled",true);
		}
		if(pwd.trim()!="" && pwd_cfd.trim()!="") //si les deux champs mdp remplis par autre chose que du vide
		{
			if(pwd!=pwd_cfd)
			{
				$("#alert_pwd_wrong").fadeIn("slow");
				$("#alert_pwd_right").fadeOut("slow");
				$("#sign_up_submit_button").attr("disabled",true);
			}
			else
			{
				$("#alert_pwd_right").fadeIn("slow");
				$("#alert_pwd_wrong").fadeOut("slow");
			}
		}
		else //si un des deux champs mdp vide
		{
			$("#alert_pwd_wrong").fadeOut("slow");
			$("#alert_pwd_right").fadeOut("slow");
			$("#sign_up_submit_button").attr("disabled",true);
		}
	});
});