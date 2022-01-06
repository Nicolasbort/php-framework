<div class="container my-5">
  <div class="row mb-3" data-aos="fade-up">
    <div class="col-12 mb-3">
      <h4 class="text-primary mb-0">Laboratório <?= $user->getName(); ?></h4>
      <small class="text-muted mb-3"><?= $user->getDocument(); ?></small>
      <div class="row">
        <div class="col-6">
          <h6 class="mt-3">Consultas por mês</h6>
          <table class="table">
              <tr>
                <th>Mês</th>
                <th>Consultas</th>
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
          <h6 class="mt-3">Consultas por ano</h6>
          <table class="table">
              <tr>
                <th>Ano</th>
                <th>Consultas</th>
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
  <div class="row mb-3 pb-3 border-bottom" data-aos="fade-up">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <h4 class="text-primary">Exames registradas</h4>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#registerExamModal">Novo Exame</button>
    </div>
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
</div>

<!-- Modal -->
<div class="modal fade" id="registerExamModal" tabindex="-1" aria-labelledby="registerExamModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerExamModalLabel">Registrar Exame</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/laboratory/createExam" method="post">
          <div class="row">

            <input type="hidden" name="laboratoryId" class="form-control" value="<?= $user->getId() ?>" required>

            <div class="col-4 mb-3">
              <label for="date" class="form-label">Data</label>
              <input type="date" name="date" class="form-control" required>
            </div>
            
            <div class="col-4 mb-3">
              <label for="patientId" class="form-label">Paciente</label>
              <select name="patientId" class="form-select" required>
                <?php foreach($patients as $patient): ?>
                <option value="<?=$patient->getId()?>"><?=$patient->getName();?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-4 mb-3">
              <label for="examType" class="form-label">Tipo</label>
              <select name="examType" class="form-select" required>
                <option>Hemograma</option>
                <option>Colesterol</option>
                <option>Ureia e Creatinina</option>
                <option>Papanicolau</option>
                <option>Exames de urina</option>
                <option>Exames de fezes</option>
                <option>Glicemia</option>
                <option>Transaminases</option>
              </select>
            </div>

            <div class="col-12 mb-3">
              <label for="result" class="form-label">Resultado</label>
              <textarea type="text" name="result" class="form-control" required></textarea>
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
    