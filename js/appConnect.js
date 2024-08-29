//******************* validation inputs ************* */
//****************************************************/
const formConnect = document.forms["formConnect"];
const errs = document.getElementById("errs");

const login = document.forms["formConnect"]["username"];
const password = document.forms["formConnect"]["password"];

//******************* Listener ******************** */
//****************************************************/

login.addEventListener("change", validLogin);
password.addEventListener("change", validPassword);

// *********************** Login *********************/

function validLogin() {
  let small = login.nextElementSibling;
  if (login.value.length < 3) {
    small.innerHTML = "Login trop court, minimum 3 lettre !";
    small.style.color = "red";
    return false;
  } else {
    small.innerHTML = "Login Valide";
    small.style.color = "green";
    return true;
  }
}

// *********************** Password ********************/

function validPassword() {
  let messg;
  let valide = false;

  if (password.value.length < 4) {
    messg = "Password trop court, Minimum 4 caractères !";
  } else if (!/[A-Z]/.test(password.value)) {
    messg = "Minimum 1 Majuscule !";
  } else if (!/[a-z]/.test(password.value)) {
    messg = "Minimum 1 Minuscule !";
  } else if (!/[0-9]/.test(password.value)) {
    messg = "Minimum 1 Chiffre !";
  } else {
    messg = "Le Password est Valide";
    valide = true;
  }

  const small = password.nextElementSibling;

  if (valide) {
    small.innerHTML = "Password Valide";
    small.style.color = "green";
    return true;
  } else {
    small.innerHTML = messg;
    small.style.color = "red";
    return false;
  }
}

//******************  Validation  **********************/

/**
 * @returns true if inputs valide
 */
function submitForm() {
  if (validLogin() && validPassword()) {
    return true;
  } else {
    return false;
  }
}

// ****************  Fetch and Create User ****************/
//*********************************************************/

formConnect.addEventListener("submit", async function (e) {
  e.preventDefault();
  if (!submitForm()) {
    return;
  }
  errs.innerHTML = "";
  await fetch("./connexion.php", {
    method: "post",
    body: new FormData(formConnect),
  }).then((response) => {
      if (response.status == 200) {
        window.location.href = "./livre-or.php"
      }
    });
});
