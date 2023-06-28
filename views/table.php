<div class="table">
    <div class="actionSection">
        <?php if($content['showSearch']): ?>
            <div class="search">
                <h1>Search Form</h1>
                <?php echo sprintf('<form action="%s" method="get">', $tableSearch['currentURL']); ?>
                <span>Suchfeld</span>
                <input class="searchField" type="text" name="searchKeyword" placeholder="Meine Suche">
                <?=$tableSearch['hiddenInput']?>
                <input type="submit" value="Suchen">
                </form>

                <a class="btn green"
                   href="<?=$tableSearch['resetUrl']; ?>">
                    Suche beenden
                </a>
            </div>
        <?php endif; ?>
        <?php foreach ($content['menu'] as $key => $menu):?>
            <div class="createNew">
                <a class="btn <?=$menu['wrapperClass'];?>" href="<?=$menu['menuURL'];?>"><?=$menu['menuLabel'];?></a>
            </div>
        <?php endforeach;?>
    </div>

    <div class="table">
        <table style="border: 1px solid black;">
            <thead>
            <tr>
                <?php foreach($content['tableHead'] as $key => $label): ?>
                    <th>
                        <?= $label; ?>
                    </th>
                <?php endforeach; ?>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($content['tableContent']) === 0): ?>
                <td colspan="<?=count($content['tableHead']);?>">No Items Found</td>
            <?php else: ?>
                <?php foreach($content['tableContent'] as $row): ?>
                    <tr>
                        <?php foreach($content['tableHead'] as $key => $label):;?>
                        <td>
                            <?= $row[$key]?>
                            <?php endforeach; //var_dump($content);?>
                        </td>
                        <?php if (is_array($row['tableMenu'])): ?>
                            <td>
                                <?php foreach ($row['tableMenu'] as $key => $tableMenu): ?>
                                    <a class="btn <?=$tableMenu['wrapperClass'];?>" href="<?=$tableMenu['menuURL'].$row['id_'.$tableMenu['targetTable']];?>"><?=$tableMenu['menuLabel'];?></a>
                                <?php endforeach;?>
                            </td>
                        <?php endif;?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
