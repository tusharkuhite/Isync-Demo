@extends('layouts.admin.index')
<<<<<<< HEAD
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @section('title', 'Dashboard- '.$setting_info['COMPANY_NAME']['vValue'])
@endif
@php
$roles  =\App\Libraries\General::get_role();

@endphp

@section('content')
<!-- Start Content -->

@section('custom-css')
<style type="text/css">
</style>
@endsection
 <!-- Content -->
 
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                    @if (isset($permission) && $permission->vRole == 'Company')
                    <img class="img-fluid" style="width:150px;height:auto;margin-bottom:20px;"  src="{{$web_image}}">
                    <div class="top-input-space">
                    <h5  class="space">Welcome to the company - {{$company_name}}</h5>
                    </div>
                      <p class="card-text">Welcome to your Johari360 dashboard, the home of your 360 assessments. Here, you can set up assessments that are fully bespoke for your colleagues. Use these insights to understand their strengths, identify areas for growth, and enhance their personal and professional development. Start exploring and make the most of your journey!</p>
                    @else
                      <div class="row row-bordered g-0">
                        <div class="col-md-8">
                          <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                          <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                          <div class="card-body">
                            <div class="text-center">
                              <div class="dropdown">
                                <button
                                  class="btn btn-sm btn-outline-primary dropdown-toggle"
                                  type="button"
                                  id="growthReportId"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  2023
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                  <a class="dropdown-item" href="javascript:void(0);">2023</a>
                                  <a class="dropdown-item" href="javascript:void(0);">2022</a>
                                  <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="growthChart"></div>
                          <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                          <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                            <div class="d-flex">
                              <div class="me-2">
                                <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                              </div>
                              <div class="d-flex flex-column">
                                <small>2023</small>
                                <h6 class="mb-0">$32.5k</h6>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2">
                                <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                              </div>
                              <div class="d-flex flex-column">
                                <small>2022</small>
                                <h6 class="mb-0">$41.2k</h6>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 col-md-12 order-1">
                  <div class="row">
                    @if(!empty($category))              
                      <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="badge bg-label-primary p-2 mb-2 me-3">
                                <i class="bx bx-category rounded" style="color: #ec8c00 !important;"></i>
                              </div>
                              <div class="dropdown">
                                <button
                                  class="btn p-0"
                                  type="button"
                                  id="cardOpt1"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                  <a class="dropdown-item"  href="{{ route('admin.category.add') }}">Add</a>
                                  <a class="dropdown-item"  href="{{ route('admin.category.listing') }}">View List</a>
                                </div>
                              </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-between">
                              <span class="fw-semibold">Category</span>
                              <h3 class="card-title mb-0" align="right">@if(isset($category)){{$category}}@else{{0}}@endif</h3>
                            </div>
                            {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>  --}}
                          </div>
                        </div>
                      </div>
                    @endif
                    @if(!empty($blog))
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="badge bg-label-success p-2 mb-2 me-3">
                              <i class="bx bxl-blogger rounded" style="color: #71dd37 !important;"></i>
                            </div> 
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item"  href="{{ route('admin.blog.add') }}">Add</a>
                                <a class="dropdown-item" href="{{ route('admin.blog.listing') }}">View List</a>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-start justify-content-between">
                          <span class="fw-semibold">Blog</span>
                           <h3 class="card-title mb-0" align="right">@if(isset($blog)){{$blog}}@else{{0}}@endif</h3>
                          </div>
                          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                        </div>
                      </div>
                    </div>
                    @endif
                    @if(!empty($service))
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="badge bg-label-info p-2 mb-2 me-3">
                              <i class="bx bx-bookmarks rounded text-info"></i>
                            </div> 
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item"  href="{{ route('admin.service.add') }}">Add</a>
                                <a class="dropdown-item" href="{{ route('admin.service.listing') }}">View List</a>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-start justify-content-between">
                          <span class="fw-semibold">Service</span>
                           <h3 class="card-title mb-0" align="right">@if(isset($service)){{$service}}@else{{0}}@endif</h3>
                          </div>
                          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                        </div>
                      </div>
                    </div>
                    @endif
                    @if(!empty($competency))
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="badge bg-label-blue p-2 mb-2 me-3">
                              <i class="bx bx-accessibility" style="color: #a663ff !important;"></i>

                            </div> 
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item"  href="{{ route('admin.competency.add') }}">Add</a>
                                <a class="dropdown-item" href="{{ route('admin.competency.listing') }}">View List</a>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-start justify-content-between">
                          <span class="fw-semibold">Competency</span>
                           <h3 class="card-title mb-0" align="right">@if(isset($competency)){{$competency}}@else{{0}}@endif</h3>
                          </div>
                          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                        </div>
                      </div>
                    </div>
                    @endif

                    @if(!empty($company))
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="badge bg-label-green p-2 mb-2 me-3">
                              <i class="bx bxs-briefcase rounded" style="color: #87ffd3 !important;"></i>

                            </div> 
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item"  href="{{ route('admin.company.add') }}">Add</a>
                                <a class="dropdown-item" href="{{ route('admin.company.listing') }}">View List</a>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-start justify-content-between">
                          <span class="fw-semibold">Company</span>
                           <h3 class="card-title mb-0" align="right">@if(isset($company)){{$company}}@else{{0}}@endif</h3>
                          </div>
                          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                        </div>
                      </div>
                    </div>
                    @endif

                    @if(!empty($statement))
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="badge bg-label-black p-2 mb-2 me-3">
                              <i class="bx bx-message-detail rounded" style="color: #2418dfb8 !important;"></i>

                            </div> 
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item"  href="{{ route('admin.statement.add') }}">Add</a>
                                <a class="dropdown-item" href="{{ route('admin.statement.listing') }}">View List</a>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-start justify-content-between">
                          <span class="fw-semibold">Statement</span>
                           <h3 class="card-title mb-0" align="right">@if(isset($statement)){{$statement}}@else{{0}}@endif</h3>
                          </div>
                          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                        </div>
                      </div>
                    </div>
                    @endif
                    
                    @if (isset($permission) && $permission->vRole == 'Company')
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="badge bg-label-success p-2 mb-2 me-3" style="background-color: #e1be5a78 !important">
                              <i class="bx bx-info-circle  rounded" style="color: #ec8c00 !important;"></i>
                            </div> 
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                {{-- <a class="dropdown-item"  href="{{ route('admin.blog.add') }}">Add</a>
                                <a class="dropdown-item" href="{{ route('admin.blog.listing') }}">View List</a> --}}
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-start justify-content-between">
                          <span class="fw-semibold">Pending Assesment</span>
                           <h3 class="card-title mb-0" align="right">@if(isset($pending)){{$pending}}@else{{0}}@endif</h3>
                          </div>
                          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                        </div>
                      </div>
                     </div>
                    

                    
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="badge bg-label-info p-2 mb-2 me-3">
                              <i class="bx bx-check-square rounded" style="color: #03c3ec !important;"></i>
                            </div> 
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                {{-- <a class="dropdown-item"  href="{{ route('admin.blog.add') }}">Add</a>
                                <a class="dropdown-item" href="{{ route('admin.blog.listing') }}">View List</a> --}}
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-start justify-content-between">
                          <span class="fw-semibold">Completed Assesment</span>
                           <h3 class="card-title mb-0" align="right">@if(isset($completed)){{$completed}}@else{{0}}@endif</h3>
                          </div>
                          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                        </div>
                      </div>
                     </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection

