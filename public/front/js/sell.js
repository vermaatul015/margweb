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
            url: add_sell_product_url,
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
            url: add_sell_paid_amount_url,
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


$(document).on("click",".stock_option",function(e){
    e.preventDefault();
    $("#choose_product_"+productCnt).trigger("click");
    var stock_id = $(this).attr("option");
    var cost_price = $(this).attr("cost_price");
    var stock_quantity = $(this).attr("stock_quantity");
    var product_name = $(this).html();
    $("#product_name"+productCnt).val(product_name)
    $("#cost_price"+productCnt).val(cost_price)
    $("#stock_quantity"+productCnt).val(stock_quantity)
    $("#stock_id"+productCnt).val(stock_id)
});


$(document).on("keyup",".quantity, .product_price",function(e){
    var quantity = $('.quantity').map((_,el) => el.value).get()
    var product_price = $('.product_price').map((_,el) => el.value).get();
    var total_price = 0;
    for(var i=0;i<quantity.length;i++){
        var q = parseInt(quantity[i]);
        var p = parseFloat(product_price[i]).toFixed(2);
        var t = (parseFloat(p) * parseFloat(q)).toFixed(2);
        total_price = parseFloat(total_price) + parseFloat(t);
    }
    $("#total_sp").html(total_price)
})

