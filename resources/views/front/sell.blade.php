@extends('front/template')
@section('title', 'Sell')

@section('content')
<div class="container-fluid">

<div class="table-header">
  <div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sellModal" id="add_sell">
    Sell Product
    </button>
  </div>
  <div>
    @if(count($data['sell']) > 0)                    
        Showing <span>{{$data['sell']->firstItem()}} to {{$data['sell']->lastItem()}} of {{$data['sell']->total()}}</span> products sold
    @endif
  </div>
</div>


<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse  " >
    
    {!! Form::open(array('route' => ['sell_list'],'method' => 'post','name'=>'srchFrm','id'=>'srchFrm','role'=>'form','class'=>'form-inline my-2 my-lg-0')) !!}
    {!! Form::text('skey',$data['skey'], array('placeholder'=>'Search','class'=>'form-control mr-sm-2','autocomplete'=>'off')) !!}
    {!! Form::submit('Search', array('class' => 'btn btn-outline-success my-2 mr-sm-2 my-sm-0')) !!}
    {!! Form::close() !!}
    
    <a href="{{ route('sell_list') }}">
    <button class="btn btn-outline-danger" >Reset</button>
    </a>
  </div>
  
</nav>


<table class="table">
  <thead>
    <tr>
      <th scope="col">@sortablelink('created_at','Sold Date Time')</th>
      <th scope="col">@sortablelink('supplier_name', 'Party Name')</th>
      <th scope="col">Total Selling Price (₹)</th>
      <th scope="col">Total Recieved Amount (₹)</th>
      <th scope="col">@sortablelink('due' ,'Due Amount (₹)')</th>
      <th scope="col">Products</th>
      <th scope="col">Amounts Recieved (₹)</th>
      <th scope="col">Action</th>
      <th scope="col">Bill</th>
    </tr>
  </thead>
  <tbody>
  @if(count($data['sell']) > 0)   
  @foreach ($data['sell'] as $key => $val)
    <tr>
      <th scope="row">{{$val->created_at->format('M jS,y h:i a')}}</th>
      <td id="supplier_name_{{$val->id}}" supplier_id="{{$val->supplier_id}}">{{$val->supplier ? $val->supplier->name : $val->supplier_name}}</td>
      <td id="total_selling_price_{{$val->id}}">{{$val->total_selling_price}}</td>
      <td id="total_recieved_amount_{{$val->id}}">{{$val->total_recieved_amount}}</td>
      <td id="due_{{$val->id}}"><div class="{{$val->due > 0 ? 'alert-danger' : 'alert-success'}}">{{$val->due}}</div></td>
      <td class="products"> 
        <a class="btn btn-primary showProductClass" body-div="products_{{$val->id}}" data-toggle="modal" data-target="#detailModal" role="button" >
          Show Products
        </a>
        
      </td>
      
      <td class="paid_amounts">
        <a class="btn btn-primary showProductClass" body-div="paids_{{$val->id}}" data-toggle="modal" data-target="#detailModal" role="button" >
          Show Recieved Amount
        </a>
        
      </td>
      <td>
        <a class="link-color1 edit_sell" sell-id="{{$val->id}}" href="" title="Edit sold product" >
        <i class="fa fa-edit" aria-hidden="true" title="Edit" alt="Edit"></i>
        </a>&nbsp;     
        <a class="link-color1 delete_sell" sell-id="{{$val->id}}" href=""  title="Delete sold product">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>
            
      </td>
      <td><a class="print_payment" href="{{route('invoice',['id'=>$val->id])}}" target="_blank" title="Ebill"><i class="fa fa-print" aria-hidden="true"></i></a></td>
    </tr>
    <tr >
      <div class="collapse" id="products_{{$val->id}}" count="{{optional($val->products)->count()}}">
        <ul class="d-flex flex-wrap list-group-horizontal">
          <li class="list-group-item"><b>NAME</b></li>
          <li class="list-group-item"><b>SELLING PRICE (₹)</b></li>
          <li class="list-group-item"><b>QUANTITY</b></li>
        </ul>
        @foreach($val->products as $k => $prd)
        <ul class="d-flex flex-wrap list-group-horizontal">
          
            <li class="list-group-item" id="product_name_{{$val->id}}_{{$k}}" stock_id="{{$prd->stock_id}}" sell_product_id="{{$prd->id}}">{{$prd->stock ? ($prd->stock->product ? $prd->stock->product->name : $prd->stock->name) : $prd->name}}</li>
            <li class="list-group-item" id="selling_price_{{$val->id}}_{{$k}}">{{$prd->selling_price}}</li>
            <li class="list-group-item" id="quantity_{{$val->id}}_{{$k}}">{{$prd->quantity}}</li>
          
          
          </ul>
          @endforeach
        
      </div>
    </tr>
    <tr>
      <div class="collapse" id="paids_{{$val->id}}" count="{{optional($val->paids)->count()}}">
        <ul class="d-flex flex-wrap list-group-horizontal">
          <li class="list-group-item"><b>PAID DATE</b></li>
          <li class="list-group-item"><b>AMOUNT (₹)</b></li>
        </ul>
          @foreach($val->paids as $k => $paid)
          <ul class="d-flex flex-wrap list-group-horizontal">
            <li class="list-group-item" id="paid_date_{{$val->id}}_{{$k}}">{{Carbon\Carbon::parse($paid->paid_date)->format('Y-m-d')}}</li>
            <li class="list-group-item" id="paid_{{$val->id}}_{{$k}}" sell_paid_amount_id="{{$paid->id}}">{{$paid->paid}}</li>
          </ul>
          @endforeach
      </div>
    </tr>
    @endforeach
    @else
        
      <tr><td colspan="9">No record found</td></tr>
      
    @endif
    
  </tbody>
