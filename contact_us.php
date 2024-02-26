<?php
session_start();
$title = 'Contact Us';
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Contact Us</h2>
        </div>
    </div>
    <?php
    include_once('includes/flash_messages.php');
    ?>
    <form class="well form-horizontal" action="" method="post"  id="contact_form">
        <fieldset id="contact">
            <div class="row">
                <div class="col-lg-3">
                    <label class="label_css" for="name">Full name*</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control-header margin-bottom" id="name" name="name" placeholder="Full Name" required>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <label class="label_css" for="email">Email*</label>
                </div>
                <div class="col-lg-9">
                    <input type="email" class="form-control-header margin-bottom" id="email" name="email" placeholder="Email" required>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <label class="label_css" for="message">Message*</label>
                </div>
                <div class="col-lg-9">
                    <textarea class="form-control-header margin-bottom heightArea" id="message" id="message" name="message" placeholder="Message" required rows="3"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3"><label class="label_css" for="Back"><a class="btn-info btn"  href="index.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label></div>
                <div class="col-lg-9">
                    <input type="hidden" name="customer_id" value="<?= $_GET['customer_id'] ?>">
                    <button type="submit" class="btn btn-success" >Send <span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>
