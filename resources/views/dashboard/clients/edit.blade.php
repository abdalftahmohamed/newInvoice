@extends('layouts.dashboard.app')
@section('title', __('dashboard.edit'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-9 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.edit') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">
                                        {{ __('dashboard.clients') }}</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="">
                                        {{ __('dashboard.edit') }}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                {{-- @include('dashboard.includes.button-header') --}}
            </div>
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-colored-form-control">
                                    {{ __('dashboard.clients') }}
                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    {{-- alert --}}
                                    @include('dashboard.includes.validations-errors')

                                    {{-- <a href="{{ route('dashboard.clients.index') }}" class="btn btn-sm btn-primary mb-2">
                                        <i class="la la-arrow-left"></i> {{ __('dashboard.back') }}
                                    </a> --}}

                                    <form class="form" action="{{ route('dashboard.clients.update' , $client->id)}}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                        @method('PUT')

                                        <input name="id" hidden value="{{ $client->id }}" />

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="eventRegInput1">{{ __('dashboard.name') }}</label>
                                                        <input type="text" value="{{$client->name}}" class="form-control" id="eventRegInput1"
                                                            placeholder="{{ __('dashboard.name') }}" name="name">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">{{ __('dashboard.email') }}</label>
                                                        <input type="email" value="{{$client->email}}" class="form-control" id="email"
                                                               placeholder="{{ __('dashboard.email') }}" name="email">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">{{ __('dashboard.phone') }}</label>
                                                        <input type="number" value="{{$client->phone}}" class="form-control" id="phone"
                                                               placeholder="{{ __('dashboard.phone') }}" name="phone">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">{{ __('dashboard.address') }}</label>
                                                        <textarea class="form-control" id="address"
                                                                  placeholder="{{ __('dashboard.address') }}"
                                                                  name="phone">{{$client->address}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="image">{{ __('dashboard.logo') }}</label>
                                                <input type="file"  name="logo" class="form-control" id="single-image-edit"
                                                    placeholder="{{ __('dashboard.logo') }}">
                                            </div>


                                            <div class="form-group">
                                                <label>{{ __('dashboard.status') }}</label>
                                                <div class="input-group">
                                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                                        <input type="radio" value="1" @checked($client->status == 1)  name="status" class="custom-control-input"
                                                            id="yes1">
                                                        <label class="custom-control-label" for="yes1">{{ __('dashboard.active') }}</label>
                                                    </div>
                                                    <div class="d-inline-block custom-control custom-radio">
                                                        <input type="radio" value="0"  @checked($client->status == 0) name="status" class="custom-control-input"
                                                            id="no1">
                                                        <label class="custom-control-label" for="no1">{{ __('dashboard.unactive') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions left">
                                            <a href="{{ url()->previous() }}" type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> {{ __('dashboard.cancel') }}
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> {{ __('dashboard.save') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>
    var lang = "{{ app()->getLocale() }}";
    $(function() {
         $('#single-image-edit').fileinput({
             theme: 'fa5',
             language:lang,
             allowedFileTypes: ['image'],
             maxFileCount: 1,
             enableResumableUpload: false,
             showUpload: false,
             initialPreviewAsData:true,
             initialPreview:[
                "{{ asset($client->logo) }}",
             ],

         });

     });
</script>
@endpush
