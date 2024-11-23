$(document).on("click","#supplier_submit",function(e){
    e.preventDefault();
    var url = $("#supplierModalLabel").html() == "Add Supplier" ? add_supplier : edit_supplier;
    $.ajax({
        url: url,
        type: "post", 
        data: { 
            "name":$("#name").val(),
            "gst":$("#gst").val(),
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
    $("#supplierModalLabel").html("Add Supplier");
    $("#name").val('')
    $("#gst").val('')
    $("#supplier_id").val('');
    $("#supplier_submit").html("Add");
    $("#supplierModal").modal("toggle")
})

$(document).on("click",".edit_supplier",function(e){
    e.preventDefault()
    var supplier_id = $(this).attr("supplier-id");
    var supplier_name = $("#supplier_name_"+supplier_id).html();
    var gst = $("#gst_"+supplier_id).html();
    $("#supplierModalLabel").html("Edit Supplier");
    $("#name").val(supplier_name)
    $("#gst").val(gst)
    $("#supplier_id").val(supplier_id);
    $("#supplier_submit").html("Edit");
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
                            swal("Supplier Deleted!", data.responseStatus.MESSAGE, "success");
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