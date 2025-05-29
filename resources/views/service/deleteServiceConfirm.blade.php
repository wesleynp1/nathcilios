<x-main-template extraStyle="/css/delete.css">        
    <form action="/deletarServico/{{$service->id}}" method="post">
        @CSRF
        <p>Tem certeza que deseja deletar o seguinte serviço?</p>
        <p>"{{$service->name}}" ofertado por  R$ {{ str_replace(".",",",$service->price) }}</p>
        <a id="botaoNao" href="/servicos">NÃO</a>
        <input id="botaoSim" type="submit" value="SIM">

        <p>Lembrando que você pode editá-lo ao invés de exluir</p>
    </form>
</x-main-template>

