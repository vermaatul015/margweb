/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
$(document).on("click","#myFunction",function(e){
    e.preventDefault();
    document.getElementById("myDropdown").classList.toggle("show");
});
  
function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        a[i].style.display = "";
        } else {
        a[i].style.display = "none";
        }
    }
}

var productCnt = 1;
$(document).on("click",".myFunction1",function(e){
    e.preventDefault();
    productCnt = $(this).attr("count");
    document.getElementById("myDropdown"+productCnt).classList.toggle("show");
});
  
function filterFunction1() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput"+productCnt);
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown"+productCnt);
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        a[i].style.display = "";
        } else {
        a[i].style.display = "none";
        }
    }
}

$(document).on("keyup",".product_keyup",function(e){
    e.preventDefault();
    filterFunction1()
});

async function AddProduct(cnt){
    let result;

    try {
        result = await $.ajax({
            url: add_buy_product_url,
            type: "post", 
            data: { 
                "count" : cnt
            },
            success: function(response) {
                if(response && response.responseStatus.STATUS == "SUCCESS"){
                    $(".product_html").append(response.responseData.product_html);
                                    
                }else{
                    var s = response.responseStatus.MESSAGE;
                    swal("Error", s, "error");
                }
            },
            error: function(xhr) {
                console.log(xhr)
            }
        });
        return result;
    } catch (error) {
        console.error(error);
    }
}

$(document).on("click",".add_product",function(e){
    e.preventDefault();
    var _this = $(this)
    var cnt = parseInt(_this.attr("count"));
    cnt = cnt+1;
    _this.attr("count",cnt);
    AddProduct(cnt);
});

async function AddPaidAmount(cnt){
    let result;

    try {
        result = await $.ajax({
            url: add_buy_paid_amount_url,
            type: "post", 
            data: { 
                "count" : cnt
            },
            success: function(response) {
                if(response && response.responseStatus.STATUS == "SUCCESS"){
                    $(".paid_amount_html").append(response.responseData.paid_html);
                    
                }else{
                    var s = response.responseStatus.MESSAGE;
                    swal("Error", s, "error");
                }
            },
            error: function(xhr) {
                console.log(xhr)
            }
        });
        return result;
    } catch (error) {
        console.error(error);
    }
}

$(document).on("click",".add_paid_amount",function(e){
    e.preventDefault();
    var _this = $(this)
    var cnt = parseInt(_this.attr("count"));
    cnt = cnt+1;
    _this.attr("count",cnt);
    AddPaidAmount(cnt);
});

$(document).on("click",".supplier_option",function(e){
    e.preventDefault();
    $("#myFunction").trigger("click");
    var supplier_id = $(this).attr("option");
    var supplier_name = $(this).html();
    $("#supplier_name").val(supplier_name)
    $("#supplier_id").val(supplier_id)
});


$(document).on("click",".product_option",function(e){
    e.preventDefault();
    $("#choose_product_"+productCnt).trigger("click");
    var product_id = $(this).attr("option");
    var product_price = $(this).attr("cost_price");
    var product_name = $(this).html();
    $("#product_name"+productCnt).val(product_name)
    $("#product_price"+productCnt).val(product_price)
    $("#product_id"+productCnt).val(product_id)
});

$(document).on("keyup",".quantity",function(e){
    var quantity = $('.quantity').map((_,el) => el.value).get()
    var product_price = $('.product_price').map((_,el) => el.value).get();
    var total_price = 0;
    for(var i=0;i<quantity.length;i++){
        var q = parseInt(quantity[i]);
        var p = parseFloat(product_price[i]).toFixed(2);
        var t = (parseFloat(p) * parseFloat(q)).toFixed(2);
        total_price = parseFloat(total_price) + parseFloat(t);
    }
    $("#total_cp").html(total_price)
})

$(document).on("keyup",".paid_amt_cl",function(e){
    var paid_amt_cl = $('.paid_amt_cl').map((_,el) => el.value).get()
    var total_cp = parseFloat($('#total_cp').html()).toFixed(2);
    var total_paid = 0.00;
    for(var i=0;i<paid_amt_cl.length;i++){
        var p = parseFloat(paid_amt_cl[i]).toFixed(2);
        total_paid = parseFloat(total_paid) + parseFloat(p);
    }
    var total_due = total_cp - total_paid;
    $("#total_due").html(total_due)
})


$(document).on('focus',".datepickfront", function(){
    $(this).datepicker({ 
        autoclose: true, 
        todayHighlight: true,
        format: 'yy-mm-dd'
    })
});

$(document).on('click','.remove_buy_product_html',function(e){
    e.preventDefault();
    $(this).parent().parent().empty()
})

