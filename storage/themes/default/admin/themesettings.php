<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.themes') ?>"><?php ee('Themes') ?></a></li>
  </ol>
</nav>
<h1 class="h3 fw-bold mb-5"><?php ee('Theme Settings') ?></h1>
<div class="row">
    <?php foreach($settings as $setting): ?>
        <?php echo $setting ?>
    <?php endforeach ?>
</div>