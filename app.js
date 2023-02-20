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


    // *********************** Email *********************/
    email.addEventListener('change', function() {

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
            return true; // pour l'utiliser dans la function de submit form
        } else{
            small.innerHTML = 'Adresse Email Pas Valide (Carectère Valide: A-Z 0-9 _.-)';
            small.style.color = 'red';
            return false;
        }
})

    // *********************** Login *********************/

    login.addEventListener('change', function(){

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
    })

    // *********************** Password ********************/

    password.addEventListener('change', function(){

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
    })

    //****************** Confermation Password ***************/

    co_password.addEventListener('change', function(){

        const small = co_password.nextElementSibling;

        if(co_password.value === password.value){
            small.innerHTML = 'Confermation Password Valide';
            small.style.color = 'green';
            return true;
        }
        else{
            small.innerHTML = 'Veuillez entrer le même Password !';
            small.style.color = 'red';
        }

    })

    // ****************  Fetch and Create User ****************/
    //*********************************************************/

    formInscription.addEventListener('submit', async function(e){

        e.preventDefault();

        
    })
