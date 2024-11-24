var validImageExtensions = ['jpeg', 'jpg', 'png', 'svg','JPEG', 'JPG', 'PNG', 'SVG'];
var maxgymLogoUploadSize = 200000; //200 kB
var user_cropper = '';
// var imageSizeMessage = 'Please upload file (jpeg/jpg/png/svg/JPEG/JPG/PNG/SVG) having size upto 200Kb';
var imageSizeMessage = 'Please upload file (jpeg/jpg/png/svg/JPEG/JPG/PNG/SVG)';
var options =
{
    thumbBox: '.thumbBox',
    spinner: '.spinner',
    imgSrc: 'avatar.png'
}
var cropper = '';

$('#logo').on('change', function(event){
    user_cropper = '';
    $('.user-cropper').show()
    $('#userLogoBox').show()
    $("#user_crop_btn").show()
    $('#user_logo_preview').html("");
    $('#user-logo-filecheck').html("");
    $("#logo_base64").val('');
    var uploadedFileSize = (event.target.files[0].size);
    var fileName = event.target.files[0].name;
    var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
    if ($.inArray(fileNameExt, validImageExtensions) == -1 
    // || uploadedFileSize > maxgymLogoUploadSize
    ) {
        
        $('#user-logo-filecheck').show();
        $('#user-logo-filecheck').html(imageSizeMessage);
        $('.user-cropper').hide()
        $("#userLogoBox").hide();
        $("#user_crop_btn").hide();
        $('#logo').val('')
    } else {
        var reader = new FileReader();
        reader.onload = function(e) {
            options.imgSrc = e.target.result;
            user_cropper = $('#userLogoBox').cropbox(options);
        }
        reader.readAsDataURL(this.files[0]);
    }
    
})
$('#userBtnCrop').on('click', function(){
    if(user_cropper){
        var img = user_cropper.getDataURL();
        $('#user_logo_preview').html('<img src="'+img+'" style="border-radius: 0;cursor: auto;width: auto;">');
        $("#logo_base64").val(img);
    }
    
})
$('#userBtnZoomIn').on('click', function(){
    if(user_cropper){
    user_cropper.zoomIn();
    }
})
$('#userBtnZoomOut').on('click', function(){
    if(user_cropper){
    user_cropper.zoomOut();
    }
})