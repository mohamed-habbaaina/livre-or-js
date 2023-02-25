
const formlivre = document.forms['formlivre'];
const inputCommentLivre = document.forms['formlivre']['comment'];

//* **************** Listener ************************/
//****************************************************/ 

inputCommentLivre.addEventListener('keyup', validComment);

//* **************** Listener ************************/
//****************************************************/ 

/**
 * minimum 8 characters to validate the comment
 */
function validComment(){

    const small = inputCommentLivre.nextElementSibling;
    if(inputCommentLivre.value.length > 7){

        small.innerHTML = 'Commentaire Valide';
        small.style.color = 'green';
    }
    else{
        small.innerHTML = 'Minimum 8 Caractères !';
        small.style.color = 'red';
    }

}

formlivre.addEventListener('submit', function(e) {
    
    e.preventDefault();
    
    const display = document.querySelector('.mess_inser');


    if(inputCommentLivre.value.length > 7){
        display.innerHTML = 'Votre message est bien enregistré !';
        display.style.color = 'green';
        formlivre.submit();
    }    
})

// creation table comments.
window.addEventListener("DOMContentLoaded", () => {


    let form = new FormData(formlivre);
    fetch("./includes/liveFetch.php",{
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: form
        })
    .then(response => {
        return response.json();
    })
    .then((data) => {

        // Selected the tbody
        const tbody = document.querySelector("tbody")

        for(let item of data){

            // creation tbody: <tr> , 3 * <td>, 
            let tr = document.createElement("tr");
            let td1 = document.createElement("td");
            let td2 = document.createElement("td");
            let td3 = document.createElement("td");

            // Assigning data to elements
            td1.textContent = item.date;
            td2.textContent = item.login;
            td3.textContent = item.commentaire;

            // to tr then to tbody
            tr.append(td1, td2,td3);
            tbody.append(tr);

        }
    })
})