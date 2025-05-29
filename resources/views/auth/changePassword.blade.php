<x-main-template extraStyle="/css/login.css">
    <form class="formulario" id="formLogin" action="/changePassword" method="POST">
        @CSRF

        <label for="inputOldPassword">Antiga Senha</label>
        <input type="password" name="current_password" id="current_password" placeholder="insira sua senha atual aqui..." required>

        <label for="inputNewPassword">Nova Senha</label>
        <input type="password" name="password" id="password" placeholder="insira sua nova senha aqui..." required>

        <label for="inputNewPassword">Repita Nova Senha</label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="insira sua nova senha novamente aqui..." required>

        <input type="submit" value="Redefinir Senha">
    </form>

    @if(Session::has("error"))
        <p class="falha">Erro:{{Session::get('error')}}</p>
        @php
            request()->session()->forget('error');
        @endphp
    @endif
</x-main-template>