<x-main-template extraStyle="/css/login.css">
        <h1>BEM VINDA!</h1>
        <h2>Por favor preencha o formulario, é rapidinho</h2>

        <form class="formulario formularioComTelefone" id="formLogin" action="/registrar" method="POST">
            @CSRF

            <label for="inputName">Seu Nome:</label>
            <input type="text" name="name" id="inputName" placeholder="insira seu nome aqui..." class="form-control" required>
            
            <label for="clientNumber">Seu número de telefone:</label>
            <input type="text" name="phone_number" id="inputClientNumber" inputmode="numeric" placeholder="Digite seu número aqui" class="form-control telefone">            
            
            <label for="inputEmail">Seu E-mail</label>
            <input type="text" name="email" id="inputEmail" placeholder="insira seu email aqui..." class="form-control" required>

            <label for="inputPassword">Sua Nova Senha</label>
            <input type="password" name="password" id="inputPassword" placeholder="insira sua senha aqui..." class="form-control" required>

            <label for="inputPassword">Repita sua Nova Senha</label>
            <input type="password" name="password_confirmation" id="inputPasswordConfirmation" placeholder="insira novamente sua senha aqui..." class="form-control" required>

            <input type="submit" class="btn btn-primary mt-5" value="CRIAR CONTA">
        </form>

        <script src="/js/inputTelefone.js"></script>

        @if(Session::has("error"))
            <p class="falha">Erro:{{Session::get('error')}}</p>
            @php
                request()->session()->forget('error');
            @endphp
        @endif
</x-main-template>