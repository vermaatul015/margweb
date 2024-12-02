<div style="width: 100%;display: flex;justify-content: space-between;">
    <div style="width: 94%;">
        <div class="form-group row">
            <span class="col-sm-2 col-form-label">Product - {{$data['count']}}</span>

            <div class="col-sm-5">
                <div class="dropdown">
                    <button id="choose_product_{{$data['count']}}" class="dropbtn myFunction1" count="{{$data['count']}}">Product <i class="fa fa-caret-down"></i></button>
                    <div id="myDropdown{{$data['count']}}" class="dropdown-content">
                        
                        <input type="text" placeholder="Search.." id="myInput{{$data['count']}}"  class="product_keyup">
                        @foreach($data['stock'] as $stock)
                        <a class="stock_option" option="{{$stock->id}}" cost_price="{{$stock->cost_price}}" stock_quantity="{{$stock->quantity}}" href="#">{{$stock->product ? $stock->product->name : $stock->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <input type="text" disabled class="form-control" id="product_name{{$data['count']}}" name="product_name[]" value="" placeholder="Product Name">
                <input type="hidden"  class="form-control" id="stock_id{{$data['count']}}" name="stock_id[]" value="">
                <input type="hidden"  class="form-control" id="sell_product_id{{$data['count']}}" name="sell_product_id[]" value="">
            </div>
            
        </div>
        <div class="form-group row">
            <span class="col-sm-2 col-form-label"></span>
            <div class="col-sm-5">
                <input type="text" class="form-control" disabled id="cost_price{{$data['count']}}" value="" placeholder="Cost Price" title="Cost Price">
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" disabled id="stock_quantity{{$data['count']}}" value="" placeholder="Available Quantity" title="Available Quantity">
            </div>
            
        </div>
        <div class="form-group row">
            <span  class="col-sm-2 col-form-label">Selling Price (₹) <br/>Quantity to sell</span>
            <div class="col-sm-5">
                <input type="text" class="form-control product_price" id="selling_price{{$data['count']}}" name="selling_price[]" value="" placeholder="Selling Price">
            </div>
            
            <div class="col-sm-5">
                <input type="text" class="form-control quantity" id="quantity{{$data['count']}}" name="quantity[]" value="" placeholder="Quantity">
            </div>
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