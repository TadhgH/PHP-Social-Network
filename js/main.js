$(document).ready(function(){

/*$("#postForm_input").on('click', function(){
	send_post();
});

function send_post() {
	var hr = new XMLHttpRequest();
	var url = "send_post.php";

	var fn = document.getElementById("post").value;
	var vars ="post="+fn;
	hr.open("POST", url, true);

	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
		}
	}
	hr.send(vars);
	document.getElementById("status").innerHTML = "processing...";
}*/

function compare(oldv, newv){
	if(oldv == newv){
		return true;
	} else {
		return false;
	}
}

function clear(){
	$('#oldpassword').val("");
	$('#newpassword').val("");
	$('#repeatpassword').val("");
}


$("#sendpass").on('click', function(e){
	e.preventDefault();
	var oldpass = $('#oldpassword').val();
	var newpass = $('#newpassword').val();
	var repass = $('#repeatpassword').val();

	var fname = $('#fname').val();
	var lname = $('#lname').val();

	var bool = false;
	

	$.post("getpass.php", {oldpass:oldpass}, function(data){
		if(data == 1){
			if(newpass == repass){
				if(newpass.length >= 5){
					$.post("account_settings.php",{newp:newpass});
					alert("passwords change");
					clear();
				} else {
					alert("new password must be 5 characters or more");
					clear();
				}
			} else {
				alert("passwords dont match");
				clear();
			}
		} else {
			alert("incorrect password");
			clear();
		}
	});
});

$('#sendbio').on('click', function(){
	//e.preventDefault();
	var fname = $('#fname').val();
	var lname = $('#lname').val();
	var bio = $('#bio').val();

	var data = {fname:fname, lname:lname, bio:bio};
	
	$.ajax({
		type: 'POST',
		url: 'upbio.php',
		data: data,
		async: false
	});

	
});

});