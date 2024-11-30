<div style="width: 100%;display: flex;justify-content: space-between;">
    <div style="width: 94%;">
        <div class="form-group row">
            <span class="col-sm-2 col-form-label">Product - {{$data['count']}}</span>

            <div class="col-sm-5">
                <div class="dropdown">
                    <button class="dropbtn myFunction1" id="choose_product_{{$data['count']}}" count="{{$data['count']}}">Product <i class="fa fa-caret-down"></i></button>
                    <div id="myDropdown{{$data['count']}}" class="dropdown-content">
                        <!-- <i class="fa fa-search"></i> -->
                        <input type="text" placeholder="Search.." id="myInput{{$data['count']}}"  class="product_keyup">
                        @foreach($data['product'] as $product)
                        <a class="product_option" option="{{$product->id}}" cost_price="{{$product->price}}" href="#">{{$product->name}}</a>
                        @endforeach
                        <!-- <a class="product_option" option="" href="#">Others</a> -->
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <input type="text" disabled class="form-control" id="product_name{{$data['count']}}" name="product_name[]" value="" placeholder="Product Name">
                <input type="hidden"  class="form-control" id="product_id{{$data['count']}}" name="product_id[]" value="">
                <input type="hidden"  class="form-control" id="buy_product_id{{$data['count']}}" name="buy_product_id[]" value="">
            </div>
            
        </div>
        <div class="form-group row">
            <span for="product_name" class="col-sm-2 col-form-label"></span>
            <div class="col-sm-5">
                <input type="text" disabled class="form-control product_price" id="product_price{{$data['count']}}" name="product_price[]" value="" placeholder="Cost Price">
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control quantity" id="quantity{{$data['count']}}" name="quantity[]" value="" placeholder="Quantity">
            </div>
            
        </div>
        
    </div>
    @if($data['count'] != 1)
    <div style="width: 5%;">
        <a class="link-color1 remove_buy_product_html" id="remove_buy_product_html{{$data['count']}}" href=""  title="Remove">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>
    </div>
    @endif
</div>