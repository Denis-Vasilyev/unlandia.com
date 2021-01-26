$(function () {
    var calc_select2 = $('.js-to-ebay').select2({select2_name: "js-to-lap"});
    calc_select2.data('select2').$container.addClass("calc-wrap");

    $('.js-calc-ebay-button').on(
        'click',
        function () {
            var clickedObj = $(this);
            $.each(
                $('.js-calc-ebay-button'),
                function() {
                    if (clickedObj.data('val') === $(this).data('val')) {
                        if (!$(this).hasClass('active')) {
                            $(this).addClass('active');
                        }
                    } else {
                        $(this).removeClass('active');
                    }
                });
    });

    $('.js-calc-ebay-btn').on(
        'click',
        function () {
            $('.calc-ebay-container .error').removeClass('error');
            var data = collectFormData();
            if(data !== null) {
                BX.ajax.runComponentAction(
                    'bberry:calculator.express.new',
                    'calcParcel', { // Вызывается без постфикса Action
                        mode: 'class',
                        data: data, // ключи объекта data соответствуют параметрам метода
                    })
                    .then(function(response) {
                        if (response.status === 'success') {
                            // Если форма успешно отправилась
                            if(!response.data.data.error) {
                                $('.calc-ebay-result').show();
                                $('.calc-ebay-addit-services').show();
                                $('.js-calc-ebay-ammount').html(response.data.data.cost + ' Р');
                                //console.log(response.data.data);
                            }
                        }
                    });
            }
            console.log(data);
    });

    function collectFormData() {
        var cityCode, deliveryType, parselWeight, additInsurance, error;

        error = false;
        cityCode = $('.js-to-ebay').val();

        if ($('.js-calc-ebay-button.active').data('val') === 'office') {
            deliveryType = false;
        } else if ($('.js-calc-ebay-button.active').data('val') === 'door') {
            deliveryType = true;
        }

        parselWeight = Number($('.js-calc-ebay-weight').val().replace(',','.'));
        additInsurance = $('.js-calc-ebay-addit-insurance').prop('checked');

        if(cityCode === '0') {
            error = true;
            $('.js-to-ebay').parent().addClass('error');
        }

        if(typeof deliveryType === 'undefined') {
            error = true;
            $('.js-calc-ebay-button').parent().parent().parent().addClass('error');
        }

        if(Number.isNaN(parselWeight) || parselWeight === 0) {
            error = true;
            $('.js-calc-ebay-weight').parent().parent().parent().addClass('error');
        }

        if(error) {
            return null;
        } else {
            return {
                cityCode: cityCode,
                deliveryType: deliveryType,
                parselWeight: parselWeight,
                additInsurance: additInsurance
            };
        }

    }
});