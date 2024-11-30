<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('front/assets/js/jquery-3.2.1.slim.min.js')}}" ></script>
    <script src="{{asset('front/assets/js/jquery-3.7.1.min.js')}}"  ></script>
    <script src="{{asset('front/assets/js/popper.min.js')}}" ></script>
    <script src="{{asset('front/assets/js/bootstrap.min.js')}}" ></script>
    <script src="{{asset('front/assets/js/bootstrap-datepicker.min.js')}}" ></script>
    <script src="{{asset('front/assets/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('front/assets/js/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/cropper/cropbox-min.js') }}"></script>
    <script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="ts"]').attr('content')
        }
      })
      var add_supplier = "{{route('add-supplier')}}"
      var edit_supplier = "{{route('edit-supplier')}}"
      var delete_supplier = "{{route('delete-supplier')}}"
      var add_product = "{{route('add-product')}}"
      var edit_product = "{{route('edit-product')}}"
      var delete_product = "{{route('delete-product')}}"
      var add_buy = "{{route('add-buy')}}"
      var edit_buy = "{{route('edit-buy')}}"
      var delete_buy = "{{route('delete-buy')}}"
      var add_buy_product_url = "{{route('add-buy-product')}}"
      var add_buy_paid_amount_url = "{{route('add-buy-paid-amount')}}"
      var edit_stock = "{{route('edit-stock')}}"
      var delete_stock = "{{route('delete-stock')}}"
      var add_sell = "{{route('add-sell')}}"
      var edit_sell = "{{route('edit-sell')}}"
      var delete_sell = "{{route('delete-sell')}}"
    </script>
    @if($data['index'] == 'Supplier') <script src="{{ asset('front/js/supplier.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Product') <script src="{{ asset('front/js/product.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Buy') <script src="{{ asset('front/js/buy.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Stock') <script src="{{ asset('front/js/stock.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Sell') <script src="{{ asset('front/js/sell.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Invoice') <script src="{{ asset('front/js/invoice.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'User') <script src="{{ asset('front/js/user.js') }}?v={{time()}}"></script> @endif
  </body>
</html>