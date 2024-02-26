<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

include BASE_PATH . '/includes/search_header.php';

$bank = new OrderingValues();
$select = array('id', 'bank_name', 'logo', 'created_at', 'updated_at');

//Start building query according to input parameters.
// If search string
if ($search_string) {
    $db->where('bank_name', '%' . $search_string . '%', 'like');
}
//If order by option selected
if ($order_by) {
    $db->orderBy($filter_col, $order_by);
}

// Get result of the query.
$rows = $db->arraybuilder()->paginate('banks', $page, $select);
$total_pages = $db->totalPages;
$title = 'Banks';
include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-7">
            <h1 class="page-header">Banks</h1>
        </div>
        <div class="col-lg-3">
            <div id="export-section" class="page-action-links text-right">
                <a href="export_banks.php"><button class="btn btn-primary">Export to CSV <i class="glyphicon glyphicon-export"></i></button></a>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="page-action-links text-right">
                <a href="add_bank.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add New  Bank</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control">
                <?php
                foreach ($bank->setBankOrderingValues() as $opt_value => $opt_name):
                    ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                    echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                endforeach;
                ?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php if ($order_by == 'Asc') echo 'selected';?> >Asc</option>
                <option value="Desc" <?php if ($order_by == 'Desc') echo 'selected';?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th width="5%">ID</th>
            <th width="30%">Bank Name</th>
            <th width="30%">Bank Image</th>
            <th width="10%">Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php $i=1; foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo xss_clean($row['bank_name']); ?></td>
                <td><?php if ($row['logo']) echo '<img src="'.$row['logo'].'" width="50" height="50">'; ?></td>
                <td>
                    <a href="edit_bank.php?bank_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_bank.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this Bank?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
        <?php endforeach;?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
        <?php echo paginationLinks($page, $total_pages, 'banks.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
