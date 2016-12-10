<link rel="alternate" hreflang="x-default" href="<?= $home ?>"/>
<?php foreach ($langs as $key => $value): ?>
    <link rel="alternate" hreflang="<?= $key ?>" href="<?= $value ?>"/>
<?php endforeach; ?>
