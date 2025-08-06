@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')
    <link href="{{asset('vendors/leaflet/leaflet.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/leaflet.markercluster/MarkerCluster.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/leaflet.markercluster/MarkerCluster.Default.css')}}" rel="stylesheet">
@endsection

@section('content')
<style type="text/css">
    .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
}

.btn-light {
    background-color: #f8f9fa;
    border-color: #f8f9fa;
}

.btn-dark {
    background-color: #343a40;
    border-color: #343a40;
}


</style>
        <div class="pb-1">
          <div class="row g-4">
            <div class="col-12 col-xxl-6">
              <div class="mb-8">
                <h2 class="mb-2">Asset Management Dashboard</h2>
                <h5 class="text-700 fw-semi-bold"></h5>
              </div>
             
              <hr>
  
    <div class="container mt-5">
@php
$buttonClasses = [
    'btn-primary',
    'btn-secondary',
    'btn-success',
    'btn-danger',
    'btn-warning',
    'btn-info',
    'btn-light',
    'btn-dark',
    'btn-link'
];


$asset_condition_counts = \DB::select(" SELECT t1.name,COUNT(t2.id) as _asset_count FROM `assets_conditions` AS t1 INNER JOIN asset_items as t2 ON t1.id=t2.asset_condition_id GROUP BY t1.id order BY t1.name ASC ");
$total_asset_count = 0;
 foreach($asset_condition_counts as $ass_key=>$asset_count){
        $total_asset_count      +=$asset_count->_asset_count ??  0;
 }

@endphp
        <!-- Row 1: Key Metrics and Health -->
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Assets</h5>
                        <p class="card-text">{{$total_asset_count ?? 0}}</p>
                    </div>
                </div>
            </div>
             @php
                
       
        @endphp
        @forelse($asset_condition_counts as $ass_key=>$asset_count)

        @php
                        // Select a random class from the array for each condition
                         $randomClass = $buttonClasses[$ass_key] ?? "btn-danger";
                    @endphp
            <div class="col-md-3">
                <div class="card text-center {!! $randomClass !!} mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{!! $asset_count->name ?? '' !!}</h5>
                        <p class="card-text">{!! $asset_count->_asset_count  ?? 0 !!}</p>
                    </div>
                </div>
            </div>
         @empty
        @endforelse

@php

$asset_valus = \DB::select(" SELECT SUM(t1.evaluated_price) as evaluated_price,
SUM(t1.accumulated_dep_val) as accumulated_dep_val,
SUM(t1.book_value) as book_value,
SUM(t1._selling_value) as _selling_value,
SUM(t1._pl_amount) as _pl_amount
FROM `asset_items` as t1 WHERE 1 ");
@endphp
            <div class="col-md-3">
                <div class="card text-center mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Asset Value</h5>
                        <p class="card-text ">{!! _report_amount($asset_valus[0]->evaluated_price ?? 0) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Accumulated Dep Value</h5>
                        <p class="card-text">{!! _report_amount($asset_valus[0]->accumulated_dep_val ?? 0) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white text-center bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Book Value</h5>
                        <p class="card-text">{!! _report_amount($asset_valus[0]->book_value ?? 0) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white text-center bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Sale Value</h5>
                        <p class="card-text">{!! _report_amount($asset_valus[0]->_selling_value ?? 0) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white text-center bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">P/L Amount</h5>
                        <p class="card-text">{!! _report_amount($asset_valus[0]->_pl_amount ?? 0) !!}</p>
                    </div>
                </div>
            </div>
        </div>

       

        <!-- Row 4: Asset Assignment and Maintenance Schedule -->
        
    </div>

   
                 
              
              
            </div>
            
          </div>
        </div>
        
      </div>




        @endsection

@section('script')
    <script src="{{asset('vendors/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('vendors/leaflet/leaflet.js')}}"></script>
    <script src="{{asset('vendors/leaflet.markercluster/leaflet.markercluster.js')}}"></script>
    <script src="{{asset('vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js')}}"></script>
    <script src="{{asset('assets/js/ecommerce-dashboard.js')}}"></script>
@endsection

