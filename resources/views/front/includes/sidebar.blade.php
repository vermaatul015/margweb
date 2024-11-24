<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{route('supplier_list')}}">MARGWEB</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item {{$data['index'] == 'Supplier' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('supplier_list')}}">Supplier <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item {{$data['index'] == 'Product' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('product_list')}}">Product</a>
      </li>
      <li class="nav-item {{$data['index'] == 'Buy' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('buy_list')}}">Buy</a>
      </li>
      <li class="nav-item {{$data['index'] == 'Stock' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('stock_list')}}">My Stocks</a>
      </li>
      <li class="nav-item {{$data['index'] == 'Sell' ? 'active' : ''}}">
        <a class="nav-link" href="#">Sell</a>
      </li>
      
    </ul>
  </div>
</nav>