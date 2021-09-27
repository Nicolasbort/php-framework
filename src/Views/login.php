<?php
    require_once "src/Core/Session.php";

    $error = Application::$app->session->getFlash('error'); 
?>

<div class="container my-5">
    <h1 class="text-center">Login</h1>

    <form class="shadow rounded p-4 bg-light w-50 m-auto" action="/users/login" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>
    