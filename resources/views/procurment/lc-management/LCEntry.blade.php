@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp
        <b><h5 class="m-3 mb-0">LC Entry</h5></b>
        <div class="container-fluid p-3 border-dark">
            <table class="table table-borderless">
                <tr>
                    <td style="text-align: right;"><label class="mt-1" >PO NO:</label></td>
                    <td><input type="text" name="" class="form-control border-primary m-0"></td>
                    <td style="text-align: right;"><label class="mt-1">LC NO:<span class="text-danger small">*</span></label></td>
                    <td><input type="text" name="" class="form-control border-primary"></td>
                    <td style="text-align: right;"><label class="mt-1">LC Date:<span class="text-danger small">*</span></label></td>
                    <td><input type="date" name="" class="form-control border-primary"></td>
                    <td style="text-align: right;"><label class="mt-1">LC Type:<span class="text-danger small">*</span></label></td>
                    <td>
                        <select class="form-control " name="swift_type">
                            <option value="">Swift Type</option>
                            <option value="1">LC Type</option>
                            <option value="2">Sea</option>
                        </select>
                        
                    </td>
                </tr>
                
                <tr>
                    <td style="text-align: right;">
                        <label class="mt-1" style="text-align:right">LCA NO:</label></td>
                    <td>
                        <input type="text" name="admins_last_name" class="form-control border-primary" >
                    </td>
                    <td style="text-align: right;"><label class="mt-1">Transport Type:<span class="text-danger small">*</span></label></td>
                    <td>
                        <select class="form-control " name="transport_type">
                            <option value="">Transport Type</option>
                            <option value="1">Air</option>
                            <option value="2">Road</option>
                            <option value="3">Sea</option>
                        </select>
                        
                    </td>
                    <td style="text-align: right;"> <label class="mt-1">Partial Shipment:</label></td>
                    <td>
                        <select class="form-control " name="partical_shipment">
                            <option value="1">Allowed</option>
                            <option value="0">Not Allowed</option>
                        </select>
                        
                    </td>
                    <td style="text-align: right;">
                        <label class="mt-1">Bank:<span class="text-danger small">*</span></label></td>
                    <td>
                        <select class="form-control " name="bank_name">
                            <option value="1">NCC</option>
                            <option value="2">Dhaka Bank</option>
                        </select>

                        
                    </td>
                </tr>
                 
                <tr>
                    <td style="text-align: right;">
                        <label class="mt-1">Currency:<span class="text-danger small">*</span></label>
                    </td>
                    <td>
                        <select class="form-control " name="currency">
                            <option value="1">US</option>
                            <option value="2">EUR</option>
                            <option value="3">RS</option>
                        </select>
                        
                    </td>
                    <td style="text-align: right;"><label class="mt-1">Suppplier:<span class="text-danger small">*</span></label>
                    </td>
                    <td>
                        <select class="form-control " name="supplier">
                            <option value="1">supplier 1</option>
                            <option value="2">supplier 1</option>
                            <option value="3">supplier 1</option>
                        </select>
                    </td>
                    <td style="text-align: right;"><label class="mt-1">CNF Agent:</label></td>
                    <td>
                        <select class="form-control " name="cnf_agent">
                            <option value="1">supplier 1</option>
                            <option value="2">supplier 1</option>
                            <option value="3">supplier 1</option>
                        </select>
                    </td>
                    <td style="text-align: right;"><label class="mt-1">Bank Branch:</label></td>
                    <td>
                        <select class="form-control " name="bank_branch">
                            <option value="1">supplier 1</option>
                            <option value="2">supplier 1</option>
                            <option value="3">supplier 1</option>
                        </select>
                        
                    </td>
                </tr>
                {{-- 4th row --}}
                <tr>
                    <td style="text-align: right;"><label class="mt-1">Insur. Com:</label></td>
                    <td>
                        <select class="form-control " name="insurance_compnay">
                            <option value="1">supplier 1</option>
                            <option value="2">supplier 1</option>
                            <option value="3">supplier 1</option>
                        </select>
                        
                    </td>
                    <td style="text-align: right;"><label class="mt-1">Insur.Cover Note:</label></td>
                    <td>
                        <input type="text" name="" class="form-control border-primary">
                    </td>
                    <td style="text-align: right;"><label class="mt-1">Ins.Cover Dt:</label></td>
                    <td><input type="date" name="" class="form-control border-primary col-12"></td>
                    <td style="text-align: right;"><label class="mt-1">LC/TT:<span class="text-danger small">*</span></label></td>
                    <td>
                        <select class="form-control " name="lc_tt">
                            <option value="1">supplier 1</option>
                            <option value="2">supplier 1</option>
                            <option value="3">supplier 1</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">Remark:</td>
                    <td colspan="3"><input type="text" name="" class="form-control border-primary"></td>
                    
                    <td>
                        <div class="form-check mt-2">
                            <input type="checkbox" class="custom-control-input" id="checkbox2">
                            <label class="custom-control-label" for="checkbox2">Is Multiple PI</label>
                          </div>
                    </td>
                </tr>
            </table>
                <h6 class="text-center">LC Details:</h6>
            <div class="row" style="height: 500px;">
                <table class="table">
                    <thead class="table-dark">
                        <th>SL#</th>
                        <th>Group Name</th>
                        <th>Item Type</th>
                        <th>Item Name</th>
                        <th>Item Qnty</th>
                        <th>UOM</th>
                        <th>Item Rate</th>
                        <th>Item Total Cost</th>
                        <th>HS Code1</th>
                        <th>HS Code2</th>
                        <th>Remarks</th>
                        <th>Weight Avg.</th>
                        <th>Price Delete</th>
                        <th>Create Row</th>
                    </thead>
                    <tbody>
                        @php
                            $items = [1];
                        @endphp
                        @foreach ($items as $item)
                        <tr>
                            <td>
                               
                                <div class="input-group-sm">
                                    <input type="text" name="" class="form-control border-dark">
                                </div>
                               
                            </td>
                            <td>
                               <select class="form-control" name="">
                                    <option value="">ItemName1</option>
                                    <option value="">ItemName2</option>
                                </select>
                            </td>
                            
                            <td>
                               <select class="form-control" name="">
                                    <option value="">ItemName1</option>
                                    <option value="">ItemName2</option>
                                </select>
                                
                            </td>
                            <td>
                                <select class="form-control" name="">
                                    <option value="">ItemName1</option>
                                    <option value="">ItemName2</option>
                                </select>
                                
                                
                            </td>
                            <td>
                                
                                <div class="input-group">
                                    <input type="number" name="item_qty" class="form-control border-dark">
                                </div>
                               
                            </td>
                            <td>
                                
                                <div class="dropdown">
                                    <button type="button" class="dropdown-toggle btn btn-outline-dark col-12" data-bs-toggle="dropdown">
                                        -ALL-
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">UOM1</a></li>
                                        <li><a class="dropdown-item" href="#">UOM2</a></li>
                                        <li><a class="dropdown-item" href="#">UOM3</a></li>
                                    </ul>
                                </div>
                                
                            </td>
                            <td>
                                
                                <div class="input-group">
                                    <input type="number" name="" class="form-control border-dark">
                                </div>
                                
                            </td>
                            <td>
                               
                                <div class="input-group">
                                    <input type="number" name="" class="form-control border-dark">
                                </div>
                                
                            </td>
                            <td>
                               
                                <div class="input-group">
                                    <input type="text" name="" class="form-control border-dark">
                                </div>
                                
                            </td>
                            <td>
                               
                                <div class="input-group">
                                    <input type="text" name="" class="form-control border-dark">
                                </div>
                                
                            </td>
                            <td>
                                
                                <div class="input-group">
                                    <input type="text" name="" class="form-control border-dark">
                                </div>
                                
                            </td>
                            <td>
                                
                                <div class="input-group">
                                    <input type="number" name="" class="form-control border-dark">
                                </div>
                                
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger" >Delete</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success" >Row</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            <div class="row">
                <div class="col-5"></div>
                <div class="col-1 mt-1" style="text-align: right">
                    <span class="">Total Qnty:</span>
                </div>
                <div class="input-group-sm col-1 p-0">
                    <input type="text" name="" class="form-control border-dark col-12">
                </div>
            </div>
            
        </div>
  @endsection