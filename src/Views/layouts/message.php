<div class="alert alert-<?= $error['color'] ?> alert-dismissable fade show d-flex justify-content-between align-items-center" role="alert"  data-aos="fade-left" data-aos-delay="100">
  <?= $error['value'] ?>
  <i type="button" class="fa fa-times" onclick="hideAlert()"></i>
</div>