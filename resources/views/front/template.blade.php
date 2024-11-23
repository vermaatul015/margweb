@include('front.includes.header')
@include('front.includes.sidebar')
 
  <!-- Full Width Column -->
  
    @yield('content')
    <!-- /.container -->
 
  <!-- /.content-wrapper -->
  @include('front.includes.footer') 

  @include('front.includes.footer_script') 
