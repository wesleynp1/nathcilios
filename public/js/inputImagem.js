const inputImagem = document.getElementById('inputImagem');
const imgPreview = document.getElementById('imgPreview');

const leitorDeArquivo = new FileReader();
const larguraMaxima = 1080;
const alturaMaxima = 1080;

//Quando o usuário fizer o upload o leitorDeArquivos lê os dados
inputImagem.onchange = ()=>{
    leitorDeArquivo.readAsDataURL(inputImagem.files[0]);
}

//Quando ele terminar de ler altera-se o preview
leitorDeArquivo.onload = ()=>{

    elementoImagem = document.createElement("img");
    elementoImagem.src = leitorDeArquivo.result;

    elementoImagem.onload = (event)=>{
        
        //redimensiona a imagem e mantem a proporção da imagem para não haver distorções
        if(elementoImagem.width > elementoImagem.height && elementoImagem.width > larguraMaxima){
            elementoImagem.height = larguraMaxima*(elementoImagem.height/elementoImagem.width)
            elementoImagem.width  = larguraMaxima;
        }else{
            if(elementoImagem.height > elementoImagem.width && elementoImagem.height > alturaMaxima){
                elementoImagem.width  = alturaMaxima*(elementoImagem.width/elementoImagem.height)
                elementoImagem.height = alturaMaxima;
            }else{
                if(elementoImagem.height == elementoImagem.width && elementoImagem.height > alturaMaxima){
                    elementoImagem.height = alturaMaxima;
                    elementoImagem.width = larguraMaxima;
                }
            }   
        }   

        //Cria um elemento canvas para redimesionar a imagem
        let meuCanvas = document.createElement("canvas");
        let contexto = meuCanvas.getContext("2d");
        meuCanvas.width = elementoImagem.width;
        meuCanvas.height = elementoImagem.height;
        contexto.drawImage(elementoImagem,0,0,elementoImagem.width,elementoImagem.height);
        
        

        //Exibe a imagem redimensionada
        meuCanvas.toBlob((b)=>{
            imgPreview.src = URL.createObjectURL(b)
            let arquivoImagemRedimesionada = new File([b],"imagemCarregadaPeloUsuário.jpg",{type: "image/jpeg"});
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(arquivoImagemRedimesionada);

            inputImagem.files = dataTransfer.files;
        },"image/jpeg")
    }
}