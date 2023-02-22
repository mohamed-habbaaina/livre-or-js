
const formComment = document.forms['formComment'];
const inputComment = document.forms['formComment']['comment'];

//* **************** Listener ************************/
//****************************************************/ 

inputComment.addEventListener('keyup', validComment);

//* **************** Listener ************************/
//****************************************************/ 

function validComment(){

    const small = inputComment.nextElementSibling;
    if(inputComment.value.length > 8){

        small.innerHTML = 'Commentaire Valide';
        small.style.color = 'green';
    }
    else{
        small.innerHTML = 'Minimum 8 Caractères !';
        small.style.color = 'red';
    }

}