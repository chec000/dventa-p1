var checked = true;
function check_all(){
	var elements = document.getElementsByName('checkbox-item');
	for(var i=0; i < elements.length; i++){
		elements[i].checked = checked;
	}
	checked = !checked;
}

function getProducts(){
	var products = '';
	var elements = document.getElementsByName('checkbox-item');
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			products += elements[i].value + ',';
		}
	}
	products = products.slice(0, -1);
	return products;
}

function onCheckout(){
	var products = getProducts();
	if (products != '') {
		var r = confirm(Joomla.JText._('COM_WISHLIST_CHECKOUT_CONFIRM_MSG'));
		if (r == true) {
			actionProducts(products, 'checkout');
		}
	}
}

function onDelete(){
	var products = getProducts();
	if (products != '') {
		var r = confirm(Joomla.JText._('COM_WISHLIST_DELETE_CONFIRM_MSG'));
		if (r == true) {
			actionProducts(products, 'deleteList');
		}
	}
}

function actionProducts(products, task){
	var str = window.location.search;
	str = replaceQueryParam('task', task, str);  
	str = replaceQueryParam('products', products, str);
	window.location = window.location.pathname + str;
}

function replaceQueryParam(param, newval, search) {
	var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
	var query = search.replace(regex, "$1").replace(/&$/, '');

	return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}