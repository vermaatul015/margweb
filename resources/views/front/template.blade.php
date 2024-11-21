@include('front.includes.header')
@include('front.includes.sidebar')
 
  <!-- Full Width Column -->
  <div class="content-wrapper">
    @yield('content')
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  @include('front.includes.footer') 

  @include('front.includes.footer_script') 
