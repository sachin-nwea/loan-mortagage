function changeCity(val) {
    $.ajax({
        type: "POST",
        url: "./get_city_list.php",
        data:'state_id='+val,
        success: function(data) {
            if(data != '') {
                $("#city-list").html(data);
            } else {
                $("#city-list").html('<option value="">Select City</option>');
            }
        }
    });
}

function fetchList(val) {
    $.ajax({
        type: "POST",
        url: "./get_customer_list.php",
        data:'city='+val,
        success: function(data) {
            if(data != '') {
                $("#customers").html(data);
            } else {
                $("#customers").html('<option value="">Select Customer</option>');
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "./get_bank_list.php",
        data:'city='+val,
        success: function(data) {
            if(data != '') {
                $("#banks").html(data);
            } else {
                $("#banks").html('<option value="">Select Bank</option>');
            }
        }
    });
}

function validPhoneNumber(mobile1, mobile2)
{
    var phoneno = /^\d{10}$/;

    if(mobile1.match(phoneno) || mobile2.match(phoneno)) {
        return true;
    } else {
        alert("Please update valid Mobile numbers(Mobile1/Mobile2)");
        return false;
    }
}

function fetchMortgageList(val) {
    $.ajax({
        type: "POST",
        url: "./get_mortgage_emails.php",
        data: 'branch_name=' + val,
        success: function (data) {
            $("#details").html(data);
        }
    });
}

function updateInterestPaymentType(val) {
    $.ajax({
        type: "POST",
        url: "./get_interest_type.php",
        data: 'bank_id=' + val,
        success: function (data) {
            $("#interest_payment_type").html(data);
        }
    });
}


function updateGoldRate(val) {
    $.ajax({
        type: "POST",
        url: "./get_gold_rate.php",
        data: 'bank_id=' + val,
        success: function (data) {
            $(".rate_per_gram").each(function () {
                $("#"+this.id).val(data);
            });
        }
    });
}


function updateCaratList(val) {
    $.ajax({
        type: "POST",
        url: "./get_carat_list.php",
        data: 'bank_id=' + val,
        success: function (data) {
            $(".carat_purity").each(function () {
                $("#"+this.id).html(data);
            });
        }
    });
}

function fetchBranchList(val) {
    $.ajax({
        type: "POST",
        url: "./get_branch_list.php",
        data: 'bank_id=' + val,
        success: function (data) {
            if (data != '') {
                $("#branches").html(data);
                $("#mortgage_table").show();
            } else {
                $("#branches").html('<option value="">Select Branch</option>');
            }
        }
    });
    updateCaratList(val);
    updateGoldRate(val);
    updateInterestPaymentType(val);
}

