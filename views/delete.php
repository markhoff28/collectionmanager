<div class="deleteForm">
    <p>Möchten sie <?=$moduleName?> mit der ID: <?=$content?> wirklich löschen:
    <form action="<?= "/mvcSammlungsverwaltung/" . $moduleName . "/delete/" . $content; ?>" method="POST">
        <input type="submit" name="delete" value="Delete" class="btn red">
        <a href="<?= "/mvcSammlungsverwaltung/" . $moduleName; ?>" class="btn green">Zurück</a>
    </form>
</div>
