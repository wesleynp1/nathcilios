<x-main-template>

    @auth
    <a href="/novoServico" class="btn btn-primary">
        Criar novo Servico
    </a>        
    <a href="/mudarSenha" class="btn btn-primary">
        mudar minha Senha
    </a>
    @endauth

    <a href="/novaMarcacao" class="btn btn-primary">
        Agendar meu atendimento
    </a>

    <p>Conteúdo chamativo do site Aqui</p>
    
</x-main-template>