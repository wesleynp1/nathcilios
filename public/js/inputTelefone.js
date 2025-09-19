Array.from(document.getElementsByClassName("telefone")).map(e=> e.oninput  = ()=>{numeroDeTelefone(e);});
Array.from(document.getElementsByClassName("formularioComTelefone")).map(f=> f.onsubmit = formularioComNumeroDeTelefone);

function numeroDeTelefone(input){
    input.value = input.value.replace(/[^0-9]/g, '');
    if(input.value.length>2)input.value = "("+input.value.slice(0,2)+") "+input.value.slice(2);
    if(input.value.length>14)input.value = input.value.slice(0,14);
}

function formularioComNumeroDeTelefone() {
    let inputClientNumber=document.getElementById("inputClientNumber");      
    inputClientNumber.value = inputClientNumber.value.replace(/[^0-9]/g, '');
}