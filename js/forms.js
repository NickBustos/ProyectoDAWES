/* Esto no se esta utilizando */
async function envioFormulario(url = '', data = {}) {
   
    const response = await fetch(url, {
      method: 'POST', 
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: JSON.stringify(data) 
    });
    //return response.json();
    return JSON.stringify(response);
  }
  
let formulario =  document.querySelector("form");
console.log(formulario);
let submit = formulario.querySelector("#envio");
console.log(submit);
submit.addEventListener("click", () => {

    let email = formulario.querySelector("#emailRegistro").value;
    console.log(email);

    envioFormulario('src/form/registerForm.php', { email: email })
    .then((data) => {
      console.log(data); 
    })
    .catch((error) => {
        console.error('ERROR:', error);
    });

  })


  
  

