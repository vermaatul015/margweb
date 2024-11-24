<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('front/assets/js/jquery-3.2.1.slim.min.js')}}" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="{{asset('front/assets/js/jquery-3.7.1.min.js')}}"  crossorigin="anonymous"></script>
    <script src="{{asset('front/assets/js/popper.min.js')}}" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="{{asset('front/assets/js/bootstrap.min.js')}}" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{asset('front/assets/js/sweetalert.min.js')}}"></script>
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
      var edit_stock = "{{route('edit-stock')}}"
      var delete_stock = "{{route('delete-stock')}}"
    </script>
    @if($data['index'] == 'Supplier') <script src="{{ asset('front/js/supplier.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Product') <script src="{{ asset('front/js/product.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Buy') <script src="{{ asset('front/js/buy.js') }}?v={{time()}}"></script> @endif
    @if($data['index'] == 'Stock') <script src="{{ asset('front/js/stock.js') }}?v={{time()}}"></script> @endif
  </body>
</html>