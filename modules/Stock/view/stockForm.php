<h1>Menge auf Lager</h1>
<form method="post">

    <div class="inputBx">
        <input type="number" step="1" value="<?=$stock?>" name="stock">
        <input type="hidden" value="<?=$formkey?>" name="formKey">
    </div>
    <div class="inputBx">
        <input type="submit" name="submit" value="<?=$moduleName?> auf Lager">
    </div>
</form>

<h1>Menge in Benutzung</h1>
<p><?=$reserved?></p>
