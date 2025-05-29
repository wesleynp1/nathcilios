<x-main-template>
        <form action="/deletarAgendamento/{{$scheduling->id}}" method="post">
            @CSRF
            <p>Tem certeza que deseja deletar o seguinte agendamento?</p>
            <p>Cliente {{ $scheduling->client_name }} marcada em {{ $scheduling->scheduled_time }} para o serviço {{ $scheduling->service_name }}</p>
            <a id="botaoNao" href="/agendamentos">NÃO</a>
            <input id="botaoSim" type="submit" value="SIM">

            <p>Lembrando que você pode editá-lo ao invés de excluir</p>
        </form>        
</x-main-template>