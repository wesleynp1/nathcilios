<x-main-template extraStyle="/css/login.css">
    <form class="formulario" id="formLogin" action="/login" method="POST">
        @CSRF

        <img src="/img/usuario.png" alt="">
        
        <label for="inputEmail">E-mail</label>
        <input type="text" name="email" id="inputEmail" placeholder="insira seu email aqui..." required>

        <label for="inputPassword">Senha</label>
        <input type="password" name="password" id="inputPassword" placeholder="insira sua senha aqui..." required>

        <input type="submit" value="ENTRAR" class="btn btn-primary">

        <p>
            <input type="checkbox" name="remember" id="inputRemember" >  Entrar automaticamente
        </p>
    </form>

    <a href="/esqueciSenha" class="btn btn-primary mt-2">Esqueci minha senha</a>
    <br>
    <a href="/registrar"> <p class="btn btn-primary mt-2"> Criar uma conta</p></a>

    @if(Session::has("error"))
        <p class="falha">Erro:{{Session::get('error')}}</p>
        @php
            request()->session()->forget('error');
        @endphp
    @endif
</x-main-template>