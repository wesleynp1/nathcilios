<x-main-template extraStyle="/css/login.css">
        <form class="formulario" id="formLogin" action="/reset-password" method="POST">
            @CSRF
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <label for="inputPassword">Nova Senha</label>
            <input type="password" name="password" id="inputPassword" placeholder="insira sua nova senha aqui..." required>

            <label for="inputPassword">Repita Nova Senha</label>
            <input type="password" name="password_confirmation" id="inputPassword" placeholder="insira novamente sua nova senha aqui..." required>

            <input type="submit" value="Redefinir Senha">
        </form>
</x-main-template>