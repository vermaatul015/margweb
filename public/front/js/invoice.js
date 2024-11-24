$('#printInvoice').click(function(){
    Popup($('.invoice')[0].outerHTML);
    function Popup(data) 
    {
        window.print();
        return true;
    }
});


function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    pdf.addHTML($('.invoice')[0], function () {
        pdf.save($('.invoice-id').text()+'.pdf');
    });
}
$("#exportPDFInvoice").click(function(){
    demoFromHTML()
})