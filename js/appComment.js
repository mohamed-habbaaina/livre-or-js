
const formComment = document.forms['formComment'];
const inputComment = document.forms['formComment']['comment'];

//* **************** Listener ************************/
//****************************************************/ 

inputComment.addEventListener('keyup', validComment);
// formComment.addEventListener('submit', preventSubmit);

//* **************** Listener ************************/
//****************************************************/ 

function validComment(){

    const small = inputComment.nextElementSibling;
    if(inputComment.value.length > 7){

        small.innerHTML = 'Commentaire Valide';
        small.style.color = 'green';
    }
    else{
        small.innerHTML = 'Minimum 8 Caractères !';
        small.style.color = 'red';
    }

}

formComment.addEventListener('submit', function(e) {
    
    e.preventDefault();
    
    const display = document.querySelector('.mess_inser');


    if(inputComment.value.length > 7){
        display.innerHTML = 'Votre message est bien enregistré <a href="livre-or.php">"Livre d\'Or"</a> !';
        display.style.color = 'green';
        formComment.submit();
    }    
})