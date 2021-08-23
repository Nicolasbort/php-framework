<?php
    require_once "src/Core/Session.php";
?>


<h1>Login</h1>

<?php
    $error = Application::$app->session->getFlash('error'); 
    if (isset($error)){
        echo $error['value'];
    }
?>

<form action="/users/login" method="post">
    <input type="text" name="email" placeholder="Email">
    <input type="text" name="password" placeholder="Senha">
    <button type="submit">Entrar</button>
</form>