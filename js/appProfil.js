//******************* Selector inputs ************* */
//****************************************************/ 
const formProfil = document.forms['formProfil'];
const login = document.forms['formProfil']['nw_login'];
const password = document.forms['formProfil']['password'];
const con_password = document.forms['formProfil']['con_password'];


//******************* Listener ******************** */
//****************************************************/ 
login.addEventListener('change', validLogin);
password.addEventListener('change', validPassword);
con_password.addEventListener('change', validCo_password);

// *********************** Login *********************/
function validLogin(){
   let small = login.nextElementSibling;
   if(login.value.length < 3){
       small.innerHTML = 'Login trop court, minimum 3 lettre !';
       small.style.color = 'red';
       return false;
   }
   else{
       small.innerHTML = 'Login Valide';
       small.style.color = 'green';
       return true;
   }
}

// *********************** Password ********************/
// *****************************************************/
function validPassword(){
   let messg;
   let valide = false;
   if(password.value.length < 4){
       messg = 'Password trop court, Minimum 4 caractères !'
   }
   else if(!/[A-Z]/.test(password.value)){
       messg = 'Minimum 1 Majuscule !';
   }
   else if (!/[a-z]/.test(password.value)){
       messg = 'Minimum 1 Minuscule !';
   }
   else if(!/[0-9]/.test(password.value)){
       messg = 'Minimum 1 Chiffre !';
   }
   else{
       messg = 'Le Password est Valide';
       valide = true;
   }
   const small = password.nextElementSibling;
   if(valide){
       small.innerHTML = 'Password Valide';
       small.style.color = 'green';
       return true;
   }
   else{
       small.innerHTML = messg;
       small.style.color = 'red';
       return false;
   }
}

//****************** Confermation Password ***************/
function validCo_password(){
    const small = con_password.nextElementSibling;
    if(con_password.value === password.value){
        small.innerHTML = 'Confermation Password Valide';
        small.style.color = 'green';
        return true;
    }
    else{
        small.innerHTML = 'Veuillez entrer le même Password !';
        small.style.color = 'red';
        return false;
    }
}

//******************  Validation  **********************/
/**
* @returns true if inputs valide
*/
function submitForm() {
    if(validLogin() && validPassword() && validCo_password()){
        return true;
    }
    else{
        return false;
    }
    
}
// ****************  Fetch and Create User ****************/
//*********************************************************/
formProfil.addEventListener('submit', async function(e){
e.preventDefault();
const payload = new FormData(this); // creation object Form.

await fetch('./inscription.php', {
method: 'post',
body: payload
})
.then((response) => {
    if(submitForm()){
        this.submit();  // submit form.
    }
    //  Displaying message if user is created.
    if(response.status == 201 && submitForm()){
        alert(response.statusText);
        window.location = "./connexion.php";
        }
        return response.text();
    })
        
        

})
