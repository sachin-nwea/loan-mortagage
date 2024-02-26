<?php
require_once './config/config.php';
?>
<fieldset>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="bank_name">Bank Name*</label>
            <select id="banks" name="bank_id" class="form-control-header " required="required">
                <option value="">Select Bank</option>
                <?php
                include './get_allowed_bank_list.php';
                foreach ($banks as $bank) {
                    $sel = $edit && $branches['bank_id'] == $bank['id']? "selected='selected'" : '';
                    echo '<option value="' . $bank['id'] . '" '. $sel.'>' . $bank['bank_name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-lg-6">
             <label class="label_css" for="branch_name">Branch name*</label>
            <input type="text" name="branch_name" value="<?php echo htmlspecialchars($edit ? $branches['branch_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Branch Name" class="form-control-header " required="required" id="branch_name">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
             <label class="label_css">Branch Area*</label>
            <input type="text" name="branch_area" value="<?php echo htmlspecialchars($edit ? $branches['branch_area'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Branch Area" class="form-control-header " id="branch_area">
        </div>
        <div class="col-lg-6">
            <label class="label_css" for="branch_code">Branch Code </label>
            <input type="text" name="branch_code" value="<?php echo htmlspecialchars($edit ? $branches['branch_code'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Branch Code" class="form-control-header " id="branch_code">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="state">State*</label>
            <select name="state" class="form-control-header " required onchange="changeCity(this.value)" required="required">
                <option value="">Select State</option>
                <?php
                include './get_state_list.php';
                foreach ($rows as $row) {
                    $sel = $edit && $row['state_id'] == $branches['state'] ? "selected" : "";
                    echo '<option value="'.$row['state_id'].'"' . $sel . '>' . $row['state_title'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-lg-6">
             <label class="label_css" for="state">City*</label>
             <select name="city"
                id="city-list" class="form-control-header " required="required">
                <option value="">Select City</option>
            <?php
            if($edit) {
                $db = getDbInstance();
                $db->where('state_id', $branches['state']);
                $db->where('status', 'Active');
                $db->orderBy('name', 'asc');
                $cityResult = $db->get('city');
                foreach ($cityResult as $city) {
                    $sel = ($city['name'] == $branches['city']) ? "selected" : "";
                    echo '<option value="' . $city['name'] . '" ' .$sel .'>' . $city['name'] . '</option>';
                }
            }
            ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css verticalTop" for="address">Branch Address</label>
            <textarea name="address" placeholder="Address" class="form-control-header heightArea" id="address"><?php echo htmlspecialchars(($edit) ? $branches['address'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="col-lg-6">
            <label class="label_css" for="pin_code">Pin Code </label>
            <input type="text" name="pin_code" maxlength="6" value="<?php echo htmlspecialchars($edit ? $branches['pin_code'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Pin Code" class="form-control-header " id="pin_code">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
             <label class="label_css" for="officer_email">Officer Email</label>
            <input type="email" name="officer_email" maxlength="40" value="<?php echo $edit ? $branches['officer_email']: ''; ?>"  placeholder="Officer Email" class="form-control-header " id="officer_email">
        </div>
        <div class="col-lg-6">
            <label class="label_css" for="officer_email2">Officer Email 2</label>
            <input type="email" name="officer_email2" maxlength="40" value="<?php echo $edit ? $branches['officer_email2']: ''; ?>"  placeholder="Officer Email2" class="form-control-header " id="officer_email2">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="email">Bank Email</label>
            <input type="email" name="email" maxlength="40" value="<?php echo $edit? $branches['email'] : ''; ?>" placeholder="E-Mail Address" class="form-control-header " id="email" >
        </div>
        <div class="col-lg-6">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <input type="hidden" name="banks_id" value="<?= $_GET['bank_id'] ?>">
             <label class="label_css" for="Back"><a class="btn-info btn"  href="branches.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label>

            <button type="submit" class="btn btn-success" onsubmit="checkFileExtension();">Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
        <div class="col-lg-6">
        </div>
    </div>
</fieldset>