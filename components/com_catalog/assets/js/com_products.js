/*js for filter*/


function filter_clear(){
	document.getElementById('product-picker__search-input').value = "";
	document.getElementById("category-filters__all-input").checked = true;
	var checkboxes = document.getElementsByTagName('input');

    for (var i = 0; i < checkboxes.length; i++)
    {
        if (checkboxes[i].type == 'checkbox')
            checkboxes[i].checked = true;
    }

    var str = window.location.search;
    str = replaceQueryParam('task', 'sortField', str)
    str = replaceQueryParam('q', '', str)
    str = replaceQueryParam('field', 'title', str)    
    str = replaceQueryParam('sortOrder', 'asc', str)    
    str = replaceQueryParam('categories', 'all', str)    
    str = replaceQueryParam('minPrice', 'min', str)    
    str = replaceQueryParam('maxPrice', 'max', str)    
    str = replaceQueryParam('Size', '9', str)       
    str = replaceQueryParam('page', '1', str)   
    window.location = window.location.pathname + str
}

var timeout = null;
function filter_search(val){
    if (timeout) {  
        clearTimeout(timeout);
    }
    timeout = setTimeout(function() {
        search(val);
    }, 1000);
}

function search(val){
    var str = window.location.search;

    var search = document.getElementById('product-picker__search-input').value;

    str = replaceQueryParam('q', search, str)    
    str = replaceQueryParam('page', '1', str)
    window.location = window.location.pathname + str
}

function replaceQueryParam(param, newval, search) {
    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
    var query = search.replace(regex, "$1").replace(/&$/, '');

    return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}

function filter_all(val){
    var checkboxes = document.getElementsByTagName('input'), val = null;    
    for (var i = 0; i < checkboxes.length; i++)
    {
        if (checkboxes[i].type == 'checkbox')
        {
            if (val === null) val = checkboxes[i].checked;
            checkboxes[i].checked = val;
        }
    }
}

function onFilter(){
    var minPrice='min', maxPrice='max';
    var filterMin = document.getElementById('filter_price-min');
    var filterMax = document.getElementById('filter_price-max');

    if (filterMin !== null) {
        minPrice = filterMin.value;
    }
    if (filterMax !== null) {
        maxPrice = filterMax.value;
    }
    var categories = getCategories();
    filter(categories, minPrice, maxPrice);
}

function getCategories(){
    var checkboxes = document.getElementsByTagName('input');
    var categories = '';
    for (var i = 1; i < checkboxes.length; i++)
    {
        if (checkboxes[i].type == 'checkbox'){
            if (checkboxes[i].checked) {
                categories += checkboxes[i].value + ',';
            }
        }
    }
    if (categories == '')
        categories = 'none'

    categories = categories.slice(0, -1);

    return categories;
}

function filter(cat, minPrice, maxPrice){
    var str = window.location.search;
    str = replaceQueryParam('task', 'sortField', str);  
    str = replaceQueryParam('categories', cat, str);    
    str = replaceQueryParam('minPrice', minPrice, str);    
    str = replaceQueryParam('maxPrice', maxPrice, str);    
    str = replaceQueryParam('page', '1', str);
    window.location = window.location.pathname + str;
}

function filter_one(){
	document.getElementById("category-filters__all-input").checked = false;
}

function filter_price() {
    var minRange = document.getElementById('filter_price-min').value;    
    var maxRange = document.getElementById('filter_price-max').value;

    var nf = new Intl.NumberFormat();
    document.getElementById('input_minPrice').innerHTML = nf.format(minRange);
    document.getElementById('input_maxPrice').innerHTML = nf.format(maxRange);
}

/*js for ordering*/
function titleOrder(){
    var title = document.getElementById("products_sort-btn-title");    
    var price = document.getElementById("products_sort-btn-price"); 
    title.classList.add("is-active");
    price.classList.remove("is-active");

    var str = window.location.search;
    str = replaceQueryParam('field', 'title', str)
    str = replaceQueryParam('sortOrder', 'asc', str)   
    window.location = window.location.pathname + str
}

function priceOrder(){    
    var price = document.getElementById("products_sort-btn-price");    
    var title = document.getElementById("products_sort-btn-title");
    price.classList.add("is-active");
    title.classList.remove("is-active");

    var str = window.location.search;
    str = replaceQueryParam('field', 'price', str);
    str = replaceQueryParam('sortOrder', 'desc', str);
    window.location = window.location.pathname + str;
}

/*js for pagination*/
function change_page(val){
    var page = val.innerHTML;
    var page_current = parseFloat(getQueryParams(document.location.search).page);        
    var page_last = parseFloat(document.getElementById('page-last').innerHTML);

    if (isNaN(page_current)) 
        page_current = parseFloat('1');

    if (page == Joomla.JText._('COM_CATALOG_PAGE_FIRST')) {
        page = '1';
    }

    if (page == Joomla.JText._('COM_CATALOG_PAGE_PREVIOUS')){        
        page_current -= 1;    
        page = page_current;
    } 

    if (page == Joomla.JText._('COM_CATALOG_PAGE_NEXT')){        
        page_current += 1;    
        page = page_current;
    } 

    if (page == Joomla.JText._('COM_CATALOG_PAGE_LAST')) {
        page = page_last;
    }

    if (page >= page_last) {
        page = page_last;
    }    

    if (page < 1) {
        page = 1;
    }

    var str = window.location.search;
    str = replaceQueryParam('task', 'sortField', str);  
    str = replaceQueryParam('page', page, str);
    window.location = window.location.pathname + str;
}

function getQueryParams(qs) {
    qs = qs.split('+').join(' ');

    var params = {},
    tokens,
    re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    return params;
}


function change_size(val){
    var str = window.location.search;
    str = replaceQueryParam('task', 'sortField', str);  
    str = replaceQueryParam('Size', val , str);    
    str = replaceQueryParam('page', '1' , str);
    window.location = window.location.pathname + str;
}

/*js for details*/

function cart_remove(){
    var value = parseFloat(document.getElementById('product-view__quantity').value);
    if (value > 1) {
        var newval = value - 1;
        document.getElementById('product-view__quantity').value = newval;
    }
}

function cart_add(){
    var value = parseFloat(document.getElementById('product-view__quantity').value);
    if (value < 999) {
        var newval = value + 1;
        document.getElementById('product-view__quantity').value = newval;
    }
}

function addCart(){
    var quantity = document.getElementById('product-view__quantity').value;
    var product = document.getElementById('product-id').value;

    ruta = 'index.php?option=com_cart&task=addCart&product=' + product + '&quantity=' + quantity;
    window.location = ruta;
}

/*js for like/dislike*/

function onLike(product_id, view){
    actionLike(product_id, 'like', view);
}

function onDislike(product_id, view){
    actionLike(product_id, 'dislike', view);
}

function actionLike(product, task, view){
    var str = window.location.search;
    str = replaceQueryParam('task', task, str);
    str = replaceQueryParam('id', product, str);
    str = replaceQueryParam('orgView', view, str);
    window.location = window.location.pathname + str;
}