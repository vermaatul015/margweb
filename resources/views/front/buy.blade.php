@extends('front/template')
@section('title', 'Buy')

@section('content')
<div class="container-fluid">

<div class="table-header">
  <div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buyModal" id="add_buy">
    Buy Product
    </button>
  </div>
  <div>
    @if(count($data['buy']) > 0)                    
        Showing <span>{{$data['buy']->firstItem()}} to {{$data['buy']->lastItem()}} of {{$data['buy']->total()}}</span> products bought
    @endif
  </div>
</div>


<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse  " >
    
    {!! Form::open(array('route' => ['buy_list'],'method' => 'post','name'=>'srchFrm','id'=>'srchFrm','role'=>'form','class'=>'form-inline my-2 my-lg-0')) !!}
    {!! Form::text('skey',$data['skey'], array('placeholder'=>'Search','class'=>'form-control mr-sm-2','autocomplete'=>'off')) !!}
    {!! Form::submit('Search', array('class' => 'btn btn-outline-success my-2 mr-sm-2 my-sm-0')) !!}
    {!! Form::close() !!}
    
    <a href="{{ route('buy_list') }}">
    <button class="btn btn-outline-danger" >Reset</button>
    </a>
  </div>
  
</nav>


<table class="table">
  <thead>
    <tr>
      <th scope="col">@sortablelink('created_at','Bought Date Time')</th>
      <th scope="col">@sortablelink('supplier_name', 'Supplier Name')</th>
      <th scope="col">@sortablelink('name' ,'Product Name')</th>
      <th scope="col">Cost Price (₹)</th>
      <th scope="col">quantity</th>
      <th scope="col">Total Cost Price (₹)</th>
      <th scope="col">Paid Amount (₹)</th>
      <th scope="col">@sortablelink('name' ,'Due Amount (₹)')</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @if(count($data['buy']) > 0)   
  @foreach ($data['buy'] as $key => $val)
    <tr>
      <th scope="row">{{$val->created_at->format('M jS,y h:i a')}}</th>
      <td id="supplier_name_{{$val->id}}" supplier_id="{{$val->supplier_id}}">{{$val->supplier ? $val->supplier->name : $val->supplier_name}}</td>
      <td id="product_name_{{$val->id}}" product_id="{{$val->product_id}}">{{$val->product ? $val->product->name : $val->name}}</td>
      <td id="cost_price_{{$val->id}}">{{$val->cost_price}}</td>
      <td id="quantity_{{$val->id}}">{{$val->quantity}}</td>
      <td id="total_cost_price_{{$val->id}}">{{$val->total_cost_price}}</td>
      <td id="paid_{{$val->id}}">{{$val->paid}}</td>
      <td id="due_{{$val->id}}" class="{{$val->due > 0 ? 'alert-danger' : 'alert-success'}}">{{$val->due}}</td>
      <td>
        <a class="link-color1 edit_buy" buy-id="{{$val->id}}" href="" title="Edit bought product" >
        <i class="fa fa-edit" aria-hidden="true" title="Edit" alt="Edit"></i>
        </a>&nbsp;     
        <a class="link-color1 delete_buy" buy-id="{{$val->id}}" href=""  title="Delete bought product">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>               
      </td>
    </tr>
    @endforeach
    @else
        
      <tr><td colspan="9">No record found</td></tr>
      
    @endif
    
  </tbody>
</table>
<div class="pull-right">
  @if(!empty($data['buy']))
  {{ $data['buy']->appends(\Request::except('page'))->render() }}
  @endif
</div>
<!-- Modal -->
<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="buyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="buyModalLabel">Buy Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form>
          <div class="form-group row">
            <label for="supplier_name" class="col-sm-2 col-form-label">Supplier</label>

            <div class="col-sm-5">
              <div class="dropdown">
                <button id="myFunction" class="dropbtn">Choose Supplier <i class="fa fa-caret-down"></i></button>
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
              <input type="text" disabled class="form-control" id="supplier_name" name="supplier_name" value="" placeholder="Supplier Name">
              <input type="hidden"  class="form-control" id="supplier_id" name="supplier_id" value="">
            </div>
          </div>
          <div class="form-group row">
            <label for="product_name" class="col-sm-2 col-form-label">Product</label>

            <div class="col-sm-5">
              <div class="dropdown">
                <button id="myFunction1" class="dropbtn">Product <i class="fa fa-caret-down"></i></button>
                <div id="myDropdown1" class="dropdown-content">
                  <!-- <i class="fa fa-search"></i> -->
                  <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction1()">
                  @foreach($data['product'] as $product)
                  <a class="product_option" option="{{$product->id}}" cost_price="{{$product->price}}" href="#">{{$product->name}}</a>
                  @endforeach
                  <!-- <a class="product_option" option="" href="#">Others</a> -->
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="product_name" name="product_name" value="" placeholder="Product Name">
              <input type="hidden"  class="form-control" id="product_id" name="product_id" value="">
            </div>
            
          </div>
          <div class="form-group row">
          <label for="product_name" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="product_price" name="cost_price" value="" placeholder="Cost Price">
            </div>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="quantity" name="quantity" value="" placeholder="Quantity">
            </div>
          </div>
          <div class="form-group row">
            <label for="paid" class="col-sm-2 col-form-label">Paid Amount(₹)</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="paid" name="paid" value="">
            </div>
          </div>
          <input type="hidden" class="form-control" id="buy_id" name="buy_id" >
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_buy_modal">Close</button>
        <button type="button" class="btn btn-primary" id="buy_submit">Add</button>
      </div>
    </div>
  </div>
</div>

</div>
@stop