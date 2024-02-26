<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
include BASE_PATH . '/includes/search_header.php';

$mortgages = new OrderingValues();
$select = array('customer_mortgages.id', 'customer_mortgages.mortgage_id', 'customers.f_name','customers.l_name', 'banks.bank_name', 'customer_mortgages.branch_name', 'customers.email', 'customers.pan_number', 'customers.phone', 'customers.phone2', 'customer_mortgages.created_by');

// If search string
if ($search_string) {
	$db->where('banks.bank_name', '%' . $search_string . '%', 'like');
	$db->orWhere('customer_mortgages.branch_name', '%' . $search_string . '%', 'like');
    $db->orWhere('customers.f_name', '%' . $search_string . '%', 'like');
    $db->orWhere('customers.l_name', '%' . $search_string . '%', 'like');
    $db->orWhere('customers.email', '%' . $search_string . '%', 'like');
    $db->orWhere('customers.pan_number', '%' . $search_string . '%', 'like');
    $db->orWhere('customers.phone', '%' . $search_string . '%', 'like');
    $db->orWhere('customers.phone2', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

//Only Super Admin allows to see all records.
if($_SESSION['admin_type'] != 'super')
    $db->where('customer_mortgages.created_by', $_SESSION['admin_user_id']);
$db->join('customers', 'customers.id=customer_mortgages.customer_id' , 'LEFT');
$db->join('banks', 'customer_mortgages.bank_id = banks.id', 'LEFT');
// Get result of the query.
$rows = $db->arraybuilder()->paginate('customer_mortgages', $page, $select);
$total_pages = $db->totalPages;

$title = 'Mortgages';
include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1>Mortgages</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_mortgage.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add New Mortgage</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control">
                <?php
                    foreach ($mortgages->setMortgagesOrderingValues() as $opt_value => $opt_name):
                        ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                        ($filter_col === $opt_value) ? $selected = 'selected' : $selected = '';
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
                <th width="5%">Sr. No</th>
                <th width="20%">Customer Name</th>
                <th width="15%">Customer Email</th>
                <th width="15%">Bank Name</th>
                <th width="15%">Branch Name</th>
                <th width="26%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo xss_clean($row['f_name']. ' ' .$row['l_name']); ?></td>
                <td><?php echo xss_clean($row['email']); ?></td>
                <td><?php echo xss_clean($row['bank_name']); ?></td>
                <td><?php echo xss_clean($row['branch_name']); ?></td>
                <td>
                    <a href="edit_mortgage.php?mortgage_id=<?php echo $row['mortgage_id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit" title="Edit Record"></i></a>
                    <a href="add_image_mortgage.php?mortgage_id=<?php echo $row['mortgage_id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-upload" title="Upload Image"></i></a>
                    <a href="print_mortgage.php?mortgage_id=<?php echo $row['mortgage_id']; ?>&formatType=L" target="_blank" class="btn btn-primary"><i class="glyphicon glyphicon-print" title="Print Landscape Mortgage"></i></a>
                    <a href="print_mortgage.php?mortgage_id=<?php echo $row['mortgage_id']; ?>&formatType=P" target="_blank" class="btn btn-primary"><i class="glyphicon glyphicon-print" title="Print Portrait Mortgage"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="glyphicon glyphicon-trash" title="Delete"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['mortgage_id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_mortgage.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['mortgage_id']; ?>">
                                <p>Are you sure you want to delete this Mortgage?</p>
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
    <?php echo paginationLinks($page, $total_pages, 'mortgages.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
