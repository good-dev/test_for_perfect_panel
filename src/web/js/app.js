var token = '100-64symbols-token-contain-a-z-A-Z-0-9-_';

$(function () {
    var $res = $('#result1');

    // Rates
    $('#test1-form').on('submit', function (e) {
        e.preventDefault();
        
        var currency = $('#currency').val(),
            url = '/api/v1?method=rates';
        if(currency!=='') url += '&currency=' + currency;
        $.ajax({
            url: url,
            headers: {
                'Authorization': 'Bearer ' + token,
            },
        })
            .done(function (data) {
                if (data.status === 'success') {
                    $res.html('');
                    for (let cur in data.data) {
                        $res.append('<div>' + cur + ' : ' + data.data[cur] + '</div>');
                    }
                } else {
                    $res.html('Error');
                }
            })
            .fail(function(){
                $res.html('Error');
            });
    });


    // Convert
    var $res2 = $('#result2');
    $('#test2-form').on('submit', function (e) {
        e.preventDefault();

        var from = $('#currency_from').val(),
            to = $('#currency_to').val(),
            value = $('#value').val(),
            url = '/api/v1?method=convert',
            params = {
                "currency_from": from,
                "currency_to": to,
                "value": value
            };
        $.ajax({
            url: url,
            dataType: 'json',
            data: params,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
        })
            .done(function (data) {
                if (data.status === 'success') {
                    var d = data.data;
                    $res2.html('<div>From: ' + d.currency_from + '</div>' +
                        '<div>To: ' + d.currency_to + '</div>' +
                        '<div>Value: ' + d.value + '</div>' +
                        '<div>Converted value: <strong>' + d.converted_value + '</strong></div>' +
                        '<div>Rate: ' + d.rate + '</div>');
                } else {
                    $res2.html('Error');
                }
            })
            .fail(function(){
                $res2.html('Error');
            });
    });
});