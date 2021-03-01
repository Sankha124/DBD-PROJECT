window.onload = function(){

    //there will be one span element for each input field
    // when the page is loaded, we create them and append them to corresponding input element 
	// they are initially hidden

    var span1 = document.createElement("span");
	span1.style.display = "none"; //hide the span element

    var span2 = document.createElement("span");
    span1.style.display = "none"; //hide the span element

    var span3 = document.createElement("span");
    span1.style.display = "none"; //hide the span element

	var username = document.getElementById("username");
    username.parentNode.appendChild(span1);

    var password = document.getElementById("password");
    password.parentNode.appendChild(span2);

    var mail = document.getElementById("email");
    mail.parentNode.appendChild(span3);


    username.onfocus = function(){
        span1.innerHTML = "Username should be alphanumeric characters";
        span1.style.display = "block";
        span1.style.color = "black";
        username.className = ("info");
    }

    password.onfocus = function(){
        
        span2.innerHTML = "password should include at least six characters";
        span2.style.display = "block";
        span2.style.color = "black";
        password.className = "info";
    }

    mail.onfocus = function(){
        
        span3.innerHTML = "Enter a valid e-mail id";
        span3.style.display = "block";
        span3.style.color = "black";
        mail.className = "info"
    }




    username.onblur = function(){
        
        var letters = /^[0-9a-zA-Z]+$/;
        if(username.value.match(letters)){
            span1.style.display = "none";
            username.style.borderColor = "green";
            username.className = "ok";
        }
        else{
            span1.innerHTML = "Error : Username invalid";
            span1.style.color = "red";
            username.style.borderColor = "red";
            username.className = "error";
        }
    }

        	
    
    password.onblur = function(){
        if(password.value.length > 5){
            span2.style.display = "none"
            password.style.borderColor = "green";
            password.className = "ok";
        }
        else{
            span2.innerHTML = "Error : Password too small";
            span2.style.color = "red";
            password.style.borderColor = "red";
            password.className = "error";
        }
    }
    mail.onblur = function(){
        if (/\S+@\S+\.\S+/.test(mail.value)){
            span3.style.display = "none";
            email.style.borderColor = "green";
            mail.className = "ok";
        }
        else{
            span3.innerHTML = "Error : E-mail id invalid";
            span3.style.color = "red";
            email.style.borderColor = "red";
            mail.className = "error";
        }

        
    }

}

