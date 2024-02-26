<?php require_once './config/config.php'; ?>

<fieldset>
    <div class="form-group">
        <label for="ornament_name">Ornament Name*</label>
          <input type="text" name="ornament_name" value="<?php echo htmlspecialchars($edit ? $ornaments['ornament_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ornament Name" class="form-control" required="required" id="ornament_name" >
    </div> 

    <div class="form-group">
        <label for="ornament_type">Ornament Sub Type*</label>
        <input type="text" name="ornament_sub_type" value="<?php echo htmlspecialchars($edit ? $ornaments['ornament_sub_type'] : '', ENT_QUOTES, 'UTF-8'); ?>"
               placeholder="Ornament Type" class="form-control" required="required" id="ornament_sub_type" ></div>
    <div class="form-group">
        <input type="hidden" name="ornament_id" value="<?= $_GET['ornament_id'] ?>">
        <label><a class="btn-info btn"  href="ornaments.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label>
        <button type="submit" class="btn btn-success" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>
