<?php
require_once './config/config.php';
?>
<fieldset>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css" for="bank_name">Bank Name*</label>
            <input type="text" class="form-control-header " name="bank_name" value="<?php echo htmlspecialchars($edit ? $banks['bank_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Bank Name" required="required" id="bank_name" >
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label class="label_css">Upload Bank Logo</label>
            <input style="display:inline" type="file" name="logo" onchange="checkExtension(this.value);" id="logo" placeholder="Add Logo" class="form-control-header "/>
            <input type="hidden" name="existing_logo" id="existing_logo" value="<?php echo htmlspecialchars($edit ? $banks['logo'] : '', ENT_QUOTES, 'UTF-8'); ?>" />
        </div>
    </div>
    <div class="row">
            <?php
            if(!empty($banks['logo'])) {
                echo '<div class="col-lg-3"><label>Uploaded Logo</label></div>';
                echo '<div class="col-lg-6 updateLogo" id="updateLogo"><img src="' . $banks['logo'] . '" height="100" width="100" /></div>';
            }
            ?>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <input type="hidden" name="banks_id" value="<?= $_GET['bank_id'] ?>">
            <label class="label_css" for="Back"><a class="btn-info btn"  href="banks.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label>
        </div>
        <div class="col-lg-9">

            <button type="submit" class="btn btn-success">Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>
<script type="text/javascript">

    function checkExtension () {
        var extension = $("#logo").val().split('.').pop().toLowerCase();

        let validExtensions= ['jpg', 'png', 'jpeg', 'gif'];
        if(extension != '' && !validExtensions.includes(extension)) {
            return false;
        }
        return true;
    }
    function checkFileExtension() {
        if(checkExtension()) {
            var existingLogo = $("#existing_logo").val();
            var extension = $("#logo").val();
            if (existingLogo == '' && extension == '') {
                alert('Please upload bank Logo');
                return false;
            }
            document.getElementById("bank_form").submit();
            return true;
        } else {
            return false;
        }
    }
</script>
