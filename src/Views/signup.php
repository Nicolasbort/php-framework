<?php
    require_once "src/Core/Session.php";

    $error = Application::$app->session->getFlash('error'); 
    
?>

<div class="container my-5">
    <h1 class="text-center">Cadastro</h1>

    <form class="shadow rounded p-4 bg-light w-50 m-auto" action="/users/signup" method="post">
        <div class="mb-3">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $error['value']; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
    