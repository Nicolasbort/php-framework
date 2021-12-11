<div class="container my-5">
  <div class="row mb-3">
    <div class="col-12 mb-3" data-aos="fade-up">
      <h4 class="text-primary mb-0">Perfil <?= $user->getName(); ?></h4>
      <small class="text-muted mb-3"><?= $user->getDocument(); ?></small>
    </div>
  </div>
  <div class="row mb-3 pb-3">
    <form action="/profile/update" method="POST" data-aos="fade-up" data-aos-delay="100">
        <div class="mb-3">
            <label for="id" class="form-label">Código</label>
            <input type="text" readonly name="id" class="form-control" value="<?= $user->getId()?>" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" value="<?= $user->getName()?>" required>
        </div>
        <div class="mb-3">
            <label for="document" class="form-label">Documento (CRM/CPF/CPNJ)</label>
            <input type="text" name="document" class="form-control" value="<?= $user->getDocument()?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $user->getEmail()?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Tipo de cadastro</label>
            <select class="form-select" name="role" disabled>
              <option value='<?=$user->getRole()?>'><?= $user->getRole()?></option>
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary w-100">
              Salvar alterações
            </button>
        </div>
      </form>
</div>
    