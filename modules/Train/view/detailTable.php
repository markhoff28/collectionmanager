<div class="actionSection">
    <div class="search">
        <?php echo sprintf('<form action="%s" method="get">', $tableSearch['currentURL']); ?>
            <span>Suchfeld</span>
            <input class="searchField" type="text" name="searchKeyword" placeholder="Meine Suche">
            <?=$tableSearch['hiddenInput']?>
            <input type="submit" value="Suchen">
        </form>

        <a class="btn green"
           href="<?= "/mvcSammlungsverwaltung/". $moduleName; ?>">
        Suche beenden
        </a>
    </div>
    <?php if (in_array('addSegmentAction', $tableAction)): ?>
        <div class="createNew">
            <a class="btn green"
               href="<?= "/mvcSammlungsverwaltung/". $moduleName . "/addSegment/" . $trainId; ?>">
                Füge Segment hinzu
            </a>
        </div>
    <?php endif;?>
</div>

<table>
    <thead>
    <?php foreach ($tableColumnData as $key => $tableColumnName): ?>
        <th><?=$tableColumnName; ?></th>
    <?php endforeach; ?>
        <th>Action</th>
    </thead>
    <tbody>
    <?php foreach ($content as $tableRow):  ?>
    <tr>
        <?php foreach ($tableColumnData as $databaseKey => $label): ?>
        <td><?=$tableRow->$databaseKey; ?></td>
        <?php endforeach;
        $tableIdName = 'id_' . $tableName;
        ?>
        <td>
            <?php if (in_array('linkToSegmentAction', $tableAction)): ?>
            <?php switch ($tableRow->type):
                case 'lokomotive':?>
                    <a  class="btn blue"
                        href="<?= "/mvcSammlungsverwaltung/Locomotive/detail/" . $tableRow->id_locomotive?>">
                    Details
                    </a>
                <?php break;
                case 'wagon':?>
                    <a  class="btn blue"
                        href="<?= "/mvcSammlungsverwaltung/Wagon/detail/" . $tableRow->id_wagon?>">
                        Details
                    </a>
            <?php
                    break;
                    default:
                endswitch;
            endif;
            if (in_array('updateSegmentAction', $tableAction)):?>
                <a class="btn orange"
                    href="<?= "/mvcSammlungsverwaltung/" . $moduleName . "/updateSegment/" . $tableRow->id_trainSegment;?>">
                Update
                </a>
            <?php endif;
            if (in_array('deleteSegmentAction', $tableAction)): ?>
                <a class="btn red"
                    href="<?= "/mvcSammlungsverwaltung/" . $moduleName . "/deleteSegment/" . $tableRow->id_trainSegment;?>">
                 Delete
                </a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
