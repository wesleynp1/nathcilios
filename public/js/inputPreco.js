function formatarDinheiro(){
    let numero = parseInt(this.value.replace(/[^0-9]/g, '')).toString();
    let numeroEmTexto = isNaN(numero) ? 0 : numero;

    while(numeroEmTexto.length<3){
        numeroEmTexto = "0"+numeroEmTexto;
    }

    numeroEmTexto = numeroEmTexto.slice(0,-2)+","+numeroEmTexto.slice(-2);
    
    this.value = "R$ "+numeroEmTexto;
}

function formatarCampoPrecoParaSubmit(input){
    input.value = input.value.replace(",",".").replace("R$ ","");
    return true;
}