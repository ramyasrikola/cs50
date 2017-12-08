
<form action="sell.php" method ="post">
    <fieldset>
        <div class="form-group">
         <select class="form-control" name="symbol">
          <option disabled selected value="">Symbol</option>
          <?php foreach($lists as $list): ?>
             <option style="text-transform:uppercase" name="<?= $list ?>"><?= $list ?></option>
          <?php endforeach ?>
         </select>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">Sell</button>
        </div>
    </fieldset>
</form>