@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp

    <div class="content">
      <div class="container-fluid">
   <h2 class="text-center">LC Costing Entry</h2>
    <div class="container-fluid   shadow-lg" >
        <div class="row justify-content-center bg-light p-3 rounded ">
            <div class="row my-2 p-4">
                <h1 class="mr-2 ju">Provisional</h1>
                <table class="table ">
                    <tr>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="supplier">Supplier:</label></td>
                        <td>
                            <input type="text" class="form-control supplier" name="supplier" id="supplier" placeholder="Enter supplier">
                        </td>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="lc_no">LC No:</label></td>
                        <td><input type="number" class="form-control" id="lc_no" placeholder="Enter LC Number"></td>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="po_no">PO No:</label></td>
                        <td><input type="text" class="form-control" id="po_no" placeholder="Enter PO number"></td>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="item">Item:</label></td>
                        <td><input type="text" class="form-control" id="item" placeholder="Enter LC name"></td>
                    </tr>
                    <tr>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="costing_no">Costing No:</label></td>
                        <td><input type="number" class="form-control" id="costing_no" placeholder="Enter costing number"></td>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="be_no">B/E No:</label></td>
                        <td><input type="number" class="form-control" id="be_no" placeholder="Enter B/E Number"></td>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="bill_no">Bill No:</label></td>
                        <td><input type="number" class="form-control" id="bill_no" placeholder="Enter bill number"></td>
                        <td class="align-middle text-black font-weight-bold bg-light"><label for="department">Department:</label></td>
                        <td>
                            <select class="form-control select2" id="department">
                                <option value="">--Select--</option>
                                <option value="1">Sales</option>
                                <option value="2">Marketing</option>
                                <option value="3">Operations</option>
                                <option value="4">Finance</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
