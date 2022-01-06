<div class="container mt-3">
    <h1 class="text-center mb-5 text-primary" data-aos="fade-up">
      <i class="fas fa-clinic-medical">&nbsp;</i>
      <span>Med<b>Docs</b></span>
    </h1>

    <h5 class="text-center text-grey mb-5" data-aos="fade-up">
      Organize seus exames e consultas todos em um único lugar, seja você um médico ou um paciente!
    </h5>

    <div class="row align-items-stretch mb-md-5">
      <div class="row col-sm-12 text-center text-primary">
        <h3 class="col-sm-12 col-md-4 mb-5" data-aos="fade-up" data-aos-delay="100">
          <i class="fas fa-diagnoses">&nbsp;</i>
          Exames
        </h3>
        <h3 class="col-sm-12 col-md-4 mb-5" data-aos="fade-up" data-aos-delay="150">
          <i class="fa fa-file">&nbsp;</i>
          Consultas
        </h3>
        <h3 class="col-sm-12 col-md-4 mb-5" data-aos="fade-up" data-aos-delay="200">
          <i class="fa fa-user">&nbsp;</i>
          Pacientes
        </h3>
      </div>
    </div>

    <?php if(!$user): ?>
      <div class="row mb-5">
        <div class="col-sm-12">
          <a class="btn btn-primary w-100" href="signup" data-aos="fade-up" data-aos-delay="300">
            Registre-se grátis agora!
          </a>
        </div>
      </div>
    <?php else: ?>
      <div class="row mb-5">
        <div class="col-sm-12 text-center" data-aos="fade-up" data-aos-delay="300">
          <p>
            Você está na conta de <i><?= $user->getName() ?></i>
          </p>
          <a class="btn btn-primary w-100 mb-3" href="/<?= $user->getRole() ?>">
            Clique aqui para acessar o sistema
          </a>
          <a href="/users/logoff">Entrar em outra conta</a>
        </div>
      </div>
    <?php endif; ?>
</div>
