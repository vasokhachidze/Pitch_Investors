@extends('layouts.app.admin-app')
@section('title', 'Setting - '.env('APP_NAME'))
@section('content')

<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Settings</h1>
      </div>
    </div>
  </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Settings</h4>
                </div> -->
                <form action="{{route('admin.setting.store')}}" class="row g-5 add-product mt-0" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <input type="hidden" id="eConfigType" name="eConfigType" value="<?php echo $eConfigType;?>">
                    <div class="row">
                    @foreach ($settings as $setting)
                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            @if($setting->eDisplayType == 'text')
                                <label for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                <input type="text" class="form-control" id="{{ $setting->vName }}" name="{{ $setting->vName }}" placeholder="Please Enter {{ $setting->vName }}" value="{{ $setting->vValue }}">

                            @elseif($setting->eDisplayType == 'textarea')
                                <label for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                <textarea class="form-control {{ $setting->vName }}" id="{{ $setting->vName }}" name="{{ $setting->vName }}" placeholder="Please enter {{ $setting->vName }}">{{ $setting->vValue }}</textarea>

                            @elseif($setting->eDisplayType == 'checkbox') 
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $setting->vName }}" name="{{ $setting->vName }}" value="Y" @if( $setting->vValue == 'Y') checked @endif>
                                    <label class="form-check-label" for="{{ $setting->vName }}">{{ $setting->vName }}</label>
                                </div>

                            @elseif($setting->eDisplayType == 'selectbox') 
                                @php
                                    $select = explode(",", $setting->vSourceValue);
                                @endphp
                                <label class="label-control" for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                <select class="form-control show-tick" id="{{ $setting->vName }}" name="{{ $setting->vName }}">
                                    @foreach ($select as $key => $value)
                                      <option value="{{ $value }}" @if($value == $setting->vValue) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>

                            @elseif($setting->eDisplayType == 'file') 
                                <label class="label-control" for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>

                                <div class="custome-files">
                                    <input type="file"  class="form-control" id="{{ $setting->vName }}" name="{{ $setting->vName }}">
                                </div>
                                @if($setting->vValue != "")
                                    <img id="img" src="{{asset('uploads/logo/'.$setting->vValue)}}" class="admin-logo" width="50px" height="auto"/>
                                @endif 

                            @elseif($setting->eDisplayType == 'hidden') 
                                <input type="hidden" id="{{ $setting->vName }}" name="{{ $setting->vName }}" value="{{ $setting->vValue }}">

                            @elseif($setting->eDisplayType == 'password') 
                                <label class="label-control" for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>

                                <input type="password" class="form-control" id="{{ $setting->vName }}" name="{{ $setting->vName }}" value="{{ $setting->vValue }}">
                            @else 
                                <label class="label-control" for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                <input type="text" class="form-control" id="{{ $setting->vName }}" name="{{ $setting->vName }}" value="{{ $setting->vValue }}" readonly>
                            @endif
                        </div>
                    @endforeach
                    </div>
                    <hr>
                        <div class="col-4 align-self-end d-inline-block">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="javascript:;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>

@endsection

@section('custom-js')
@endsection