@section('custom-js')
=======
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
  <div class="row">
    <div class="col-xxl-8 mb-6 order-0">
      <div class="card">
        <div class="d-flex align-items-start row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary mb-3">Congratulations {{ Session::get('username') }}! 🎉</h5>
              <p class="mb-6">You have done 72% more sales today.<br>Check your new badge in your profile.</p>
  
              <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-6">
              <img src="{{ asset('admin/assets/img/illustrations/man-with-laptop-light.png') }}" height="175" class="scaleX-n1-rtl" alt="View Badge User">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 order-1">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-6 mb-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Profit</p>
              <h4 class="card-title mb-3">$12,628</h4>
              <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-6 mb-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="wallet info" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Sales</p>
              <h4 class="card-title mb-3">$4,679</h4>
              <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Total Revenue -->
    <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
      <div class="card">
        <div class="row row-bordered g-0">
          <div class="col-lg-8">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                <h5 class="m-0 me-2">Total Revenue</h5>
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="totalRevenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded bx-lg text-muted"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalRevenue">
                  <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                  <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                  <a class="dropdown-item" href="javascript:void(0);">Share</a>
                </div>
              </div>
            </div>
            <div id="totalRevenueChart" class="px-3" style="min-height: 332px;"><div id="apexchartsd9y7oj6u" class="apexcharts-canvas apexchartsd9y7oj6u apexcharts-theme-light" style="width: 466px; height: 317px;"><svg id="SvgjsSvg2117" width="466" height="317" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="466" height="317"><div class="apexcharts-legend apexcharts-align-left apx-legend-position-top" xmlns="http://www.w3.org/1999/xhtml" style="right: 0px; position: absolute; left: 0px; top: 4px; max-height: 158.5px;"><div class="apexcharts-legend-series" rel="1" seriesname="2024" data:collapsed="false" style="margin: 2px 10px;"><span class="apexcharts-legend-marker" rel="1" data:collapsed="false" style="background: rgb(105, 108, 255) !important; color: rgb(105, 108, 255); height: 8px; width: 8px; left: -5px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="1" i="0" data:default-text="2024" data:collapsed="false" style="color: rgb(100, 110, 120); font-size: 13px; font-weight: 400; font-family: &quot;Public Sans&quot;;">2024</span></div><div class="apexcharts-legend-series" rel="2" seriesname="2023" data:collapsed="false" style="margin: 2px 10px;"><span class="apexcharts-legend-marker" rel="2" data:collapsed="false" style="background: rgb(3, 195, 236) !important; color: rgb(3, 195, 236); height: 8px; width: 8px; left: -5px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="2" i="1" data:default-text="2023" data:collapsed="false" style="color: rgb(100, 110, 120); font-size: 13px; font-weight: 400; font-family: &quot;Public Sans&quot;;">2023</span></div></div><style type="text/css">	
        
        .apexcharts-legend {	
          display: flex;	
          overflow: auto;	
          padding: 0 10px;	
        }	
        .apexcharts-legend.apx-legend-position-bottom, .apexcharts-legend.apx-legend-position-top {	
          flex-wrap: wrap	
        }	
        .apexcharts-legend.apx-legend-position-right, .apexcharts-legend.apx-legend-position-left {	
          flex-direction: column;	
          bottom: 0;	
        }	
        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left, .apexcharts-legend.apx-legend-position-top.apexcharts-align-left, .apexcharts-legend.apx-legend-position-right, .apexcharts-legend.apx-legend-position-left {	
          justify-content: flex-start;	
        }	
        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center, .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {	
          justify-content: center;  	
        }	
        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right, .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {	
          justify-content: flex-end;	
        }	
        .apexcharts-legend-series {	
          cursor: pointer;	
          line-height: normal;	
        }	
        .apexcharts-legend.apx-legend-position-bottom .apexcharts-legend-series, .apexcharts-legend.apx-legend-position-top .apexcharts-legend-series{	
          display: flex;	
          align-items: center;	
        }	
        .apexcharts-legend-text {	
          position: relative;	
          font-size: 14px;	
        }	
        .apexcharts-legend-text *, .apexcharts-legend-marker * {	
          pointer-events: none;	
        }	
        .apexcharts-legend-marker {	
          position: relative;	
          display: inline-block;	
          cursor: pointer;	
          margin-right: 3px;	
          border-style: solid;
        }	
          
        .apexcharts-legend.apexcharts-align-right .apexcharts-legend-series, .apexcharts-legend.apexcharts-align-left .apexcharts-legend-series{	
          display: inline-block;	
        }	
        .apexcharts-legend-series.apexcharts-no-click {	
          cursor: auto;	
        }	
        .apexcharts-legend .apexcharts-hidden-zero-series, .apexcharts-legend .apexcharts-hidden-null-series {	
          display: none !important;	
        }	
        .apexcharts-inactive-legend {	
          opacity: 0.45;	
        }</style></foreignObject><g id="SvgjsG2119" class="apexcharts-inner apexcharts-graphical" transform="translate(55.59029579162598, 52)"><defs id="SvgjsDefs2118"><linearGradient id="SvgjsLinearGradient2123" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2124" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2125" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2126" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskd9y7oj6u"><rect id="SvgjsRect2128" width="400.409704208374" height="240.62888854598998" x="-5" y="-3" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskd9y7oj6u"></clipPath><clipPath id="nonForecastMaskd9y7oj6u"></clipPath><clipPath id="gridRectMarkerMaskd9y7oj6u"><rect id="SvgjsRect2129" width="394.409704208374" height="238.62888854598998" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2127" width="19.520485210418702" height="234.62888854598998" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2123)" class="apexcharts-xcrosshairs" y2="234.62888854598998" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2149" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2150" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText2152" font-family="Public Sans" x="27.886407443455287" y="263.62888854599" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2153">Jan</tspan><title>Jan</title></text><text id="SvgjsText2155" font-family="Public Sans" x="83.65922233036586" y="263.62888854599" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2156">Feb</tspan><title>Feb</title></text><text id="SvgjsText2158" font-family="Public Sans" x="139.43203721727645" y="263.62888854599" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2159">Mar</tspan><title>Mar</title></text><text id="SvgjsText2161" font-family="Public Sans" x="195.204852104187" y="263.62888854599" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2162">Apr</tspan><title>Apr</title></text><text id="SvgjsText2164" font-family="Public Sans" x="250.9776669910976" y="263.62888854599" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2165">May</tspan><title>May</title></text><text id="SvgjsText2167" font-family="Public Sans" x="306.75048187800815" y="263.62888854599" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2168">Jun</tspan><title>Jun</title></text><text id="SvgjsText2170" font-family="Public Sans" x="362.5232967649187" y="263.62888854599" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2171">Jul</tspan><title>Jul</title></text></g></g><g id="SvgjsG2186" class="apexcharts-grid"><g id="SvgjsG2187" class="apexcharts-gridlines-horizontal"><line id="SvgjsLine2189" x1="0" y1="0" x2="390.409704208374" y2="0" stroke="#e4e6e8" stroke-dasharray="7" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2190" x1="0" y1="46.925777709197995" x2="390.409704208374" y2="46.925777709197995" stroke="#e4e6e8" stroke-dasharray="7" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2191" x1="0" y1="93.85155541839599" x2="390.409704208374" y2="93.85155541839599" stroke="#e4e6e8" stroke-dasharray="7" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2192" x1="0" y1="140.77733312759398" x2="390.409704208374" y2="140.77733312759398" stroke="#e4e6e8" stroke-dasharray="7" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2193" x1="0" y1="187.70311083679198" x2="390.409704208374" y2="187.70311083679198" stroke="#e4e6e8" stroke-dasharray="7" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2194" x1="0" y1="234.62888854598998" x2="390.409704208374" y2="234.62888854598998" stroke="#e4e6e8" stroke-dasharray="7" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG2188" class="apexcharts-gridlines-vertical"></g><line id="SvgjsLine2196" x1="0" y1="234.62888854598998" x2="390.409704208374" y2="234.62888854598998" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2195" x1="0" y1="1" x2="0" y2="234.62888854598998" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2130" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2131" class="apexcharts-series" seriesName="2024" rel="1" data:realIndex="0"><path id="SvgjsPath2133" d="M 18.126164838245934 130.77733312759398L 18.126164838245934 66.31093325103758Q 18.126164838245934 56.31093325103758 28.126164838245934 56.31093325103758L 21.64665004866464 56.31093325103758Q 31.64665004866464 56.31093325103758 31.64665004866464 66.31093325103758L 31.64665004866464 66.31093325103758L 31.64665004866464 130.77733312759398Q 31.64665004866464 140.77733312759398 21.64665004866464 140.77733312759398L 28.126164838245934 140.77733312759398Q 18.126164838245934 140.77733312759398 18.126164838245934 130.77733312759398z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 18.126164838245934 130.77733312759398L 18.126164838245934 66.31093325103758Q 18.126164838245934 56.31093325103758 28.126164838245934 56.31093325103758L 21.64665004866464 56.31093325103758Q 31.64665004866464 56.31093325103758 31.64665004866464 66.31093325103758L 31.64665004866464 66.31093325103758L 31.64665004866464 130.77733312759398Q 31.64665004866464 140.77733312759398 21.64665004866464 140.77733312759398L 28.126164838245934 140.77733312759398Q 18.126164838245934 140.77733312759398 18.126164838245934 130.77733312759398z" pathFrom="M 18.126164838245934 130.77733312759398L 18.126164838245934 130.77733312759398L 31.64665004866464 130.77733312759398L 31.64665004866464 130.77733312759398L 31.64665004866464 130.77733312759398L 31.64665004866464 130.77733312759398L 31.64665004866464 130.77733312759398L 18.126164838245934 130.77733312759398" cy="56.31093325103758" cx="70.89897972515651" j="0" val="18" barHeight="84.4663998765564" barWidth="19.520485210418702"></path><path id="SvgjsPath2134" d="M 73.89897972515651 130.77733312759398L 73.89897972515651 117.92928873115538Q 73.89897972515651 107.92928873115538 83.89897972515651 107.92928873115538L 77.4194649355752 107.92928873115538Q 87.4194649355752 107.92928873115538 87.4194649355752 117.92928873115538L 87.4194649355752 117.92928873115538L 87.4194649355752 130.77733312759398Q 87.4194649355752 140.77733312759398 77.4194649355752 140.77733312759398L 83.89897972515651 140.77733312759398Q 73.89897972515651 140.77733312759398 73.89897972515651 130.77733312759398z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 73.89897972515651 130.77733312759398L 73.89897972515651 117.92928873115538Q 73.89897972515651 107.92928873115538 83.89897972515651 107.92928873115538L 77.4194649355752 107.92928873115538Q 87.4194649355752 107.92928873115538 87.4194649355752 117.92928873115538L 87.4194649355752 117.92928873115538L 87.4194649355752 130.77733312759398Q 87.4194649355752 140.77733312759398 77.4194649355752 140.77733312759398L 83.89897972515651 140.77733312759398Q 73.89897972515651 140.77733312759398 73.89897972515651 130.77733312759398z" pathFrom="M 73.89897972515651 130.77733312759398L 73.89897972515651 130.77733312759398L 87.4194649355752 130.77733312759398L 87.4194649355752 130.77733312759398L 87.4194649355752 130.77733312759398L 87.4194649355752 130.77733312759398L 87.4194649355752 130.77733312759398L 73.89897972515651 130.77733312759398" cy="107.92928873115538" cx="126.67179461206709" j="1" val="7" barHeight="32.848044396438596" barWidth="19.520485210418702"></path><path id="SvgjsPath2135" d="M 129.6717946120671 130.77733312759398L 129.6717946120671 80.38866656379699Q 129.6717946120671 70.38866656379699 139.6717946120671 70.38866656379699L 133.1922798224858 70.38866656379699Q 143.1922798224858 70.38866656379699 143.1922798224858 80.38866656379699L 143.1922798224858 80.38866656379699L 143.1922798224858 130.77733312759398Q 143.1922798224858 140.77733312759398 133.1922798224858 140.77733312759398L 139.6717946120671 140.77733312759398Q 129.6717946120671 140.77733312759398 129.6717946120671 130.77733312759398z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 129.6717946120671 130.77733312759398L 129.6717946120671 80.38866656379699Q 129.6717946120671 70.38866656379699 139.6717946120671 70.38866656379699L 133.1922798224858 70.38866656379699Q 143.1922798224858 70.38866656379699 143.1922798224858 80.38866656379699L 143.1922798224858 80.38866656379699L 143.1922798224858 130.77733312759398Q 143.1922798224858 140.77733312759398 133.1922798224858 140.77733312759398L 139.6717946120671 140.77733312759398Q 129.6717946120671 140.77733312759398 129.6717946120671 130.77733312759398z" pathFrom="M 129.6717946120671 130.77733312759398L 129.6717946120671 130.77733312759398L 143.1922798224858 130.77733312759398L 143.1922798224858 130.77733312759398L 143.1922798224858 130.77733312759398L 143.1922798224858 130.77733312759398L 143.1922798224858 130.77733312759398L 129.6717946120671 130.77733312759398" cy="70.38866656379699" cx="182.44460949897766" j="2" val="15" barHeight="70.38866656379699" barWidth="19.520485210418702"></path><path id="SvgjsPath2136" d="M 185.44460949897766 130.77733312759398L 185.44460949897766 14.692577770919797Q 185.44460949897766 4.692577770919797 195.44460949897766 4.692577770919797L 188.96509470939637 4.692577770919797Q 198.96509470939637 4.692577770919797 198.96509470939637 14.692577770919797L 198.96509470939637 14.692577770919797L 198.96509470939637 130.77733312759398Q 198.96509470939637 140.77733312759398 188.96509470939637 140.77733312759398L 195.44460949897766 140.77733312759398Q 185.44460949897766 140.77733312759398 185.44460949897766 130.77733312759398z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 185.44460949897766 130.77733312759398L 185.44460949897766 14.692577770919797Q 185.44460949897766 4.692577770919797 195.44460949897766 4.692577770919797L 188.96509470939637 4.692577770919797Q 198.96509470939637 4.692577770919797 198.96509470939637 14.692577770919797L 198.96509470939637 14.692577770919797L 198.96509470939637 130.77733312759398Q 198.96509470939637 140.77733312759398 188.96509470939637 140.77733312759398L 195.44460949897766 140.77733312759398Q 185.44460949897766 140.77733312759398 185.44460949897766 130.77733312759398z" pathFrom="M 185.44460949897766 130.77733312759398L 185.44460949897766 130.77733312759398L 198.96509470939637 130.77733312759398L 198.96509470939637 130.77733312759398L 198.96509470939637 130.77733312759398L 198.96509470939637 130.77733312759398L 198.96509470939637 130.77733312759398L 185.44460949897766 130.77733312759398" cy="4.692577770919797" cx="238.21742438588822" j="3" val="29" barHeight="136.08475535667418" barWidth="19.520485210418702"></path><path id="SvgjsPath2137" d="M 241.21742438588822 130.77733312759398L 241.21742438588822 66.31093325103758Q 241.21742438588822 56.31093325103758 251.21742438588822 56.31093325103758L 244.7379095963069 56.31093325103758Q 254.7379095963069 56.31093325103758 254.7379095963069 66.31093325103758L 254.7379095963069 66.31093325103758L 254.7379095963069 130.77733312759398Q 254.7379095963069 140.77733312759398 244.7379095963069 140.77733312759398L 251.21742438588822 140.77733312759398Q 241.21742438588822 140.77733312759398 241.21742438588822 130.77733312759398z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 241.21742438588822 130.77733312759398L 241.21742438588822 66.31093325103758Q 241.21742438588822 56.31093325103758 251.21742438588822 56.31093325103758L 244.7379095963069 56.31093325103758Q 254.7379095963069 56.31093325103758 254.7379095963069 66.31093325103758L 254.7379095963069 66.31093325103758L 254.7379095963069 130.77733312759398Q 254.7379095963069 140.77733312759398 244.7379095963069 140.77733312759398L 251.21742438588822 140.77733312759398Q 241.21742438588822 140.77733312759398 241.21742438588822 130.77733312759398z" pathFrom="M 241.21742438588822 130.77733312759398L 241.21742438588822 130.77733312759398L 254.7379095963069 130.77733312759398L 254.7379095963069 130.77733312759398L 254.7379095963069 130.77733312759398L 254.7379095963069 130.77733312759398L 254.7379095963069 130.77733312759398L 241.21742438588822 130.77733312759398" cy="56.31093325103758" cx="293.9902392727988" j="4" val="18" barHeight="84.4663998765564" barWidth="19.520485210418702"></path><path id="SvgjsPath2138" d="M 296.9902392727988 130.77733312759398L 296.9902392727988 94.46639987655638Q 296.9902392727988 84.46639987655638 306.9902392727988 84.46639987655638L 300.51072448321753 84.46639987655638Q 310.51072448321753 84.46639987655638 310.51072448321753 94.46639987655638L 310.51072448321753 94.46639987655638L 310.51072448321753 130.77733312759398Q 310.51072448321753 140.77733312759398 300.51072448321753 140.77733312759398L 306.9902392727988 140.77733312759398Q 296.9902392727988 140.77733312759398 296.9902392727988 130.77733312759398z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 296.9902392727988 130.77733312759398L 296.9902392727988 94.46639987655638Q 296.9902392727988 84.46639987655638 306.9902392727988 84.46639987655638L 300.51072448321753 84.46639987655638Q 310.51072448321753 84.46639987655638 310.51072448321753 94.46639987655638L 310.51072448321753 94.46639987655638L 310.51072448321753 130.77733312759398Q 310.51072448321753 140.77733312759398 300.51072448321753 140.77733312759398L 306.9902392727988 140.77733312759398Q 296.9902392727988 140.77733312759398 296.9902392727988 130.77733312759398z" pathFrom="M 296.9902392727988 130.77733312759398L 296.9902392727988 130.77733312759398L 310.51072448321753 130.77733312759398L 310.51072448321753 130.77733312759398L 310.51072448321753 130.77733312759398L 310.51072448321753 130.77733312759398L 310.51072448321753 130.77733312759398L 296.9902392727988 130.77733312759398" cy="84.46639987655638" cx="349.7630541597094" j="5" val="12" barHeight="56.310933251037596" barWidth="19.520485210418702"></path><path id="SvgjsPath2139" d="M 352.7630541597094 130.77733312759398L 352.7630541597094 108.54413318931577Q 352.7630541597094 98.54413318931577 362.7630541597094 98.54413318931577L 356.2835393701281 98.54413318931577Q 366.2835393701281 98.54413318931577 366.2835393701281 108.54413318931577L 366.2835393701281 108.54413318931577L 366.2835393701281 130.77733312759398Q 366.2835393701281 140.77733312759398 356.2835393701281 140.77733312759398L 362.7630541597094 140.77733312759398Q 352.7630541597094 140.77733312759398 352.7630541597094 130.77733312759398z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 352.7630541597094 130.77733312759398L 352.7630541597094 108.54413318931577Q 352.7630541597094 98.54413318931577 362.7630541597094 98.54413318931577L 356.2835393701281 98.54413318931577Q 366.2835393701281 98.54413318931577 366.2835393701281 108.54413318931577L 366.2835393701281 108.54413318931577L 366.2835393701281 130.77733312759398Q 366.2835393701281 140.77733312759398 356.2835393701281 140.77733312759398L 362.7630541597094 140.77733312759398Q 352.7630541597094 140.77733312759398 352.7630541597094 130.77733312759398z" pathFrom="M 352.7630541597094 130.77733312759398L 352.7630541597094 130.77733312759398L 366.2835393701281 130.77733312759398L 366.2835393701281 130.77733312759398L 366.2835393701281 130.77733312759398L 366.2835393701281 130.77733312759398L 366.2835393701281 130.77733312759398L 352.7630541597094 130.77733312759398" cy="98.54413318931577" cx="405.53586904661995" j="6" val="9" barHeight="42.2331999382782" barWidth="19.520485210418702"></path></g><g id="SvgjsG2140" class="apexcharts-series" seriesName="2023" rel="2" data:realIndex="1"><path id="SvgjsPath2142" d="M 18.126164838245934 160.77733312759398L 18.126164838245934 201.78084414955137Q 18.126164838245934 211.78084414955137 28.126164838245934 211.78084414955137L 21.64665004866464 211.78084414955137Q 31.64665004866464 211.78084414955137 31.64665004866464 201.78084414955137L 31.64665004866464 201.78084414955137L 31.64665004866464 160.77733312759398Q 31.64665004866464 150.77733312759398 21.64665004866464 150.77733312759398L 28.126164838245934 150.77733312759398Q 18.126164838245934 150.77733312759398 18.126164838245934 160.77733312759398z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 18.126164838245934 160.77733312759398L 18.126164838245934 201.78084414955137Q 18.126164838245934 211.78084414955137 28.126164838245934 211.78084414955137L 21.64665004866464 211.78084414955137Q 31.64665004866464 211.78084414955137 31.64665004866464 201.78084414955137L 31.64665004866464 201.78084414955137L 31.64665004866464 160.77733312759398Q 31.64665004866464 150.77733312759398 21.64665004866464 150.77733312759398L 28.126164838245934 150.77733312759398Q 18.126164838245934 150.77733312759398 18.126164838245934 160.77733312759398z" pathFrom="M 18.126164838245934 160.77733312759398L 18.126164838245934 160.77733312759398L 31.64665004866464 160.77733312759398L 31.64665004866464 160.77733312759398L 31.64665004866464 160.77733312759398L 31.64665004866464 160.77733312759398L 31.64665004866464 160.77733312759398L 18.126164838245934 160.77733312759398" cy="191.78084414955137" cx="70.89897972515651" j="0" val="-13" barHeight="-61.003511021957394" barWidth="19.520485210418702"></path><path id="SvgjsPath2143" d="M 73.89897972515651 160.77733312759398L 73.89897972515651 225.24373300415039Q 73.89897972515651 235.24373300415039 83.89897972515651 235.24373300415039L 77.4194649355752 235.24373300415039Q 87.4194649355752 235.24373300415039 87.4194649355752 225.24373300415039L 87.4194649355752 225.24373300415039L 87.4194649355752 160.77733312759398Q 87.4194649355752 150.77733312759398 77.4194649355752 150.77733312759398L 83.89897972515651 150.77733312759398Q 73.89897972515651 150.77733312759398 73.89897972515651 160.77733312759398z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 73.89897972515651 160.77733312759398L 73.89897972515651 225.24373300415039Q 73.89897972515651 235.24373300415039 83.89897972515651 235.24373300415039L 77.4194649355752 235.24373300415039Q 87.4194649355752 235.24373300415039 87.4194649355752 225.24373300415039L 87.4194649355752 225.24373300415039L 87.4194649355752 160.77733312759398Q 87.4194649355752 150.77733312759398 77.4194649355752 150.77733312759398L 83.89897972515651 150.77733312759398Q 73.89897972515651 150.77733312759398 73.89897972515651 160.77733312759398z" pathFrom="M 73.89897972515651 160.77733312759398L 73.89897972515651 160.77733312759398L 87.4194649355752 160.77733312759398L 87.4194649355752 160.77733312759398L 87.4194649355752 160.77733312759398L 87.4194649355752 160.77733312759398L 87.4194649355752 160.77733312759398L 73.89897972515651 160.77733312759398" cy="215.24373300415039" cx="126.67179461206709" j="1" val="-18" barHeight="-84.4663998765564" barWidth="19.520485210418702"></path><path id="SvgjsPath2144" d="M 129.6717946120671 160.77733312759398L 129.6717946120671 183.01053306587218Q 129.6717946120671 193.01053306587218 139.6717946120671 193.01053306587218L 133.1922798224858 193.01053306587218Q 143.1922798224858 193.01053306587218 143.1922798224858 183.01053306587218L 143.1922798224858 183.01053306587218L 143.1922798224858 160.77733312759398Q 143.1922798224858 150.77733312759398 133.1922798224858 150.77733312759398L 139.6717946120671 150.77733312759398Q 129.6717946120671 150.77733312759398 129.6717946120671 160.77733312759398z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 129.6717946120671 160.77733312759398L 129.6717946120671 183.01053306587218Q 129.6717946120671 193.01053306587218 139.6717946120671 193.01053306587218L 133.1922798224858 193.01053306587218Q 143.1922798224858 193.01053306587218 143.1922798224858 183.01053306587218L 143.1922798224858 183.01053306587218L 143.1922798224858 160.77733312759398Q 143.1922798224858 150.77733312759398 133.1922798224858 150.77733312759398L 139.6717946120671 150.77733312759398Q 129.6717946120671 150.77733312759398 129.6717946120671 160.77733312759398z" pathFrom="M 129.6717946120671 160.77733312759398L 129.6717946120671 160.77733312759398L 143.1922798224858 160.77733312759398L 143.1922798224858 160.77733312759398L 143.1922798224858 160.77733312759398L 143.1922798224858 160.77733312759398L 143.1922798224858 160.77733312759398L 129.6717946120671 160.77733312759398" cy="173.01053306587218" cx="182.44460949897766" j="2" val="-9" barHeight="-42.2331999382782" barWidth="19.520485210418702"></path><path id="SvgjsPath2145" d="M 185.44460949897766 160.77733312759398L 185.44460949897766 206.47342192047117Q 185.44460949897766 216.47342192047117 195.44460949897766 216.47342192047117L 188.96509470939637 216.47342192047117Q 198.96509470939637 216.47342192047117 198.96509470939637 206.47342192047117L 198.96509470939637 206.47342192047117L 198.96509470939637 160.77733312759398Q 198.96509470939637 150.77733312759398 188.96509470939637 150.77733312759398L 195.44460949897766 150.77733312759398Q 185.44460949897766 150.77733312759398 185.44460949897766 160.77733312759398z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 185.44460949897766 160.77733312759398L 185.44460949897766 206.47342192047117Q 185.44460949897766 216.47342192047117 195.44460949897766 216.47342192047117L 188.96509470939637 216.47342192047117Q 198.96509470939637 216.47342192047117 198.96509470939637 206.47342192047117L 198.96509470939637 206.47342192047117L 198.96509470939637 160.77733312759398Q 198.96509470939637 150.77733312759398 188.96509470939637 150.77733312759398L 195.44460949897766 150.77733312759398Q 185.44460949897766 150.77733312759398 185.44460949897766 160.77733312759398z" pathFrom="M 185.44460949897766 160.77733312759398L 185.44460949897766 160.77733312759398L 198.96509470939637 160.77733312759398L 198.96509470939637 160.77733312759398L 198.96509470939637 160.77733312759398L 198.96509470939637 160.77733312759398L 198.96509470939637 160.77733312759398L 185.44460949897766 160.77733312759398" cy="196.47342192047117" cx="238.21742438588822" j="3" val="-14" barHeight="-65.69608879287719" barWidth="19.520485210418702"></path><path id="SvgjsPath2146" d="M 241.21742438588822 160.77733312759398L 241.21742438588822 164.24022198219296Q 241.21742438588822 174.24022198219296 251.21742438588822 174.24022198219296L 244.7379095963069 174.24022198219296Q 254.7379095963069 174.24022198219296 254.7379095963069 164.24022198219296L 254.7379095963069 164.24022198219296L 254.7379095963069 160.77733312759398Q 254.7379095963069 150.77733312759398 244.7379095963069 150.77733312759398L 251.21742438588822 150.77733312759398Q 241.21742438588822 150.77733312759398 241.21742438588822 160.77733312759398z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 241.21742438588822 160.77733312759398L 241.21742438588822 164.24022198219296Q 241.21742438588822 174.24022198219296 251.21742438588822 174.24022198219296L 244.7379095963069 174.24022198219296Q 254.7379095963069 174.24022198219296 254.7379095963069 164.24022198219296L 254.7379095963069 164.24022198219296L 254.7379095963069 160.77733312759398Q 254.7379095963069 150.77733312759398 244.7379095963069 150.77733312759398L 251.21742438588822 150.77733312759398Q 241.21742438588822 150.77733312759398 241.21742438588822 160.77733312759398z" pathFrom="M 241.21742438588822 160.77733312759398L 241.21742438588822 160.77733312759398L 254.7379095963069 160.77733312759398L 254.7379095963069 160.77733312759398L 254.7379095963069 160.77733312759398L 254.7379095963069 160.77733312759398L 254.7379095963069 160.77733312759398L 241.21742438588822 160.77733312759398" cy="154.24022198219296" cx="293.9902392727988" j="4" val="-5" barHeight="-23.462888854598997" barWidth="19.520485210418702"></path><path id="SvgjsPath2147" d="M 296.9902392727988 160.77733312759398L 296.9902392727988 220.5511552332306Q 296.9902392727988 230.5511552332306 306.9902392727988 230.5511552332306L 300.51072448321753 230.5511552332306Q 310.51072448321753 230.5511552332306 310.51072448321753 220.5511552332306L 310.51072448321753 220.5511552332306L 310.51072448321753 160.77733312759398Q 310.51072448321753 150.77733312759398 300.51072448321753 150.77733312759398L 306.9902392727988 150.77733312759398Q 296.9902392727988 150.77733312759398 296.9902392727988 160.77733312759398z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 296.9902392727988 160.77733312759398L 296.9902392727988 220.5511552332306Q 296.9902392727988 230.5511552332306 306.9902392727988 230.5511552332306L 300.51072448321753 230.5511552332306Q 310.51072448321753 230.5511552332306 310.51072448321753 220.5511552332306L 310.51072448321753 220.5511552332306L 310.51072448321753 160.77733312759398Q 310.51072448321753 150.77733312759398 300.51072448321753 150.77733312759398L 306.9902392727988 150.77733312759398Q 296.9902392727988 150.77733312759398 296.9902392727988 160.77733312759398z" pathFrom="M 296.9902392727988 160.77733312759398L 296.9902392727988 160.77733312759398L 310.51072448321753 160.77733312759398L 310.51072448321753 160.77733312759398L 310.51072448321753 160.77733312759398L 310.51072448321753 160.77733312759398L 310.51072448321753 160.77733312759398L 296.9902392727988 160.77733312759398" cy="210.5511552332306" cx="349.7630541597094" j="5" val="-17" barHeight="-79.7738221056366" barWidth="19.520485210418702"></path><path id="SvgjsPath2148" d="M 352.7630541597094 160.77733312759398L 352.7630541597094 211.16599969139097Q 352.7630541597094 221.16599969139097 362.7630541597094 221.16599969139097L 356.2835393701281 221.16599969139097Q 366.2835393701281 221.16599969139097 366.2835393701281 211.16599969139097L 366.2835393701281 211.16599969139097L 366.2835393701281 160.77733312759398Q 366.2835393701281 150.77733312759398 356.2835393701281 150.77733312759398L 362.7630541597094 150.77733312759398Q 352.7630541597094 150.77733312759398 352.7630541597094 160.77733312759398z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke="#ffffff" stroke-opacity="1" stroke-linecap="round" stroke-width="6" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskd9y7oj6u)" pathTo="M 352.7630541597094 160.77733312759398L 352.7630541597094 211.16599969139097Q 352.7630541597094 221.16599969139097 362.7630541597094 221.16599969139097L 356.2835393701281 221.16599969139097Q 366.2835393701281 221.16599969139097 366.2835393701281 211.16599969139097L 366.2835393701281 211.16599969139097L 366.2835393701281 160.77733312759398Q 366.2835393701281 150.77733312759398 356.2835393701281 150.77733312759398L 362.7630541597094 150.77733312759398Q 352.7630541597094 150.77733312759398 352.7630541597094 160.77733312759398z" pathFrom="M 352.7630541597094 160.77733312759398L 352.7630541597094 160.77733312759398L 366.2835393701281 160.77733312759398L 366.2835393701281 160.77733312759398L 366.2835393701281 160.77733312759398L 366.2835393701281 160.77733312759398L 366.2835393701281 160.77733312759398L 352.7630541597094 160.77733312759398" cy="201.16599969139097" cx="405.53586904661995" j="6" val="-15" barHeight="-70.38866656379699" barWidth="19.520485210418702"></path></g><g id="SvgjsG2132" class="apexcharts-datalabels" data:realIndex="0"></g><g id="SvgjsG2141" class="apexcharts-datalabels" data:realIndex="1"></g></g><line id="SvgjsLine2197" x1="0" y1="0" x2="390.409704208374" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2198" x1="0" y1="0" x2="390.409704208374" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2199" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2200" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2201" class="apexcharts-point-annotations"></g></g><g id="SvgjsG2172" class="apexcharts-yaxis" rel="0" transform="translate(17.590295791625977, 0)"><g id="SvgjsG2173" class="apexcharts-yaxis-texts-g"><text id="SvgjsText2174" font-family="Public Sans" x="20" y="53.5" text-anchor="end" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-yaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2175">30</tspan><title>30</title></text><text id="SvgjsText2176" font-family="Public Sans" x="20" y="100.425777709198" text-anchor="end" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-yaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2177">20</tspan><title>20</title></text><text id="SvgjsText2178" font-family="Public Sans" x="20" y="147.351555418396" text-anchor="end" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-yaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2179">10</tspan><title>10</title></text><text id="SvgjsText2180" font-family="Public Sans" x="20" y="194.277333127594" text-anchor="end" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-yaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2181">0</tspan><title>0</title></text><text id="SvgjsText2182" font-family="Public Sans" x="20" y="241.203110836792" text-anchor="end" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-yaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2183">-10</tspan><title>-10</title></text><text id="SvgjsText2184" font-family="Public Sans" x="20" y="288.12888854599" text-anchor="end" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-yaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan2185">-20</tspan><title>-20</title></text></g></g><g id="SvgjsG2120" class="apexcharts-annotations"></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(105, 108, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(3, 195, 236);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
          <div class="resize-triggers"><div class="expand-trigger"><div style="width: 491px; height: 410px;"></div></div><div class="contract-trigger"></div></div></div>
          <div class="col-lg-4 d-flex align-items-center">
            <div class="card-body px-xl-9" style="position: relative;">
              <div class="text-center mb-6">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-primary">
                    <script>
                    document.write(new Date().getFullYear() - 1)
  
                    </script>2024
                  </button>
                  <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0);">2021</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">2020</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">2019</a></li>
                  </ul>
                </div>
              </div>
  
              <div id="growthChart" style="min-height: 154.875px;"><div id="apexcharts1z3os2qk" class="apexcharts-canvas apexcharts1z3os2qk apexcharts-theme-light" style="width: 202px; height: 154.875px;"><svg id="SvgjsSvg2202" width="202" height="154.875" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2204" class="apexcharts-inner apexcharts-graphical" transform="translate(-6, -25)"><defs id="SvgjsDefs2203"><clipPath id="gridRectMask1z3os2qk"><rect id="SvgjsRect2206" width="222" height="285" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask1z3os2qk"></clipPath><clipPath id="nonForecastMask1z3os2qk"></clipPath><clipPath id="gridRectMarkerMask1z3os2qk"><rect id="SvgjsRect2207" width="220" height="287" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient2212" x1="1" y1="0" x2="0" y2="1"><stop id="SvgjsStop2213" stop-opacity="1" stop-color="rgba(105,108,255,1)" offset="0.3"></stop><stop id="SvgjsStop2214" stop-opacity="0.6" stop-color="rgba(255,255,255,0.6)" offset="0.7"></stop><stop id="SvgjsStop2215" stop-opacity="0.6" stop-color="rgba(255,255,255,0.6)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient2223" x1="1" y1="0" x2="0" y2="1"><stop id="SvgjsStop2224" stop-opacity="1" stop-color="rgba(105,108,255,1)" offset="0.3"></stop><stop id="SvgjsStop2225" stop-opacity="0.6" stop-color="rgba(105,108,255,0.6)" offset="0.7"></stop><stop id="SvgjsStop2226" stop-opacity="0.6" stop-color="rgba(105,108,255,0.6)" offset="1"></stop></linearGradient></defs><g id="SvgjsG2208" class="apexcharts-radialbar"><g id="SvgjsG2209"><g id="SvgjsG2210" class="apexcharts-tracks"><g id="SvgjsG2211" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 73.83506097560974 167.17541022773656 A 68.32987804878049 68.32987804878049 0 1 1 142.16493902439026 167.17541022773656" fill="none" fill-opacity="1" stroke="rgba(255,255,255,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="17.357317073170734" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 73.83506097560974 167.17541022773656 A 68.32987804878049 68.32987804878049 0 1 1 142.16493902439026 167.17541022773656"></path></g></g><g id="SvgjsG2217"><g id="SvgjsG2222" class="apexcharts-series apexcharts-radial-series" seriesName="Growth" rel="1" data:realIndex="0"><path id="SvgjsPath2227" d="M 73.83506097560974 167.17541022773656 A 68.32987804878049 68.32987804878049 0 1 1 175.95555982735613 100.85758285229481" fill="none" fill-opacity="0.85" stroke="url(#SvgjsLinearGradient2223)" stroke-opacity="1" stroke-linecap="butt" stroke-width="17.357317073170734" stroke-dasharray="5" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="234" data:value="78" index="0" j="0" data:pathOrig="M 73.83506097560974 167.17541022773656 A 68.32987804878049 68.32987804878049 0 1 1 175.95555982735613 100.85758285229481"></path></g><circle id="SvgjsCircle2218" r="54.65121951219512" cx="108" cy="108" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG2219" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)" style="opacity: 1;"><text id="SvgjsText2220" font-family="Public Sans" x="108" y="123" text-anchor="middle" dominant-baseline="auto" font-size="15px" font-weight="500" fill="#646e78" class="apexcharts-text apexcharts-datalabel-label" style="font-family: &quot;Public Sans&quot;;">Growth</text><text id="SvgjsText2221" font-family="Public Sans" x="108" y="99" text-anchor="middle" dominant-baseline="auto" font-size="22px" font-weight="500" fill="#384551" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Public Sans&quot;;">78%</text></g></g></g></g><line id="SvgjsLine2228" x1="0" y1="0" x2="216" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2229" x1="0" y1="0" x2="216" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG2205" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div>
              <div class="text-center fw-medium my-6">62% Company Growth</div>
  
              <div class="d-flex gap-3 justify-content-between">
                <div class="d-flex">
                  <div class="avatar me-2">
                    <span class="avatar-initial rounded-2 bg-label-primary"><i class="bx bx-dollar bx-lg text-primary"></i></span>
                  </div>
                  <div class="d-flex flex-column">
                    <small>
                      <script>
                      document.write(new Date().getFullYear() - 1)
  
                      </script>2024
                    </small>
                    <h6 class="mb-0">$32.5k</h6>
                  </div>
                </div>
                <div class="d-flex">
                  <div class="avatar me-2">
                    <span class="avatar-initial rounded-2 bg-label-info"><i class="bx bx-wallet bx-lg text-info"></i></span>
                  </div>
                  <div class="d-flex flex-column">
                    <small>
                      <script>
                      document.write(new Date().getFullYear() - 2)
  
                      </script>2023
                    </small>
                    <h6 class="mb-0">$41.2k</h6>
                  </div>
                </div>
              </div>
            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 275px; height: 375px;"></div></div><div class="contract-trigger"></div></div></div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Total Revenue -->
    <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2">
      <div class="row">
        <div class="col-6 mb-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="paypal" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Payments</p>
              <h4 class="card-title mb-3">$2,456</h4>
              <small class="text-danger fw-medium"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
            </div>
          </div>
        </div>
        <div class="col-6 mb-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="Credit Card" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="cardOpt1">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Transactions</p>
              <h4 class="card-title mb-3">$14,857</h4>
              <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
            </div>
          </div>
        </div>
        <div class="col-12 mb-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center flex-sm-row flex-column gap-10" style="position: relative;">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                  <div class="card-title mb-6">
                    <h5 class="text-nowrap mb-1">Profile Report</h5>
                    <span class="badge bg-label-warning">YEAR 2022</span>
                  </div>
                  <div class="mt-sm-auto">
                    <span class="text-success text-nowrap fw-medium"><i class="bx bx-up-arrow-alt"></i> 68.2%</span>
                    <h4 class="mb-0">$84,686k</h4>
                  </div>
                </div>
                <div id="profileReportChart" style="min-height: 75px;"><div id="apexchartsdoltphr5" class="apexcharts-canvas apexchartsdoltphr5 apexcharts-theme-light" style="width: 150px; height: 75px;"><svg id="SvgjsSvg2231" width="150" height="75" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2233" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs2232"><clipPath id="gridRectMaskdoltphr5"><rect id="SvgjsRect2238" width="151" height="80" x="-4.5" y="-2.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskdoltphr5"></clipPath><clipPath id="nonForecastMaskdoltphr5"></clipPath><clipPath id="gridRectMarkerMaskdoltphr5"><rect id="SvgjsRect2239" width="146" height="79" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><filter id="SvgjsFilter2245" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood2246" flood-color="#ffab00" flood-opacity="0.15" result="SvgjsFeFlood2246Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite2247" in="SvgjsFeFlood2246Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2247Out"></feComposite><feOffset id="SvgjsFeOffset2248" dx="5" dy="10" result="SvgjsFeOffset2248Out" in="SvgjsFeComposite2247Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur2249" stdDeviation="3 " result="SvgjsFeGaussianBlur2249Out" in="SvgjsFeOffset2248Out"></feGaussianBlur><feMerge id="SvgjsFeMerge2250" result="SvgjsFeMerge2250Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode2251" in="SvgjsFeGaussianBlur2249Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode2252" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend2253" in="SourceGraphic" in2="SvgjsFeMerge2250Out" mode="normal" result="SvgjsFeBlend2253Out"></feBlend></filter></defs><line id="SvgjsLine2237" x1="0" y1="0" x2="0" y2="75" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="75" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG2254" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2255" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2263" class="apexcharts-grid"><g id="SvgjsG2264" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2266" x1="0" y1="0" x2="142" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2267" x1="0" y1="18.75" x2="142" y2="18.75" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2268" x1="0" y1="37.5" x2="142" y2="37.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2269" x1="0" y1="56.25" x2="142" y2="56.25" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2270" x1="0" y1="75" x2="142" y2="75" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG2265" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2272" x1="0" y1="75" x2="142" y2="75" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2271" x1="0" y1="1" x2="0" y2="75" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2240" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG2241" class="apexcharts-series" seriesName="seriesx1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath2244" d="M 0 71.25C 9.94 71.25 18.46 11.25 28.4 11.25C 38.339999999999996 11.25 46.86 58.125 56.8 58.125C 66.74 58.125 75.26 20.625 85.2 20.625C 95.14 20.625 103.66 35.625 113.6 35.625C 123.53999999999999 35.625 132.06 5.625 142 5.625" fill="none" fill-opacity="1" stroke="rgba(255,171,0,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskdoltphr5)" filter="url(#SvgjsFilter2245)" pathTo="M 0 71.25C 9.94 71.25 18.46 11.25 28.4 11.25C 38.339999999999996 11.25 46.86 58.125 56.8 58.125C 66.74 58.125 75.26 20.625 85.2 20.625C 95.14 20.625 103.66 35.625 113.6 35.625C 123.53999999999999 35.625 132.06 5.625 142 5.625" pathFrom="M -1 112.5L -1 112.5L 28.4 112.5L 56.8 112.5L 85.2 112.5L 113.6 112.5L 142 112.5"></path><g id="SvgjsG2242" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle2278" r="0" cx="0" cy="0" class="apexcharts-marker wxpu0k2fd no-pointer-events" stroke="#ffffff" fill="#ffab00" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG2243" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2273" x1="0" y1="0" x2="142" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2274" x1="0" y1="0" x2="142" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2275" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2276" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2277" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect2236" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG2262" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2234" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 37.5px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 171, 0);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
              <div class="resize-triggers"><div class="expand-trigger"><div style="width: 308px; height: 141px;"></div></div><div class="contract-trigger"></div></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- Order Statistics -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1 me-2">Order Statistics</h5>
            <p class="card-subtitle">42.82k Total Sales</p>
          </div>
          <div class="dropdown">
            <button class="btn text-muted p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bx bx-dots-vertical-rounded bx-lg"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
              <a class="dropdown-item" href="javascript:void(0);">Select All</a>
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-6" style="position: relative;">
            <div class="d-flex flex-column align-items-center gap-1">
              <h3 class="mb-1">8,258</h3>
              <small>Total Orders</small>
            </div>
            <div id="orderStatisticsChart" style="min-height: 117.55px;"><div id="apexcharts4n1oou41" class="apexcharts-canvas apexcharts4n1oou41 apexcharts-theme-light" style="width: 110px; height: 117.55px;"><svg id="SvgjsSvg2279" width="110" height="117.55" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2281" class="apexcharts-inner apexcharts-graphical" transform="translate(-7, 0)"><defs id="SvgjsDefs2280"><clipPath id="gridRectMask4n1oou41"><rect id="SvgjsRect2283" width="130" height="153" x="-4.5" y="-2.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask4n1oou41"></clipPath><clipPath id="nonForecastMask4n1oou41"></clipPath><clipPath id="gridRectMarkerMask4n1oou41"><rect id="SvgjsRect2284" width="125" height="152" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG2285" class="apexcharts-pie"><g id="SvgjsG2286" transform="translate(0, 0) scale(1)"><circle id="SvgjsCircle2287" r="37.518292682926834" cx="60.5" cy="60.5" fill="transparent"></circle><g id="SvgjsG2288" class="apexcharts-slices"><g id="SvgjsG2289" class="apexcharts-series apexcharts-pie-series" seriesName="Electronic" rel="1" data:realIndex="0"><path id="SvgjsPath2290" d="M 60.5 10.475609756097555 A 50.024390243902445 50.024390243902445 0 0 1 110.52439024390245 60.5 L 98.01829268292684 60.5 A 37.518292682926834 37.518292682926834 0 0 0 60.5 22.981707317073166 L 60.5 10.475609756097555 z" fill="rgba(113,221,55,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-0" index="0" j="0" data:angle="90" data:startAngle="0" data:strokeWidth="5" data:value="50" data:pathOrig="M 60.5 10.475609756097555 A 50.024390243902445 50.024390243902445 0 0 1 110.52439024390245 60.5 L 98.01829268292684 60.5 A 37.518292682926834 37.518292682926834 0 0 0 60.5 22.981707317073166 L 60.5 10.475609756097555 z" stroke="#ffffff"></path></g><g id="SvgjsG2291" class="apexcharts-series apexcharts-pie-series" seriesName="Sports" rel="2" data:realIndex="1"><path id="SvgjsPath2292" d="M 110.52439024390245 60.5 A 50.024390243902445 50.024390243902445 0 0 1 15.92794192413799 83.21059792599539 L 27.07095644310349 77.53294844449654 A 37.518292682926834 37.518292682926834 0 0 0 98.01829268292684 60.5 L 110.52439024390245 60.5 z" fill="rgba(105,108,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-1" index="0" j="1" data:angle="153" data:startAngle="90" data:strokeWidth="5" data:value="85" data:pathOrig="M 110.52439024390245 60.5 A 50.024390243902445 50.024390243902445 0 0 1 15.92794192413799 83.21059792599539 L 27.07095644310349 77.53294844449654 A 37.518292682926834 37.518292682926834 0 0 0 98.01829268292684 60.5 L 110.52439024390245 60.5 z" stroke="#ffffff"></path></g><g id="SvgjsG2293" class="apexcharts-series apexcharts-pie-series" seriesName="Decor" rel="3" data:realIndex="2"><path id="SvgjsPath2294" d="M 15.92794192413799 83.21059792599539 A 50.024390243902445 50.024390243902445 0 0 1 12.923977684844871 45.04161328138981 L 24.817983263633657 48.90620996104236 A 37.518292682926834 37.518292682926834 0 0 0 27.07095644310349 77.53294844449654 L 15.92794192413799 83.21059792599539 z" fill="rgba(133,146,163,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-2" index="0" j="2" data:angle="45" data:startAngle="243" data:strokeWidth="5" data:value="25" data:pathOrig="M 15.92794192413799 83.21059792599539 A 50.024390243902445 50.024390243902445 0 0 1 12.923977684844871 45.04161328138981 L 24.817983263633657 48.90620996104236 A 37.518292682926834 37.518292682926834 0 0 0 27.07095644310349 77.53294844449654 L 15.92794192413799 83.21059792599539 z" stroke="#ffffff"></path></g><g id="SvgjsG2295" class="apexcharts-series apexcharts-pie-series" seriesName="Fashion" rel="4" data:realIndex="3"><path id="SvgjsPath2296" d="M 12.923977684844871 45.04161328138981 A 50.024390243902445 50.024390243902445 0 0 1 60.491269096883734 10.475610518012587 L 60.4934518226628 22.98170788850944 A 37.518292682926834 37.518292682926834 0 0 0 24.817983263633657 48.90620996104236 L 12.923977684844871 45.04161328138981 z" fill="rgba(3,195,236,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-3" index="0" j="3" data:angle="72" data:startAngle="288" data:strokeWidth="5" data:value="40" data:pathOrig="M 12.923977684844871 45.04161328138981 A 50.024390243902445 50.024390243902445 0 0 1 60.491269096883734 10.475610518012587 L 60.4934518226628 22.98170788850944 A 37.518292682926834 37.518292682926834 0 0 0 24.817983263633657 48.90620996104236 L 12.923977684844871 45.04161328138981 z" stroke="#ffffff"></path></g></g></g><g id="SvgjsG2297" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"><text id="SvgjsText2298" font-family="Helvetica, Arial, sans-serif" x="60.5" y="77.5" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#646e78" class="apexcharts-text apexcharts-datalabel-label" style="font-family: Helvetica, Arial, sans-serif;">Weekly</text><text id="SvgjsText2299" font-family="Public Sans" x="60.5" y="59.5" text-anchor="middle" dominant-baseline="auto" font-size="18px" font-weight="500" fill="#384551" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Public Sans&quot;;">38%</text></g></g><line id="SvgjsLine2300" x1="0" y1="0" x2="121" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2301" x1="0" y1="0" x2="121" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG2282" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(113, 221, 55);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(105, 108, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 3;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(133, 146, 163);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 4;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(3, 195, 236);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
          <div class="resize-triggers"><div class="expand-trigger"><div style="width: 308px; height: 119px;"></div></div><div class="contract-trigger"></div></div></div>
          <ul class="p-0 m-0">
            <li class="d-flex align-items-center mb-5">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Electronic</h6>
                  <small>Mobile, Earbuds, TV</small>
                </div>
                <div class="user-progress">
                  <h6 class="mb-0">82.5k</h6>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-5">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Fashion</h6>
                  <small>T-shirt, Jeans, Shoes</small>
                </div>
                <div class="user-progress">
                  <h6 class="mb-0">23.8k</h6>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-5">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Decor</h6>
                  <small>Fine Art, Dining</small>
                </div>
                <div class="user-progress">
                  <h6 class="mb-0">849k</h6>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Sports</h6>
                  <small>Football, Cricket Kit</small>
                </div>
                <div class="user-progress">
                  <h6 class="mb-0">99</h6>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Order Statistics -->
  
    <!-- Expense Overview -->
    <div class="col-md-6 col-lg-4 order-1 mb-6">
      <div class="card h-100">
        <div class="card-header nav-align-top">
          <ul class="nav nav-pills" role="tablist">
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income" aria-selected="true">Income</button>
            </li>
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link" role="tab" aria-selected="false" tabindex="-1">Expenses</button>
            </li>
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link" role="tab" aria-selected="false" tabindex="-1">Profit</button>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel" style="position: relative;">
              <div class="d-flex mb-6">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="User">
                </div>
                <div>
                  <p class="mb-0">Total Balance</p>
                  <div class="d-flex align-items-center">
                    <h6 class="mb-0 me-1">$459.10</h6>
                    <small class="text-success fw-medium">
                      <i class="bx bx-chevron-up bx-lg"></i>
                      42.9%
                    </small>
                  </div>
                </div>
              </div>
              <div id="incomeChart" style="min-height: 232px;"><div id="apexchartsibe32afp" class="apexcharts-canvas apexchartsibe32afp apexcharts-theme-light" style="width: 307px; height: 232px;"><svg id="SvgjsSvg2302" width="307" height="232" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2304" class="apexcharts-inner apexcharts-graphical" transform="translate(10, 10)"><defs id="SvgjsDefs2303"><clipPath id="gridRectMaskibe32afp"><rect id="SvgjsRect2309" width="286.6927080154419" height="194.62888854598998" x="-3.5" y="-1.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskibe32afp"></clipPath><clipPath id="nonForecastMaskibe32afp"></clipPath><clipPath id="gridRectMarkerMaskibe32afp"><rect id="SvgjsRect2310" width="307.6927080154419" height="219.62888854598998" x="-14" y="-14" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient2328" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2329" stop-opacity="0.5" stop-color="rgba(105,108,255,0.5)" offset="0"></stop><stop id="SvgjsStop2330" stop-opacity="0.25" stop-color="rgba(195,196,255,0.25)" offset="0.95"></stop><stop id="SvgjsStop2331" stop-opacity="0.25" stop-color="rgba(195,196,255,0.25)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine2308" x1="0" y1="0" x2="0" y2="191.62888854598998" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="191.62888854598998" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG2334" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2335" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText2337" font-family="Helvetica, Arial, sans-serif" x="0" y="220.62888854598998" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2338">Jan</tspan><title>Jan</title></text><text id="SvgjsText2340" font-family="Helvetica, Arial, sans-serif" x="46.61545133590698" y="220.62888854598998" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2341">Feb</tspan><title>Feb</title></text><text id="SvgjsText2343" font-family="Helvetica, Arial, sans-serif" x="93.23090267181396" y="220.62888854598998" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2344">Mar</tspan><title>Mar</title></text><text id="SvgjsText2346" font-family="Helvetica, Arial, sans-serif" x="139.84635400772095" y="220.62888854598998" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2347">Apr</tspan><title>Apr</title></text><text id="SvgjsText2349" font-family="Helvetica, Arial, sans-serif" x="186.46180534362793" y="220.62888854598998" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2350">May</tspan><title>May</title></text><text id="SvgjsText2352" font-family="Helvetica, Arial, sans-serif" x="233.0772566795349" y="220.62888854598998" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2353">Jun</tspan><title>Jun</title></text><text id="SvgjsText2355" font-family="Helvetica, Arial, sans-serif" x="279.6927080154419" y="220.62888854598998" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a7acb2" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2356">Jul</tspan><title>Jul</title></text></g></g><g id="SvgjsG2359" class="apexcharts-grid"><g id="SvgjsG2360" class="apexcharts-gridlines-horizontal"><line id="SvgjsLine2362" x1="0" y1="0" x2="279.6927080154419" y2="0" stroke="#e4e6e8" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2363" x1="0" y1="47.907222136497495" x2="279.6927080154419" y2="47.907222136497495" stroke="#e4e6e8" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2364" x1="0" y1="95.81444427299499" x2="279.6927080154419" y2="95.81444427299499" stroke="#e4e6e8" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2365" x1="0" y1="143.72166640949249" x2="279.6927080154419" y2="143.72166640949249" stroke="#e4e6e8" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2366" x1="0" y1="191.62888854598998" x2="279.6927080154419" y2="191.62888854598998" stroke="#e4e6e8" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG2361" class="apexcharts-gridlines-vertical"></g><line id="SvgjsLine2368" x1="0" y1="191.62888854598998" x2="279.6927080154419" y2="191.62888854598998" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2367" x1="0" y1="1" x2="0" y2="191.62888854598998" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2311" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG2312" class="apexcharts-series" seriesName="seriesx1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath2332" d="M 0 191.62888854598998L 0 138.93094419584276C 16.31540796756744 138.93094419584276 30.30004336833954 95.81444427299499 46.61545133590698 95.81444427299499C 62.93085930347442 95.81444427299499 76.91549470424653 134.140221982193 93.23090267181396 134.140221982193C 109.5463106393814 134.140221982193 123.53094604015351 38.32577770919801 139.84635400772095 38.32577770919801C 156.16176197528839 38.32577770919801 170.1463973760605 114.977333127594 186.46180534362793 114.977333127594C 202.77721331119537 114.977333127594 216.76184871196747 71.86083320474626 233.0772566795349 71.86083320474626C 249.39266464710235 71.86083320474626 263.3773000478744 100.60516648664475 279.6927080154419 100.60516648664475C 279.6927080154419 100.60516648664475 279.6927080154419 100.60516648664475 279.6927080154419 191.62888854598998M 279.6927080154419 100.60516648664475z" fill="url(#SvgjsLinearGradient2328)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskibe32afp)" pathTo="M 0 191.62888854598998L 0 138.93094419584276C 16.31540796756744 138.93094419584276 30.30004336833954 95.81444427299499 46.61545133590698 95.81444427299499C 62.93085930347442 95.81444427299499 76.91549470424653 134.140221982193 93.23090267181396 134.140221982193C 109.5463106393814 134.140221982193 123.53094604015351 38.32577770919801 139.84635400772095 38.32577770919801C 156.16176197528839 38.32577770919801 170.1463973760605 114.977333127594 186.46180534362793 114.977333127594C 202.77721331119537 114.977333127594 216.76184871196747 71.86083320474626 233.0772566795349 71.86083320474626C 249.39266464710235 71.86083320474626 263.3773000478744 100.60516648664475 279.6927080154419 100.60516648664475C 279.6927080154419 100.60516648664475 279.6927080154419 100.60516648664475 279.6927080154419 191.62888854598998M 279.6927080154419 100.60516648664475z" pathFrom="M -1 239.53611068248748L -1 239.53611068248748L 46.61545133590698 239.53611068248748L 93.23090267181396 239.53611068248748L 139.84635400772095 239.53611068248748L 186.46180534362793 239.53611068248748L 233.0772566795349 239.53611068248748L 279.6927080154419 239.53611068248748"></path><path id="SvgjsPath2333" d="M 0 138.93094419584276C 16.31540796756744 138.93094419584276 30.30004336833954 95.81444427299499 46.61545133590698 95.81444427299499C 62.93085930347442 95.81444427299499 76.91549470424653 134.140221982193 93.23090267181396 134.140221982193C 109.5463106393814 134.140221982193 123.53094604015351 38.32577770919801 139.84635400772095 38.32577770919801C 156.16176197528839 38.32577770919801 170.1463973760605 114.977333127594 186.46180534362793 114.977333127594C 202.77721331119537 114.977333127594 216.76184871196747 71.86083320474626 233.0772566795349 71.86083320474626C 249.39266464710235 71.86083320474626 263.3773000478744 100.60516648664475 279.6927080154419 100.60516648664475" fill="none" fill-opacity="1" stroke="#696cff" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskibe32afp)" pathTo="M 0 138.93094419584276C 16.31540796756744 138.93094419584276 30.30004336833954 95.81444427299499 46.61545133590698 95.81444427299499C 62.93085930347442 95.81444427299499 76.91549470424653 134.140221982193 93.23090267181396 134.140221982193C 109.5463106393814 134.140221982193 123.53094604015351 38.32577770919801 139.84635400772095 38.32577770919801C 156.16176197528839 38.32577770919801 170.1463973760605 114.977333127594 186.46180534362793 114.977333127594C 202.77721331119537 114.977333127594 216.76184871196747 71.86083320474626 233.0772566795349 71.86083320474626C 249.39266464710235 71.86083320474626 263.3773000478744 100.60516648664475 279.6927080154419 100.60516648664475" pathFrom="M -1 239.53611068248748L -1 239.53611068248748L 46.61545133590698 239.53611068248748L 93.23090267181396 239.53611068248748L 139.84635400772095 239.53611068248748L 186.46180534362793 239.53611068248748L 233.0772566795349 239.53611068248748L 279.6927080154419 239.53611068248748"></path><g id="SvgjsG2313" class="apexcharts-series-markers-wrap" data:realIndex="0"><g id="SvgjsG2315" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskibe32afp)"><circle id="SvgjsCircle2316" r="6" cx="0" cy="138.93094419584276" class="apexcharts-marker no-pointer-events wcphzz8ns" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="0" j="0" index="0" default-marker-size="6"></circle><circle id="SvgjsCircle2317" r="6" cx="46.61545133590698" cy="95.81444427299499" class="apexcharts-marker no-pointer-events w2tn3yroj" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="1" j="1" index="0" default-marker-size="6"></circle></g><g id="SvgjsG2318" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskibe32afp)"><circle id="SvgjsCircle2319" r="6" cx="93.23090267181396" cy="134.140221982193" class="apexcharts-marker no-pointer-events w1c2f2q8a" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="2" j="2" index="0" default-marker-size="6"></circle></g><g id="SvgjsG2320" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskibe32afp)"><circle id="SvgjsCircle2321" r="6" cx="139.84635400772095" cy="38.32577770919801" class="apexcharts-marker no-pointer-events w1a1h8zpp" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="3" j="3" index="0" default-marker-size="6"></circle></g><g id="SvgjsG2322" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskibe32afp)"><circle id="SvgjsCircle2323" r="6" cx="186.46180534362793" cy="114.977333127594" class="apexcharts-marker no-pointer-events wsapldr06" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="4" j="4" index="0" default-marker-size="6"></circle></g><g id="SvgjsG2324" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskibe32afp)"><circle id="SvgjsCircle2325" r="6" cx="233.0772566795349" cy="71.86083320474626" class="apexcharts-marker no-pointer-events wmhnalpm5" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="5" j="5" index="0" default-marker-size="6"></circle></g><g id="SvgjsG2326" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskibe32afp)"><circle id="SvgjsCircle2327" r="6" cx="279.6927080154419" cy="100.60516648664475" class="apexcharts-marker no-pointer-events wxnb7p4ud" stroke="#696cff" fill="#ffffff" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="6" j="6" index="0" default-marker-size="6"></circle></g></g></g><g id="SvgjsG2314" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2369" x1="0" y1="0" x2="279.6927080154419" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2370" x1="0" y1="0" x2="279.6927080154419" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2371" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2372" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2373" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2374" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2375" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><rect id="SvgjsRect2307" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG2357" class="apexcharts-yaxis" rel="0" transform="translate(-8, 0)"><g id="SvgjsG2358" class="apexcharts-yaxis-texts-g"></g></g><g id="SvgjsG2305" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 116px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(105, 108, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light"><div class="apexcharts-xaxistooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
              <div class="d-flex align-items-center justify-content-center mt-6 gap-3">
                <div class="flex-shrink-0" style="position: relative;">
                  <div id="expensesOfWeek" style="min-height: 57.7px;"><div id="apexcharts9wmzr1ih" class="apexcharts-canvas apexcharts9wmzr1ih apexcharts-theme-light" style="width: 60px; height: 57.7px;"><svg id="SvgjsSvg2376" width="60" height="57.7" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2378" class="apexcharts-inner apexcharts-graphical" transform="translate(-10, -10)"><defs id="SvgjsDefs2377"><clipPath id="gridRectMask9wmzr1ih"><rect id="SvgjsRect2380" width="86" height="87" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask9wmzr1ih"></clipPath><clipPath id="nonForecastMask9wmzr1ih"></clipPath><clipPath id="gridRectMarkerMask9wmzr1ih"><rect id="SvgjsRect2381" width="84" height="89" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG2382" class="apexcharts-radialbar"><g id="SvgjsG2383"><g id="SvgjsG2384" class="apexcharts-tracks"><g id="SvgjsG2385" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 40 19.336585365853654 A 20.663414634146346 20.663414634146346 0 1 1 39.9963935538176 19.336585680575453" fill="none" fill-opacity="1" stroke="rgba(228,230,232,0.85)" stroke-opacity="1" stroke-linecap="round" stroke-width="4.760097560975613" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 40 19.336585365853654 A 20.663414634146346 20.663414634146346 0 1 1 39.9963935538176 19.336585680575453"></path></g></g><g id="SvgjsG2387"><g id="SvgjsG2391" class="apexcharts-series apexcharts-radial-series" seriesName="seriesx1" rel="1" data:realIndex="0"><path id="SvgjsPath2392" d="M 40 19.336585365853654 A 20.663414634146346 20.663414634146346 0 1 1 23.28294639915962 52.1456503839557" fill="none" fill-opacity="0.85" stroke="rgba(105,108,255,0.85)" stroke-opacity="1" stroke-linecap="round" stroke-width="4.907317073170734" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="234" data:value="65" index="0" j="0" data:pathOrig="M 40 19.336585365853654 A 20.663414634146346 20.663414634146346 0 1 1 23.28294639915962 52.1456503839557"></path></g><circle id="SvgjsCircle2388" r="16.283365853658538" cx="40" cy="40" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG2389" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)" style="opacity: 1;"><text id="SvgjsText2390" font-family="Public Sans" x="40" y="45" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#646e78" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Public Sans&quot;;">$65</text></g></g></g></g><line id="SvgjsLine2393" x1="0" y1="0" x2="80" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2394" x1="0" y1="0" x2="80" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG2379" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div>
                <div class="resize-triggers"><div class="expand-trigger"><div style="width: 61px; height: 59px;"></div></div><div class="contract-trigger"></div></div></div>
                <div>
                  <h6 class="mb-0">Income this week</h6>
                  <small>$39k less than last week</small>
                </div>
              </div>
            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 308px; height: 383px;"></div></div><div class="contract-trigger"></div></div></div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Expense Overview -->
  
    <!-- Transactions -->
    <div class="col-md-6 col-lg-4 order-2 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Transactions</h5>
          <div class="dropdown">
            <button class="btn text-muted p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bx bx-dots-vertical-rounded bx-lg"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
              <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
            </div>
          </div>
        </div>
        <div class="card-body pt-4">
          <ul class="p-0 m-0">
            <li class="d-flex align-items-center mb-6">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="d-block">Paypal</small>
                  <h6 class="fw-normal mb-0">Send money</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">
                  <h6 class="fw-normal mb-0">+82.6</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-6">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="d-block">Wallet</small>
                  <h6 class="fw-normal mb-0">Mac'D</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">
                  <h6 class="fw-normal mb-0">+270.69</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-6">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="d-block">Transfer</small>
                  <h6 class="fw-normal mb-0">Refund</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">
                  <h6 class="fw-normal mb-0">+637.91</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-6">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="d-block">Credit Card</small>
                  <h6 class="fw-normal mb-0">Ordered Food</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">
                  <h6 class="fw-normal mb-0">-838.71</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-6">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="d-block">Wallet</small>
                  <h6 class="fw-normal mb-0">Starbucks</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">
                  <h6 class="fw-normal mb-0">+203.33</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="d-block">Mastercard</small>
                  <h6 class="fw-normal mb-0">Ordered Food</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">
                  <h6 class="fw-normal mb-0">-92.45</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Transactions -->
  </div>
  
            </div>
>>>>>>> 594515e (testing)

@endsection
