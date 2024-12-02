



$(document).on("click","#stock_submit",function(e){
    e.preventDefault();
    var url = edit_stock;
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "stock_id":$("#stock_id").val()
        },
        success: function(data) {
            if(data && data.hasOwnProperty('responseStatus')){
                if(data.responseStatus.STATUS == "FAILED"){
                    var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                    swal("Validation Error", s, "error");
                }else{
                    $("#close_stock_modal").trigger("click")
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

$(document).on("click",".edit_stock",function(e){
    e.preventDefault()
    var stock_id = $(this).attr("stock-id");
    var product_id = $("#product_name_"+stock_id).attr("product_id");
    var product_name = $("#product_name_"+stock_id).html();
    var cost_price = $("#cost_price_"+stock_id).html();
    var quantity = $("#quantity_"+stock_id).html();
    $("#stockModalLabel").html("Edit Stock");
    $("#product_id").val(product_id)
    $("#cost_price").val(cost_price)
    $("#product_name").val(product_name)
    $("#quantity").val(quantity)
    $("#stock_id").val(stock_id);
    // $("#stock_submit").html("Edit");
    $("#stockModal").modal("toggle")
});

$(document).on("click",".delete_stock",function(e){
    e.preventDefault();
    var stock_id = $(this).attr("stock-id");
    swal({
        title: "Are you sure you want to delete your stock record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: delete_stock,
                type: "post", 
                data: { 
                    "stock_id":stock_id
                },
                success: function(data) {
                    if(data && data.hasOwnProperty('responseStatus')){
                        if(data.responseStatus.STATUS == "FAILED"){
                            var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                            swal("Validation Error", s, "error");
                        }else{
                            $("#close_stock_modal").trigger("click")
                            swal("Stock Deleted!", data.responseStatus.MESSAGE, "success");
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