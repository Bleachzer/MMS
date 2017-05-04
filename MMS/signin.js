function checkPass()
{
    var pass1 = document.getElementById('password1');
    var pass2 = document.getElementById('password2');

    var message = document.getElementById('confirmMessage');

    if(pass1.value == pass2.value){
        pass2.style.backgroundColor = "#66cc66";
        message.style.color = "#ff6666";
        message.innerHTML = "Passwords Match"
    }
    else
    {
        pass2.style.backgroundColor = "#ff6666";
        message.style.color = "#ff6666";
        message.innerHTML = "Passwords Do Not Match!"
    }

    if(pass2.value == ""){
        pass2.style.backgroundColor = "";
        message.style.color = "";
        message.innerHTML = ""
    }

}


$(document).ready(function(){

    $("#signin").click(function(){
        $("form").submit(function(){
            if ($("#password1").val() != $("#password2").val()) 
            {
                return false;
            }
            else
            {
                return true;
            }
        });
    })


    

    $("#back").click(function(){
        $(".container").load("index.html");
    })

    $("form").submit(function(e){
        $.ajax({
            type:'POST',
            url:'checkuser.php',
            async:false,
            data:{
                name:$(".username").val()
            },
            success:function(data){
                if (data) {
                    document.getElementById('usernamemess').style.color = "#ff6666";
                    document.getElementById('usernamemess').innerHTML = "Username has already exit";
                    $("#signin").submit(function(){
                        e.preventDefault();
                    });
                }
                else{
                    document.getElementById('usernamemess').innerHTML = "";
                    $("#signin").submit(function(){
                        return;
                    });
                }
            }
        });
        return true;
    });
}) 
