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






    <div  class="invoice continer" style="margin:60px 198px">

    <style type="text/css">
      * {
        margin: 0;
        padding: 0;
        text-indent: 0;
      }

      .s1 {
        color: #110572;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 20pt;
      }

      .s2 {
        color: #110572;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 10pt;
      }

      .s3 {
        color: #110572;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 9pt;
      }

      .s4 {
        color: #110572;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
      }

      .s5 {
        color: #110572;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
      }

      .s6 {
        color: #110572;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 12pt;
      }

      .s7 {
        color: #110572;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
      }

      .s8 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 10pt;
      }

      .s9 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 10pt;
        vertical-align: -2pt;
      }

      .s10 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 8pt;
      }

      .s11 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 9pt;
      }

      .s12 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 10pt;
      }

      .s13 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 9pt;
      }

      .s14 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 6pt;
      }

      .s15 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 7pt;
      }

      .s16 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
      }

      .s17 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 6pt;
      }

      .s18 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 7pt;
      }

      .s19 {
        color: black;
        font-family: "Arial Narrow", sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 7pt;
      }

      .s20 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 9pt;
      }

      .s21 {
        color: black;
        font-family: Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 9pt;
      }

      .s22 {
        color: black;
        font-family: "Arial Narrow", sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
      }

      .s23 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: italic;
        font-weight: bold;
        text-decoration: underline;
        font-size: 10pt;
      }

      .s24 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 7pt;
      }

      h1 {
        color: #E5E5E5;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 30pt;
      }

      p {
        color: black;
        font-family: Arial, sans-serif;
        font-style: italic;
        font-weight: normal;
        text-decoration: none;
        font-size: 7pt;
        margin: 0pt;
      }

      /* table,
      tbody {
        vertical-align: top;
        overflow: visible;
      } */
    </style>

    <table id="invoice_print" style="border-collapse:collapse;margin-left:6.125pt;width:100%;" cellspacing="0">
      <tr style="height:101pt">
        <td style="width:100%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="10">
          <p class="s1" style="padding-right: 12pt;text-indent: 0pt;text-align: center;">{{strtoupper($data['user']->name)}}</p>
          @if($data['user']->address)
          <p class="s2" style="padding-top: 11pt;padding-left: 4pt;padding-right: 12pt;text-indent: 0pt;line-height: 11pt;text-align: center;">{{$data['user']->address}}</p>
          <!-- <p class="s3" style="padding-left: 3pt;padding-right: 12pt;text-indent: 0pt;line-height: 10pt;text-align: center;"></p> -->
          @endif
          @if($data['user']->phone_no)
          <p class="s4" style="padding-top: 8pt;padding-left: 7pt;padding-right: 12pt;text-indent: 0pt;line-height: 9pt;text-align: center;">Phone : {{$data['user']->phone_no}}</p>
          @endif
          <!-- <p style="padding-left: 6pt;padding-right: 12pt;text-indent: 0pt;line-height: 9pt;text-align: center;">
            <a href="mailto:mansk26@gmail.com" class="s5" target="_blank">E-Mail : mansk26@gmail.com</a>
          </p> -->
          <p class="s6" style="padding-left: 5pt;padding-right: 12pt;text-indent: 0pt;text-align: center;">GST INVOICE</p>
        </td>
      </tr>
      <tr style="height:13pt">
        <td style="width:563pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="10">
          <p class="s7" style="padding-top: 1pt;padding-left: 6pt;padding-right: 12pt;text-indent: 0pt;text-align: center;">GSTIN : {{$data['user']->gst}}</p>
        </td>
      </tr>
      <tr style="height:12pt">
        <td style="width:281pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt" colspan="2">
          <p class="s8" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">{{$data['sell']->supplier ? $data['sell']->supplier->name : $data['sell']->supplier_name}}</p>
        </td>
        <td style="width:38pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" rowspan="4">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:30pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" rowspan="4">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:214pt;border-top-style:solid;border-top-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="6">
          @php
          $string = $data['user']->name;
          preg_match_all('/\b\w/', $string, $matches);
          $cmpfirstLetters = implode('', $matches[0]);
          $firstGstChar = substr($data['user']->gst, 0, 3);
          @endphp
          <p class="s9" style="padding-left: 9pt;text-indent: 0pt;line-height: 10pt;text-align: left;">Invoice No. : <span class="s10">{{strtoupper($cmpfirstLetters)}}-{{$firstGstChar}}/{{sprintf('%04u', $data['sell']->id)}} </span>
            
          </p>
        </td>
      </tr>
      <tr style="height:11pt">
        <td style="width:281pt;border-left-style:solid;border-left-width:1pt" colspan="2">
          <p class="s11" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;"> @if($data['sell']->supplier && $data['sell']->supplier->address){{$data['sell']->supplier->address}}@endif</p>
        </td>
        <td style="width:57pt" colspan="2">
          <p class="s12" style="padding-left: 9pt;text-indent: 0pt;line-height: 10pt;text-align: left;"></p>
        </td>
        <td style="width:23pt">
          <p class="s12" style="padding-left: 4pt;text-indent: 0pt;line-height: 10pt;text-align: left;"></p>
        </td>
        <td style="width:29pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:24pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:27pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:54pt;border-right-style:solid;border-right-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
      </tr>
      <tr style="height:37pt">
        <td style="width:281pt;border-left-style:solid;border-left-width:1pt" colspan="2">
          <p class="s11" style="padding-left: 7pt;padding-right: 164pt;text-indent: -2pt;line-height: 94%;text-align: left;"></p>
          <p class="s11" style="padding-left: 5pt;text-indent: 0pt;line-height: 9pt;text-align: left;">@if($data['sell']->supplier && $data['sell']->supplier->phone_no)PH.NO.: {{$data['sell']->supplier->phone_no}}@endif</p>
        </td>
        <td style="width:57pt" colspan="2">
          <p class="s12" style="padding-left: 8pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Date : <span> {{$data['sell']->created_at->format('d/m/Y')}}</span></p>
          <p class="s12" style="padding-left: 8pt;padding-right: 6pt;text-indent: 0pt;text-align: left;"></p>
        </td>
        <td style="width:23pt">
          <p class="s12" style="padding-left: 4pt;text-indent: 0pt;line-height: 11pt;text-align: left;"></p>
          <p class="s12" style="padding-left: 4pt;text-indent: 0pt;line-height: 11pt;text-align: left;"></p>
          <p class="s12" style="padding-left: 4pt;text-indent: 0pt;line-height: 11pt;text-align: left;"></p>
        </td>
        <td style="width:29pt">
          <p class="s12" style="padding-top: 10pt;padding-left: 3pt;text-indent: 0pt;text-align: left;"></p>
        </td>
        <td style="width:24pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:27pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:54pt;border-right-style:solid;border-right-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
      </tr>
      <tr style="height:16pt">
        <td style="width:281pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" colspan="2">
          <p class="s11" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">@if($data['sell']->supplier && $data['sell']->supplier->gst)GSTIN : {{$data['sell']->supplier->gst}}@endif</p>
        </td>
        <td style="width:214pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="6">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
      </tr>
      <tr style="height:13pt">
        <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s13" style="padding-left: 3pt;text-indent: 0pt;line-height: 11pt;text-align: left;">SN</p>
        </td>
        <td style="width:264pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s13" style="padding-left: 12pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Product</p>
        </td>
        <td style="width:38pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s13" style="padding-left: 6pt;text-indent: 0pt;line-height: 11pt;text-align: left;">HSN</p>
        </td>
        <td style="width:30pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s13" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">QTY</p>
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s13" style="padding-left: 11pt;text-indent: 0pt;line-height: 11pt;text-align: left;">MRP</p>
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s13" style="padding-left: 11pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Rate</p>
        </td>
        <td style="width:29pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s13" style="padding-left: 4pt;text-indent: 0pt;line-height: 11pt;text-align: left;">DIS</p>
        </td>
        <td style="width:24pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s14" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">SGST</p>
        </td>
        <td style="width:27pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p class="s14" style="padding-left: 4pt;text-indent: 0pt;text-align: left;">CGST</p>
        </td>
        <td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#C1F9FC">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
      </tr>
      
      <tr style="height:348pt">
        <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
          @foreach($data['sell']->products as $key => $prd)
          <p class="s15" style="padding-top: 1pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">{{++$key}}.</p>
          @endforeach
          <!-- <p class="s15" style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">2.</p> -->
        </td>
        <td style="width:264pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
        @foreach($data['sell']->products as $key => $prd)
          <p class="s16" style="padding-top: 1pt;padding-left: 10pt;text-indent: 0pt;text-align: left;">{{$prd->stock ? ($prd->stock->product ? $prd->stock->product->name : $prd->stock->name) : $prd->name}}</p>
        @endforeach
          <!-- <p class="s16" style="padding-left: 10pt;text-indent: 0pt;text-align: left;">4&quot; GRINDING WHEEL</p> -->
        </td>
        <td style="width:38pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
        @foreach($data['sell']->products as $key => $prd)
          <p class="s15" style="padding-top: 1pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">{{$prd->stock ? ($prd->stock->product ? $prd->stock->product->hsn : '') : ''}}</p>
          @endforeach
          <!-- <p style="text-indent: 0pt;text-align: left;" />
          <p class="s15" style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">8204</p> -->
        </td>
        <td style="width:30pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
        @foreach($data['sell']->products as $key => $prd)
          <p class="s15" style="padding-top: 1pt;padding-left: 11pt;text-indent: 0pt;text-align: left;">{{$prd->quantity}}</p>
          @endforeach
          <!-- <p class="s15" style="padding-top: 2pt;padding-left: 13pt;text-indent: 0pt;text-align: left;">25</p> -->
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
        @foreach($data['sell']->products as $key => $prd)
          <p class="s17" style="padding-top: 1pt;padding-left: 16pt;text-indent: 0pt;text-align: left;">0.00</p>
          @endforeach
          <!-- <p class="s17" style="padding-top: 3pt;padding-left: 16pt;text-indent: 0pt;text-align: left;">0.00</p> -->
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
        @foreach($data['sell']->products as $key => $prd)
          <p class="s17" style="padding-top: 1pt;padding-left: 20pt;text-indent: 0pt;text-align: left;">{{$prd->selling_price}}</p>
          @endforeach
          <!-- <p class="s17" style="padding-top: 3pt;padding-left: 16pt;text-indent: 0pt;text-align: left;">21.18</p> -->
        </td>
        <td style="width:29pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
        @foreach($data['sell']->products as $key => $prd)
          <p class="s18" style="padding-top: 1pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">0.00</p>
          @endforeach
          <!-- <p class="s18" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">0.00</p> -->
        </td>
        <td style="width:24pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
          <!-- <p class="s18" style="padding-top: 1pt;padding-left: 3pt;text-indent: 0pt;text-align: left;">9.00</p>
          <p class="s18" style="padding-top: 2pt;padding-left: 3pt;text-indent: 0pt;text-align: left;">9.00</p> -->
        </td>
        <td style="width:27pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
          <!-- <p class="s18" style="padding-top: 1pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">9.00</p>
          <p class="s18" style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">9.00</p> -->
        </td>
        <td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
        @foreach($data['sell']->products as $key => $prd)
          <p class="s18" style="padding-top: 1pt;padding-left: 18pt;text-indent: 0pt;text-align: left;">{{number_format((float)((int)$prd->quantity * (float)$prd->selling_price), 2, '.', '')}}</p>
          @endforeach
          <!-- <p class="s18" style="padding-top: 2pt;padding-left: 23pt;text-indent: 0pt;text-align: left;">529.50</p> -->
        </td>
      </tr>
      <tr style="height:10pt">
        <td style="width:281pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt" colspan="2">
          <p class="s19" style="padding-left: 5pt;text-indent: 0pt;line-height: 8pt;text-align: left;"></p>
        </td>
        <td style="width:38pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" rowspan="2">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:30pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" rowspan="2">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" rowspan="2">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:93pt;border-top-style:solid;border-top-width:1pt" colspan="3">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:27pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" rowspan="2">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-right-style:solid;border-right-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
      </tr>
      <tr style="height:54pt">
        <td style="width:281pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" colspan="2">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:93pt;border-bottom-style:solid;border-bottom-width:1pt" colspan="3">
          <p class="s20" style="padding-left: 14pt;text-indent: 0pt;text-align: left;">SUB TOTAL</p>
          <p class="s11" style="padding-left: 14pt;text-indent: 0pt;text-align: left;"></p>
          <p class="s11" style="padding-left: 14pt;text-indent: 0pt;text-align: left;"></p>
          <p class="s11" style="padding-left: 14pt;text-indent: 0pt;text-align: left;"></p>
          <p class="s8" style="padding-left: 14pt;text-indent: 0pt;line-height: 10pt;text-align: left;"></p>
        </td>
        <td style="width:54pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
          <p class="s13" style="padding-right: 9pt;text-indent: 0pt;line-height: 11pt;text-align: right;">{{$data['sell']->total_selling_price}}</p>
          <p class="s21" style="padding-right: 9pt;text-indent: 0pt;line-height: 11pt;text-align: right;"></p>
          <p class="s21" style="padding-right: 9pt;text-indent: 0pt;line-height: 11pt;text-align: right;"></p>
          <p class="s21" style="padding-right: 9pt;text-indent: 0pt;line-height: 10pt;text-align: right;"></p>
          <p class="s8" style="padding-left: 25pt;text-indent: 0pt;line-height: 10pt;text-align: left;"></p>
        </td>
      </tr>
      <tr style="height:14pt">
        <td style="width:281pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" colspan="2">
          <!-- <p class="s22" style="padding-top: 1pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Rs. Three Thousand Three Only</p> -->
        </td>
        <td style="width:38pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:30pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:93pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" colspan="3">
          <p class="s8" style="padding-top: 1pt;padding-left: 14pt;text-indent: 0pt;line-height: 11pt;text-align: left;">GRAND TOTAL</p>
        </td>
        <td style="width:27pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
          <p class="s8" style="padding-top: 1pt;padding-left: 8pt;text-indent: 0pt;line-height: 11pt;text-align: left;">{{$data['sell']->total_selling_price}}</p>
        </td>
      </tr>
      <tr style="height:128pt">
        <td style="width:281pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" colspan="2">
          <p class="s23" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Terms &amp; Conditions&nbsp;&nbsp;</p>
          <p class="s16" style="padding-left: 5pt;padding-right: 45pt;text-indent: 0pt;line-height: 108%;text-align: left;">Goods once sold will not be taken back or exchanged. Bills not paid due date will attract 24% interest.</p>
          <p class="s16" style="padding-left: 5pt;padding-right: 45pt;text-indent: 0pt;line-height: 108%;text-align: left;">All disputes subject to Muzaffarpur Jurisdiction only. Prescribed Sales Tax declaration will be given.</p>
        </td>
        <td style="width:38pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:30pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
        </td>
        <td style="width:214pt;border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="6">
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
          <p class="s24" style="padding-left: 2pt;text-indent: 0pt;text-align: left;">For {{strtoupper($data['user']->name)}}</p>
          <p style="text-indent: 0pt;text-align: left;">
            <br />
          </p>
          <p class="s10" style="padding-left: 62pt;text-indent: 0pt;text-align: left;">Authorised signatory</p>
        </td>
      </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;">
      <br />
    </p>

    
    </div> 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <!-- <div class="invoice continer" style="width:1200px; margin: 0 auto; padding: 0 15px;font-family: sans-serif;">
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
        </div> -->
        
</div>


    









    


    
</div>
@stop