<?php
// Per page limit for pagination.
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$db = getDbInstance();
$db->pageLimit = 20;
// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
$page = 1;
}
// If filter types are not selected we show latest added data first
if (!$filter_col) {
$filter_col = 'id';
}
if (!$order_by) {
$order_by = 'asc';
}
