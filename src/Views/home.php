<div class="container">
    <h1>home page</h1>

    <?php
        if ($user) {
            echo "Olá {$user->getName()}";
        }
    ?>
</div>
