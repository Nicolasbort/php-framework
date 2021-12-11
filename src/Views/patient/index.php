<div class="container my-5">
  <div class="row mb-3">
    <div class="col-12 mb-3" data-aos="fade-up">
      <h4 class="text-primary mb-0">Paciente <?= $user->getName(); ?></h4>
      <small class="text-muted mb-3"><?= $user->getDocument(); ?></small>
      <h6><?= count($exams) ?> exames(s) registados</h6>
      <h6><?= count($consults) ?> consultas(s) registados</h6>
    </div>
  </div>
  <div class="row mb-3 pb-3">
    <h4 class="text-primary" data-aos="fade-up">Exames registrados</h4>
    <?php foreach($exams as $exam): ?>
      <div class="card col-12 shadow-sm rounded p-4 bg-light mb-3" data-aos="fade-up" data-aos-delay="100">
        <h5 class="text-dark">#<?=$exam->getId()?></h5>
        <p><i class="fa fa-calendar">&nbsp;</i> <?= $exam->getDate() ?></p>
        <p><i class="fa fa-user">&nbsp;</i> <?= $exam->getUserId() ?></p>
        <p><i class="fa fa-file">&nbsp;</i> <?= $exam->getType() ?></p>
        <p><i class="fa fa-check">&nbsp;</i> <?= $exam->getResult() ?></p>
      </div>
    <?php endforeach ?>
  </div>
  <div class="row mb-3 pb-3">
    <h4 class="text-primary" data-aos="fade-up" data-aos-delay="100">Consultas registradas</h4>
    <?php foreach($consults as $consult): ?>
      <div class="card col-12 shadow-sm rounded p-4 bg-light mb-3" data-aos="fade-up">
        <h5 class="text-dark">#<?=$consult->getId()?></h5>
        <p><i class="fa fa-calendar">&nbsp;</i> <?= $consult->getDate(true)->format('d/m/Y H:i') ?></p>
        <p><i class="fa fa-user">&nbsp;</i> <?= $consult->getUserId() ?></p>
        <p><i class="fa fa-file">&nbsp;</i> <?= $consult->getReceipt() ?></p>
        <p><i class="fa fa-check">&nbsp;</i> <?= $consult->getObservation() ?></p>
      </div>
    <?php endforeach ?>
  </div>
</div>
    