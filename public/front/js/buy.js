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


$(document).on("click",".product_option",function(e){
    e.preventDefault();
    $("#myFunction1").trigger("click");
    var product_id = $(this).attr("option");
    var product_price = $(this).attr("cost_price");
    var product_name = $(this).html();
    $("#product_name").val(product_name)
    $("#product_price").val(product_price)
    $("#product_id").val(product_id)
});



$(document).on("click","#buy_submit",function(e){
    e.preventDefault();
    var url = $("#buyModalLabel").html() == "Buy Product" ? add_buy : edit_buy;
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "supplier_id":$("#supplier_id").val(),
            "supplier_name":$("#supplier_name").val(),
            "product_id":$("#product_id").val(),
            "cost_price":$("#product_price").val(),
            "name":$("#product_name").val(),
            "quantity":$("#quantity").val(),
            "paid":$("#paid").val(),
            "buy_id":$("#buy_id").val()
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
    $("#product_id").val('')
    $("#product_price").val('')
    $("#product_name").val('')
    $("#quantity").val('')
    $("#quantity").prop('disabled', false);
    $("#paid").val('')
    $("#buy_id").val('');
    $("#buy_submit").html("Add");
    $("#buyModal").modal("toggle")
})

$(document).on("click",".edit_buy",function(e){
    e.preventDefault()
    var buy_id = $(this).attr("buy-id");
    var supplier_id = $("#supplier_name_"+buy_id).attr("supplier_id");
    var supplier_name = $("#supplier_name_"+buy_id).html();
    var product_id = $("#product_name_"+buy_id).attr("product_id");
    var product_name = $("#product_name_"+buy_id).html();
    var cost_price = $("#cost_price_"+buy_id).html();
    var quantity = $("#quantity_"+buy_id).html();
    var paid = $("#paid_"+buy_id).html();
    $("#buyModalLabel").html("Edit bought Product");
    $("#supplier_id").val(supplier_id)
    $("#supplier_name").val(supplier_name)
    $("#product_id").val(product_id)
    $("#product_price").val(cost_price)
    $("#product_name").val(product_name)
    $("#quantity").val(quantity)
    $("#quantity").prop('disabled', true);
    $("#paid").val(paid)
    $("#buy_id").val(buy_id);
    $("#buy_submit").html("Edit");
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