<form class="form" id="formService" action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf

    <img src="" alt="" id="imgPreview">
    <label for="inputImage">Imagem</label>
    <input type="file" name="image" id="inputImagem"  accept="image/png, image/jpeg">
    
    <label for="inputNome" >Nome</label>
    <input type="text" name="name" id="inputNome" value="{{ isset($service) ? $service->name : '' }}" required>
    <br>

    <label for="inputPreco">Preço</label>
    <input type="text" name="price" id="inputPreco" value="{{  isset($service) ?  $service->price : 0 }}" required>
    <br>

    <label for="inputDescricao">Descrição</label>
    <div id="editor">
        <p>{!! isset($service) ? $service->description : '' !!}</p>
    </div>           
    <br>

    <input type="submit" id="botaoSubmit" value="CADASTRAR">
</form>    

<style>
    #formService{
        display: flex;        
        flex-direction: column;
        margin: 0px 32px;
    }
</style>

<script>
    const inputPreco  = document.getElementById("inputPreco");
    const formulario  = document.getElementById("formService");
</script>
<script src="/js/inputPreco.js"></script>
<script src="/js/inputImagem.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    formulario.onsubmit = ()=>{
        let input = document.createElement("input");
        
        input.type = "text";
        input.value = quill.getSemanticHTML();
        input.name = "description";
        input.hidden = true;

        formulario.append(input);
    }
</script>