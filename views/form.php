<h2><?=$moduleName?> <?=$action?></h2>

<?php //var_dump($formContent); ?>
<form method="post">
    <?php foreach ($formContent as $label => $formItem):?>
        <div>
            <?php if($label == 'ID') {
                continue;
            }?>
            <span><?=$label?></span>
            <?=$formItem['inputType']?>
            <?php if($formItem['error']):?>
                <span class="invalidFeedback"><?=$formItem['error']?></span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <div class="inputBx">
        <input type="submit" name="submit" value="<?=$moduleName?> <?=$action?>">
    </div>
</form>
