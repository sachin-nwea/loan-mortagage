<?php
require_once './config/config.php';
?>
<fieldset>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="f_name">First Name*</label>
            <input type="text" class="form-control-header " maxlength="30" name="f_name" value="<?php echo htmlspecialchars($edit ? $customer['f_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="First Name" required="required" id = "f_name" >
        </div>
        <div class="col-lg-6">
            <label class="label_css" for="l_name">Last name*</label>
            <input type="text" class="form-control-header " maxlength="30" required="required" id="l_name" name="l_name" value="<?php echo htmlspecialchars($edit ? $customer['l_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Last Name">
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
                    if ($edit && $row['state_id'] == $customer['state']) {
                        $sel = "selected";
                    } else if($row['state_title'] == 'Maharashtra') {
                        $sel = "selected='selected'";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$row['state_id'].'"' . $sel . '>' . $row['state_title'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="col-lg-6">
            <label class="label_css" for="city">City*</label>
            <select name="city" id="city-list" class="form-control-header " required="required">
                <option value="">Select City</option>
                <?php
                if($edit) {
                    $db = getDbInstance();
                    $db->where('state_id', $customer['state']);
                    $db->where('status', 'Active');
                    $db->orderBy('name', 'asc');
                    $cityResult = $db->get('city');
                    foreach ($cityResult as $city) {
                        $sel = ($city['name'] == $customer['city']) ? "selected" : "";
                        echo '<option value="' . $city['name'] . '" ' .$sel .'>' . $city['name'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="phone">Mobile*</label>
            <input name="phone" class="form-control-header " autocomplete="off" maxlength="12" value="<?php echo htmlspecialchars($edit ? $customer['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="9876543210"  maxlength="10"type="text" id="phone" required="required">
        </div>
        <div class="col-lg-6">
            <label class="label_css" for="phone2">Mobile 2</label>
            <input name="phone2" class="form-control-header " autocomplete="off" maxlength="12" value="<?php echo htmlspecialchars($edit ? $customer['phone2'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="9876543210"   type="text" id="phone2" >
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="pan_number">PAN Number*</label>
            <input name="pan_number" class="form-control-header " maxlength="10" required="required" autocomplete="off" value="<?php echo htmlspecialchars($edit ? $customer['pan_number'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Pan Number"  maxlength="10" type="text" id="pan_number">
        </div>
        <div class="col-lg-6">
            <label class="label_css" for="aadhaar_number">Aadhaar Number </label>
            <input name="aadhaar_number" class="form-control-header " maxlength="14" autocomplete="off" value="<?php echo htmlspecialchars($edit ? $customer['aadhaar_number'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Aadhaar Number"  maxlength="12" type="text" id="aadhaar_number">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="l_name">Father/Spouse name</label>
            <input type="text" class="form-control-header " maxlength="40" id="father_name" name="father_name" value="<?php echo htmlspecialchars($edit ? $customer['father_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Father/Spouse Name">
        </div>
        <div class="col-lg-6">
            <label class="label_css" for="email">Email</label>
            <input type="email" name="email" autocomplete="off" value="<?php echo htmlspecialchars($edit ? $customer['email'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="E-Mail Address" class="form-control-header " id="email" >
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css verticalTop" for="address">Customer Address</label>
            <textarea name="address" placeholder="Address" autocomplete="off" class="form-control-header heightArea" id="address"><?php echo htmlspecialchars(($edit) ? $customer['address'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <label class="label_css" for="Back"><a class="btn-info btn"  href="customers.php"> <span class="glyphicon glyphicon-backward">  </span><?= __('Back to Listing') ?></a></label></div>
        <div class="col-lg-9">
            <input type="hidden" name="customer_id" value="<?= $_GET['customer_id'] ?>">
            <button type="submit" class="btn btn-success" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
    <script>
        <?php if (!$edit) { ?>
            changeCity(21);
        <?php } ?>

    </script>
</fieldset>
