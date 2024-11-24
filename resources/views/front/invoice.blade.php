@extends('front/template')
@section('title', 'Bill')

@section('content')

@if(!$data['sell'])
{{dd("No Sold record Found!")}}
@endif
@if(!$data['user'])
<a href="{{route('user')}}">company details</a>
{{dd("Please add your company details!")}}
@endif
<div id="invoice">
    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            <!-- <button id="exportPDFInvoice" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button> -->
        </div>
        <hr>
    </div>







    <div class="invoice continer" style="width:1200px; margin: 0 auto; padding: 0 15px;font-family: sans-serif;">
    <div>
        @if($data['user'] && $data['user']->logo)
        <img src="{{$data['base_url'].'/'.$data['user']->logo}}" alt="logo" style="width: 150px; height: auto;margin-top: 20px;">
        @endif
        </div>
        <div style="text-align: end;">
        <h3 style="margin: 5px 0px;color:#404040;">{{$data['user']->name}}</h3>
        @if($data['user']->gst)<p style="margin: 5px 0px; color:#404040;">{{$data['user']->gst}}</p>@endif
        </div>
        <hr style="border: 1px solid #008e94;">
        <div>
        <p style="margin: 5px 0px;color:#404040;">INVOICE TO:</p>
            <h3 style="margin: 5px 0px;color:#404040;">{{$data['sell'] ? ($data['sell']->supplier ? $data['sell']->supplier->name : $data['sell']->supplier_name) : ''}}</h3>
            @if($data['sell']->supplier)<p style="margin: 5px 0px; color:#404040;">{{optional($data['sell']->supplier)->gst}}</p>@endif
        </div>
       
        <div style="text-align: end;">
        @if($data['sell']->id)<h3 style="margin: 5px 0px;color:#404040;" class="invoice-id">{{strtoupper(substr($data['user']->name, 0, 1)).'-'.$data['sell']->id}}</h3>@endif
        @if($data['sell']->created_at)
        @php
        $created_at_timestamp = strtotime($data['sell']->created_at);
        $created_at = date('F jS, Y', $created_at_timestamp);
        @endphp
        <p >Date of Invoice: {{$created_at}}</p>
        @endif
        </div>
        
        <div>
        <ul style="display: flex; width: 100%; padding:0px;background: #eee;color:#404040;margin: 0px; margin-bottom:1px; ">
            <li style="width: 100%; list-style: none; padding: 10px; font-size: 14px; font-weight: 600;">PRODUCT NAME</li>
            <li style="width: 100%; list-style: none;text-align: end; padding: 10px;font-size: 14px; font-weight: 600;">PRICE</li>
            <li style="width: 100%; list-style: none;text-align: end;padding: 10px;font-size: 14px; font-weight: 600;">QUANTITY</li>
            <li style="width: 100%; list-style: none;text-align: end;padding: 10px;font-size: 14px; font-weight: 600;">TOTAL PRICE</li>
            </ul>
        </div>
        <div>
        <ul style="display: flex; width: 100%; padding:0px; margin: 0px;">
            <li style="width: 100%; list-style: none; background:#ddd;padding: 10px;font-size: 13px;color: #313030;">{{$data['sell']->stock ? ($data['sell']->stock->product ? $data['sell']->stock->product->name : $data['sell']->stock->name) : $data['sell']->name}}</li>
            <li style="width: 100%; list-style: none;background: #eee;text-align: end;padding: 10px;font-size: 13px;color: #313030;border-bottom: 1px solid #3989c6;">₹{{$data['sell']->selling_price}}</li>
            <li style="width: 100%; list-style: none;background:#ddd;text-align:end;padding: 10px;font-size: 13px;color: #313030;border-bottom: 1px solid #3989c6;">{{$data['sell']->quantity}}</li>
            <li style="width: 100%; list-style: none;background:#3989c6;text-align: end;padding: 10px;font-size: 13px;color: #fff;border-bottom: 1px solid #3989c6;">₹{{$data['sell']->total_selling_price}} </li>
            </ul>
        </div>
        <div>
        <ul style="display: flex; width: 100%; padding:0px; margin: 0px;">
            <li style="list-style: none; width: 100%;"></li>
            <li style="list-style: none; width: 100%;"></li>
            <li style="width: 100%; list-style: none;text-align:end;padding: 10px;font-size: 16px;color: #1c69a5;">Amount Recieved</li>
            <li style="width: 100%; list-style: none;text-align: end;padding: 10px;font-size: 16px;color: #1c69a5;">₹{{$data['sell']->amount_received}} </li>
            </ul>
        </div>
        <br>
        <h2>Thank You!</h2>
        <br>
        <br>
        <div>
        <hr>
            
            <p style="text-align: center; color: #868686; font-size: 14px;">Invoice was created on a computer and is valid without the signature and seal</p>
        </div>
        
    </div>


    









    


    
</div>
@stop