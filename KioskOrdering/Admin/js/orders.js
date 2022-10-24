document.addEventListener("DOMContentLoaded", function() {
    
    let getData = (paymentMethod, tableNo, year, month, day) => {
        $.ajax({
            url: `../json/ordersHistoryTableAPI.php?payMeth=${paymentMethod}&tbl=${tableNo}&year=${year}&month=${month}&day=${day}`,
            success: function(data){
                data = JSON.parse(data);
                let htmlOutput = data.map(val => {
                    return(`
                        <tr data-trans-id="${val.TransactionID}" data-table-no="${val.TableNo}" data-price="${val.TotalPrice}" data-date="${val.DatePaid}">
                            <td>${val.TransactionID}</td>
                            <td>${val.TableNo}</td>
                            <td>${val.PaymentMethod}</td>
                            <td>${val.TotalPrice}</td>
                            <td>${val.DatePaid}</td>
                        </tr>
                    `);
                });
                $('table tbody').html(htmlOutput);
            }
        })
        .then(() => {
            let rows = document.querySelectorAll('table tbody tr');
            for(let i = 0; i < rows.length; i++){
                rows[i].addEventListener('click', function(){
                    let transactionID = this.dataset.transId;
                    let tblNo = this.dataset.tableNo;
                    let price = this.dataset.price;
                    let date = this.dataset.date
                    $('#modalDetails .modal-dialog .modal-content').load('../ajax/getOrderDetails.php',{
                        transactionID, tblNo, price, date
                    }, function(){
                        $('#modalDetails').modal('show');
                    });
                });
            }
        });
    }
    
    let pad = (num, size) => {
        num = num.toString();
        while (num.length < size) num = "0" + num;
        return num;
    }
    
    let setDaysInSelect = (year, month) => {
        let date = new Date(year, month, 0).getDate();
        let dateHTML = "";

        for(let i = 1; i <= date; i++){
            dateHTML += `<option value="${pad(i, 2)}">${pad(i, 2)}</option>`
        }
        
        $('#day option').after(dateHTML);
    }
    
    let setMonthsInSelect = () => {
        let monthHTML = "";
        for(let i = 1; i <= 12; i++){
            monthHTML += `<option value="${pad(i, 2)}">${pad(i, 2)}</option>`
        }
        
        $('#month option').after(monthHTML);
    }
    
    let tableNo = "";
    let paymentMethod = "";
    let year = $('#year').val();
    let month = pad(new Date().getMonth() + 1, 2);
    let day = "";
    
    getData(paymentMethod, tableNo, year, month, day);
    
    setMonthsInSelect();
    setDaysInSelect(year, pad(new Date().getMonth(), 2) + 1);
    
    $('#month').val(pad(new Date().getMonth() + 1, 2));
    
    $('#paymentMethod').on('change', function(){
        paymentMethod = $(this).val();
        getData(paymentMethod, tableNo, year, month, day);
    });
    
    $('#tableNo').on('change', function(){
        tableNo = $(this).val();
        getData(paymentMethod, tableNo, year, month, day);
    });
    
    $('#year').on('change', function(){
        year = $(this).val();
        month = "";
        
        if(year == ""){
            day = "";
            $('#day').html('<option value="">Day</option>')
            $('#month').html('<option value="">Month</option>');
        }
        else{
            $('#month').html('<option value="">Month</option>');
            setMonthsInSelect();
        }
        
        if(month != ""){
            $('#day').html('<option>Day</option>');
            setDaysInSelect(year, month);
        }
        else{
            $('#day').html('<option value="">Day</option>');
        }
        
        getData(paymentMethod, tableNo, year, month, day);
    });
    
    $('#month').on('change', function(){
        month = $(this).val();
        day = "";
        
        if(month == ""){
            $('#day').html('<option value="">Day</option>');
        }
        else{
            $('#day').html('<option value="">Day</option>');
            setDaysInSelect(year, month);
        }
        
        getData(paymentMethod, tableNo, year, month, day);
    });
    
    $('#day').on('change', function(){
        day = $(this).val();
        getData(paymentMethod, tableNo, year, month, day);
    });
});
    
document.title = "Orders History";