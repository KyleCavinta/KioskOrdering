$(function(){

    function renderMenuItems(items){
        let htmlOutput = items.map(function(item){
            let itemID = (item.FoodID == undefined) ? item.PromoID : item.FoodID;
            return `
                <div class="food-card p-3">
                    <div class="top-section">
                        <img src="../img/menu-items/${item.Image}" class="img-food" width="220px" height="220px">
                    </div>
                    
                    ${(item.Status == 1) ? '<img src="../img/ic_best_seller.png" class="img-best">' : ""}
                    
                    <div class="mid-section">
                        <h1 class="food-name">${item.Name}</h1>
                    </div>

                    <div class="bot-section">
                        <label class="price">₱ ${item.Price}</label>

                        <div class="add-item" data-item-id="${itemID}">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        return htmlOutput;
    }

    function orderFunction(){
        //Food Items function
        let foodItems = $('.food-card .add-item');
        for(let i = 0; i < foodItems.length; i++){
            $(foodItems[i]).off('click');
            $(foodItems[i]).on('click', function(){
                window.location.replace('../pages/modification.php?item-id=' + this.dataset.itemId);
            });
        }
    }

    function lightHouseFunction(){
        $('.food-card img.img-food').on('click', function(e){
            $('#lighthouse').css('opacity', '1').css('visibility', 'visible');
            $('#lighthouse img').attr('src', $(this).attr('src'));
            $('#lighthouse h1').text($(this).parent().next().children('h1').text());
        });

        $('#lighthouse img').on('click', function(e){
            e.stopPropagation();
        })

        $('#lighthouse, #lighthouse i').on('click', function(){
            $('#lighthouse').css('opacity', '0').css('visibility', 'hidden');
        });
    }


    let clickedCategory;

    //click category function
    let categoryNavigation = $('.food-category ul li');
    for(let i = 0; i < categoryNavigation.length; i++){
        $(categoryNavigation[i]).on('click', function(){
            $(categoryNavigation).children().removeClass('active');
            $(this).children().addClass("active");

            clickedCategory = i;

            let category = $(this).children().data('category');
            $.getJSON(`../json/GetMenuItemsByCategory.php?cat=${category}`, function(menuItems){
                let menuHtml = renderMenuItems(menuItems);
                $('.food-menu .inner-con').html(menuHtml);
            })
            .then(function(){
                orderFunction();
                lightHouseFunction(); // Image view function
                $('.food-menu').scrollLeft(0); //Scroll left when categories refresh
            });
            $('.input-search').val('');
        });
    }
    //Click the all category
    $(categoryNavigation[0]).click();



    //Search Item function
    $('.input-search').on('input', function(){
        if(this.value == ""){
            $(categoryNavigation[clickedCategory]).click();
        }
        else{
            $(categoryNavigation).children().removeClass('active');

            $.getJSON(`../json/GetMenuItemBySearch.php?str=${this.value}`, function(menuItems){
                let menuHtml = renderMenuItems(menuItems);
                $('.food-menu .inner-con').html(menuHtml);
            }).then(function(){
                orderFunction();
                lightHouseFunction(); // Image view function
                $('.food-menu').scrollLeft(0); //Scroll left when categories refresh
            });
        }
    });


    //Navigate to cart
    $('.cart-icon img, .cart-icon span').on('click', function(){
        window.location.href="../pages/cart.php";
    })
});