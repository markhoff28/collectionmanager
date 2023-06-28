<h2><?=$moduleName?> <?=$action?></h2>

<h2>Füge Zug mit der Nummer <?=$trainId?> Items hinzu</h2>
<form method="post">
    <div>
        <span>Locomotive</span>
        <select name="locomotive">
            <option value="empty">Keine Lokomotive</option>
            <?php foreach ($locomotives as $locomotive): ?>
                <?php if ($locomotive->id_locomotive == $formContent[0]->fk_segmentEntity && $formContent[0]->fk_segmentType == 1):?>
                    <option value="<?=$locomotive->id_locomotive?>" selected><?=$locomotive->name?></option>
                <?php else: ?>
                    <option value="<?=$locomotive->id_locomotive?>"><?=$locomotive->name?></option>
                <?php  endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <span>Wagon</span>
        <select name="wagon">
            <option value="empty">Kein Wagon</option>
            <?php foreach ($wagons as $wagon): ?>
                <?php if ($wagon->id_wagon == $formContent[0]->fk_segmentEntity && $formContent[0]->fk_segmentType == 2): ?>
                    <option value="<?=$wagon->id_wagon?>" selected><?=$wagon->name?></option>
                <?php else: ?>
                    <option value="<?=$wagon->id_wagon?>"><?=$wagon->name?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="inputBx">
        <input type="hidden" name="trainId" value="<?=$trainId?>">
        <input type="hidden" name="tableId" value="<?=$tableId?>">
        <input type="submit" name="submit" value="<?=$moduleName?> <?=$action?>">
    </div>
</form>
