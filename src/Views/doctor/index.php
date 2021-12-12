<div class="container my-5">
  <div class="row mb-3">
    <div class="col-12 mb-3" data-aos="fade-up">
      <h4 class="text-primary mb-0">Médico <?= $user->getName(); ?></h4>
      <small class="text-muted"><?= $user->getDocument(); ?></small>
      <h5 class="mt-3">Métricas</h5>
      <div class="row">
        <div class="col-6">
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
    </div>
  </div>
  <div class="row mb-3 pb-3 g-3" data-aos="fade-up">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <h4 class="text-primary">Consultas registradas</h4>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#registerConsultModal">Nova Consulta</button>
    </div>
    <?php if($consults): ?>
      <?php foreach($consults as $consult): ?>
        <div class="col-6" data-aos="fade-up" data-aos-delay="100">
          <div class="card card-body shadow-sm rounded">
            <h5 class="text-dark">#<?=$consult->getId()?> - Paciente #<?= $consult->getUserId() ?></h5>
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

<!-- Modal -->
<div class="modal fade" id="registerConsultModal" tabindex="-1" aria-labelledby="registerConsultModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerConsultModalLabel">Registrar Consulta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/doctor/createConsult" method="post">
          <div class="row">
          <input type="hidden" name="doctorId" class="form-control" value="<?= $user->getId() ?>" required>

            <div class="col-6 mb-3">
              <label for="date" class="form-label">Data</label>
              <input type="date" name="date" class="form-control" required>
            </div>
            
            <div class="col-6 mb-3">
              <label for="patientId" class="form-label">Paciente</label>
              <select name="patientId" class="form-select" required>
                <?php foreach($patients as $patient): ?>
                <option value="<?=$patient->getId()?>"><?=$patient->getName();?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-12 mb-3">
              <label for="receipt" class="form-label">Receita</label>
              <textarea type="text" name="receipt" class="form-control" required></textarea>
            </div>

            <div class="col-12 mb-3">
              <label for="observation" class="form-label">Observação</label>
              <textarea type="text" name="observation" class="form-control"></textarea>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary col-12">Registrar</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
    