</table>
<div class="pull-right">
  @if(!empty($data['sell']))
  {{ $data['sell']->appends(\Request::except('page'))->render() }}
  @endif
</div>
<!-- Modal -->
<div class="modal fade" id="sellModal" tabindex="-1" role="dialog" aria-labelledby="sellModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sellModalLabel">Sell Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-body-scroll">
        
        <form>
          <div class="form-group row">
            <label for="supplier_name" class="col-sm-2 col-form-label">Party</label>

            <div class="col-sm-5">
              <div class="dropdown">
                <button id="myFunction" class="dropbtn">Choose Party <i class="fa fa-caret-down"></i></button>
                <div id="myDropdown" class="dropdown-content">
                  <!-- <i class="fa fa-search"></i> -->
                  <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
                  @foreach($data['supplier'] as $supplier)
                  <a class="supplier_option" option="{{$supplier->id}}" href="#">{{$supplier->name}}</a>
                  @endforeach
                  <a class="supplier_option" option="" href="#">Others</a>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="supplier_name" name="supplier_name" value="" placeholder="Party Name">
              <input type="hidden"  class="form-control" id="supplier_id" name="supplier_id" value="">
            </div>
          </div>
          @include('front.elements.sell_products',[
            $data
          ])
          <div class="product_html">
          </div>
          <div class="add_product_btn">
            <a class="btn btn-primary add_product" count="1" role="button" >
              Add more product
            </a>
          </div>
          <div class="calculate_price">
            Total Selling Price (₹): <span id="total_sp">0.00</span>
            Total Due (₹): <span id="total_due">0.00</span>
          </div>
          
          @include('front.elements.sell_paid_amount',[
            $data
          ])
          <div class="paid_amount_html">
          </div>
          <div class="add_product_btn">
            <a class="btn btn-primary add_paid_amount" count="1" role="button" >
              Add more paid amount
            </a>
          </div>
          <!-- <div class="form-group row">
            <label for="product_name" class="col-sm-2 col-form-label">Product</label>

            <div class="col-sm-5">
              <div class="dropdown">
                <button id="myFunction1" class="dropbtn">Product <i class="fa fa-caret-down"></i></button>
                <div id="myDropdown1" class="dropdown-content">
                  
                  <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction1()">
                  @foreach($data['stock'] as $stock)
                  <a class="stock_option" option="{{$stock->id}}" selling_price="{{$stock->selling_price}}" stock_quantity="{{$stock->quantity}}" href="#">{{$stock->name}}</a>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="product_name" name="name" value="" placeholder="Product Name">
              <input type="hidden"  class="form-control" id="stock_id" name="stock_id" value="">
            </div>
            
          </div>
          <div class="form-group row">
            <label for="product_name" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="selling_price" name="selling_price" value="" placeholder="Selling Price">
            </div>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled id="stock_quantity" value="" placeholder="Available Quantity" title="Available Quantity">
            </div>
          </div>
          <div class="form-group row">
            <label for="amount_received" class="col-sm-2 col-form-label">Quantity to sell</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="quantity" name="quantity" value="" placeholder="Quantity">
            </div>
          </div>
          <div class="form-group row">
            <label for="amount_received" class="col-sm-2 col-form-label">Amount Recieved(₹)</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="amount_received" name="amount_received" value="">
            </div>
          </div> -->
          <input type="hidden" class="form-control" id="sell_id" name="sell_id" >
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_sell_modal">Close</button>
        <button type="button" class="btn btn-primary" id="sell_submit">Add</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel"> Product Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-body-scroll" id="detailModalBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_detail_modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>
@stop