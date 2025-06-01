<header id="mainHeader" class="container-fluid bg-dark">
    <div id="titleContainer" class="row">
        <div class="col-12 d-flex align-items-center">
            <img src="/img/Nathcilios.png" class="img-fluid m-auto my-1"/>
        </div>
    </div>

    <nav class="row text-center justify-content-between">
        <a href="/"             class="col mb-1">Início</a>
        <a href="/servicos"     class="col mb-1  mx-2">Serviços</a>
        <a href="/agendamentos" class="col mb-1 me-2">Marcações</a>
        <a href="/agenda"       class="col mb-1 me-2">Agenda</a>
        
        @guest
            <a href="/login"        class="col mb-1 ">login</a>
        @endguest

        @auth
            <div class="col mb-1">
                <div class="container-fluid">
                    <form action="/logout" method="POST" class="row">
                        @csrf
                        <input type="submit" value="Sair" class="col-12">
                    </form>    
                </div>
            </div>
        @endauth        
    </nav>
</header>