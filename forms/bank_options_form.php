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
                    $db = getDbInstance();
                    $banks = $db->get('banks');
                    foreach ($banks as $bank) {
                        $sel = $edit && $bank_options['bank_id'] == $bank['id']? "selected='selected'" : '';
                        echo '<option value="' . $bank['id'] . '" '. $sel.'>' . $bank['bank_name'] . '</option>';
                     }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="gold_rate">Bank Gold Rate*</label>
            <input type="number" class="form-control-header " name="gold_rate" value="<?php echo htmlspecialchars($edit ? $bank_options['gold_rate'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Gold Rate" required="required" id = "gold_rate" >
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="account_number">Account Number</label>
            <input type="text" class="form-control-header " name="account_number" maxlength="20" value="<?php echo htmlspecialchars($edit ? $bank_options['account_number'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Account Number" id = "account_number" >
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <label class="label_css">Carat Options </label>
        </div>
        <div class="col-lg-9">
            <input type="checkbox" name="24_carat" id="24_carat" value="24" class="margin-right" <?php echo (str_contains($bank_options['carats_options'], '24')) ? "checked='checked'": ""; ?>>
            <label class="carat_label" for="24_carat">24</label>
            <input type="checkbox" name="23_carat" id="23_carat" value="23" class="margin-right" <?php echo (str_contains($bank_options['carats_options'], '23')) ? "checked='checked'": ""; ?>>
            <label class="carat_label" for="23_carat">23</label>
            <input type="checkbox" name="22_carat" id="22_carat" value="22" class="margin-right" <?php echo (str_contains($bank_options['carats_options'], '22')) ? "checked='checked'": ""; ?>>
            <label class="carat_label" for="22_carat">22</label>
            <input type="checkbox" id="21_carat" name="21_carat" value="21" class="margin-right" <?php echo (str_contains($bank_options['carats_options'], '21')) ? "checked='checked'": ""; ?>>
            <label class="carat_label" for="21_carat">21</label>
            <input type="checkbox" id="20_carat" name="20_carat" value="20" class="margin-right" <?php echo (str_contains($bank_options['carats_options'], '20')) ? "checked='checked'": ""; ?>>
            <label class="carat_label" for="20_carat">20</label>
            <input type="checkbox" id="19_carat" name="19_carat" value="19" class="margin-right" <?php echo (str_contains($bank_options['carats_options'], '19')) ? "checked='checked'": ""; ?>>
            <label class="carat_label" for="19_carat">19</label>
            <input type="checkbox" id="18_carat" name="18_carat" value="18" class="margin-right" <?php echo (str_contains($bank_options['carats_options'], '18')) ? "checked='checked'": ""; ?>>
            <label class="carat_label" for="18_carat">18</label>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <label class="label_css">Loan Period Options </label>
        </div>
        <div class="col-lg-9">
            <input type="checkbox" name="12_months" id="12_months" value="12 months" class="margin-right" <?php echo (str_contains($bank_options['loan_options'], '12 months')) ? "checked='checked'": ""; ?>>
            <label class="loan_label" for="12_months">12 months</label>
            <input type="checkbox" id="9_months" name="9_months" value="9 months" class="margin-right"<?php echo (str_contains($bank_options['loan_options'], '9 months')) ? "checked='checked'": ""; ?>>
            <label class="loan_label" for="9_months">9 months</label>
            <input type="checkbox" name="6_months" id="6_months" value="6 months" class="margin-right" <?php echo (str_contains($bank_options['loan_options'], '6 months')) ? "checked='checked'": ""; ?>>
            <label class="loan_label" for="6_months">6 months</label>
            <input type="checkbox" id="3_months" name="3_months" value="3 months" class="margin-right" <?php echo (str_contains($bank_options['loan_options'], '3 months')) ? "checked='checked'": ""; ?>>
            <label class="loan_label" for="3_months">3 months</label>
            <input type="checkbox" id="3_years" name="3_years" value="3 years" class="margin-right" <?php echo (str_contains($bank_options['loan_options'], '3 years')) ? "checked='checked'": ""; ?>>
            <label class="loan_label" for="3_years">3 years</label>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <input type="hidden" name="banks_id" value="<?= $_GET['carat_id'] ?>">
            <label class="label_css" for="Back"><a class="btn-info btn"  href="bank_options.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label>

            <button type="submit" class="btn btn-success">Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>
