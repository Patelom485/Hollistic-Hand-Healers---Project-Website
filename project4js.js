
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const showPasswordIcon = document.getElementById('show-password');

    showPasswordIcon.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var emailConfirmationCheckbox = document.getElementById("emailconfirmation");
    var emailLabel = document.getElementById("emailRequiredLabel");

    emailConfirmationCheckbox.addEventListener("change", function () {
      emailLabel.innerText = emailConfirmationCheckbox.checked ? "REQUIRED" : "";

      var emailInput = document.getElementById("emailAddress");
      emailInput.required = emailConfirmationCheckbox.checked;
    });
  });
  document.addEventListener('DOMContentLoaded', function () {

    var closeButton = document.getElementById("closeButton");
    if (closeButton) {
        closeButton.addEventListener("click", function () {
            closePopup();
        });
    }
});

window.onload = function validate() {
    document.getElementById("validationForm").onsubmit = function () {
        
        resetBorderColors();

        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const password = document.getElementById('password').value;
        const therapistId = document.getElementById('therapistId').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        const emailAddress = document.getElementById('emailAddress').value;
        const emailconfirmation = document.getElementById('emailconfirmation').checked;
 
        if (firstName === "" || firstName.length < 3 || firstName.length > 6) {
            highlightInputBox("firstName");
            showpopup("First Name should be between 3 and 6 characters");
            return false;
        }
        if (lastName === "" || lastName.length < 3 || lastName.length > 6) {
            highlightInputBox("lastName");
            showpopup("Last Name should be between 3 and 6 characters");
            return false;
        }
        
        if (password === "") {
            highlightInputBox("password");
            showpopup("Password is required");
            return false;
        } else if (!/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{1,8}$/.test(password)) {
            highlightInputBox("password");
            showpopup("Enter 8 Characters max:\n one special case (@','$','.','#','!','%','*','?','&','^'),\n one Upper Case(A to Z),\n one numeric value (1-9)");
            return false;
        }

        //  therapist ID Validation
        if (therapistId === "") {
            highlightInputBox("therapistId");
            showpopup("Therapist ID is required");
            return false;
        } else if (!/^\d{6}$/.test(therapistId)) {
            highlightInputBox("therapistId");
            showpopup("Therapist ID must be a 6-digit number");
            return false;
        }


        // Phone Number Validation
        var phoneNumberPattern = /^\d{3}[-\s]?\d{3}[-\s]?\d{4}$/;
        if (phoneNumber=== ""){
            highlightInputBox("phoneNumber");
            showpopup("Phone Number is required");
            return false;
        }
        else if (!phoneNumberPattern.test(phoneNumber)) {
            highlightInputBox("phoneNumber");
            showpopup("Invalid Phone Number");
            return false;
        }

        var emailAddressPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if(emailConfirmation && emailAddress === ""){
            highlightInputBox("emailAddress");
            showpopup("Email address is required");
            return false;
        }
        else if (emailConfirmation &&  !emailAddressPattern.test(emailAddress)) {
            highlightInputBox("emailAddress");
            showpopup("Please Enter a valid Email Address ");
            return false;
        }
       
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'verify.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                displayPopup(response.message);
            }
        }

        const params = `firstName=${firstName}&lastName=${lastName}&password=${password}&therapistId=${therapistId}&phoneNumber=${phoneNumber}&emailAddress=${emailAddress}&emailconfirmation=${emailconfirmation}`;
        xhr.send(params);
       
        return false;
    };
    document.getElementById("popup").onclick = function () {
        closePopup();
    };
};



function showpopup(message) {
    showPopup(message);

}

function highlightInputBox(elementId) {
    var inputElement = document.getElementById(elementId);
    if (inputElement) {
        inputElement.style.border = "4px solid blue";
        return false;
    }
}

function resetBorderColors() {
    var inputElements = document.getElementsByTagName("input");
    for (var i = 0; i < inputElements.length; i++) {
        inputElements[i].style.border = "";
    }
}
function showPopup(message) {
    var popup = document.getElementById("popup");
    var popupContent = document.getElementById("popupContent");
    popupContent.innerText = message;
    popup.style.display = "flex"; 
  }
  function closePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = "none";
  }

  window.addEventListener('DOMContentLoaded', () => {
    const xhr = new XMLHttpRequest();
    
    xhr.open('GET', 'header.html', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const headerContent = xhr.responseText;
            document.querySelector('.header-container').innerHTML = headerContent;
        }
    };
    
    xhr.send();
});


document.addEventListener('DOMContentLoaded', () => {
    const createAccountForm = document.getElementById('createAccountForm');
    const popup = document.getElementById('popup');
    const popupContent = document.getElementById('popupContent');

    createAccountForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const clientId = document.getElementById('clientId').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'create-account.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                popupContent.innerText = response.message;
                popup.style.display = 'block';
                
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            }
        };

        xhr.send(`client_first_name=${firstName}&client_last_name=${lastName}&client_id=${clientId}`);
    });
});


