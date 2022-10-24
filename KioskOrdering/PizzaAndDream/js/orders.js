$.getScript('../js/resources.js');
$(function(){
    
    let tableNo = $('#tableNo').val();
    
    $('#btnBack').on('click', function(){
        window.location.replace('../pages/cart.php');
    });
    
    $('#btnTotal').on('click', function(){ 
        showMod($('#feedback'));
        $('#feedback .title').text("Confirmation");
        $('#feedback p').html(`
            Do you want to proceed with the payment?
            <span style="font-weight: 600;">Reminder: </span>You can't go back to this page once you proceed
        `);
        $('#feedback .footer').html(`
            <button class="mod-button" id="btnYes">Yes</button>
            <button class="mod-button" id="btnNo">No</button>
        `);
        
        $('#btnNo').on('click', function(){
            hideMod($('#feedback'));
            $('#feedback .title').text("");
            $('#feedback p').html("");
            $('#feedback .footer').html("");
            $(this).off('click');
        });
        $('#btnYes').on('click', function(){
            $.ajax({
                url: '../php/PayOrdersFunction.php',
                cache: false,
                success: function(e){
                    window.location.replace('../pages/payment.php');
                }
            });
        })
    })
    
    setInterval(function(e){
        $.ajax({
            url: '../../Cart.json',
            cache: false,
            success: function(data){
                let tableData = data[tableNo];
                let foodItems = tableData['FoodItems'];
                let promoItems = tableData['PromoItems'];
                let serviceStatuses = foodItems.map(e => e.ServiceStatus).concat(promoItems.map(e => e.ServiceStatus));
                
                if(serviceStatuses.indexOf("pending") != -1){
                    $('.notify h1').text("Pending");
                    $('#btnTotal').removeClass('active').prop('disabled', true);
                }else if(serviceStatuses.indexOf("preparing") != -1){
                    $('.notify h1').text("Preparing");
                    $('#btnTotal').removeClass('active').prop('disabled', true);
                }else if(serviceStatuses.indexOf("serving") != -1){
                    $('.notify h1').text("Serving");
                    $('#btnTotal').removeClass('active').prop('disabled', true);
                }else if(serviceStatuses.indexOf("enjoy") != -1){
                    $('.notify h1').text("Enjoy");
                    $('#btnTotal').addClass('active').prop('disabled', false);
                }
            }
        });
    }, 1000);

});