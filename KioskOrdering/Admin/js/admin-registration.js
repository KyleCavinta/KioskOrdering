$(() => {
    
    $('#btnSubmit').on('click', e => {
        e.preventDefault();
        
        let firstname = $('#fName').val();
        let lastname = $('#lName').val();
        let pos = $('#position').val();
        let username = $('#username').val();
        let pswd = $('#password').val();
        let pswdConf = $('#passwordConf').val();
        
        if(firstname === "" || lastname === "" || pos === "" || username === "" || pswd === "" || pswdConf === ""){
            alert("Please complete the input fields");
        }
        else if(pswd.length < 8){
            alert("Password must be at least 8 characters");            
        }
        else if(pswd !== pswdConf){
            alert("Password don't match");
        }
        else{
            $.ajax({
                url: "../php/AdminRegistration.php",
                method: "POST",
                data:{
                    'firstname': firstname,
                    'lastname': lastname,
                    'pos': pos,
                    'username': username,
                    'pswd': pswd
                },
                success: e => {
                    if(e == "1"){
                        alert("Account Registration Successful!");
                        window.location.replace("../pages/login.php");
                    }
                    else{
                        alert("Account Registration Failed! Something went wrong in the server");
                    }
                }
            });
        }
    });
    
});