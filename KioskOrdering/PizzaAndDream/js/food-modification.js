$.getScript('../js/resources.js');
$(function(){
    
    function computeTotal(size, qty, category, origPrice){
        let totalPrice = 0;
        let sizePrice = 0;
        if(category == "Pizza"){
            switch(size){
                case "Double":{
                    sizePrice = origPrice;
                };
                break;

                case "Medium":{
                    sizePrice = origPrice + 210.00;
                };
                break;

                case "Large":{
                    sizePrice = origPrice + (210.00 * 2);
                };
                break;

                case "XLarge":{
                    sizePrice = origPrice + (210.00 * 3);
                };
                break;
            }
        }
        else if(category == "Chicken"){
            if(size == "Large"){
                sizePrice = origPrice + 230.00;
            }
            else{
                sizePrice = origPrice;
            }
        }
        else if(category == "Pasta"){
            if(size == "Large"){
                sizePrice = origPrice + 170.00;
            }
            else{
                sizePrice = origPrice;
            }
        }
        else{
            sizePrice = origPrice;
        }

        totalPrice = (sizePrice * qty).toFixed(2);
        $('.total .price').text('₱ ' + totalPrice);
        return totalPrice;
    }
    
    let quantity = parseInt($('#quantity').val());
    let description = $('#selectSize').find(':selected').data('desc');
    let category = $('h5.title').text();
    let origPrice = parseFloat($('#origPrice').val());
    let totalPrice = parseFloat($('input#totalPrice').val());
    
    $('#btnCancel').on('click', function(){
        hideMod($('#modifyItem'));
        $('.food-container').css('overflow', 'auto');
    });
    
    $('#btnIncrement').on('click', function(){
        if(quantity >= 100){
            quantity = 1;
        }
        else{
            quantity++;
        }
        totalPrice = computeTotal(description, quantity, category, origPrice);
        
        $('h2#totalPrice').text('₱ ' + totalPrice);
        $('#quantity').val(quantity);
    });
    $('#btnDecrement').on('click', function(){
        if(quantity <= 1){
            quantity = 1;
        }
        else{
            quantity--;
        }
        totalPrice = computeTotal(description, quantity, category, origPrice);
        
        $('h2#totalPrice').text('₱ ' + totalPrice);
        $('#quantity').val(quantity);
    });
    $('#selectSize').on('change', function(){
        description  = $(this).find(':selected').data('desc');
        totalPrice = computeTotal(description, quantity, category, origPrice);
        $('h2#totalPrice').text('₱ ' + totalPrice);
    });
    
    $('#btnRemove').on('click', function(){
        showMod($('#feedback'), 270);
        $('#feedback .title').text("Confirmation");
        $('#feedback p').text("Are you sure you want to remove this item?");
        $('#feedback .footer').html(`
            <button class="mod-button" id="btnYes">Yes</button>
            <button class="mod-button" id="btnNo">No</button>
        `);
        $('#btnYes').on('click', function(){
            $.ajax({
                url: '../php/RemoveCartItem.php',
                method: 'POST',
                data:{
                    category: 'food',
                    index: $('#itemIndex').val()
                },
                success: function(e){
                    if(e){
                        window.location.reload();
                        $('#btnYes').off('click');
                    }
                    else{
                        showMod($('#feedback'), 270);
                        $('#feedback .title').text("Reminder");
                        $('#feedback p').text("Unable to remove food item, the item is already preparing");
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
            });
        });
        $('#btnNo').on('click', function(){
            hideMod($('#feedback'));
            $('#feedback .title').text("");
            $('#feedback p').text("");
            $('#feedback .footer').html("");
            $(this).off('click')
        });
    });
    
    $('#btnEdit').on('click', function(){
        $.ajax({
            url: '../php/EditCartItem.php',
            method: 'POST',
            data: {
                category: 'food',
                index: $('#itemIndex').val(),
                size: $('#selectSize').val(),
                quantity: quantity,
                totalPrice: totalPrice
            },
            success: function(e){
                if(e){
                    window.location.reload();
                }
                else{
                    showMod($('#feedback'), 270);
                    $('#feedback .title').text("Reminder");
                    $('#feedback p').text("The item is already preparing by the kitchen. Proceed to menu and add the item again for any additional");
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
        })
    })
    
});