</div>
    <div class="container  shadow-lg">
        <div class="row justify-content-center">
            <div class="col-12 card border-secondary">
                <form>
                    <div class="form-row mb-2">
                        <div class="form-group col-md-4">
                            <label for="item_quantity" >Item Quantity</label>
                            <input type="number" class="form-control" id="item_quantity" placeholder="0">
                        </div>
                        <div class="form-group col-md-4 ">
                            <label class="col-sm-6 col-form-label" for="item_quantity"></label>
                            <input type="number" class="form-control" id="item_quantity" placeholder="0" min="0" step="any">
                        </div>
                        <div class="roundedform-group col-md-4">
                            <label  >Global Taxes</label>
                            <input type="number" class="form-control" id="global_taxes" placeholder="0">
                        </div>
                    </div>
    
                    
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">Commercial Details</div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="commercial_value" class="col-sm-4 col-form-label">Commercial Value:</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="commercial_value" placeholder="0">
                                            </div>
                                            
                                            <label for="conversion_rate" class="col-sm-4 col-form-label">Conversion Rate:</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="conversion_rate" placeholder="0">
                                            </div>
                                            <label for="document_value" class="col-sm-4 col-form-label">Document Value</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="document_value" placeholder="0">

                                            </div>
                                            <label for="marine_insurance" class="col-sm-4 col-form-label">Marine Insurance:</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="marine_insurance" placeholder="0">
                                            </div>
                                            
                                            <label for="insurance_Others" class="col-sm-4 col-form-label">Insurence & Others:</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="insurance_Others" placeholder="0">
                                            </div>
                                            <label for="assessable_value" class="col-sm-4 col-form-label">Assessable Value</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="assessable_value" placeholder="0">

                                            </div>
                                            
                                            <!-- Repeat the pattern for other fields -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
    
                        <div class="col-6">
                            <div class="card border-prima">
                                <div class="card-header bg-primary text-white">Taxes & Charges</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="cd" class="col-sm-4 col-form-label">CD:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="cd" placeholder="0">
                                        </div>
                        
                                        <label for="rd" class="col-sm-4 col-form-label">RD:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="rd" placeholder="0">
                                        </div>
                        
                                        <label for="sd" class="col-sm-4 col-form-label">SD:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="sd" placeholder="0">
                                        </div>
                        
                                        <label for="vat" class="col-sm-4 col-form-label">VAT:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="vat" placeholder="0">
                                        </div>
                        
                                        <label for="ait" class="col-sm-4 col-form-label">AIT:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="ait" placeholder="0">
                                        </div>
                        
                                        <label for="at" class="col-sm-4 col-form-label">AT:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="at" placeholder="0">
                                        </div>
                        
                                        <label for="total_item_taxes" class="col-sm-4 col-form-label">Total Item Taxes:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="total_item_taxes" placeholder="0">
                                        </div>
                        
                                        <label for="total_tax_amount" class="col-sm-4 col-form-label">Total Taxes Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="total_tax_amount" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <div class="card border-secondary">
                                <div class="card-header bg-info text-white">Clearing Charges</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="port_charge" class="col-sm-6 col-form-label">Port Charge:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="port_charge"placeholder="0">
                                        </div>
                        
                                        <label for="add_vat" class="col-sm-6 col-form-label">Add Vat:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="add_vat" placeholder="0">
                                        </div>
                        
                                        <label for="ait" class="col-sm-6 col-form-label">AIT:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="ait" placeholder="0">
                                        </div>
                        
                                        <label for="others" class="col-sm-6 col-form-label">Others:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="others" placeholder="0">
                                        </div>
                        
                                        <label for="total_port_charge" class="col-sm-6 col-form-label">Total Port Charge:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="total_port_charge" placeholder="0">
                                        </div>
                                    </div>
                                    <!-- Add other fields here -->
                                </div>
                            </div>
                        </div>
                        

    <div class="col-4">
        <div class="card border-secondary">
            <div class="card-header bg-warning text-white">Additional Charges</div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="shipping_charge" class="col-sm-6 col-form-label">Shipping Charge:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="shipping_charge" placeholder="0">
                    </div>
    
                    <label for="noc_charge" class="col-sm-6 col-form-label">NOC Charge:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="noc_charge" placeholder="0">
                    </div>
    
                    <label for="safta_charge" class="col-sm-6 col-form-label">SAFTA Charge:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="safta_charge" placeholder="0">
                    </div>
    
                    <label for="transport" class="col-sm-6 col-form-label">Transport:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="transport" placeholder="0">
                    </div>
    
                    <label for="cf_comm" class="col-sm-6 col-form-label">C&F Comm:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="cf_comm" placeholder="0">
                    </div>
                </div>
                <!-- Add other fields here -->
            </div>
        </div>
    </div>
    
    <div class="col-4">
        <div class="card border-secondary">
            <div class="card-header bg-danger text-white">Total Charges</div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="others_charge" class="col-sm-6 col-form-label">Others Charge:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control others_charge" name="others_charge" id="others_charge"placeholder="0" min="0" step="any">
                    </div>
    
                    <label for="boperator_charge" class="col-sm-6 col-form-label">B. Operator Crg:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="boperator_charge" placeholder="0">
                    </div>
    
                    <label for="sp_per_charge" class="col-sm-6 col-form-label">Sp. Per. Crg:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="sp_per_charge"placeholder="0">
                    </div>
    
                    <label for="moscellaneous" class="col-sm-6 col-form-label">Miscellaneous:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="moscellaneous" placeholder="0">
                    </div>
    
                    <label for="total_charge" class="col-sm-6 col-form-label">Total Charge:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="total_charge" placeholder="0">
                    </div>
                </div>
                <!-- Add other fields here -->
            </div>
        </div>
    </div>
    </div>
    

                    
    
                    <div class="row">
                        <div class="col-3">
                            <div class="card border-secondary">
                                <div class="card-header bg-info text-white">Sea Freight</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        
                                        <input type="text" class="form-control" id="sea_freight" placeholder="0">
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <!-- Add more cards for the remaining fields here -->
                    </div>
    
                    
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-5">
                <div class="card border-secondary">
                    <div class="card-header bg-info text-white">Total with VAT</div>
                    <div class="card-body">
                        <div class="form-group">
                            
                            <input type="text" class="form-control" id="total_with_vat" placeholder="0">
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add more cards for the remaining fields here -->
        </div>
    
        <div class="row justify-content-center mt-3 p-3">
            <div class="col-12 ">
                <table>
                    <tr>
                        <td><button type="button" class="btn btn-info hover-effect">New</button></td>
                        <td><button type="button" class="btn btn-success hover-effect">Save</button></td>
                        <td><button type="button" class="btn btn-secondary hover-effect">Refresh</button></td>
                        <td><button type="button" class="btn btn-danger hover-effect">Close</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>

    @endsection