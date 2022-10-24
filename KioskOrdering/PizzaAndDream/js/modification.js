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

    // Exit function
    $('.img-exit img').on('click', function(){
        window.location.replace('../pages/menu.php');
    });

    let id = $('#itemID').val(); //Food item ID

    let price = JSON.parse($('#price').val()); // default price
    let category = $('#category').val();
    let qty = 1; // Default quantity
    let size = (category != "Promo") ? JSON.parse($('select').val())['description'] : ""; // if category is not promo get the default size
    let totalPrice = price;


    //Increment quantity
    $('#btn-increment').on('click', function(){
        qty++;
        $('#num-quantity').val(qty);
        totalPrice = computeTotal(size, qty, category, price);
    });

    //Decrement quantity
    $('#btn-decrement').on('click', function(){
        if(qty <= 1){ qty = 1; }
        else{ qty--; }
        $('#num-quantity').val(qty);
        totalPrice = computeTotal(size, qty, category, price);
    });


    //Size Selection
    $('select').on('change', function(){
        if(category != "Promo"){
            size = JSON.parse($('select').val())['description'];
            totalPrice = computeTotal(size, qty, category, price);
        }
    });

    // add to cart function
    $('.promo-cart, .cart').on('click', function(){
        let formData = new FormData();
        if(category != "Promo"){
            formData.append('FoodID', id);
            formData.append('Quantity', qty);
            formData.append('Size', JSON.parse($('select').val())['size']);
            formData.append('TotalPrice', totalPrice);
            formData.append('category', "Food");
        }
        else{
            //Include selected food
            let foodIncluded = [];
            let select = $('select');
            for(let i = 0; i < select.length; i++){
                foodIncluded.push($(select[i]).val());
            }

            formData.append('PromoID', id);
            formData.append('FoodIncluded', foodIncluded);
            formData.append('category', "Promo");
        }

        $.ajax({
            url: '../php/AddToCartFunction.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(e){
                if(e.includes("error")){
                    alert("Item insertion failed, please contact support");
                }
                else{
                    window.location.replace('../pages/cart.php');
                }
            }
        });
    });
});