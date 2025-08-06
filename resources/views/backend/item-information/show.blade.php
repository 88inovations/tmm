@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
 <a class="nav-link"  href="{{url('item-information')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('item-information-edit')
    <a class="nav-link"  title="Edit" href="{{ route('item-information.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    <!-- title row -->
    <div class="row">
     
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col text-center">
        {{ $settings->_top_title ?? '' }}<br>
        <img src="{{asset($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}"  style="max-width: 260px;height: 60px;">
        <h2 class="page-header">
            {{$settings->name ?? '' }}
          
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
        <h4 class="text-center"><b> {{$page_name ?? '' }}</b></h4>
      </div>
      <!-- /.col -->
      
        @php
                         $default_image = $settings->logo;
                         @endphp     
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 ">
        <table  class="table table-bordered">
         <tr>
             <td style="width:15%;">{{__('label.id')}}</td>
             <td style="width:35%;">{{$data->id ?? ''}}</td>
             </tr>
         <tr>
             <td style="width:15%;">{{__('label._image')}}</td>
             <td style="width:35%;">
                 <img class="myImage" src="{{asset($data->_image ?? $default_image)}}" alt="Click me to open modal" title="Click display Image" data-toggle="modal" data-target="#imageModal" style="width:150px;height: 100px;" >
            </td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._item')}}</td>
             <td style="width:35%;">{{$data->_item ?? ''}}</td>
             </tr>
         <tr>
             <td style="width:15%;">{{__('label._code')}}</td>
             <td style="width:35%;">{{ $data->_code ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._barcode')}}</td>
             <td style="width:35%;">{{$data->_barcode ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._category_id')}}</td>
             <td style="width:35%;">{{ $data->_category->_name ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._unit_id')}}</td>
             <td style="width:35%;">{{$data->_units->_name ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._pack_size_id')}}</td>
             <td style="width:35%;">{{ $data->_pack_size->_name ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._generic_name')}}</td>
             <td style="width:35%;">{{$data->_generic_name ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._description')}}</td>
             <td style="width:35%;">{{ $data->_description ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._strength')}}</td>
             <td style="width:35%;">{{$data->_strength ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._oringin')}}</td>
             <td style="width:35%;">{{ $data->_oringin ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._pur_rate')}}</td>
             <td style="width:35%;">{{$data->_pur_rate ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._sale_rate')}}</td>
             <td style="width:35%;">{{ $data->_sale_rate ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._trade_price')}}</td>
             <td style="width:35%;">{{$data->_trade_price ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._mrp_price')}}</td>
             <td style="width:35%;">{{ $data->_mrp_price ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._discount')}}</td>
             <td style="width:35%;">{{$data->_discount ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._vat')}}</td>
             <td style="width:35%;">{{ $data->_vat ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._reorder')}}</td>
             <td style="width:35%;">{{$data->_reorder ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._order_qty')}}</td>
             <td style="width:35%;">{{ $data->_order_qty ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._balance')}}</td>
             <td style="width:35%;">{{$data->_balance ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._opening_qty')}}</td>
             <td style="width:35%;">{{ $data->_opening_qty ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._manufacture_company')}}</td>
             <td style="width:35%;">{{$data->_manufacture_company ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._warranty')}}</td>
             <td style="width:35%;">{{ $data->_warranty_name->_name ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._unique_barcode')}}</td>
             <td style="width:35%;">{{$data->_unique_barcode ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._kitchen_item')}}</td>
             <td style="width:35%;">{{ $data->_kitchen_item ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label._created_by')}}</td>
             <td style="width:35%;">{{$data->_created_by ?? ''}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label._updated_by')}}</td>
             <td style="width:35%;">{{ $data->_updated_by ?? '' }}</td>
         </tr>
         <tr>
             <td style="width:15%;">{{__('label.created_at')}}</td>
             <td style="width:35%;">{{ _view_date_formate($data->created_at ?? '')}}</td>
        </tr>
         <tr>
             <td style="width:15%;">{{__('label.updated_at')}}</td>
             <td style="width:35%;">{{ _view_date_formate($data->updated_at ?? '')}}</td>
         </tr>
          
      

          <tbody>
            
          
          </tbody>
          <tfoot>
            
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
 <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid" id="modalImage" src="">
                </div>
            </div>
        </div>
    </div>
    
    <!-- /.row -->
  </section>

@endsection

@section('script')

<script type="text/javascript">
     $('.myImage').on('click', function() {
        var imgSrc = $(this).attr('src');
        $('#modalImage').attr('src', imgSrc);
    });

</script>
@endsection