$(document).on("click","#buy_submit",function(e){
    e.preventDefault();
    var url = $("#buyModalLabel").html() == "Buy Product" ? add_buy : edit_buy;
    var product_id_arr = $("input[name^='product_id']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var product_price_arr = $("input[name^='product_price']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var product_name_arr = $("input[name^='product_name']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var quantity_arr = $("input[name^='quantity']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var paid_arr = $("input[name^='paid_amt']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var paid_date_arr = $("input[name^='paid_date']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var buy_product_id_arr = $("input[name^='buy_product_id']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var buy_paid_id_arr = $("input[name^='buy_paid_id']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "supplier_id":$("#supplier_id").val(),
            "supplier_name":$("#supplier_name").val(),
            "product_id":product_id_arr,
            "cost_price":product_price_arr,
            "name":product_name_arr,
            "quantity":quantity_arr,
            "paid":paid_arr,
            "paid_date":paid_date_arr,
            "buy_id":$("#buy_id").val(),
            "buy_product_id":buy_product_id_arr,
            "buy_paid_id":buy_paid_id_arr

        },
        success: function(data) {
            if(data && data.hasOwnProperty('responseStatus')){
                if(data.responseStatus.STATUS == "FAILED"){
                    var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                    swal("Validation Error", s, "error");
                }else{
                    $("#close_buy_modal").trigger("click")
                    swal("Success!", data.responseStatus.MESSAGE, "success");
                    location.reload();
                        
                }
            }
        },
        error: function(xhr) {
            console.log(xhr)
        }
    });
});
$(document).on("click","#add_buy",function(e){
    e.preventDefault();
    $("#buyModalLabel").html("Buy Product");
    $("#supplier_id").val('')
    $("#supplier_name").val('')
    $("#total_cp").html('0.00')
    $("#total_due").html('0.00');
    $("#product_id1").val('')
    $("#product_price1").val('')
    $("#product_name1").val('')
    $("#quantity1").val('')
    $("#quantity1").prop('disabled', false);
    $("#buy_product_id1").val('')
    $(".product_html").empty();
    $("#paid1").val('');
    $("#paid1").prop('disabled', false);
    $("#paid_date1").val('')
    $("#buy_paid_id1").val('')
    $(".paid_amount_html").empty();
    $("#buy_id").val('');
    $(".add_product").show();
    $(".remove_buy_product_html").show()
    $("#buy_submit").html("Add");
    $("#buyModal").modal("toggle")
})

$(document).on("click",".edit_buy", async function(e){
    e.preventDefault()
    var buy_id = $(this).attr("buy-id");
    var supplier_id = $("#supplier_name_"+buy_id).attr("supplier_id");
    var supplier_name = $("#supplier_name_"+buy_id).html();
    var total_cost_price = $("#total_cost_price_"+buy_id).html();
    var due = $("#due_"+buy_id).children().html();
    $("#supplier_id").val(supplier_id)
    $("#supplier_name").val(supplier_name)
    $("#total_cp").html(total_cost_price);
    $("#total_due").html(due);
    $(".product_html").empty();
    var product_cnt = $("#products_"+buy_id).attr("count");
    for(var p = 0; p < product_cnt; p++){
        var product_id = $("#product_name_"+buy_id+"_"+p).attr("product_id");
        var product_name = $("#product_name_"+buy_id+"_"+p).html();
        var cost_price = $("#cost_price_"+buy_id+"_"+p).html();
        var quantity = $("#quantity_"+buy_id+"_"+p).html();
        var buy_product_id = $("#product_name_"+buy_id+"_"+p).attr("buy_product_id");
        var pr_cnt = p+1;
        if(pr_cnt > 1){
            await AddProduct(pr_cnt)
        }
        $("#product_id"+pr_cnt).val(product_id)
        $("#buy_product_id"+pr_cnt).val(buy_product_id)
        $("#product_price"+pr_cnt).val(cost_price)
        $("#product_name"+pr_cnt).val(product_name)
        $("#quantity"+pr_cnt).val(quantity)
        $("#quantity"+pr_cnt).prop('disabled', true);
        var pa_cnt_s = pr_cnt ;
        $(".add_product").attr("count",pa_cnt_s);
        
    }
    $(".paid_amount_html").empty();
    var paid_cnt = $("#paids_"+buy_id).attr("count");
    for(var k = 0; k < paid_cnt; k++){
        var paid = $("#paid_"+buy_id+"_"+k).html();
        var paid_date = $("#paid_date_"+buy_id+"_"+k).html();
        var buy_paid_amount_id = $("#paid_"+buy_id+"_"+k).attr("buy_paid_amount_id");
        var pa_cnt = k+1;
        if(pa_cnt > 1){
            await AddPaidAmount(pa_cnt)
        }
        $("#paid"+pa_cnt).val(paid);
        $("#paid"+pa_cnt).prop('disabled', true);
        $("#paid_date"+pa_cnt).val(paid_date);
        $("#buy_paid_id"+pa_cnt).val(buy_paid_amount_id);
        var pa_cnt_s = pa_cnt ;
        $(".add_paid_amount").attr("count",pa_cnt_s);
    }
    $("#buyModalLabel").html("Edit bought Product");
    $(".add_product").hide();
    $(".remove_buy_product_html").hide()
    $("#buy_id").val(buy_id);
    $("#buy_submit").html("OK");
    $("#buyModal").modal("toggle")
});

$(document).on("click",".delete_buy",function(e){
    e.preventDefault();
    var buy_id = $(this).attr("buy-id");
    swal({
        title: "Are you sure you want to delete bought record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: delete_buy,
                type: "post", 
                data: { 
                    "buy_id":buy_id
                },
                success: function(data) {
                    if(data && data.hasOwnProperty('responseStatus')){
                        if(data.responseStatus.STATUS == "FAILED"){
                            var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                            swal("Validation Error", s, "error");
                        }else{
                            $("#close_buy_modal").trigger("click")
                            swal("Bought record Deleted!", data.responseStatus.MESSAGE, "success");
                            location.reload();
                        }
                    }
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            });
        }
    });
    
});


$(document).on("click",".showProductClass",function(e){
    e.preventDefault();
    $('#detailModalBody').empty();
    var id = $(this).attr("body-div");
    var html = $("#"+id).html();
    $("#detailModalBody").html(html);
    $("#detailModal").modal("toggle")
});

$('#detailModal').on('hidden.bs.modal', function () {
    $('#detailModalBody').empty();
});