  var loginClick = function()
    {
        $("div.login-register-span span:nth-child(1)").addClass("display-none");
        $("div.login-register-span span:nth-child(2)").removeClass("display-none");

        $("div.user-login").addClass("display-none");
        $("div.user-register").removeClass("display-none");
        
    }

    var registerClick = function()
    {
        $("div.login-register-span span:nth-child(1)").removeClass("display-none");
        $("div.login-register-span span:nth-child(2)").addClass("display-none");

        $("div.user-login").removeClass("display-none");
        $("div.user-register").addClass("display-none");
        
    }