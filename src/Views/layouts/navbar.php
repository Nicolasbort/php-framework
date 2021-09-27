<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
  <div class="container">
    <a class="navbar-brand text-primary" href="/">
      <i class="fas fa-clinic-medical">&nbsp;</i>
      <span>Med<b>Docs</b></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <?php if(!$user): ?>
        <li class="nav-item">
          <a class="nav-link <?=$viewName == 'home' ? 'active' : ''?>" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=$viewName == 'login' ? 'active' : ''?>" href="/login">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=$viewName == 'signup' ? 'active' : ''?>" href="/signup">Cadastrar</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link <?= strpos($viewName, 'index') ? 'active' : ''?>" href="/<?= $user->role ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=$viewName == 'profile' ? 'active' : ''?>" href="/profile">Perfil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#logoffModal">
            Logoff
          </a>
        </li>
      <?php endif; ?>
      <li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#debugModal">
            Debug
          </a>
        </li>
      </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Debug Modal -->
<div class="modal fade" id="debugModal" tabindex="-1" aria-labelledby="debugModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="debugModalLabel">
          <i class="fa fa-terminal">&nbsp;</i>
          Debug
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo '<pre>' . var_export(get_defined_vars(), true) . '</pre>'; ?>
      </div>
    </div>
  </div>
</div>

<!-- Logoff Modal -->
<div class="modal fade" id="logoffModal" tabindex="-1" aria-labelledby="logoffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoffModalLabel">
          Logoff
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Deseja sair do sistema?
        <div class="container row mt-3">
          <div class="col-6">
            <a class="btn btn-secondary w-100" data-bs-dismiss="modal" aria-label="Close">Cancelar</a>
          </div>
          <div class="col-6">
            <a class="btn btn-danger  w-100" href="/users/logoff">Sair</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>