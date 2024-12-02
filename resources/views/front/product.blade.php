@extends('front/template')
@section('title', 'Product')

@section('content')
<div class="container">

<div class="table-header">
  <div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal" id="add_product">
    Add Product
    </button>
  </div>
  <div>
    @if(count($data['product']) > 0)                    
        Showing <span>{{$data['product']->firstItem()}} to {{$data['product']->lastItem()}} of {{$data['product']->total()}}</span> Product
    @endif
  </div>
</div>


<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse  " >
    
    {!! Form::open(array('route' => ['product_list'],'method' => 'post','name'=>'srchFrm','id'=>'srchFrm','role'=>'form','class'=>'form-inline my-2 my-lg-0')) !!}
    {!! Form::text('skey',$data['skey'], array('placeholder'=>'Search','class'=>'form-control mr-sm-2','autocomplete'=>'off')) !!}
    {!! Form::submit('Search', array('class' => 'btn btn-outline-success my-2 mr-sm-2 my-sm-0')) !!}
    {!! Form::close() !!}
    
    <a href="{{ route('product_list') }}">
    <button class="btn btn-outline-danger" >Reset</button>
    </a>
  </div>
  
</nav>


<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">@sortablelink('supplier_name', 'Party Name')</th>
      <th scope="col">@sortablelink('name' ,'Product Name')</th>
      <th scope="col">Price (₹)</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @if(count($data['product']) > 0)   
  @foreach ($data['product'] as $key => $val)
    <tr>
      <th scope="row">{{++$key}}</th>
      <td id="supplier_name_{{$val->id}}" supplier_id="{{$val->supplier_id}}">{{$val->supplier ? $val->supplier->name : $val->supplier_name}}</td>
      <td id="product_name_{{$val->id}}">{{$val->name}}</td>
      <td id="price_{{$val->id}}">{{$val->price}}</td>
      <td>
        <a class="link-color1 edit_product" product-id="{{$val->id}}" href="" title="Edit product" >
        <i class="fa fa-edit" aria-hidden="true" title="Edit" alt="Edit"></i>
        </a>&nbsp;     
        <a class="link-color1 delete_product" product-id="{{$val->id}}" href=""  title="Delete product">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>               
      </td>
    </tr>
    @endforeach
    @else
        
      <tr><td colspan="5">No record found</td></tr>
      
    @endif
    
  </tbody>
</table>
<div class="pull-right">
  @if(!empty($data['product']))
  {{ $data['product']->appends(\Request::except('page'))->render() }}
  @endif
</div>
<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form>
          <div class="form-group row">
            <label for="supplier_name" class="col-sm-2 col-form-label">Party Name</label>

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
              <input type="text" disabled class="form-control" id="supplier_name" name="supplier_name" value="">
              <input type="hidden"  class="form-control" id="supplier_id" name="supplier_id" value="">
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Product Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" value="">
            </div>
          </div>
          <div class="form-group row">
            <label for="price" class="col-sm-2 col-form-label">Price(₹)</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="price" name="price" >
            </div>
          </div>
          <input type="hidden" class="form-control" id="product_id" name="product_id" >
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_product_modal">Close</button>
        <button type="button" class="btn btn-primary" id="product_submit">Add</button>
      </div>
    </div>
  </div>
</div>

</div>
@stop