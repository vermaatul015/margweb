@extends('front/template')
@section('title', 'Party')

@section('content')
<div class="container">
  
<div class="table-header">
  <div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#supplierModal" id="add_supplier">
    Add Party
    </button>
  </div>
  <div>
    @if(count($data['supplier']) > 0)                    
        Showing <span>{{$data['supplier']->firstItem()}} to {{$data['supplier']->lastItem()}} of {{$data['supplier']->total()}}</span> Party
    @endif
  </div>
</div>


<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse  " >
    
    {!! Form::open(array('route' => ['supplier_list'],'method' => 'post','name'=>'srchFrm','id'=>'srchFrm','role'=>'form','class'=>'form-inline my-2 my-lg-0')) !!}
    {!! Form::text('skey',$data['skey'], array('placeholder'=>'Search','class'=>'form-control mr-sm-2','autocomplete'=>'off')) !!}
    {!! Form::submit('Search', array('class' => 'btn btn-outline-success my-2 mr-sm-2 my-sm-0')) !!}
    {!! Form::close() !!}
    
    <a href="{{ route('supplier_list') }}">
    <button class="btn btn-outline-danger" >Reset</button>
    </a>
  </div>
  
</nav>


<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">@sortablelink('name')</th>
      <th scope="col">@sortablelink('gst')</th>
      <th scope="col">Phone No</th>
      <th scope="col">Address</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @if(count($data['supplier']) > 0)   
  @foreach ($data['supplier'] as $key => $val)
    <tr>
      <th scope="row">{{++$key}}</th>
      <td id="supplier_name_{{$val->id}}">{{$val->name}}</td>
      <td id="gst_{{$val->id}}">{{$val->gst}}</td>
      <td id="phone_no_{{$val->id}}">{{$val->phone_no}}</td>
      <td id="address_{{$val->id}}">{{$val->address}}</td>
      <td>
        <a class="link-color1 edit_supplier" supplier-id="{{$val->id}}" href="" title="Edit Party" >
        <i class="fa fa-edit" aria-hidden="true" title="Edit" alt="Edit"></i>
        </a>&nbsp;     
        <a class="link-color1 delete_supplier" supplier-id="{{$val->id}}" href=""  title="Delete Party">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>               
      </td>
    </tr>
    @endforeach
    @else
        
      <tr><td colspan="4">No record found</td></tr>
      
    @endif
    
  </tbody>
</table>
<div class="pull-right">
  @if(!empty($data['supplier']))
  {{ $data['supplier']->appends(\Request::except('page'))->render() }}
  @endif
</div>
<!-- Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="supplierModalLabel">Add Party</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Party Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" value="">
            </div>
          </div>
          <div class="form-group row">
            <label for="gst" class="col-sm-2 col-form-label">GST</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="gst" name="gst" >
            </div>
          </div>
          <div class="form-group row">
            <label for="phone_no" class="col-sm-2 col-form-label">Phone No</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="phone_no" name="phone_no" >
            </div>
          </div>
          <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="address" name="address" >
            </div>
          </div>
          <input type="hidden" class="form-control" id="supplier_id" name="supplier_id" >
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_supplier_modal">Close</button>
        <button type="button" class="btn btn-primary" id="supplier_submit">Add</button>
      </div>
    </div>
  </div>
</div>

</div>
@stop