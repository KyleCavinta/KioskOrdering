$(function(){
    
    let isTableClicked = false;
    let tableNo = undefined;
    let tables = $('.table-part .cus-table');
    
    $('.status-container').hide();
    
    for(let i = 0; i < tables.length; i++){
        $(tables[i]).on('click', function(){
            $(tables).css('background-color', '#ffffff').css('color', '#000000');
            $(this).css('background-color', '#393A40').css('color', 'white');
            
            tableNo = $(this).data('tableNo');
            $('#tableNo').text(tableNo);
            
            $('.orders table').load('../ajax/get-kitchen-orders.php', {
                'table-no': tableNo
            },
            function(){
                let ordersCount = parseInt($('#ordersCount').val());
                let status = $('#status').val();
                let pageStatus = $('#pageStatus').val();
                
                if(ordersCount > 0 && pageStatus == "orders"){
                    $('.status-container').show();
                    $('.status-container select').val(status);
                }else{
                    $('.status-container').hide();
                }
            });
            
            isTableClicked = true;
        });
    }
    
    $('.status-container select').on('change', function(){
        $.ajax({
            url: '../php/UpdateCartServiceStatus.php',
            method: 'POST',
            data:{
                'table-no': tableNo,
                'status': this.value
            }
        })
    });
    
    setInterval(function(){
        if(isTableClicked){
            $('.orders table').load('../ajax/get-kitchen-orders.php', {
                'table-no': tableNo
            },
            function(){
                let ordersCount = parseInt($('#ordersCount').val());
                let status = $('#status').val();
                let pageStatus = $('#pageStatus').val();
                
                if(ordersCount > 0 && pageStatus == "orders"){
                    $('.status-container').show();
                    $('.status-container select').val(status);
                }else{
                    $('.status-container').hide();
                }
            });
        }
        
        $.ajax({
            url:'../../Cart.json',
            cache: false,
            success:function(data){
                for(let i = 0; i < tables.length; i++){
                    let span = $(tables[i]).children('i').children();
                    let tableData = data[tables[i].dataset.tableNo];
                    let itemStatus = (tableData['FoodItems'].map(e => e.ItemStatus)).concat(tableData['PromoItems'].map(e => e.ItemStatus));
                    if(itemStatus.indexOf("new") != -1 && tableData['PageStatus'] == "orders"){
                        $(span).css('visibility', 'visible');
                        $(span).css('opacity', '1');
                    }
                    else{
                        $(span).css('visibility', 'hidden');
                        $(span).css('opacity', '0');
                    }
                }
            }
        });
        
        $('.clock span').load('../ajax/running-time.php', {});
    }, 1000);
    
    
    $('#btnLogout').on('click', e => {
        if(confirm("Are you sure you want to logout?")){
            location.replace('../php/LogoutFunction.php');
        }
    });
    
    document.title = "Kitchen";
    
});