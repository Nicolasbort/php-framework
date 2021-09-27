<div class="container mt-3">
    <h1 class="text-center">Home Page</h1>

    <?php if ($user): ?>
        <h1>Olá <?= $user->getName() ?></h1>
    <?php endif; ?>
</div>
