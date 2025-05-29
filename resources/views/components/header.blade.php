<header id="mainHeader" class="container-fluid bg-dark">
    <div id="titleContainer" class="row">

        <h1 class="col-10 text-center text-white">Sistema de Marcação de atendimento</h1>

        <div id="loginContainer" class="col-2">
            @guest
                <a href="/login">login</a>
            @endguest

            @auth
                <span>{{ auth()->user()->name }},</span>
                <form action="/logout" method="POST">
                    @csrf
                    <input type="submit" value="Sair">
                </form>                
            @endauth        
        </div>
    </div>

    <nav class="row text-center justify-content-between">
        <a href="/"             class="col mb-1">Início    </a>
        <a href="/servicos"     class="col mb-1  mx-2">Serviços  </a>
        <a href="/agendamentos" class="col mb-1  me-2">Marcações </a>
        <a href="/agenda"       class="col mb-1">Agenda    </a>
    </nav>
</header>