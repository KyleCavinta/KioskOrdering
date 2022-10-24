$(document).ready(function(){
    $(".toggle").click(function(){
        $(".container").addClass("active");
    })
    $(".close").click(function(){
        $(".container").removeClass("active");
    })






    //Logout function
    $('a#navLogout').on('click', e => {
        if(confirm("Are you sure you want to logout?")){
            e.preventDefault();
            location.replace("../php/LogoutFunction.php");
        }
    });

})