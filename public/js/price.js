//Plugin is useful to format input fields and HTML elements as prices.

$('#element').priceFormat({
    prefix: '(PLN) ',
    suffix: '',
    thousandsSeparator: ' ',
    centsSeparator: '.',  
    clearSuffix: true,
    clearPrefix: true,
    thousandsSeparator: ''
});

$("#float").click(function() {
    $('#element').priceToFloat();
});