function verif(){
	if($("#form-password").val()!= $("#form-password2").val())	
		$("#verif_password").show();

	else
		$("#verif_password").hide();
}