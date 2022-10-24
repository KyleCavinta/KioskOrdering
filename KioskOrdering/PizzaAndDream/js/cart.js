$.getScript('../js/resources.js');
$(function(){
    
    $('i.fa-chevron-left').on('click', function(){
        window.location.replace('../pages/menu.php');
    });
    
    let items = $('.item');
    for(let i = 0; i < items.length; i++){
        $(items[i]).on('click', function(){
            let category = $(this).data('category');
            let index = $(this).data('index');
            
            $('.food-container').css('overflow', 'hidden');
            if(category == "food"){
                showMod($('#modifyItem'), 130);
                $('#modifyItem .mod-content').load('../ajax/food-modification.php', {
                    'index': index
                });
            }
            else{
                showMod($('#modifyItem'), 110);
                $('#modifyItem .mod-content').load('../ajax/promo-modification.php', {
                    'index': index
                });
            }
        });
    }
    
    $('#btnMakeOrder').on('click', function(){
        $.getJSON('../../Cart.json?v=' + new Date().getTime(), function(data){
            let tableData = data[$('#tableNo').val()];
            let count = tableData['FoodItems'].length + tableData['PromoItems'].length;
            if(count > 0){
                showMod($('#feedback'));
                $('#feedback .title').text("Confirmation");
                $('#feedback p').html(`
                    Are you sure about your orders?
                    <br>
                    <span style="font-weight: 600;">Reminder: </span>You cannot delete or edit once you proceed to this transaction
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
                    window.location.replace('../pages/orders.php');
                })
            }
            else{
                showMod($('#feedback'));
                $('#feedback .title').text("Reminder");
                $('#feedback p').text("You cannot make order in an empty cart. Please proceed to menu and order an item");
                $('#feedback .footer').html(`<button class="mod-button" id="btnOkay">Okay</button>`);
                
                $('#btnOkay').on('click', function(){
                    hideMod($('#feedback'));
                    $('#feedback .title').text("");
                    $('#feedback p').text("");
                    $('#feedback').html("");
                    $(this).off('click');
                });
            }
        });
    });
    
});