<div class="container my-5">
  <div class="row mb-3">
    <div class="col-12 mb-3" data-aos="fade-up">
      <h4 class="text-primary mb-0">Paciente <?= $user->getName(); ?></h4>
      <small class="text-muted mb-3"><?= $user->getDocument(); ?></small>
      <h5 class="mt-3">Consultas</h5>
      <div class="row">
        <div class="col-6">
          <h6 class="mt-3">Consultas por mês</h6>
          <table class="table">
              <tr>
                <th>Mês</th>
                <th>Consultas</th>
              </tr>
              <?php if($consults_by_month): ?>
                <?php foreach($consults_by_month as $month=>$count): ?>
                  <tr>
                    <th><?=$month?></th>
                    <td><?=$count?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="2">Nenhum consulta registrado</td>
                </tr>
              <?php endif; ?>
          </table>
        </div>
        <div class="col-6">
          <h6 class="mt-3">Consultas por ano</h6>
          <table class="table">
              <tr>
                <th>Ano</th>
                <th>Consultas</th>
              </tr>
              <?php if($consults_by_year): ?>
                <?php foreach($consults_by_year as $month=>$count): ?>
                  <tr>
                    <th><?=$month?></th>
                    <td><?=$count?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="2">Nenhum consulta registrado</td>
                </tr>
              <?php endif; ?>
          </table>
        </div>
      </div>
      <h5 class="mt-3">Exames</h5>
      <div class="row">
        <div class="col-6">
          <table class="table">
              <tr>
                <th>Mês</th>
                <th>Exames</th>
              </tr>
            <?php if($exams_by_month): ?>
              <?php foreach($exams_by_month as $month=>$count): ?>
                <tr>
                  <th><?=$month?></th>
                  <td><?=$count?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="2">Nenhum exame registrado</td>
              </tr>
            <?php endif; ?>
          </table>
        </div>
        <div class="col-6">
          <table class="table">
              <tr>
                <th>Ano</th>
                <th>Exames</th>
              </tr>
            <?php if($exams_by_month): ?>
              <?php foreach($exams_by_year as $month=>$count): ?>
                <tr>
                  <th><?=$month?></th>
                  <td><?=$count?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="2">Nenhum exame registrado</td>
              </tr>
            <?php endif; ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-3 pb-3 g-3">
    <h4 class="text-primary" data-aos="fade-up">Exames registrados</h4>
    <?php if($exams): ?>
      <?php foreach($exams as $exam): ?>
          <div class="col-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card card-body shadow-sm rounded">
              <h5 class="text-dark">Paciente #<?= $exam->getUserId() ?> <small class="text-muted">#<?=$exam->getId()?></small></h5>
              <small><i class="fa fa-calendar">&nbsp;</i> <?= $exam->getDate() ?></small>
              <div class="mb-1 mt-3">
                <h6 class="text-dark"><i class="fa fa-file text-dark">&nbsp;</i>Tipo</h6>
                <p><?= $exam->getType() ?></p>
              </div>
              <div class="mb-1">
                <h6 class="text-dark"><i class="fa fa-check  text-dark">&nbsp;</i>Resultado</h6>
                <p><?= $exam->getResult() ?></p>
              </div>
            </div>
          </div>
      <?php endforeach ?>
    <?php else: ?>
      <div class="col-12 d-flex justify-content-between align-items-center">
        Nenhum exame encontrada
      </div>
    <?php endif; ?>
  </div>
  <div class="row mb-3 pb-3 g-3">
    <h4 class="text-primary" data-aos="fade-up" data-aos-delay="100">Consultas registradas</h4>
    <?php if($consults): ?>
      <?php foreach($consults as $consult): ?>
        <div class="col-6" data-aos="fade-up" data-aos-delay="100">
          <div class="card card-body shadow-sm rounded">
            <h5 class="text-dark">Paciente #<?= $consult->getUserId() ?> <small class="text-muted">#<?=$consult->getId()?></small></h5>
            <small><i class="fa fa-calendar">&nbsp;</i> <?= $consult->getDate() ?></small>
            <div class="mb-1 mt-3">
              <h6 class="text-dark"><i class="fa fa-file text-dark">&nbsp;</i>Receita</h6>
              <p><?= $consult->getReceipt() ?></p>
            </div>
            <div class="mb-1">
              <h6 class="text-dark"><i class="fa fa-check  text-dark">&nbsp;</i>Observação</h6>
              <p><?= $consult->getObservation() ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 d-flex justify-content-between align-items-center">
        Nenhuma consulta encontrada
      </div>
    <?php endif; ?>
  </div>
</div>
    