<x-main-template extraStyle="/css/login.css">
        <form class="formulario" id="formLogin" action="/registrar" method="POST">
            @CSRF

            <label for="inputName">Nome</label>
            <input type="text" name="name" id="inputName" placeholder="insira seu nome aqui..." required>
            
            <label for="inputEmail">E-mail</label>
            <input type="text" name="email" id="inputEmail" placeholder="insira seu email aqui..." required>

            <label for="inputPassword">Nova Senha</label>
            <input type="password" name="password" id="inputPassword" placeholder="insira sua senha aqui..." required>

            <label for="inputPassword">Repita sua Senha</label>
            <input type="password" name="password_confirmation" id="inputPasswordConfirmation" placeholder="insira novamente sua senha aqui..." required>

            <input type="submit" value="ENTRAR">
        </form>

        @if(Session::has("error"))
            <p class="falha">Erro:{{Session::get('error')}}</p>
            @php
                request()->session()->forget('error');
            @endphp
        @endif
</x-main-template>