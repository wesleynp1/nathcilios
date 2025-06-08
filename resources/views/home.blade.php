<x-main-template>

    @auth
    <a href="/mudarSenha" class="btn btn-primary">
        mudar minha Senha
    </a>
    @endauth

    <a href="/novaMarcacao" class="btn btn-primary mt-2">
        Agendar meu atendimento
    </a>

    <a href="/servicos">
        <div class="container p-2 service mt-2">
            <div class="row">
                <div class="col-6  m-auto">
                    <p  class="fs-2 text-center">Ver Serviços e Técnicas Oferecidas</p1>
                </div>                
                <img src='/img/FotoCilios.jpg' class="col-6">
            </div>
        </div>
    </a>

    
    <h2 class="mt-2">Onde Estamos:<h2>
    <div class="container overflow-scroll mt-2">
        <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d1158.3710323822518!2d-43.24020673036149!3d-22.870812998705002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjLCsDUyJzE0LjkiUyA0M8KwMTQnMjIuNCJX!5e1!3m2!1spt-BR!2sbr!4v1749411780760!5m2!1spt-BR!2sbr" width="500" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <div>
    
    <h2 class="mt-2">Visite nosso Instragram<h2>
    <a href="https://www.instagram.com/nathcilios/">
        <div class="container">
            <img src='/img/RedeSocialInstagram.png' class="InstagramIcon">
            <span class="col-6 m-auto">Nathcilios</span>        
        </div>
    </a>

    
</x-main-template>