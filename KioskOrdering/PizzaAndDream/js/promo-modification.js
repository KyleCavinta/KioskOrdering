$.getScript('../js/resources.js');
$(function(){
    
    $('#btnCancel').on('click', function(){
        hideMod($('#modifyItem'));
        $('.food-container').css('overflow', 'auto');
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
                    category: 'promo',
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
            $(this).off('click');
        });
    });
    
    $('#btnEdit').on('click', function(){
        let select = $('select');
        let foodIncluded = [];
        for(let i = 0; i < select.length; i++){
            foodIncluded.push(select[i].value);
        }
        
        $.ajax({
            url: '../php/EditCartItem.php',
            method: 'POST',
            data:{
                category: 'promo',
                index: $('#itemIndex').val(),
                foodIncluded: foodIncluded
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
        });
    });
    
})