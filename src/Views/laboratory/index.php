<h1>Laboratório</h1>
<div class="container my-5">
    <h4 class="text-center">Registrar Exame</h4>

    <form class="shadow-sm card rounded p-4 bg-light m-auto" action="/laboratory/createExam" method="post">
        <input type="hidden" name="laboratoryId" class="form-control" value="<?= $user->getId() ?>" required>

        <div class="mb-3">
          <label for="" class="form-label">Data</label>
          <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="" class="form-label">Paciente</label>
          <select name="patientId" class="form-select" required>
            <?php foreach($patients as $patient): ?>
            <option value="<?=$patient->getId()?>"><?=$patient->getName();?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="" class="form-label">Tipo</label>
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

        <div class="mb-3">
          <label for="" class="form-label">Resultado</label>
          <input type="text" name="result" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Registrar</button>
        <a href="login" class="text-center">Não tem conta? Registre-se grátis agora</a>
    </form>
</div>

<div class="container my-5">
  <h4 class="text-center mt-5">Exames</h4>
  <table class="table border rounded shadow-sm m-auto bg-light">
    <thead>
      <tr>
        <th>#</th>
        <th>Data</th>
        <th>Paciente</th>
        <th>Tipo</th>
        <th>Resultado</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($exams as $exam): ?>
      <tr>
        <td><?= substr($exam->getId(), 0, 3).'...' ?></td>
        <td><?= $exam->getDate() ?></td>
        <td><?= $exam->getPatientName() ?></td>
        <td><?= $exam->getExamType() ?></td>
        <td><?= $exam->getResult() ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
    