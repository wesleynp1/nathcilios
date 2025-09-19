<form class="form" id="formService" action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf

    <img src="" alt="" id="imgPreview">
    <label for="inputImage">Imagem</label>
    <input type="file" name="image" id="inputImagem"  accept="image/png, image/jpeg">
    
    <label for="inputNome" >Nome</label>
    <input type="text" name="name" id="inputNome" value="{{ isset($service) ? $service->name : '' }}" required>
    <br>

    <label for="inputPreco">Preço Aplicação</label>
    <input type="text" name="price" id="inputPreco" value="{{  isset($service) ?  $service->price : 0 }}" required>
    <br>

    <label for="inputPreco">Preço Manutenção</label>
    <input type="text" name="maintenance_price" id="inputMaintenencePreco" value="{{  isset($service) ?  $service->maintenance_price : 0 }}">
    <br>

    <label for="inputDescricao">Descrição</label>
    <textarea type="text" name="description" id="inputDescricao" required>{{ isset($service) ? $service->description : '' }}</textarea>

    <input type="submit" id="botaoSubmit" value="CADASTRAR" class="btn btn-primary">

    
</form>    

<style>
    #formService{
        display: flex;        
        flex-direction: column;
        margin: 0px 32px;
    }
</style>

<script src="/js/inputPreco.js"></script>

<script>
    const inputPreco = document.getElementById("inputPreco");
    const inputMaintenencePreco = document.getElementById("inputMaintenencePreco");
    
    inputPreco.oninput = formatarDinheiro;
    inputMaintenencePreco.oninput = formatarDinheiro;
    document.getElementById("formService").onsubmit = ()=>{formatarCampoPrecoParaSubmit(inputPreco);formatarCampoPrecoParaSubmit(inputMaintenencePreco)}

    inputPreco.oninput();
    inputMaintenencePreco.oninput();
</script>

<script src="/js/inputImagem.js"></script>