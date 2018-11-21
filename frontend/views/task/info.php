<?php
?>

<h2><?= $message ?></h2>
<div>
  <?php foreach ($data as $name => $value): ?>
    <p><?= $name ?>: <?= $value ?></p>
  <?php endforeach; ?>
</div>
