<x-main-template extraStyle="/css/login.css">
    <form class="formulario" id="formLogin" action="/forgot-password" method="POST">
        @CSRF
        
        <label for="inputEmail">E-mail</label>
        <input type="text" name="email" id="inputEmail" placeholder="insira seu email aqui..." required>

        <input type="submit" value="ENVIAR E-MAIL">
    </form>
    <p>Te enviaremos um link por email, basta clicar nele</p> 
    <p>DICA: se não encontrá-lo na sua caixa de email verifique a caixa de SPAM</p>
</x-main-template>