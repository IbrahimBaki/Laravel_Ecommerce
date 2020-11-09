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
                                <li class="breadcrumb-item"><a href="{{route('admin.products')}}">
                                        {{__('admin/general.products')}} </a>
                                </li>
                                <li class="breadcrumb-item active">{{__('admin/products.images')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"
                                        id="basic-layout-form">{{__('admin/products.productsImages')}}</h3>
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
                                       class="btn btn-outline-info">{{__('admin/general.price')}}</a>
                                    <a href=""
                                       class="btn btn-outline-info">{{__('admin/products.stock')}}</a>
                                    <a href=""
                                       class="btn btn-info">{{__('admin/products.images')}}</a>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')


                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @isset($product)
                                            <div class="row d-flex justify-content-center">
                                                @forelse($product->images as $image)
                                                    <div class="mx-1">
                                                        <img width="120px" height="150px" class="rounded"
                                                             src="{{asset('assets/images/products/'.$image->photo)}}"
                                                             alt="Product Images"><br>
                                                        <form method="get"
                                                              action="{{route('admin.products.images.delete',$image->id)}}">
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-min-width  mt-1 rounded">
                                                                {{__('admin/general.delete')}}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @empty
                                                    <p class="">No Images Found</p>
                                                @endforelse
                                            </div>
                                        @endisset
                                        <form class="form"
                                              action="{{route('admin.products.images.store.db')}}"
                                              method="POST"
                                              enctype="multipart/form-data"
                                        >
                                            @csrf

                                            <input type="hidden" name="product_id" value="{{$id}}">
                                            <div class="form-body">
                                                <h4 class="form-section"><i
                                                        class="ft-home"></i> {{__('admin/products.productsImages')}}
                                                </h4>
                                                <div class="form-group">
                                                    <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                                        <div
                                                            class="dz-message mt-5">{{__('admin/products.dzUploadHere')}}</div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> {{__('admin/general.cancel')}}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{__('admin/general.save')}}
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
        var uploadedDocumentMap = {}
        Dropzone.options.dpzMultipleFiles = {
            paramName: "dzfile", // The name that will be used to transfer the file
            // autoProcessQueue: false,
            maxFilesize: 5, // MB
            clickable: true,
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            dictFallbackMessage: "{{__('admin/products.fallBackMess')}}",
            dictInvalidFileType: "{{__('admin/products.invalidFType')}}",
            dictCancelUpload: "{{__('admin/products.cancelUpload')}}",
            dictCancelUploadConfirmation: "{{__('admin/products.cancelingConfirm')}}",
            dictRemoveFile: "{{__('admin/general.delete')}}",
            dictMaxFilesExceeded: "{{__('admin/products.maxFiles')}}",
            headers: {
                'X-CSRF-TOKEN':
                    "{{ csrf_token() }}"
            }
            ,
            url: "{{ route('admin.products.images.store') }}", // Set the url
            success:
                function (file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                    uploadedDocumentMap[file.name] = response.name
                }
            ,
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            }
            ,
            // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
            init: function () {
                @if(isset($event) && $event->document)
                var files =
                {!! json_encode($event->document) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }
    </script>
@stop
