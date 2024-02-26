<?php
require_once './config/config.php';
include './get_allowed_bank_list.php';
?>
<fieldset>
    <div class="row">
            <div class="col-lg-4">
            <input type="hidden" name="mortgage_main_id" value="<?= $_GET['mortgage_id']?>" >
            <label class="label_css" for="state"><?= __('Customer State')?>*</label>
            <select name="state_id" class="form-control-header " required onchange="changeCity(this.value)" required="required">
                <option value="">Select State</option>
                <?php
                include_once './get_state_list.php';
                $sel = "";
                foreach ($rows as $state) {
                    if ($edit && $state['state_id'] == $mortgages['state_id']) {
                        $sel = "selected='selected'";
                    } else if($state['state_title'] == 'Maharashtra') {
                        $sel = "selected='selected'";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$state['state_id'].'"' . $sel . '>' . $state['state_title'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label class="label_css" for="state">Customer City*</label>
            <select name="city" id="city-list" class="form-control-header " required="required" onchange="fetchList(this.value)">
                <option value="">Select City</option>
            <?php
                if($edit) {
                    $db = getDbInstance();
                    $db->where('state_id', $mortgages['state_id']);
                    $db->where('status', 'Active');
                    $db->orderBy('name', 'asc');
                    $cityResult = $db->get('city');
                    foreach ($cityResult as $city) {
                        $sel = ($city['name'] == $mortgages['city']) ? "selected='selected'" : "";
                        echo '<option value="' . $city['name'] . '" ' .$sel .'>' . $city['name'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label class="label_css" for="banks_name"> Bank Name*</label>
            <select id="banks" name="bank_id" class="form-control-header " required="required" onchange="fetchBranchList(this.value);">
                <option value="">Select Bank</option>
                <?php
                if ($edit) {
                    include './get_allowed_bank_list.php';
                    if (isset($banks) && isset($banks[0]['bank_name'])) {
                        echo '<option value="' . $banks[0]['id'] . '" selected="selected">' . $banks[0]['bank_name'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        <label class="label_css" for="customer_name"> Customer Name*</label>
        <select id="customers" name="customer_id" class="form-control-header " required="required">
            <option value="">Select Customer</option>
            <?php
            if ($edit) {
                $db->pageLimit = 100;
                $db->where('id', $mortgages['customer_id']);
                if($_SESSION['admin_type'] != 'super')
                    $db->where('customers.created_by', $_SESSION['admin_user_id']);
                $customer = $db->get('customers');
                if (isset($customer)) {
                    $customer_name = $customer[0]['f_name'] . ' ' . $customer[0]['l_name'];
                    echo '<option value="' . $customer[0]['id'] . '" selected="selected" >' . $customer_name . '</option>';
                }
            }
            ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label class="label_css" for="branches"> Branch Name*</label>
            <select id="branches" name="branch_name" class="form-control-header " required="required">
                <option value="">Select Branch</option>
                <?php
                if ($edit) {
                    $db->pageLimit = 100;
                    if($_SESSION['admin_type'] != 'super')
                        $db->where('branches.created_by', $_SESSION['admin_user_id']);
                    $db->where('branch_name', $mortgages['branch_name']);

                    $branches = $db->get('branches');
                    if(isset($branches) && isset($branches[0]['branch_name'])) {
                        $branch = $branches[0]['branch_name'];
                        echo '<option value="'.$branch. '" selected="selected">' . $branch. '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label class="label_css" for="interest_payment_type"> Loan Period*</label>
            <select name="interest_payment_type" class="form-control-header " required="required" id="interest_payment_type">
                <?php
                $interestListsOptions = "<option value=''>Select Interest Month</option>";
                if($edit) {
                    $db->pageLimit = 10;
                    $db->where('bank_id', $mortgages['bank_id']);
                    $interestLists = $db->get('bank_list');

                    foreach ( $interestLists as $interestList) {
                        $options = explode('-', $interestList['loan_options']);
                        foreach($options as $option) {
                            if($option != '') {
                                $sel = ($option == $mortgages['interest_payment_type'] )? "selected='selected'" : '';
                                $interestListsOptions .= '<option value="' . $option . '" '. $sel. '>' . $option . '</option>';
                            }
                        }
                    }
                }
                echo $interestListsOptions;
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label class="label_css" for="interest_payment_type"> Loan Requested amt</label>
            <input class="form-control-header " type="text" id="loan_requested" name="loan_requested" maxlength="8" value="<?= $mortgages['loan_requested']?>">
        </div>
        <div class="col-lg-4">
            <label class="label_css" for="interest_payment_type"> Loan Approved amt</label>
            <input class="form-control-header " type="text" id="loan_approved" name="loan_approved" maxlength="8" value="<?= $mortgages['loan_approved']?>">
        </div>
        <div class="col-lg-4">
            <label class="label_css" for="bag_pouch"> Bag/Pouch </label>
            <select class="form-control-bag form-bag-select" name="number" id="number">
                <option value="IBLM" <?php echo ($mortgages['number'] == 'IBLM')? "'selected'='selected'": '';?>>IBLM</option>
                <option value="IBLS" <?php ($mortgages['number'] == 'IBLS')? "'selected'='selected'": ""; ?> >IBLS</option>
            </select>
            <input class="form-control-bag form-bag-input" type="text" id="bag_pouch" name="bag_pouch" value="<?= $mortgages['bag_pouch']?>">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label class="test_css" for="test_conducted"> Test Completed </label>
            <input type="checkbox" name="acid_test" id="acid_test" value="Yes" <?php echo ($mortgages['acid_test'] == 'Yes') ? "checked='checked'": ""; ?>>
                <label class="test_css" for="acid_test">Acid Test</label>
            <input type="checkbox" id="sound_test" name="sound_test" value="Yes" <?php echo ($mortgages['sound_test'] == 'Yes') ? 'checked="checked"': ''; ?>>
                <label class="test_css" for="sound_test">Sound Test</label>
            <input type="checkbox" id="touch_sound_test" name="touch_sound_test" value="Yes" <?php echo ($mortgages['touch_sound_test'] == 'Yes') ? 'checked="checked"': ''; ?>>
            <label class="test_css" for="touch_stone_test">Touch Sound Test</label>
        </div>
    </div>
    <div class="form-group">
        <table id="mortgage_table">
            <thead class="border thead-center">
                <th class="border table-padding" style="width:5%">Sr No.</th>
                <th class="border table-padding" style="width:12%">Description Of Gold Ornaments</th>
                <th class="border table-padding" style="width:4%">Hallmark</th>
                <th class="border table-padding" style="width:9%">No Of Units</th>
                <th class="border table-padding" style="width:9%">Gross Weight in Grams</th>
                <th class="border table-padding" style="width:9%">Net Weight (Gross Weight less Stone, dust, etc.) in Grams</th>
                <th class="border table-padding" style="width:9%">Purity in Carat</th>
                <th class="border table-padding" style="width:9%">Equivalent Weight of 22-Carat gold(Grams)</th>
                <th class="border table-padding" style="width:9%">Rate Per Gram For 22 Carat</th>
                <th class="border table-padding" style="width:9%">Value Of Gold Ornaments</th>
                <th class="border table-padding" style="width:10%">Actions</th>
            </thead>
            <tbody id="tbody">
                <?php
                $row = 0;
                foreach ($mortgages['mortgages_data'] as $mortgage) {
                ?>
                <tr id="row_<?= $row ?>">
                    <td class="border table-padding" ><?= $row+1 ?></td>
                    <td class="border">
                        <?php
                        $db = getDbInstance();
                        // Set pagination limit
                        $db->pageLimit = 50;
                        if($_SESSION['admin_type'] != 'super')
                            $db->where('ornaments.created_by', $_SESSION['admin_user_id']);
                        $ornaments = $db->get('ornaments');
                        $ornaments_rows = '';
                        ?>
                            <select class="form-control-ornaments " name="ornament_name[]" id="ornament_name_<?= $row ?>" onchange="addRequiredAll('<?= $row ?>');">
                                <option value="">Select Ornament</option>
                                <?php
                                foreach ($ornaments as $ornament) {
                                    $ornamentName = $ornament['ornament_sub_type'].' '.$ornament['ornament_name'];
                                    $sel = ($edit && $ornamentName == $mortgage['ornament_name'])? "selected='selected'" : '';
                                    $ornaments_rows .= "<option value='".$ornamentName."'". $sel.">" . $ornamentName . "</option>";
                                }
                                echo $ornaments_rows;
                                ?>
                            </select>
                    </td>
                    <td class="border" id="hallmark_<?= $row ?>">
                        <select class="hall_picker" name="hallmark[]" id="hallmark_<?= $row ?>">
                            <?php
                            $no = "selected='selected'";
                            if ($edit) {
                                $yes = ($mortgage['hallmark'] == 'Yes')? "selected='selected'" : '';
                                $no = ($yes == '') ? "selected='selected'" : '';
                            } ?>

                            <option value="Yes" <?= $yes ?>>Yes</option>
                            <option value="No" <?= $no ?>>No</option>
                        </select>
                    </td>
                    <td class="border" id="no_of_unit_<?= $row ?>">
                        <input class="form-control-rows total_no_of_unit" type="number" id="row_no_of_units_<?= $row ?>" name="no_of_units[]" value="<?= $mortgage['no_of_units']?>" onchange="updateNoOfCount();" >
                        </td>
                    <td class="border" id="weight_<?= $row ?>">
                        <input class="form-control-rows total_weight" type="text" id="row_weight_<?= $row ?>" name="weight[]"
                               value="<?= $mortgage['weight']?>" onchange="updateTotalWeight();">
                        </td>
                    <td class="border" id="net_weight_<?= $row ?>">
                        <input class="form-control-rows total_net_weight" type="text" id="row_net_weight_<?= $row ?>" name="net_weight[]"
                               value="<?= $mortgage['net_weight']?>" onchange="updateEquiWeight(this.value, <?= $row ?>);">
                    </td>
                    <td class="border" id="carat_purity_<?= $row ?>">
                        <select id="row_carat_purity_<?= $row ?>" name="carat_purity[]" class="form-control-rows carat_purity" required="required" onchange="updateWeight(this.value, <?= $row ?>)">
                            <option value="">Carat Value</option>

                            <?php
                            if($edit) {
                                $db->pageLimit = 5;
                                $db->where('bank_id', $mortgages['bank_id']);
                                $caratLists = $db->get('bank_list');
                                $caratOptions = '';
                                foreach ( $caratLists as $caratList) {
                                    $carats = explode('-', $caratList['carats_options']);
                                    foreach ($carats as $carat) {
                                        if ($carat != '') {
                                            $sel = ($mortgage['carat_purity'] == $carat)? "selected='selected'" : '';
                                            $caratOptions .= '<option value="' . $carat . '" '. $sel.'>' . $carat . '</option>';
                                        }
                                    }
                                }
                                echo $caratOptions;
                            }
                            ?>
                        </select>
                    </td>
                    <td class="border" id="equivalent_weight_<?= $row ?>">
                        <input class="form-control-rows total_equivalent_weight"  readonly='readonly' id="row_equivalent_weight_<?= $row ?>"
                               name="equivalent_weight[]" value="<?= $mortgage['equivalent_weight'] ?>" onchange="updateFinal(this.value, <?= $row ?>)">
                    </td>
                    <td class="border" id="rate_per_gram_<?= $row ?>">
                        <input type="text" readonly="readonly" class="form-control-rows rate_per_gram" id="row_rate_per_gram_<?= $row ?>"
                               name="rate_per_gram[]" value="<?= $mortgage['rate_per_gram']?>" >
                    </td>
                    <td class="border finalvalue" id="final_value_<?= $row ?>">
                        <input type="text" readonly="readonly" class="form-control-rows price" id="row_final_value_<?= $row ?>"
                               name="final_value[]" value="<?= $mortgage['final_value'] ?>">
                    </td>
                    <td class="border">
                        <?php if ($edit) { ?>
                        <input type='button' class="delete_button btn btn-danger" id="row_delete_button_<?= $row ?>" value="Delete" onclick="delete_row('<?= $row ?>');" >
                        <?php } ?>
                    </td>
                </tr>
            <?php
            $row++;
                }
            ?>
            <tfoot>
                <td class="border" colspan="2"><div class="totalRow">Total</div></td>
                <td class="border""></td>
                <td class="border"><input type="text" class="form-control-rows" readonly="readonly" name="total_no_of_units" id="total_no_of_units" value="<?= $mortgages['total_no_of_units'] ?>"></td>
                <td class="border"><input type="text" class="form-control-rows" readonly="readonly" name="total_weight" id="total_weight" value="<?php echo ($mortgages['total_weight'])?: 0.00 ?>"></td>
                <td class="border"><input type="text" class="form-control-rows" readonly="readonly" name="total_net_weight" id="total_net_weight" value="<?php echo ($mortgages['total_net_weight'])?: 0.00 ?>"></td>
                <td class="border"></td>
                <td class="border"><input type="text" class="form-control-rows" readonly="readonly" name="total_equivalent_weight" id="total_equivalent_weight" value="<?php echo ($mortgages['total_equivalent_weight'])?: 0 ?>"></td>
                <td class="border"></td>
                <td class="border color-style">
                    <input type="text" id="total_amount" class="form-control-rows color-style" name="total_amount" value="<?php echo ($mortgages['total_amount'])?: 0 ?>" readonly="readonly">
                </td>
                <td class="border""></td>
            </tfoot>
        </table>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label for="Back"><a class="btn-info btn"  href="mortgages.php" ><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label>
            <button type="submit" class="btn btn-success" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
        <div class="col-lg-6 text-right">
            <input class="insert_button .btn btn-warning" type="button" value="Insert Row" onclick="add_row();" />
        </div>
    </div>
    <div class="form-group ">

    </div>            
</fieldset>
<script type="text/javascript">

    $(document).ready(function () {
        updateAllTotals();
        <?php if (!$edit) { ?>
            updateInitialTotal();
            updateCaratList($('#banks').val());
        <?php } ?>
    });

    function updateInitialTotal() {

        $(".finalvalue").each(function () {
            if (isNaN(this.value)) {
                $("#row_"+this.id).val('0.00');
            }
        });
    }
    function delete_row(no) {
        document.getElementById("row_"+no+"").outerHTML="";
        updateAllTotals();
    }

    function add_row() {
        var table=document.getElementById("tbody");
        var row_number=(table.rows.length);
        var number=(table.rows.length)+1;
        var table_len=(table.rows.length);
        var row = table.insertRow(row_number).outerHTML="<tr class='border' id='row_"+table_len+"' width='100%'>" +
            "<td class='border table-padding'>"+number+"</td>" +
            "<td class='border' id='row_ornament_name_"+table_len+"'>" +
            "<select class='form-control-ornaments ' name='ornament_name[]' onchange='addRequiredAll("+table_len+");'>" +
            "<option value=''>Select Ornament</option>" +
            "<?php
                $db = getDbInstance();
                // Set pagination limit
                $db->pageLimit = 50;
                if($_SESSION['admin_type'] != 'super')
                    $db->where('ornaments.created_by', $_SESSION['admin_user_id']);
                $ornaments = $db->get('ornaments');
                $ornaments_rows = '';
                foreach ($ornaments as $ornament) {
                    $ornaments_rows .= "<option value='".$ornament['ornament_sub_type'].' '. $ornament['ornament_name']."'>" . $ornament['ornament_sub_type']. ' '. $ornament['ornament_name'] . "</option>";
                }
                echo $ornaments_rows;
            ?></select></td>" +
            "<td class='border' ><select class='hall_picker' name='hallmark[]' id='hallmark_"+table_len+"'>"+
                "<option value='Yes' >Yes</option><option value='No' selected='selected'>No</option></select>" +
            "<td class='border'><input class='form-control-rows total_no_of_unit' id='row_no_of_units_"+table_len+"' type='number' name='no_of_units[]' onchange='updateNoOfCount();' /></td>"+
            "<td class='border'><input class='form-control-rows total_weight' id='row_weight_"+table_len+"' type='text' name='weight[]' value='' onchange='updateTotalWeight(this.value);' onkeyup='checkIsNumber(this.value, "+table_len+");'/></td>"+
            "<td class='border'><input class='form-control-rows' id='row_net_weight_"+table_len+"' type='text' name='net_weight[]' value='' onchange='updateEquiWeight(this.value,"+table_len+")' onkeyup='checkIsNumber(this.value, "+table_len+");'/></td>"+
            "<td class='border'><select class='form-control-rows carat_purity' id='row_carat_purity_"+table_len+"' name='carat_purity[]'  onchange='updateWeight(this.value, "+table_len+")'>"+
            "<option value=''>Carat value</option></select></td>" +
            "<td class='border'><input class='form-control-rows' id='row_equivalent_weight_"+table_len+"' type='text' readonly='readonly' name='equivalent_weight[]' value='' onchange='updateFinal(this.value, "+table_len+")' /></td>"+
            "<td class='border'><input class='form-control-rows rate_per_gram' readonly='readonly' id='row_rate_per_gram_"+table_len+"' type='text' name='rate_per_gram[]')'/></td>"+
            "<td class='border'><input class='form-control-rows price'  id='row_final_value_"+table_len+"' type='text' name='final_value[]' value=''/></td>"+
            "<td class='border'><input class='delete_button btn btn-danger' type='button'  id='row_delete_button_"+table_len+"' value='Delete' onclick='delete_row(\""+table_len+"\");'></td> </tr>";

            insertCaratList(table_len);
            insertGoldRate(table_len);
    }
    function updateTotal(ratePerGram, Id) {
        var weight = $("#row_equivalent_weight_"+Id).val();
        var finalValue = ratePerGram * weight;
        $("#row_final_value_"+Id).val((finalValue).toFixed(2));
        updateFinalTotal();
    }

    function updateEquiWeight(netWeight, Id) {
        var netWeightValue = parseFloat(netWeight);
        var weight = $("#row_weight_"+Id).val();
        var error = false;
        var sixtyPercentValue =  parseFloat(weight * .60);
        if(isNaN(weight) || isNaN(netWeight) || weight == null || weight == '') {
            alert('Weight should be a valid number.');
            error = true;
        } else if (netWeightValue < sixtyPercentValue || netWeightValue > parseFloat(weight)) {
            alert('Net Weight cannot be greater or less then 60% of weight, please add again.');
            error = true;
        }
        if(error === true) {
            $("#row_equivalent_weight_" + Id).val(0.00);
            $("#row_net_weight_"+Id).val(0.00);
            $("#row_final_value_"+Id).val(0.00);
            updateAllTotals();
            return false;
        }
        $("#row_equivalent_weight_"+Id).val((netWeightValue * ($("#row_carat_purity_"+Id).val()/22)).toFixed(2));
        updateTotalEquivalentWeight();
        updateTotalNetWeight();
        updateFinalTotal();
        updateTotal($("#row_rate_per_gram_"+Id).val(), Id);
    }

    function updateWeight(caratValue, Id) {
        var netWeightValue = $("#row_net_weight_"+Id).val();
        if(netWeightValue != '') {
            var finalValue = netWeightValue * (caratValue / 22);
            $("#row_equivalent_weight_" + Id).val(finalValue.toFixed(2));
        }
        updateFinalTotal();
        updateTotalEquivalentWeight();
        updateTotal($("#row_rate_per_gram_"+Id).val(), Id);
    }

    function updateFinalTotal() {
        var sum = 0;
        $(".price").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
        $("#total_amount").val(sum.toFixed(2));
    }

    function updateNoOfCount() {
        var sum = 0;
        $(".total_no_of_unit").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseInt(this.value);
            }
        });
        $("#total_no_of_units").val(sum);
    }

    function updateTotalWeight() {
        var sum = 0;
        $(".total_weight").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
        $("#total_weight").val(sum.toFixed(2));
    }

    function updateTotalNetWeight() {
        var sum = 0;
        $(".total_net_weight").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
        $("#total_net_weight").val(sum.toFixed(2));
    }

    function updateTotalEquivalentWeight() {
        var sum = 0;
        $(".total_equivalent_weight").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
        $("#total_equivalent_weight").val(sum.toFixed(2));
    }

    function updateFinal(equiValentWeight, Id) {
        var ratePerGram = $("#row_rate_per_gram_"+Id).val();
        updateTotal(ratePerGram, Id);
        updateFinalTotal();
        updateTotalEquivalentWeight();
    }

    function addRequiredAll(Id) {
        $("#row_rate_per_gram_"+Id).attr('required',true);
        $("#row_equivalent_weight_"+Id).attr('required',true);
        $("#row_no_of_units_"+Id).attr('required',true);
        $("#row_net_weight_"+Id).attr('required',true);
        $("#row_weight_"+Id).attr('required',true);
        $("#row_carat_purity_"+Id).attr('required', true);
    }

    function insertCaratList(id) {
        var dataCarat = $("#row_carat_purity_0").html();
        if(id != 0 && null != dataCarat) {
            $("#row_carat_purity_" + id).html(dataCarat);
        } else {
            updateCaratList($('#banks').val());
        }
    }

    function insertGoldRate(id) {
        var goldRate = $("#row_rate_per_gram_0").val();
        if(id != 0 && null != goldRate) {
            $("#row_rate_per_gram_" + id).val(goldRate);
        } else {
            updateGoldRate($('#banks').val());
        }
    }

    function updateAllTotals() {
        updateFinalTotal();
        updateNoOfCount();
        updateTotalWeight();
        updateTotalNetWeight();
        updateTotalEquivalentWeight();
    }
    <?php if (!$edit) { ?>
    changeCity(21);
    <?php } ?>
</script>
<?php if(!$edit) echo '<script type="text/javascript"> $("#mortgage_table").hide();</script>'; ?>
