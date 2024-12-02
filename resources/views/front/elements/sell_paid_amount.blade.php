<div style="width: 100%;display: flex;justify-content: space-between;">
    <div class="form-group row" style="width: 94%;">
        <span class="col-sm-2 col-form-label">Amount Recieved(₹)</span>
        <div class="col-sm-5">
            <input type="text" class="form-control datepickfront" id="paid_date{{$data['count']}}" name="paid_date[]" value="" readonly placeholder="Paid Date" title="Paid Date" >
        </div>
        <div class="col-sm-5">
            <input type="text" class="form-control paid_amt_cl" id="paid{{$data['count']}}" name="paid_amt[]" value="">
            <input type="hidden"  class="form-control" id="sell_paid_id{{$data['count']}}" name="sell_paid_id[]" value="">
        </div>
    </div>
    @if($data['count'] != 1)
    <div style="width: 5%;">
        <a class="link-color1 remove_sell_product_html" id="remove_sell_product_html{{$data['count']}}" href=""  title="Remove">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>
    </div>
    @endif
</div>