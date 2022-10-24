$.getScript('../js/resources.js');
$(function(){

    let totalPrice = parseFloat($('#totalPrice').val());
    
    //Show Orders
    $('.btn-bill').on('click', function(){
        $('.bg-bill-pop-up').css('visibility', 'visible').css('opacity', '1')
        $('.bg-bill-pop-up .bill-content').css('margin-top', '100px');

        $('.bg-bill-pop-up .bill-content').load('../ajax/payment-bill.php', {},
        function(){
            $('#btnCloseBill').off('click');
            $('#btnCloseBill').on('click', function(){
                $('.bg-bill-pop-up').css('visibility', 'hidden').css('opacity', '0')
                $('.bg-bill-pop-up .bill-content').css('margin-top', '-100px');
            });
        });
    });
    
    //Choose Payment mode
    $('.btn-Cash').css('border', '5px solid #D5995B');
    let paymentMode = "cash";
    $('.btn-Cash, .btn-GCash').on('click', function(){
        paymentMode = $(this).data('mode');
        if(paymentMode == "cash"){
            $('.btn-Cash').css('border', '5px solid #D5995B');
            $('.btn-GCash').css('border', 'none');

            $('#txtCash').prop('readonly', false);
        }
        else{
            $('.btn-GCash').css('border', '5px solid #D5995B');
            $('.btn-Cash').css('border', 'none');

            $('.bg-pop-up').css('opacity', '1').css('visibility', 'visible');

            $('#txtCash').prop('readonly', true).val('');

            $.ajax({
                url: '../php/PayGCashFunction.php',
                method: 'POST',
                data:{
                    'amount-paid': totalPrice
                },
                cache: false
            });
        }
    });


    //Cancel QR code
    $('#btnCancelQR').on('click', function(){
        $.ajax({ 
            url: '../php/CancelGCashPayment.php',
            cache: false });
        $('.bg-pop-up').css('opacity', '0').css('visibility', 'hidden');
        $('.btn-Cash').click();
    });


    $('.btn-done-qr').on('click', function(){
        window.location.replace('../pages/feedback.php');
    });
    
    
    setInterval(function(){
        //Running time in bill
        $.ajax({
            url: '../ajax/running-time.php',
            success: function(e){
                $('.time').text(e);
            }
        });

        //QR CODE button disable
        $.ajax({
            url: '../../Cart.json',
            cache: false,
            success: function(data){
                let tableNo = $('#tableNo').val();
                let payment = data[tableNo]['Payment'];

                if("PaymentMethod" in payment){
                    $('.btn-done-qr').addClass('disabled').prop('disabled', true);
                    $('#btnCancelQR').show();
                }
                else{
                    $('.btn-done-qr').removeClass('disabled').prop('disabled', false);
                    $('#btnCancelQR').hide();
                }
            }
        });
    }, 500);


    //Pay orders
    $('#Pay-Orders').on('click', function(){
        if($('#txtCash').val().length > 0){
            let inputCash = parseFloat($('#txtCash').val());
            
            if(inputCash >= totalPrice){
                showMod($('#feedback'), 270);
                $('#feedback .title').text("Confirmation");
                $('#feedback p').text("Are you sure you want to pay your orders?");
                $('#feedback .footer').html(`
                    <button class="mod-button" id="btnYes">Yes</button>
                    <button class="mod-button" id="btnNo">No</button>
                `);
                $('#btnYes').on('click', function(){
                    $.ajax({
                        url: '../php/PayCashFunction.php',
                        method: 'POST',
                        data:{
                            'amount-paid': inputCash,
                            'payment-method': 'cash',
                        },
                        success: function(e){
                            window.location.replace('../pages/feedback.php');
                        }
                    });
                });
                $('#btnNo').on('click', function(){
                    hideMod($('#feedback'));
                    $('#feedback .title').text("");
                    $('#feedback p').text("");
                    $('#feedback .footer').html("");
                    $(this).off('click')
                });
            }
            else{
                showMod($('#feedback'), 270);
                $('#feedback .title').text("Reminder");
                $('#feedback p').text("Please input the proper cash amount");
                $('#feedback .footer').html(`<button class="mod-button" id="btnOkay">Okay</button>`);
                $('#btnOkay').on('click', function(){
                    hideMod($('#feedback'));
                    $('#feedback .title').text("");
                    $('#feedback p').text("");
                    $('#feedback .footer').html(``);
                    $(this).off('click');
                });
            }
        }
        else{
            showMod($('#feedback'), 270);
            $('#feedback .title').text("Reminder");
            $('#feedback p').text("Please input your available cash");
            $('#feedback .footer').html(`<button class="mod-button" id="btnOkay">Okay</button>`);
            $('#btnOkay').on('click', function(){
                hideMod($('#feedback'));
                $('#feedback .title').text("");
                $('#feedback p').text("");
                $('#feedback .footer').html(``);
                $(this).off('click');
            });
        }
    });

});