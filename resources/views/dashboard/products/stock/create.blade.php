@extends('layouts.admin')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('admin/shipping.main')}} </a>
                                </li>

                                <li class="breadcrumb-item active"><a
                                        href="{{route('admin.categories')}}">{{__('admin/products.products')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('admin/categories.add')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{--            --}}
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"
                                        id="basic-layout-form"> {{__('admin/products.productAdd')}} </h4>
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
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.products.stock.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" value="{{$id}}" name="id">

                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> {{__('admin/products.stockData')}}
                                                </h4>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="sku"> {{__('admin/products.sku')}} </label>
                                                            <input type="text"
                                                                   @isset($product)
                                                                   value="{{$product->sku ?? old('sku')}}"
                                                                   @endisset
                                                                   id="sku"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="sku">
                                                            @error("sku")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="in_stock"> {{__('admin/products.productStatus')}} </label>
                                                            <select name="in_stock" class="select2 form-control" id="in_stock" >
                                                                <optgroup label="">
                                                                    <option  @isset($product) @if($product->in_stock == 1) selected @endif @endisset
                                                                        value="1">{{__('admin/products.avail')}}</option>
                                                                    <option @isset($product) @if($product->in_stock == 0) selected @endif @endisset
                                                                    value="0" >{{__('admin/products.nonAvail')}}</option>
                                                                </optgroup>
                                                            </select>
                                                            @error("in_stock")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="manage_stock"> {{__('admin/products.stockFollow')}} </label>
                                                            <select name="manage_stock" class="select2 form-control" id="manage_stock" >
                                                                <optgroup label="">
                                                                    <option @isset($product) @if($product->in_stock == 1) selected @endif @endisset
                                                                    value="1">{{__('admin/products.allow')}}</option>
                                                                    <option @isset($product) @if($product->in_stock == 0) selected @endif @endisset
                                                                    value="0" >{{__('admin/products.disallow')}}</option>
                                                                </optgroup>
                                                            </select>
                                                            @error("manage_stock")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 " @isset($product) @if($product->in_stock == 0) style="display: none" @endif @endisset id="qty" >
                                                        <div class="form-group">
                                                            <label for="qty"> {{__('admin/products.qty')}} </label>
                                                            <input type="number"
                                                                   @isset($product)
                                                                   value="{{$product->qty ?? old('qty')}}"
                                                                   @endisset
                                                                   id="qty"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="qty">
                                                            @error("qty")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>


                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                            onclick="history.back();">
                                                        <i class="ft-x"></i>{{__('admin/categories.cancel')}}
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i>{{__('admin/categories.save')}}
                                                    </button>
                                                </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>

        </div>
    </div>


@stop
@section('script')
    <script>
        $(document).on('change','#manage_stock',function (){
           if($(this).val() == 1){
               $('#qty').show();
           }else{
               $('#qty').hide();
           }

        });

    </script>
@stop

