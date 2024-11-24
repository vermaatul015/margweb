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


$(document).on("click","#myFunction1",function(e){
    e.preventDefault();
    document.getElementById("myDropdown1").classList.toggle("show");
});
  
function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput1");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown1");
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
    $("#myFunction1").trigger("click");
    var stock_id = $(this).attr("option");
    var selling_price = $(this).attr("selling_price");
    var stock_quantity = $(this).attr("stock_quantity");
    var product_name = $(this).html();
    $("#product_name").val(product_name)
    $("#selling_price").val(selling_price)
    $("#stock_quantity").val(stock_quantity)
    $("#stock_id").val(stock_id)
});



$(document).on("click","#sell_submit",function(e){
    e.preventDefault();
    var url = $("#sellModalLabel").html() == "Sell Product" ? add_sell : edit_sell;
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "supplier_id":$("#supplier_id").val(),
            "supplier_name":$("#supplier_name").val(),
            "stock_id":$("#stock_id").val(),
            "selling_price":$("#selling_price").val(),
            "name":$("#product_name").val(),
            "quantity":$("#quantity").val(),
            "amount_received":$("#amount_received").val(),
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
    $("#stock_id").val('')
    $("#selling_price").val('')
    $("#product_name").val('')
    $("#quantity").val('')
    $("#quantity").prop('disabled', false);
    $("#amount_received").val('')
    $("#sell_id").val('');
    $("#stock_quantity").show();
    $("#sell_submit").html("Add");
    $("#sellModal").modal("toggle")
})

$(document).on("click",".edit_sell",function(e){
    e.preventDefault()
    var sell_id = $(this).attr("sell-id");
    var supplier_id = $("#supplier_name_"+sell_id).attr("supplier_id");
    var supplier_name = $("#supplier_name_"+sell_id).html();
    var stock_id = $("#product_name_"+sell_id).attr("stock_id_id");
    var product_name = $("#product_name_"+sell_id).html();
    var selling_price = $("#selling_price_"+sell_id).html();
    var quantity = $("#quantity_"+sell_id).html();
    var amount_received = $("#amount_received_"+sell_id).html();
    $("#sellModalLabel").html("Edit sold Product");
    $("#supplier_id").val(supplier_id)
    $("#supplier_name").val(supplier_name)
    $("#stock_id").val(stock_id)
    $("#selling_price").val(selling_price)
    $("#product_name").val(product_name)
    $("#quantity").val(quantity)
    $("#quantity").prop('disabled', true);
    $("#amount_received").val(amount_received)
    $("#sell_id").val(sell_id);
    $("#stock_quantity").hide();
    $("#sell_submit").html("Edit");
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