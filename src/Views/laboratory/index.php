<div class="container my-5">
  <div class="row mb-3" data-aos="fade-up">
    <div class="col-12 mb-3">
      <h4 class="text-primary mb-0">Laboratório <?= $user->getName(); ?></h4>
      <small class="text-muted mb-3"><?= $user->getDocument(); ?></small>
      <h6><?= count($exams) ?> exame(s) registados</h6>
    </div>
  </div>
  <div class="row mb-3 pb-3">
    <h4 class="text-primary" data-aos="fade-up>Registrar Exame</h4>
    <div class="card col-12 shadow-sm rounded p-4 bg-light mb-3" data-aos="fade-up" data-aos-delay="100">
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
            <textarea type="text" name="result" class="form-control" required>
            </textarea>
          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-primary col-12">Registrar</button>
          </div>

        </div>
      </form>
    </div>
  </div>
  <div class="row mb-3 pb-3 border-bottom">
    <h4 class="text-primary" data-aos="fade-up">Exames registrados</h4>
    <?php foreach($exams as $exam): ?>
      <div class="card col-12 shadow-sm rounded p-4 bg-light mb-3" data-aos="fade-up" data-aos-delay="100">
        <h5 class="text-dark">#<?=$exam->getId()?></h5>
        <p><i class="fa fa-calendar">&nbsp;</i> <?= $exam->getDate() ?></p>
        <p><i class="fa fa-user">&nbsp;</i> <?= $exam->getPatientName() ?></p>
        <p><i class="fa fa-file">&nbsp;</i> <?= $exam->getExamType() ?></p>
        <p><i class="fa fa-check">&nbsp;</i> <?= $exam->getResult() ?></p>
      </div>
    <?php endforeach ?>
  </div>
</div>
    