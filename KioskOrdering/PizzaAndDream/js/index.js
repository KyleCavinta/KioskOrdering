$(function(){

    $('button').on('click', function(){
        $.ajax({
            url: '../php/IndexFunction.php',
            method: 'POST',
            data:{
                'table-no': $('#tableNo').val()
            },
            cache: false,
            success: function(e){
                window.location.replace('../pages/menu.php');
            }
        });
    });

});