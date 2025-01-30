@extends('layouts.admin.index')
@section('content')
@php
$title  = Request::segment(3);
@endphp

 <div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
                 <div class="row mb-2">
                    <div class="col-sm-6 mt-2">
                        <h5>{{$title}}</h5>
                    </div>
                 </div>
                    <form action="{{route('admin.setting.store')}}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-4">
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
                                <div class="row g-3">
                                    @foreach ($settings as $setting)
                                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                        @if($setting->eDisplayType == 'text')
                                        <label for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                        <input type="text" class="form-control" id="{{ $setting->vName }}"
                                            name="{{ $setting->vName }}" placeholder="Please Enter {{ $setting->vName }}"
                                            value="{{ $setting->vValue }}">

                                        @elseif($setting->eDisplayType == 'textarea')
                                        <label for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                        <textarea class="form-control" id="{{ $setting->vName }}"
                                            name="{{ $setting->vName }}"
                                            placeholder="Please enter {{ $setting->vName }}">{{ $setting->vValue }}</textarea>

                                        @elseif($setting->eDisplayType == 'checkbox')
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="{{ $setting->vName }}"
                                                name="{{ $setting->vName }}" value="Y" @if( $setting->vValue == 'Y') checked
                                            @endif>
                                            <label class="form-check-label"
                                                for="{{ $setting->vName }}">{{ $setting->vName }}</label>
                                        </div>

                                        @elseif($setting->eDisplayType == 'selectbox')
                                        @php
                                        $select = explode(",", $setting->vSourceValue);
                                        @endphp
                                        <label class="label-control"
                                            for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                        <select class="form-control show-tick" id="{{ $setting->vName }}"
                                            name="{{ $setting->vName }}">
                                            @foreach ($select as $key => $value)
                                            <option value="{{ $value }}" @if($value==$setting->vValue) selected
                                                @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>

                                        @elseif($setting->eDisplayType == 'file')
                                        <label class="label-control"
                                            for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>

                                        <div class="custome-files">
                                            <input type="file" class="form-control" id="{{ $setting->vName }}"
                                                name="{{ $setting->vName }}">
                                        </div>
                                        @if($setting->vValue != "")
                                        <img id="img" src="{{asset('uploads/logo/'.$setting->vValue)}}" class="admin-logo"
                                            width="50px" height="auto" />
                                        @endif

                                        @elseif($setting->eDisplayType == 'hidden')
                                        <input type="hidden" id="{{ $setting->vName }}" name="{{ $setting->vName }}"
                                            value="{{ $setting->vValue }}">

                                        @elseif($setting->eDisplayType == 'password')
                                        <label class="label-control"
                                            for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>

                                        <input type="password" class="form-control" id="{{ $setting->vName }}"
                                            name="{{ $setting->vName }}" value="{{ $setting->vValue }}">
                                        @else
                                        <label class="label-control"
                                            for="{{ $setting->vName }}">{{ $setting->vDesc }}</label>
                                        <input type="text" class="form-control" id="{{ $setting->vName }}"
                                            name="{{ $setting->vName }}" value="{{ $setting->vValue }}" readonly>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                

                                <div class="col-12 align-self-end d-inline-block btn-space mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="javascript:;" class="btn btn-info">Back</a>
                                </div>
                         
                            </div>
                        </div>
                    </form> 
        </div>
    </div>
</div>
@endsection

@section('custom-js')
@endsection
