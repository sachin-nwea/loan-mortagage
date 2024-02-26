<fieldset>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-3 control-label"><?= __('User name')?>*</label>
        <div class="col-md-3 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  type="text" name="user_name" autocomplete="off" placeholder="<?= __('User name')?>" class="form-control" required="" value="<?php echo ($edit) ? $admin_account['user_name'] : ''; ?>" autocomplete="off" <?php echo ($edit) ? 'disabled' : ''; ?>>
            </div>
        </div>
        <label class="col-md-3 control-label"><?= __('Full name')?>*</label>
        <div class="col-md-3 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  type="text" name="full_name" autocomplete="off" placeholder="<?= __('Full name')?>" class="form-control" required="required" value="<?php echo ($edit) ? $admin_account['full_name'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?= __('Father Full name')?>*</label>
        <div class="col-md-3 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  type="text" name="father_name" maxlength="30" placeholder="<?= __('Father Full name')?>" class="form-control" required="required" value="<?php echo ($edit) ? $admin_account['father_name'] : ''; ?>" autocomplete="off">
            </div>
        </div>
        <label class="col-md-3 control-label"><?= __('Email')?>*</label>
        <div class="col-md-3 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-inbox"></i></span>
                <input  type="email" name="email" maxlength="80" placeholder="<?= __('Email')?>" class="form-control" required="required" value="<?php echo ($edit) ? $admin_account['email'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label"><?= __('Age')?></label>
        <div class="col-md-3 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-heart"></i></span>
                <input  type="text" name="age" maxlength="2" placeholder="<?= __('Age')?>" class="form-control" required="required" value="<?php echo ($edit) ? $admin_account['age'] : ''; ?>" autocomplete="off">
            </div>
        </div>
        <label class="col-md-3 control-label"><?= __('Resident Area')?></label>
        <div class="col-md-3 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                <input  type="text" name="area" placeholder="<?= __('Resident Area')?>" class="form-control" required="required" value="<?php echo ($edit) ? $admin_account['area'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?= __('User Type')?></label>
        <div class="col-md-3 inputGroupContainer">
            <label class="radio-inline">
                <input type="radio" class="radiobutton" name="admin_type" value="<?= __('admin')?>" required="" <?php echo (($edit && $admin_account['admin_type'] =='admin') || (!$edit)) ? "checked": ''; ?>/><?= __('Admin')?>
            </label>
            <label class="radio-inline">
                <input type="radio" class="radiobutton" name="admin_type" value="<?= __('super')?>" required="" <?php echo ($edit && $admin_account['admin_type'] =='super') ? "checked": "" ; ?>/><?= __('Super admin')?>
            </label>
        </div>
        <label class="col-md-3 control-label"><?= __('User Status')?></label>
        <div class="col-md-3 inputGroupContainer">
            <label class="radio-inline">
                <input type="radio" class="radiobutton" name="status" value="<?= __('Active')?>" required="" <?php echo (($edit && $admin_account['status'] =='Active') || (!$edit)) ? "checked": ''; ?>/><?= __('Active')?></label>
            <label class="radio-inline"><input type="radio" class="radiobutton" name="status" value="<?= __('Inactive')?>" required="" <?php echo ($edit && $admin_account['status'] =='Inactive') ? "checked": "" ; ?>/><?= __('Inactive')?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Bank Allowed</label>
        <div class="col-md-3 inputGroupContainer">
            <select id="banks" name="banks_allowed[]" class="form-control-header heightExtra" multiple="multiple">

                <?php
                $db = getDbInstance();
                $db->pageLimit = 100;
                $banks = $db->get('banks');
                $sel = "";
                $selectAll = '';
                if($admin_account['banks_allowed'] == 'all' || !$edit) {
                    $selectAll = "selected='selected'";
                }
                echo '<option value="all"'. $selectAll.'>All Banks</option>';
                foreach ($banks as $bank) {
                    $allowedBanks = explode("," , $admin_account['banks_allowed']);
                    if (in_array( $bank['id'], $allowedBanks)) {
                        $sel = "selected='selected'";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$bank['id'].'"' . $sel . '>' . $bank['bank_name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <label class="col-md-3 control-label">State Allowed</label>
        <div class="col-md-3 inputGroupContainer">
            <select id="states" name="state_allowed[]" class="form-control-header heightExtra" multiple="multiple">
                <?php
                include "./get_state_list.php";
                $sel = "";
                $selectAll = '';
                if($admin_account['state_allowed'] == 'all' || !$edit) {
                    $selectAll = "selected='selected'";
                }
                echo '<option value="all"'. $selectAll.'>All States</option>';
                foreach ($rows as $row) {
                    if (in_array($row['state_id'], explode(",", $admin_account['state_allowed']))) {
                        $sel = "selected='selected'";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$row['state_id'].'"' . $sel . '>' . $row['state_title'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <!-- Text input-->
    <?php if(!$edit) { ?>
        <div class="form-group">
            <label class="col-md-3 control-label"><?= __('Password')?></label>
            <div class="col-md-3 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" name="password" autocomplete="off" placeholder="<?= __('Password')?> " class="form-control" <?php echo (!$edit)? 'required=""':''; ?> autocomplete="off">
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Button -->
    <div class="form-group">
        <div class="col-md-3"><label for="Back"><a class="btn-info btn"  href="admin_users.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label></div>
        <div class="col-md-9">
        <?php if($edit) { ?>
            <input type="hidden" name="id" value="<?= $_GET['admin_user_id'] ?>">
        <?php } ?>
            <button type="submit" class="btn btn-success" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>