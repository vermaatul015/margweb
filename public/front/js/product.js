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

$(document).on("click",".supplier_option",function(e){
    e.preventDefault();
    $("#myFunction").trigger("click");
    var supplier_id = $(this).attr("option");
    var supplier_name = $(this).html();
    $("#supplier_name").val(supplier_name)
    $("#supplier_id").val(supplier_id)
});



$(document).on("click","#product_submit",function(e){
    e.preventDefault();
    var url = $("#productModalLabel").html() == "Add Product" ? add_product : edit_product;
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "supplier_id":$("#supplier_id").val(),
            "supplier_name":$("#supplier_name").val(),
            "name":$("#name").val(),
            "price":$("#price").val(),
            "hsn":$("#hsn").val(),
            "product_id":$("#product_id").val()
        },
        success: function(data) {
            if(data && data.hasOwnProperty('responseStatus')){
                if(data.responseStatus.STATUS == "FAILED"){
                    var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                    swal("Validation Error", s, "error");
                }else{
                    $("#close_product_modal").trigger("click")
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
$(document).on("click","#add_product",function(e){
    e.preventDefault();
    $("#productModalLabel").html("Add Product");
    $("#supplier_id").val('')
    $("#supplier_name").val('')
    $("#name").val('')
    $("#price").val('')
    $("#hsn").val('')
    $("#product_id").val('');
    $("#product_submit").html("Add");
    $("#productModal").modal("toggle")
})

$(document).on("click",".edit_product",function(e){
    e.preventDefault()
    var product_id = $(this).attr("product-id");
    var supplier_id = $("#supplier_name_"+product_id).attr("supplier_id");
    var supplier_name = $("#supplier_name_"+product_id).html();
    var product_name = $("#product_name_"+product_id).html();
    var price = $("#price_"+product_id).html();
    var hsn = $("#hsn_"+product_id).html();
    $("#productModalLabel").html("Edit Product");
    $("#supplier_id").val(supplier_id)
    $("#supplier_name").val(supplier_name)
    $("#name").val(product_name)
    $("#price").val(price)
    $("#hsn").val(hsn)
    $("#product_id").val(product_id);
    $("#product_submit").html("OK");
    $("#productModal").modal("toggle")
});

$(document).on("click",".delete_product",function(e){
    e.preventDefault();
    var product_id = $(this).attr("product-id");
    swal({
        title: "Are you sure you want to delete product?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: delete_product,
                type: "post", 
                data: { 
                    "product_id":product_id
                },
                success: function(data) {
                    if(data && data.hasOwnProperty('responseStatus')){
                        if(data.responseStatus.STATUS == "FAILED"){
                            var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                            swal("Validation Error", s, "error");
                        }else{
                            $("#close_product_modal").trigger("click")
                            swal("Product Deleted!", data.responseStatus.MESSAGE, "success");
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