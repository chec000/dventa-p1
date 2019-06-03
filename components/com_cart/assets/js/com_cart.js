/*General JS*/

function cart_remove(val){
    var name = val.name;
    var price = getPrice(val);
    var quantity = getQuantity(val);
    if (quantity > 1) {
        quantity -= 1;
        setQuantity(name, quantity);
        setLineTotal(name, price, quantity);    
        setTotal();
    }
}

function cart_add(val){
    var name = val.name;
    var price = getPrice(val);
    var quantity = getQuantity(val);
    if (quantity < 999) {
        quantity += 1;
        setQuantity(name, quantity);
        setLineTotal(name, price, quantity);    
        setTotal();
    }
}

function setLineTotal(name, price, quantity) {
    var lineTotal = price * quantity;
    var nf = new Intl.NumberFormat('es-MX');
    document.getElementById('cart-details__lineTotal-cell_' + name).innerHTML = nf.format(lineTotal);
    document.getElementById('cart-details__lineTotal-cell-val_' + name).value = lineTotal;
}

function getQuantity(val){
    var current_item = val.name;
    var quantity = parseFloat(document.getElementById('quantity-input_' + current_item).value);
    return quantity;
}

function setQuantity(name, value){
    cartId = getCartId(name);
    updateItem(cartId, value);
    document.getElementById('quantity-input_' + name).value = value;
}

function getPrice(val){
    var current_item = val.name;
    var price = document.getElementById('cart-details__price-cell_' + current_item).value;
    return price;
}

function getCartId(val){
    cartId = document.getElementById('delete-btn_' + val).value;
    return cartId;
}

function setTotal(){
    var lineTotalElements = document.getElementsByName('lineTotal');
    var total = 0;
    var nf = new Intl.NumberFormat('es-MX');

    for (var i = 0; i < lineTotalElements.length; i++)
        total += parseFloat(lineTotalElements[i].value);

    document.getElementById('cart-details__cart-total-cell').innerHTML = nf.format(total);
}

function deleteItem(val) {
    var itemId = val.value;

    var str = window.location.search;
    str = replaceQueryParam('task', 'deleteItem', str); 
    str = replaceQueryParam('id', itemId, str);
    window.location = window.location.pathname + str;
}

function updateItem(id, val) {
    var str = window.location.search;
    str = replaceQueryParam('task', 'updateItem', str); 
    str = replaceQueryParam('id', id, str);
    str = replaceQueryParam('quantity', val, str);
    window.location = window.location.pathname + str;
}

function emptyCart(){
    var str = window.location.search;
    str = replaceQueryParam('task', 'emptyCart', str);
    window.location = window.location.pathname + str;
}

function replaceQueryParam(param, newval, search) {
    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
    var query = search.replace(regex, "$1").replace(/&$/, '');

    return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}