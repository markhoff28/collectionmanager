<h1><?=$moduleName?> Details</h1>
<?php foreach ($detailAttribute as $key => $value): ?>
    <?php if ($value == 'Bezeichnung' || $value == 'Baureihe' || $value == 'Herstellernummer' || $value == 'Preis'): ?>
        <h1><?=$value?>: <?=$content[0]->$key?></h1>
    <?php continue; endif; ?>
    <p><?=$value?>: <?=$content[0]->$key?></p>
<?php endforeach;?>


<?php foreach ($widgetPlugins as $widgetPlugin): ?>
<?php $widgetPlugin->execute(); ?>
<?php endforeach; ?>
