@extends('layouts.store')
@section('title','Cart')
@section('content')

    <!-- Title Page -->
    <section class="bg-title-page p-t-40 p-b-50 flex-col-c-m"
             style="background-image: url({{asset('assets/store/images/heading-pages-01.jpg')}});">
        <h2 class="l-text2 t-center">
            Cart
        </h2>
    </section>
    <!--Cart -->
    <section class="cart bgwhite p-t-70 p-b-100">
        <div class="container">
        @include('site.includes.alerts.success')
        @include('site.includes.alerts.errors')
        <!-- Cart item -->
            @if(Cart::instance('inCart')->count()>0)
                <div class="justify-content-center d-flex alert alert-primary">
                    <h2>{{Cart::instance('inCart')->count()}} item(s) in Shopping Cart</h2>
                </div>
                <div class="container-table-cart pos-relative">
                    <div class="wrap-table-shopping-cart bgwhite">
                        <table class="table-shopping-cart">
                            <tr class="table-head">
                                <th class="column-1"></th>
                                <th class="column-2">Product</th>
                                <th class="column-3">Price</th>
                                <th class="column-4 p-l-70">Quantity</th>
                                <th class="column-5">Total</th>
                                <th class="column-6"></th>
                                <th class="column-7"></th>
                            </tr>
                            @foreach(Cart::instance('inCart')->content() as $item)
                                <tr class="table-row">
                                    <td class="column-1">
                                        <div class="cart-img-product b-rad-4 o-f-hidden">
                                            @foreach($item->model->images as $image)
                                                <img src="{{asset('assets/images/products/'. $image->photo)}}"
                                                     alt="IMG-PRODUCT">
                                                @break
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="column-2">
                                        <a href="{{route('shop.show.one',$item->model->slug)}}">
                                            <p> {{$item->model->name}}</p></a>
                                    </td>
                                    <td class="column-3">{{$item->model->price}}</td>
                                    <td class="column-4">
                                        <div class="flex-w bo5 of-hidden w-size17">
                                            <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2"><i class="fs-12 fa fa-minus" aria-hidden="true"></i></button>
                                            <input class="size8 m-text18 t-center num-product" type="number"
                                                   name="num-product1"
                                                   value="{{$item->qty}}">
                                            <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2"><i class="fs-12 fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                    </td>
                                    <td class="column-5">{{$item->price}}</td>
                                    <td class="column-6">
                                        <form action="{{route('cart.save.later',$item->rowId)}}" method="POST">
                                            @csrf
                                            <button type="submit" class=" size15 flex-c-m  bg1 bo-rad-23 hov1 s-text10  p-l-2 mr-5"
                                                    aria-label="Close">Save Later
                                            </button>
                                        </form>
                                    </td>
                                    <td class="column-7">
                                        <form action="{{route('cart.destroy',$item->rowId)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class=" size7 flex-c-m  bg1 bo-rad-23 hov1 s-text1 trans-0-4 ml-2 mr-2"
                                                    aria-label="Close">X
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
                    <div class="flex-w flex-m w-full-sm">
                        <div class="size11 bo4 m-r-10">
                            <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
                        </div>
                        <div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
                            <!-- Button -->
                            <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">Apply coupon</button>
                        </div>
                    </div>
                    <div class="size10 trans-0-4 m-t-10 m-b-10">
                        <!-- Button -->
                        <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">Update Cart</button>
                    </div>
                </div>
            @else
                <div class="justify-content-center d-flex alert alert-danger">
                <h3>No Products in cart</h3>
                </div>
        @endif
        <!-- Total -->
            <div class="bo9 w-size30 p-l-40 p-r-40 p-t-10 p-b-12 m-t-5 m-r-0 m-l-auto p-lr-15-sm">
                <h5 class="m-text20 p-b-15">Cart Totals</h5>
                <!--  -->
                <div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">Subtotal:</span>
                    <span class="m-text21 w-size20 w-full-sm">{{Cart::instance('inCart')->subtotal()}}</span>
                </div>
                <div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">Tax:</span>
                    <span class="m-text21 w-size20 w-full-sm">{{Cart::instance('inCart')->tax()}}</span>
                </div>
                <!--  -->
                <div class="flex-w flex-sb-m p-t-10 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">Total:</span>
                    <span class="m-text21 w-size20 w-full-sm">{{Cart::instance('inCart')->total()}}</span>
                </div>
                <div class="size15 trans-0-4">
                    <!-- Button -->
                    <a href="{{route('checkout.index')}}" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">Proceed to Checkout</a>
                </div>
            </div>

            @if(Cart::instance('saveForLater')->count()>0)
                <div class="justify-content-center d-flex alert alert-primary">
                    <h2>{{Cart::instance('saveForLater')->count()}} item(s) Saved for Later</h2>
                </div>
                <div class="container-table-cart pos-relative">
                    <div class="wrap-table-shopping-cart bgwhite">
                        <table class="table-shopping-cart">
                            <tr class="table-head">
                                <th class="column-1"></th>
                                <th class="column-2">Product</th>
                                <th class="column-3">Price</th>
                                <th class="column-4 p-l-70">Quantity</th>
                                <th class="column-5">Total</th>
                                <th class="column-6"></th>
                                <th class="column-7"></th>
                            </tr>
                            @foreach(Cart::instance('saveForLater')->content() as $item)
                                <tr class="table-row">
                                    <td class="column-1">
                                        <div class="cart-img-product b-rad-4 o-f-hidden">
                                            @foreach($item->model->images as $image)
                                                <img src="{{asset('assets/images/products/'. $image->photo)}}"
                                                     alt="IMG-PRODUCT">
                                                @break
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="column-2">
                                        <a href="{{route('shop.show.one',$item->model->slug)}}">
                                            <p> {{$item->model->name}}</p></a>
                                    </td>
                                    <td class="column-3">{{$item->model->price}}</td>
                                    <td class="column-4">
                                        <div class="flex-w bo5 of-hidden w-size17">
                                            <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2"><i class="fs-12 fa fa-minus" aria-hidden="true"></i></button>
                                            <input class="size8 m-text18 t-center num-product" type="number"
                                                   name="num-product1"
                                                   value="{{$item->qty}}">
                                            <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2"><i class="fs-12 fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                    </td>
                                    <td class="column-5">{{$item->price}}</td>
                                    <td class="column-6">
                                        <form action="{{route('saveForLater.move.to.cart',$item->rowId)}}" method="POST">
                                            @csrf
                                            <button type="submit" class=" size15 flex-c-m  bg1 bo-rad-23 hov1 s-text10  p-l-2 mr-5"
                                                    aria-label="Close">Move To Cart
                                            </button>
                                        </form>
                                    </td>
                                    <td class="column-7">
                                        <form action="{{route('saveForLater.destroy',$item->rowId)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class=" size7 flex-c-m  bg1 bo-rad-23 hov1 s-text1 trans-0-4 ml-2 mr-2"
                                                    aria-label="Close">X
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @else
                <div class="justify-content-center d-flex alert alert-danger">
                <h3>No Items Saved for Later</h3>
                </div>
            @endif





        </div>
    </section>

@stop
