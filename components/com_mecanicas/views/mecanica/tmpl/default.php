<?php
defined('_JEXEC') or die;
?>

<div id="w-mecanica">
  <?php foreach($this->items as $item):?>
    <div class="mecanica-section">
      <?php echo $item->content; ?>
    </div>
  <?php endforeach; ?>
</div>