$(document).on("keyup",".paid_amt_cl",function(e){
    var paid_amt_cl = $('.paid_amt_cl').map((_,el) => el.value).get()
    var total_cp = parseFloat($('#total_sp').html()).toFixed(2);
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

$(document).on('click','.remove_sell_product_html',function(e){
    e.preventDefault();
    $(this).parent().parent().empty()
})


$(document).on("click","#sell_submit",function(e){
    e.preventDefault();
    var url = $("#sellModalLabel").html() == "Sell Product" ? add_sell : edit_sell;
    var stock_id_arr = $("input[name^='stock_id']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var selling_price_arr = $("input[name^='selling_price']").map(function (idx, ele) {
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
    var sell_product_id_arr = $("input[name^='sell_product_id']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    var sell_paid_id_arr = $("input[name^='sell_paid_id']").map(function (idx, ele) {
        return $(ele).val();
    }).get();
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "supplier_id":$("#supplier_id").val(),
            "supplier_name":$("#supplier_name").val(),
            "stock_id":stock_id_arr,
            "selling_price":selling_price_arr,
            "name":product_name_arr,
            "quantity":quantity_arr,
            "paid":paid_arr,
            "paid_date":paid_date_arr,
            "sell_product_id":sell_product_id_arr,
            "sell_paid_id":sell_paid_id_arr,
            "sell_id":$("#sell_id").val()
        },
        success: function(data) {
            if(data && data.hasOwnProperty('responseStatus')){
                if(data.responseStatus.STATUS == "FAILED"){
                    var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                    swal("Validation Error", s, "error");
                }else{
                    $("#close_sell_modal").trigger("click")
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
$(document).on("click","#add_sell",function(e){
    e.preventDefault();
    $("#sellModalLabel").html("Sell Product");
    $("#supplier_id").val('')
    $("#supplier_name").val('')
    $("#total_sp").html('0.00')
    $("#total_due").html('0.00')
    $("#stock_id1").val('')
    $("#selling_price1").val('')
    $("#selling_price1").prop('disabled', false);
    $("#product_name1").val('')
    $("#quantity1").val('')
    $("#quantity1").prop('disabled', false);
    $("#sell_product_id1").val('')
    $(".product_html").empty();
    $("#paid1").val('');
    $("#paid1").prop('disabled', false);
    $("#paid_date1").val('')
    $("#sell_paid_id1").val('')
    $(".paid_amount_html").empty();
    $("#sell_id").val('');
    $(".add_product").show();
    $(".remove_sell_product_html").show()
    $("#cost_price1").show();
    $("#stock_quantity1").show();
    $("#sell_submit").html("Add");
    $("#sellModal").modal("toggle")
})

$(document).on("click",".edit_sell",async function(e){
    e.preventDefault()
    var sell_id = $(this).attr("sell-id");
    var supplier_id = $("#supplier_name_"+sell_id).attr("supplier_id");
    var supplier_name = $("#supplier_name_"+sell_id).html();
    var total_selling_price = $("#total_selling_price_"+sell_id).html();
    var due = $("#due_"+sell_id).children().html();
    $("#supplier_id").val(supplier_id)
    $("#supplier_name").val(supplier_name)
    $("#total_sp").html(total_selling_price);
    $("#total_due").html(due);
    $(".product_html").empty();
    var product_cnt = $("#products_"+sell_id).attr("count");
    for(var p = 0; p < product_cnt; p++){
        var stock_id = $("#product_name_"+sell_id+"_"+p).attr("stock_id");
        var product_name = $("#product_name_"+sell_id+"_"+p).html();
        var selling_price = $("#selling_price_"+sell_id+"_"+p).html();
        var quantity = $("#quantity_"+sell_id+"_"+p).html();
        var sell_product_id = $("#product_name_"+sell_id+"_"+p).attr("sell_product_id");
        var pr_cnt = p+1;
        if(pr_cnt > 1){
            await AddProduct(pr_cnt)
        }
        $("#stock_id"+pr_cnt).val(stock_id)
        $("#sell_product_id"+pr_cnt).val(sell_product_id)
        $("#selling_price"+pr_cnt).val(selling_price)
        $("#selling_price"+pr_cnt).prop('disabled', true);
        $("#product_name"+pr_cnt).val(product_name)
        $("#quantity"+pr_cnt).val(quantity)
        $("#quantity"+pr_cnt).prop('disabled', true);
        $("#cost_price"+pr_cnt).hide();
        $("#stock_quantity"+pr_cnt).hide();
        var pa_cnt_s = pr_cnt ;
        $(".add_product").attr("count",pa_cnt_s);
        
    }
    $(".paid_amount_html").empty();
    var paid_cnt = $("#paids_"+sell_id).attr("count");
    for(var k = 0; k < paid_cnt; k++){
        var paid = $("#paid_"+sell_id+"_"+k).html();
        var paid_date = $("#paid_date_"+sell_id+"_"+k).html();
        var sell_paid_amount_id = $("#paid_"+sell_id+"_"+k).attr("sell_paid_amount_id");
        var pa_cnt = k+1;
        if(pa_cnt > 1){
            await AddPaidAmount(pa_cnt)
        }
        $("#paid"+pa_cnt).val(paid);
        $("#paid"+pa_cnt).prop('disabled', true);
        $("#paid_date"+pa_cnt).val(paid_date);
        $("#sell_paid_id"+pa_cnt).val(sell_paid_amount_id);
        var pa_cnt_s = pa_cnt ;
        $(".add_paid_amount").attr("count",pa_cnt_s);
    }
    $("#sellModalLabel").html("Edit sold Product");
    
    $("#sell_id").val(sell_id);
    // $("#stock_quantity").hide();
    $(".add_product").hide();
    $(".remove_sell_product_html").hide()
    $("#sell_submit").html("OK");
    $("#sellModal").modal("toggle")
});

$(document).on("click",".delete_sell",function(e){
    e.preventDefault();
    var sell_id = $(this).attr("sell-id");
    swal({
        title: "Are you sure you want to delete sold record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: delete_sell,
                type: "post", 
                data: { 
                    "sell_id":sell_id
                },
                success: function(data) {
                    if(data && data.hasOwnProperty('responseStatus')){
                        if(data.responseStatus.STATUS == "FAILED"){
                            var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                            swal("Validation Error", s, "error");
                        }else{
                            $("#close_sell_modal").trigger("click")
                            swal("Sold record Deleted!", data.responseStatus.MESSAGE, "success");
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