$(document).on("click","#supplier_submit",function(e){
    e.preventDefault();
    var url = $("#supplierModalLabel").html() == "Add Party" ? add_supplier : edit_supplier;
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "name":$("#name").val(),
            "gst":$("#gst").val(),
            "phone_no":$("#phone_no").val(),
            "address":$("#address").val(),
            "supplier_id": $("#supplier_id").val() 
        },
        success: function(data) {
            if(data && data.hasOwnProperty('responseStatus')){
                if(data.responseStatus.STATUS == "FAILED"){
                    var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                    swal("Validation Error", s, "error");
                }else{
                    $("#close_supplier_modal").trigger("click")
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
$(document).on("click","#add_supplier",function(e){
    e.preventDefault();
    $("#supplierModalLabel").html("Add Party");
    $("#name").val('')
    $("#gst").val('')
    $("#phone_no").val('')
    $("#address").val('')
    $("#supplier_id").val('');
    $("#supplier_submit").html("Add");
    $("#supplierModal").modal("toggle")
})

$(document).on("click",".edit_supplier",function(e){
    e.preventDefault()
    var supplier_id = $(this).attr("supplier-id");
    var supplier_name = $("#supplier_name_"+supplier_id).html();
    var gst = $("#gst_"+supplier_id).html();
    var phone_no = $("#phone_no_"+supplier_id).html();
    var address = $("#address_"+supplier_id).html();
    $("#supplierModalLabel").html("Edit Party");
    $("#name").val(supplier_name)
    $("#gst").val(gst)
    $("#phone_no").val(phone_no)
    $("#address").val(address)
    $("#supplier_id").val(supplier_id);
    $("#supplier_submit").html("OK");
    $("#supplierModal").modal("toggle")
});

$(document).on("click",".delete_supplier",function(e){
    e.preventDefault();
    var supplier_id = $(this).attr("supplier-id");
    swal({
        title: "Are you sure you want to delete supplier?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: delete_supplier,
                type: "post", 
                data: { 
                    "supplier_id":supplier_id
                },
                success: function(data) {
                    if(data && data.hasOwnProperty('responseStatus')){
                        if(data.responseStatus.STATUS == "FAILED"){
                            var s = data.responseStatus.MESSAGE.replace(/\,/g, '\n');
                            swal("Validation Error", s, "error");
                        }else{
                            $("#close_supplier_modal").trigger("click")
                            swal("Party Deleted!", data.responseStatus.MESSAGE, "success");
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