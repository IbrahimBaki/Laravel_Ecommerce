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
                                        href="{{route('admin.dashboard')}}">{{__('admin/general.main')}} </a>
                                </li>

                                <li class="breadcrumb-item active"><a
                                        href="{{route('admin.categories')}}">{{__('admin/general.products')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('admin/general.price')}}
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
                                        id="basic-layout-form"> {{__('admin/products.priceData')}} </h4>
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
                                <div class="d-flex justify-content-center">
                                    <a href=""
                                       class="btn btn-outline-info">{{__('admin/products.description')}}</a>
                                    <a href=""
                                       class="btn btn-info">{{__('admin/general.price')}}</a>
                                    <a href=""
                                       class="btn btn-outline-info">{{__('admin/products.stock')}}</a>
                                    <a href=""
                                       class="btn btn-outline-info">{{__('admin/products.images')}}</a>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.products.price.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" value="{{$id}}" name="id">

                                            <div class="form-body">
                                                <h4 class="form-section"><i
                                                        class="ft-home"></i> {{__('admin/products.priceData')}}
                                                </h4>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="price"> {{__('admin/products.productPrice')}} </label>
                                                            <input type="number"
                                                                   value="{{$product->price ?? old('price')}}"
                                                                   id="price"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="price">
                                                            @error("price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="special_price"> {{__('admin/products.productSpecialPrice')}} </label>
                                                            <input type="number"
                                                                   value="{{$product->special_price ?? old('special_price')}}"
                                                                   id="special_price"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="special_price">
                                                            @error("special_price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="special_price_type"> {{__('admin/products.specialPriceType')}} </label>
                                                            <select name="special_price_type"
                                                                    class="form-control"
                                                                    id="special_price_type"
                                                            >
                                                                <optgroup label="choose Type">
                                                                    <option @isset($product) @if($product->special_price_type == 'percent') selected @endif @endisset
                                                                        value="percent">Percent</option>
                                                                    <option
                                                                        @isset($product) @if($product->special_price_type == 'fixed') selected @endif @endisset
                                                                        value="fixed">Fixed</option>
                                                                </optgroup>
                                                            </select>
                                                            @error("special_price_type")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                               <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="special_price_start">{{__('admin/products.specialPriceStart')}}</label>
                                                            <input type="date"
                                                                   name="special_price_start"
                                                                   id="special_price_start"
                                                                   class="form-control"
                                                                   @isset($product)
                                                                   value="{{date('Y-m-d',strtotime($product->special_price_start)) ?? old('special_price_start')}}"
                                                                   @endisset
                                                                   placeholder=""
                                                            >
                                                            @error("special_price_start")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="special_price_end">{{__('admin/products.specialPriceEnd')}}</label>
                                                            <input type="date"
                                                                   name="special_price_end"
                                                                   id="special_price_end"
                                                                   class="form-control"
                                                                   @isset($product)
                                                                   value="{{date('Y-m-d',strtotime($product->special_price_end)) ?? old('special_price_end')}}"
                                                                   @endisset
                                                                   placeholder=""

                                                            >
                                                            @error("special_price_end")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                               </div>
                                            </div>


                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                            onclick="history.back();">
                                                        <i class="ft-x"></i>{{__('admin/general.cancel')}}
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i>{{__('admin/general.save')}}
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

