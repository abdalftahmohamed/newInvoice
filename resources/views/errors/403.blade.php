<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>{{__('Error 403 Dashboard')}}
    </title>

    @include('errors.css')
</head>
<body class="vertical-layout vertical-menu-modern 1-column   menu-expanded blank-page blank-page"
      data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 p-0">
                        <div class="card-header bg-transparent border-0">
                            <h2 class="error-code text-center mb-2">404</h2>
                            <h3 class="text-uppercase text-center">{{__('Access Denied/Forbidden !')}}</h3>
                        </div>
                        <div class="card-content">
                            <fieldset class="row py-2">
                                <div class="input-group col-12">
                                    <input type="text" class="form-control form-control-xl input-xl border-grey border-lighten-1 "
                                           placeholder="Search..." aria-describedby="button-addon2">
                                    <span class="input-group-append" id="button-addon2">
                      <button class="btn btn-lg btn-secondary border-grey border-lighten-1" type="button"><i class="ft-search"></i></button>
                    </span>
                                </div>
                            </fieldset>
                            <div class="row py-2">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <a href="{{route('dashboard.home')}}" class="btn btn-primary btn-block"><i class="ft-home"></i> {{__('Back to Home')}}</a>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <a href="#" class="btn btn-danger btn-block"><i class="ft-search"></i> {{__('Advanced search')}}</a>
                                </div>
                            </div>
                        </div>
                        @include('errors.footer')
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
@include('errors.script')

</body>
</html>
