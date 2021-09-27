<div class="container my-5">
  <div class="row mb-3">
    <div class="col-12 mb-3" data-aos="fade-up">
      <h4 class="text-primary mb-0">Médico <?= $user->getName(); ?></h4>
      <small class="text-muted mb-3"><?= $user->getDocument(); ?></small>
      <h6><?= count($consults) ?> consultas(s) registados</h6>
    </div>
  </div>
  <div class="row mb-3 pb-3">
    <h4 class="text-primary" data-aos="fade-up">Registrar Consulta</h4>
    <div class="card col-12 shadow-sm rounded p-4 bg-light mb-3" data-aos="fade-up" data-aos-delay="100">
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
            <textarea type="text" name="receipt" class="form-control" required>
            </textarea>
          </div>

          <div class="col-12 mb-3">
            <label for="observation" class="form-label">Observação</label>
            <textarea type="text" name="observation" class="form-control">
            </textarea>
          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-primary col-12">Registrar</button>
          </div>

        </div>
      </form>
    </div>
  </div>
  <div class="row mb-3 pb-3">
    <h4 class="text-primary" data-aos="fade-up">Consultas registradas</h4>
    <?php foreach($consults as $consult): ?>
      <div class="card col-12 shadow-sm rounded p-4 bg-light mb-3" data-aos="fade-up" data-aos-delay="100">
        <h5 class="text-dark">#<?=$consult->getId()?></h5>
        <p><i class="fa fa-calendar">&nbsp;</i> <?= $consult->getDate() ?></p>
        <p><i class="fa fa-user">&nbsp;</i> <?= $consult->getPatientName() ?></p>
        <p><i class="fa fa-file">&nbsp;</i> <?= $consult->getReceipt() ?></p>
        <p><i class="fa fa-check">&nbsp;</i> <?= $consult->getObservation() ?></p>
      </div>
    <?php endforeach ?>
  </div>
</div>
    