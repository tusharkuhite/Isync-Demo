@extends('layouts.admin.index')
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

@endsection
