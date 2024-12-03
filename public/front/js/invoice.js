$('#printInvoice').click(function(){
    Popup($('#invoice_print').outerHTML);
    function Popup(data) 
    {
        window.print(data);
        return true;
    }
});

function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    pdf.addHTML($('#invoice_print'), function () {
        pdf.save($('.invoice-id').text()+'.pdf');
    });
}
$("#exportPDFInvoice").click(function(){
    demoFromHTML()
})