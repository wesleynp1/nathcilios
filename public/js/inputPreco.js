inputPreco.addEventListener("input", formatarDinheiro);
formulario.addEventListener("submit",formatarCampoPrecoParaSubmit);            

formatarDinheiro(inputPreco);//formatação inicial

function formatarDinheiro(){
    let numero = parseInt(inputPreco.value.replace(/[^0-9]/g, '')).toString();
    let numeroEmTexto = isNaN(numero) ? 0 : numero;

    while(numeroEmTexto.length<3){
        numeroEmTexto = "0"+numeroEmTexto;
    }

    numeroEmTexto = numeroEmTexto.slice(0,-2)+","+numeroEmTexto.slice(-2);
    
    inputPreco.value = "R$ "+numeroEmTexto;
}

function formatarCampoPrecoParaSubmit(){
    inputPreco.value = inputPreco.value.replace(",",".").replace("R$ ","");
    return true;
}   