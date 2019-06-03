function changeCedis(val){
	var str = window.location.search;
	str = replaceQueryParam('task', 'delivery', str);  
	str = replaceQueryParam('cedis', val , str);    
	window.location = window.location.pathname + str;
}

function replaceQueryParam(param, newval, search) {
	var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
	var query = search.replace(regex, "$1").replace(/&$/, '');

	return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}

var toggle = false;
function editAddress(){
	var state = document.getElementById('field-state');
	document.getElementById('field-city').readOnly = toggle;
	document.getElementById('field-town').readOnly = toggle;

	if (toggle)
		state.classList.add('disabled');
	else
		state.classList.remove('disabled');


	toggle = !toggle;
}