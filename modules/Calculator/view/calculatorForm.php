<form method="post">
    <input type="number" name="number1" value="<?=$numbers[0] ?? '';?>"/>
    <select name="operator">
        <?php foreach($operators as $operator): ?>
            <?php if ($operatorKey == $operator['key']): ?>
                <option value="<?=$operator['key'] ?>" selected><?=$operator['label']; ?></option>
            <?php else: ?>
                <option value="<?=$operator['key'] ?>"><?=$operator['label']; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <input type="number" name="number2" value="<?=$numbers[1] ?? '';?>"/>
    <input type="submit" name="calculate" value="=">
    <p>
        <b>Result:</b><?=$content;?>
    </p>
</form>
