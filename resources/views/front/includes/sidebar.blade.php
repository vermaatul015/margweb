<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{route('supplier_list')}}">MARGWEB</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item {{$data['index'] == 'Supplier' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('supplier_list')}}">Party <span class="sr-only">(current)</span></a>
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
        <a class="nav-link" href="{{route('sell_list')}}">Sell</a>
      </li>
      
    </ul>

    <form class="form-inline my-2 my-lg-0">
      <a href="{{route('user')}}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
          </svg>
      </a>
    </form>
  </div>
</nav>