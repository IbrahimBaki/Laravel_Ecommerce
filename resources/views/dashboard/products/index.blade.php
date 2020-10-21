@extends('layouts.admin')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> {{__('admin/products.products')}} </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('admin/categories.main')}}</a>
                                </li>
                                <li class="breadcrumb-item active"> {{__('admin/products.products')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin/products.allProducts')}} </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal">
                                            <thead class="">
                                            <tr>
                                                <th>{{__('admin/products.name')}}</th>
                                                <th>{{__('admin/products.slug')}}</th>
                                                <th> {{__('admin/products.status')}}</th>
                                                <th>{{__('admin/products.productPrice')}}</th>
                                                <th>{{__('admin/products.edit')}}</th>
                                                <th>{{__('admin/products.delete')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($products)
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$product -> name}}</td>
                                                        <td>{{$product -> slug}}</td>
                                                        <td>{{$product -> getActive()}}</td>
                                                        <td>{{$product -> price}}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    edit
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="{{route('admin.products.general.edit',$product->id)}}">الوصف</a>
                                                                    <a class="dropdown-item" href="{{route('admin.products.price.edit',$product->id)}}">السعر</a>
                                                                    <a class="dropdown-item" href="{{route('admin.products.stock.edit',$product->id)}}">المستودع</a>
                                                                    <a class="dropdown-item" href="{{route('admin.products.images.edit',$product->id)}}">الصور</a>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <a href=""
                                                               class="btn btn-danger btn-min-width box-shadow-3 ">{{__('admin/products.delete')}}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! $products -> links() !!}
                </section>
            </div>
        </div>
    </div>




@stop

