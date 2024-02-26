<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
include BASE_PATH . '/includes/search_header.php';

$ornaments = new OrderingValues();

$select = array('id', 'ornament_name', 'ornament_sub_type', 'created_at', 'updated_at');

// If search string
if ($search_string) {
	$db->where('ornament_name', '%' . $search_string . '%', 'like');
	$db->orWhere('ornament_sub_type', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = 100;

// Get result of the query.
if($_SESSION['admin_type'] != 'super')
    $db->where('ornaments.created_by', $_SESSION['admin_user_id']);

$rows = $db->arraybuilder()->paginate('ornaments', $page, $select);
$total_pages = $db->totalPages;

$title = 'Ornaments';
include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-7">
            <h1 class="page-header">Ornaments</h1>
        </div>
        <div class="col-lg-3">
            <div id="export-section" class="page-action-links text-right">
                <a href="export_ornaments.php"><button class="btn btn-primary">Export to CSV <i class="glyphicon glyphicon-export"></i></button></a>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="page-action-links text-right">
                <a href="add_ornament.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add New  Ornament</a>
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
foreach ($ornaments->setOrnmentsOrderingValues() as $opt_value => $opt_name):
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
                <th width="5%">ID</th>
                <th width="30%">Ornament Name</th>
                <th width="20%">Ornament Sub Type</th>
                <th width="20%">Created On</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i= 1; foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo xss_clean($row['ornament_name']); ?></td>
                <td><?php echo xss_clean($row['ornament_sub_type']); ?></td>
                <td><?php echo xss_clean($row['created_at']); ?></td>
                 <td>
                    <a href="edit_ornaments.php?ornament_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_ornament.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this Ornament?</p>
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
    <?php echo paginationLinks($page, $total_pages, 'ornaments.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
