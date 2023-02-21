/**
 * @return menu hamberger
 */
const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav_bar');
    // const navLinks = document.querySelectorAll('.nav-links li');
    
    burger.addEventListener('click', () => {
        
        //  Toggel nav
        nav.classList.toggle('nav-active');

        //  Animate Links
        // navLinks.forEach((link, index) => {
        //     if (link.style.animation) {
        //         link.style.animation = '';
        //     } else {
        //         link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 1.5}s`;
        //     }
        // });
    });
    }
    navSlide();

    //******************* validation inputs ************* */
    //****************************************************/ 
    const formInscription = document.forms['formInscription'];

    const email = document.forms['formInscription']['email'];
    const login = document.forms['formInscription']['username'];
    const password = document.forms['formInscription']['password'];
    const co_password = document.forms['formInscription']['co_password'];


    //******************* Listener ******************** */
    //****************************************************/ 

    email.addEventListener('change', validEmail);
    login.addEventListener('change', validLogin);
    password.addEventListener('change', validPassword);
    co_password.addEventListener('change', validCo_password);


    // *********************** Email *********************/
    function validEmail(){

        // Creation of the Regexp to validate the email
        let emailRegExp = new RegExp(
          '^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,}$', 'g'
        );

       //  test the email address
        let testEmail = emailRegExp.test(email.value); // return true ou false.

        //  Get the small tag: 'nextElementSibling'
        let small = email.nextElementSibling;

        // Displaying the email validation
        if(testEmail){
            small.innerHTML = 'Adresse Email Valide';
            small.style.color = 'green';
            return true; // pour l'utiliser dans la function de submitForm
        } else{
            small.innerHTML = 'Adresse Email Pas Valide (Carectère Valide: A-Z 0-9 _.-)';
            small.style.color = 'red';
            return false;
        }
}

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

        const small = co_password.nextElementSibling;

        if(co_password.value === password.value){
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
 * 
 * @returns true if inputs valide
 */
    function submitForm() {

        if(validEmail() && validLogin() && validPassword() && validCo_password()){
            return true;
        }
        else{
            return false;
        }
        
    }


    // ****************  Fetch and Create User ****************/
    //*********************************************************/

    formInscription.addEventListener('submit', async function(e){

        e.preventDefault();

        const payload = new FormData(this); // creation object Form.

        let email = payload.get('email');
        let login = payload.get('username');
        let password = payload.get('password');
        let co_password = payload.get('co_password');

        await fetch('./inscription.php', {
            method: 'post',
            body: payload
        })
        .then((response) => {

            //  Displaying message if user is created.
            if(response.status == 201 && submitForm()){
                alert(response.statusText);
                this.submit();  // submit form.
            }
            return response.text();
        })
        
        

    })
