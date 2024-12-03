@extends('front/template')
@section('title', 'User')

@section('content')
<div class="container-fluid">

    <div class="table-header">
        <div>
            <h1>
             My Company
            </h1>
        </div>
    </div>

    
    @include('front/includes/flash_message')
        

    <form action="{{route('user_details_update')}}" name="userDetailForm" id="userDetailForm" role='form' method="post" enctype="multipart/form-data">
    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Company Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{$data['user'] ? $data['user']->name : ''}}" placeholder="Company Name">
            </div>
        </div>
        <div class="form-group row">
            <label for="gst" class="col-sm-2 col-form-label">GST</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="gst" name="gst" value="{{$data['user'] ? $data['user']->gst : ''}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="phone_no" class="col-sm-2 col-form-label">Phone No</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="phone_no" name="phone_no" value="{{$data['user'] ? $data['user']->phone_no : ''}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="address" name="address" value="{{$data['user'] ? $data['user']->address : ''}}">
            </div>
        </div>
<!--
        @if($data['user'] && $data['user']->logo)
        <div class="form-group row">
            <label for="gst" class="col-sm-2 col-form-label">Logo </label>                   
            <div class="col-sm-10">
                <img class="img-responsive image-border" src="{{ $data['base_url'].$data['user']->logo }}" alt="Photo" width="160">
                @php $deleteConfirmMsg = 'Are you sure?' @endphp
                <a class="link-color1" onclick="return confirm('{{$deleteConfirmMsg}}')" title="Delete" href="{{ \URL::route('user_logo_delete') }}">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a> 
            </div>
        </div>
        @else

        <div class="form-group row">
            <label for="gst" class="col-sm-2 col-form-label">Logo </label>                   
            <div class="col-lg-3 col-xs-12">
                {{ Form::file('logo', array('class' => 'form-control','id' => 'logo')) }}
                {{ Form::hidden('logo_base64', '', array('id' => 'logo_base64')) }}
                <div id="user-logo-filecheck" class="error-text" style="display:none;color: red;"></div>
                </div>
                <div class="col-lg-6 text-center user-cropper" style="display:none">

                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <label>Crop Logo</label>
                            <div class="resize_userLogoBox_holder">
                                <div class="imageBox userLogoBox" id="userLogoBox" style="display:none">
                                    <div class="thumbBox" style="width: 82px;height: 82px;"></div>
                                </div>
                            </div>
                        
                        <div class="action crop-action">
                            <div id="user_crop_btn" style="display:none">
                                <input type="button" class="btn-default" id="userBtnCrop" value="Crop" style="float: right">
                                <input type="button" class="btn-default" id="userBtnZoomIn" value="+" style="float: right">
                                <input type="button" class="btn-default" id="userBtnZoomOut" value="-" style="float: right">
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <label>Final Preview</label>
                        <div class="cropped banner_cropped_image" id="user_logo_preview"></div>
                    </div>
                </div>
            </div>
        </div>
        
        @endif
-->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@stop