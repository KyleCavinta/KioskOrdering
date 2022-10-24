$(function(){
    
    let indexClicked;
    let gCashAmountPaid = 0;
    let isClicked = false;
    let tables = $('.cus-table');
    for(let i = 0; i < tables.length; i++){
        $(tables[i]).on('click', function(e){
            let tableNo = $(tables[i]).data('tableNo');
            
            $('.receipt .table-container tbody').load('../ajax/cashier-payment-details.php', {
                'table-no': tableNo
            },
            function(){
                let subTotal = $('#subTotal').val();
                let vat = $('#tax').val();
                let totalPrice = $('#totalPrice').val();
                let paymentMethod = $('#paymentMethod').val();
                let amountPaid = $('#amountPaid').val();
                
                $('#dispSubTotal').text("₱ " + subTotal);
                $('#dispTax').text("₱ " + vat);
                $('#dispTotalPrice').text("₱ " + totalPrice);
                $('#dispPaymentMethod').text(paymentMethod);
                $('#dispAmountPaid').text("₱ " + amountPaid);
                
                gCashAmountPaid = totalPrice;
                
                if(parseFloat(totalPrice) > 0){
                    $('#btnCheckout').prop('disabled', false);
                }
                else{
                    $('#btnCheckout').prop('disabled', true);
                }
            });
            
            $('#tableNo').text(tableNo);
            
            indexClicked = i;
            isClicked = true;
            
            $(tables).css('background', '#ffffff').css('color', '#4e4e4e');
            $(this).css('background', '#b9b9b9').css('color', '#ffffff');
        });
    }
    
    setInterval(function(){
        if(isClicked){
            $(tables[indexClicked]).click();
        }
        
        $.ajax({
            url: '../../Cart.json',
            cache: false,
            success: function(data){
                for(let i = 0; i < tables.length; i++){
                    let tableData = data[tables[i].dataset.tableNo];
                    let payment = tableData.Payment;
                    if(payment.hasOwnProperty("PaymentMethod")){
                        $(tables[i]).children('span').text(payment.PaymentMethod);
                        $(tables[i]).children('span').show();
                        console.log("YES")
                    }
                    else{
                        $(tables[i]).children('span').text();
                        $(tables[i]).children('span').hide();
                    }
                }
            }
        });
        
        $.ajax({url: '../ajax/running-time.php', success: e => $('.running-time').text(e)})
    }, 1000);
    
    
    $('#btnCheckout').on('click', function(){
        window.scroll(0, 0);
        $('.confirm-container').css('opacity', '1').css('visibility', 'visible');
        $('body').css('overflow', 'hidden');
        
        $('#printableReceipt').load('../ajax/printable-receipt.php',{
            'table-no': $(tables[indexClicked]).data('tableNo')
        });
    });
    
    
    $('#btnConfirmationNo').on('click', function(){
        $('.confirm-container').css('opacity', '0').css('visibility', 'hidden');
        $('body').css('overflow', 'auto');
    });
    
    
    $('#btnConfirmationYes').on('click', function(){
        $.ajax({
            url: '../php/CheckoutOrders.php',
            method: 'POST',
            data: {
                'table-no': $(tables[indexClicked]).data('tableNo'),
                'gcash-paid': gCashAmountPaid
            },
            cache: false,
            success: function(e){
                if(e.includes("error")){
                    alert("Something went wrong checking out the orders please contact support")
                }
                else{
                    html2pdf().from($('.print-receipt')[0]).set({
                        margin: [0, 0, 0, 0],
                        filename: $(tables[indexClicked]).data('tableNo') + "-" + new Date().getTime(),
                        html2canvas: {
                            scale: 5
                        },
                        jsPDF: {
                            unit: 'px',
                            format: [370, $('.print-receipt').height() + 200],
                        }
                    }).save().then(function(){
                        alert("Orders successfully Checked out!");
                        window.location.reload();
                    });
                }
            }
        });
    });
    
    $('#btnLogout').on('click', e => {
        if(confirm("Are you sure you want to logout?")){
            location.replace("../php/LogoutFunction.php");
        }
    });
    
    document.title = "Cashier";
    
});