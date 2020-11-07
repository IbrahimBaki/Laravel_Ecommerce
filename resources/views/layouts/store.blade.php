<!DOCTYPE html>
<html class="loading" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{asset('assets/store/images/icons/favicon.png')}}"/>
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/animate/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/css-hamburgers/hamburgers.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/animsition/css/animsition.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/slick/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/lightbox2/css/lightbox.min.cs')}}s">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/vendor/noui/nouislider.min.css')}}">


    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->

    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/fonts/themify/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/fonts/elegant-font/html-css/style.css')}}">

    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/store/css/main.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->

    <!-- END: Custom CSS-->
    @yield('style')


    <style>


    </style>

</head>
<body class="animsition">

<!-- Begin Header-->
@include('site.includes.header')
<!-- End Header-->

<!-- Begin Sidebar-->
@include('site.includes.sidebar')
<!-- End Sidebar-->


@yield('content')

<!-- Begin footer-->
@include('site.includes.footer')
<!-- End Sidebar-->
<!-- BEGIN VENDOR JS-->
<script type="text/javascript" src="{{asset('assets/store/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/animsition/js/animsition.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/bootstrap/js/popper.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/slick/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/countdowntime/countdowntime.j')}}s"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/lightbox2/js/lightbox.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/vendor/noui/nouislider.min.js')}}"></script>



<!-- BEGIN VENDOR JS-->


<!-- BEGIN PAGE VENDOR JS-->

<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{asset('assets/store/js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/store/js/slick-custom.js')}}"></script>


<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript">
    $(".selection-1").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect2')
    });
</script>

<script type="text/javascript">
    $('.block2-btn-addcart').each(function(){
        var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to cart !", "success");
        });
    });

    $('.block2-btn-addwishlist').each(function(){
        var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");
        });
    });
    $('.btn-addcart-product-detail').each(function(){
        var nameProduct = $('.product-detail-name').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");
        });
    });

</script>

<script type="text/javascript">
    /*[ No ui ]
    ===========================================================*/
    var filterBar = document.getElementById('filter-bar');

    noUiSlider.create(filterBar, {
        start: [ 50, 200 ],
        connect: true,
        range: {
            'min': 50,
            'max': 200
        }
    });

    var skipValues = [
        document.getElementById('value-lower'),
        document.getElementById('value-upper')
    ];

    filterBar.noUiSlider.on('update', function( values, handle ) {
        skipValues[handle].innerHTML = Math.round(values[handle]) ;
    });
</script>
<!-- END PAGE LEVEL JS-->



@yield('script')
</body>
</html>
