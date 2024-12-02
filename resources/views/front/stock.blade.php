@extends('front/template')
@section('title', 'Stock')

@section('content')
<div class="container-fluid">

<div class="table-header">
  <div>
    
  </div>
  <div>
    @if(count($data['stock']) > 0)                    
        Showing <span>{{$data['stock']->firstItem()}} to {{$data['stock']->lastItem()}} of {{$data['stock']->total()}}</span> Stocks
    @endif
  </div>
</div>


<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse  " >
    
    {!! Form::open(array('route' => ['stock_list'],'method' => 'post','name'=>'srchFrm','id'=>'srchFrm','role'=>'form','class'=>'form-inline my-2 my-lg-0')) !!}
    {!! Form::text('skey',$data['skey'], array('placeholder'=>'Search','class'=>'form-control mr-sm-2','autocomplete'=>'off')) !!}
    {!! Form::submit('Search', array('class' => 'btn btn-outline-success my-2 mr-sm-2 my-sm-0')) !!}
    {!! Form::close() !!}
    
    <a href="{{ route('stock_list') }}">
    <button class="btn btn-outline-danger" >Reset</button>
    </a>
  </div>
  
</nav>


<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">@sortablelink('name' ,'Product Name')</th>
      <th scope="col">Cost Price (₹)</th>
      <th scope="col">quantity</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @if(count($data['stock']) > 0)   
  @foreach ($data['stock'] as $key => $val)
    <tr>
      <th scope="row">{{++$key}}</th>
      <td id="product_name_{{$val->id}}" product_id="{{$val->product_id}}">{{$val->product ? $val->product->name : $val->name}}</td>
      <td id="cost_price_{{$val->id}}">{{$val->cost_price}}</td>
      <td id="quantity_{{$val->id}}">{{$val->quantity}}</td>
      <td>
        <!-- <a class="link-color1 edit_stock" stock-id="{{$val->id}}" href="" title="Edit Stock" >
        <i class="fa fa-edit" aria-hidden="true" title="Edit" alt="Edit"></i>
        </a>&nbsp;      -->
        <a class="link-color1 delete_stock" stock-id="{{$val->id}}" href=""  title="Delete Stock">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>               
      </td>
    </tr>
    @endforeach
    @else
        
      <tr><td colspan="6">No record found</td></tr>
      
    @endif
    
  </tbody>
</table>
<div class="pull-right">
  @if(!empty($data['stock']))
  {{ $data['stock']->appends(\Request::except('page'))->render() }}
  @endif
</div>
<!-- Modal -->
<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="stockModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="stockModalLabel">Edit Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Product</label>

            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="product_name" name="name" value="" placeholder="Product Name">
              <input type="hidden"  class="form-control" id="product_id" name="product_id" value="">
            </div>
            
          </div>
          <div class="form-group row">
          <label for="cost_price" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="cost_price" name="cost_price" value="" placeholder="Cost Price">
            </div>
            <div class="col-sm-5">
              <input type="text" disabled class="form-control" id="quantity" name="quantity" value="" placeholder="Quantity">
            </div>
          </div>
          <input type="hidden" class="form-control" id="stock_id" name="stock_id" >
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_stock_modal">Close</button>
        <button type="button" class="btn btn-primary" id="stock_submit">Edit</button>
      </div>
    </div>
  </div>
</div>

</div>
@stop