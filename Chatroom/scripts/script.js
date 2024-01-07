$(document).ready(function() {
    // AUTHME LOGIN
    let timeout;

    $('#logout').click(function() {
        $.ajax({
            url: 'backend/authme/logout.php',
            method: 'post',
            data: {request: 'logout',},
            success: function() {
                location.reload();
            }
        });
    });

    $('#login').click(function(event) {
        if (timeout != undefined) {
            clearTimeout(timeout);
            console.log(timeout);
        }

        function resetError() {
            $('#errorMessage').html('');
        }

        function loginReload() {location.reload();}
        event.preventDefault();
        data = $("#login-card-form").serializeArray();
        dataArr = JSON.stringify(data);
        loginDetails = []
        $.each(data, function(i, field) {
               loginDetails[field.name] = field.value;
        });
        username = loginDetails['username'].trim();
        password = loginDetails['password'].trim();
        
        if (!username) {
            error = 'Please enter your username!';
        } else if(!password) {
            error = 'Please enter your password!';
        } else {
            error = '';
        }

        $.ajax({
            url : 'backend/authme/sign-in.php',
            method: 'post',
            data: {
                username: username,
                password: password,
                request: 'login',
            },
            success: function(data) {
                // console.log(data);
                if (data == '!Uidfound' || data == '!pwdMatch') {
                    error = 'You entered wrong username or password!';
                }
                if (error) {
                    $('#errorMessage').html(error);
                    timeout = setTimeout(resetError, 5000);
                    return;
                } 
                $('#errorMessage').html('<span>WELCOME!</span>');
                timeout = setTimeout(loginReload, 500);
            }
        });
    });

    $('#showReg').click(function() {
        $('.login-card-container').toggleClass('hidden');
        $('.register-card-container').toggleClass('hidden');
    });

    $('#showLgn').click(function() {
        $('.login-card-container').toggleClass('hidden');
        $('.register-card-container').toggleClass('hidden');
    });
    // =============================================================== //

});