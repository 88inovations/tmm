<!DOCTYPE html>
<html style="height: auto;" lang="en">

<head>
	 @php
    $_show_delivery_man = $form_settings->_show_delivery_man ?? 0;
    $_show_sales_man = $form_settings->_show_sales_man ?? 0;
    $_show_barcode = $form_settings->_show_barcode ?? 0;
    $_show_cost_rate =  $form_settings->_show_cost_rate ?? 0;
    $_show_vat =  $form_settings->_show_vat ?? 0;
   $_inline_discount = $form_settings->_inline_discount ?? 0;
    $_show_self = $form_settings->_show_self ?? 0;
    $_show_warranty = $form_settings->_show_warranty ?? 0;
    $_defaut_customer = $form_settings->_defaut_customer ?? 0;
    
   $default_image = $settings->logo;
    
    @endphp
	<!-- TABLES CSS CODE -->
	<meta charset="UTF-8">
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{$settings->name ?? '' }}</title>
	 <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/x-icon" href="{{asset('/')}}{{$default_image ?? ''}}">
	<link rel="icon" type="image/x-icon" href="{{asset('/')}}{{$default_image ?? ''}}" />
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<!--<link rel="stylesheet" href="https://pos.creatantech.com/theme/css/font-awesome-4.7.0/css/font-awesome.min.css"> -->
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/ionicons.min.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/select2.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/AdminLTE.min.css')}}">
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/_all-skins.min.css')}}">
	<!-- bootstrap date-range-picker -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/daterangepicker.css')}}">
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/datepicker3.css')}}">
	<!--Toastr notification -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/toastr.css')}}">
	<!--Custom Css File-->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/custom.css')}}">
	<!-- Autocomplete -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/autocomplete.css')}}">
	<!-- Pace Loader -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/pace.min.css')}}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{asset('backend/pos-template/css/orange.css')}}">
	<!-- Theme color finder -->
	<script type="text/javascript">
	var theme_skin = (typeof(Storage) !== "undefined") ? localStorage.getItem('skin') : 'skin-black';
	theme_skin = (theme_skin == '' || theme_skin == null) ? 'skin-black' : theme_skin;
	var sidebar_collapse = (typeof(Storage) !== "undefined") ? localStorage.getItem('collapse') : 'skin-black';
	var EW_TOKEN = "N9GRAo42tvdLHNoicq-XdA..";
	</script>
	<!-- jQuery 2.2.3 -->
	<script src="{{asset('backend/pos-template/js/jquery-2.2.3.min.js')}}"></script>
	<!-- iCheck -->
	
	<script src="https://use.fontawesome.com/0ccc3c060c.js"></script>
	<link rel="stylesheet" href="{{asset('/backend/pos_style.css')}}">
	<style type="text/css">
	.select2-container--default .select2-selection--single {
		border-radius: 0px;
	}
	/*LEFT SIDE: ITEMS TABLE*/
	
	.table-striped > tbody > tr:nth-of-type(2n+1) {
		background-color: #f1f1f1;
	}
	
	.table-striped > tbody > tr {
		background-color: #f9f9f9;
	}
	/*SET TOTAL FONT*/
	
	.tot_qty,
	.tot_amt,
	.tot_disc,
	.tot_grand {
		font-size: 19px;
		color: #023763;
	}
	/*CURSOR POINTER CLASS*/
	
	.pointer {
		cursor: pointer;
	}
	
	.navbar-nav > .user-menu > .dropdown-width-lg {
		width: 350px;
	}
	
	.header-custom {
		background-image: -webkit-gradient(linear, left top, right top, from(#20b9ae), to(#006fd6));
		color: white;
	}
	
	.border-custom-bottom {
		border-bottom: 1px solid;
		padding-top: 10px;
		padding-bottom: 5px;
	}
	
	.custom-font-size {
		font-size: 22px;
	}
	
	.search_item {
		/*text-transform: uppercase;*/
		font-size: 12px;
		color: #000000;
		text-align: center;
		text-overflow: hidden;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
	}
	
.item_image {
    min-width: 70px;
    min-height: 70px;
    max-width: 70px;
    max-height: 70px;
}
	
	.item_box {
		border-top: none;
	}
	
	.min_width {
		min-width: 70px;
	}
	
	.errors {
		color: red;
		font-weight: bold;
		text-align: left;
	}
	.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    position: relative;
    min-height: 1px;
    padding-right: 10px !important;
    padding-left: 10px !important;
}

.skin-black .main-header .navbar .navbar-nav>li>a {
    border-right: 0px solid #eee;
}
.skin-black .main-header .navbar .navbar-custom-menu .navbar-nav>li>a, .skin-black .main-header .navbar .navbar-right>li>a {
    border-left: 0px solid #eee;
    border-right-width: 0;
}
.bg-primary {
    color: #fff;
    background-color: #3c8dbc;
}

@media (min-width: 1200px){
	.container {
	    width: 100%;
	}
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #ddd !important;
}

.box {
    
    border-top: 0px;
}
.main-header .logo {
    -webkit-transition: width .3s ease-in-out;
    -o-transition: width .3s ease-in-out;
    transition: width .3s ease-in-out;
    display: block;
    float: left;
    height: 60px;
    font-size: 20px;
    line-height: 50px;
    text-align: center;
    width: 300px !important;
    font-family: math;
    padding: 0 15px;
    font-weight: 300;
    overflow: hidden;
    color: #000;
}


	</style>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="skin-blue layout-top-nav pace-done" style="height: auto;" cz-shortcut-listen="true">
	<div class="pace  pace-inactive">
		<div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
			<div class="pace-progress-inner"></div>
		</div>
		<div class="pace-activity"></div>
	</div>
	<script type="text/javascript">
	if(theme_skin != 'skin-blue') {
		$("body").addClass(theme_skin);
		$("body").removeClass('skin-blue');
	}
	if(sidebar_collapse == 'true') {
		$("body").addClass('sidebar-collapse');
	}
	</script>

	
	<div class="wrapper" style="height: auto;">
		<header class="main-header">
			<nav class="navbar navbar-static-top">
				<div class="container">
					<div class="navbar-header">
						<a href="{{url('/home')}}" class="logo hidden-xs">
							<!-- mini logo for sidebar mini 50x50 pixels --><span class="logo-mini"><img src="{{asset('/')}}{{$default_image ?? ''}}" alt="{{$settings->name ?? '' }}" style="height: 50px; width: 50px;"></span>
							<!-- logo for regular state and mobile devices --><span class="logo-lg"><img src="{{asset('/')}}{{$default_image ?? ''}}" alt="{{$settings->name ?? '' }}" style="height: 50px; width: 50px; -webkit-filter: drop-shadow(0 0 1px #000); filter: drop-shadow(0 0 1px #000);"> {{$settings->name ?? '' }}</span></a>
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"> <i class="fa fa-bars"></i> </button>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
						<ul class="nav navbar-nav">
							<li class=""><a class="new_invoice_link" href="{{url('sales')}}" title="View Sales List!"><i class="fa fa-list text-green"></i> <span style="font-weight:bold;">Sales List</span></a></li>
							<li class=""><a class="new_invoice_link" href="{{url('pos-sales')}}" title="Create New POS Invoice"><i class="fa fa-calculator text-green "></i> <span style="font-weight:bold;">New Invoice</span></a></li>
							<li class=""><a class="new_invoice_link" href="{{url('item-information')}}" title="View Items List"><i class="fa  fa-cubes text-green "></i> <span style="font-weight:bold;">Items List</span></a></li>
						</ul>
					</div>
					<!-- /.navbar-collapse -->
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class=""><a class="new_invoice_link" href="#" data-toggle="modal" data-target="#invoicePrint-modal" title="Last Invoice Print" ><i class="fa  fa-print text-red "></i> </a></li>
							
							<!-- User Account Menu -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle new_invoice_link" data-toggle="dropdown" title="Click To View Hold Invoices" aria-expanded="false"> <span class="text-bold">Hold List</span> <span class="label label-success hold_invoice_list_count">0</span> </a>
								<ul class="dropdown-menu dropdown-width-lg">
									<!-- Menu Body -->
									<li class="user-body">
										<div class="row">
											<div class="col-xs-12 text-center " style="max-height:300px;overflow-y: scroll;">
												<table class="table table-bordered" width="100%">
													<thead>
														<tr>
															<th>ID</th>
															<th>Date</th>
															<th>Customer</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody id="hold_invoice_list"> </tbody>
												</table>
											</div>
										</div>
										<!-- /.row -->
										<!--</li>-->
									</li>
								</ul>
							</li>
							<!-- Messages: style can be found in dropdown.less-->
							<li class="hidden-xs" style="cursor: pointer;" id="fullscreen"><a title="Fullscreen On/Off"><i class="fa fa-arrows text-green"></i></a></li>
							
							<!-- User Account Menu -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user text-green"></i> <span class="hidden-xs text-bold" >{{ Auth::user()->name ?? '' }}</span> </a>
								
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header"> 

										<p>  {{ Auth::user()->name ?? '' }} </p>
									</li>
									<!-- Menu Body -->
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left"> 
											@if(Auth::user()->ref_id ==0)
									           <a class="dropdown-item text-center btn btn-success" 
									                        href="{{ url('users') }}/{{Auth::user()->id}}/edit"
									                        >
									                  {{ __('Profile') }}
									                </a>
									          @else
									            <a class="dropdown-item text-center btn btn-success" 
									                        href="{{ url('branch_user') }}/{{Auth::user()->id}}/edit"
									                        >
									                  {{ __('Profile') }}
									            </a>
									          @endif
									      </div>
										<div class="pull-right">
										 <a class="dropdown-item text-center btn btn-danger" 
					                        href="{{ route('logout') }}"
					                        onclick="event.preventDefault();
					                                                     document.getElementById('logout-form').submit();">
					                  {{ __('Logout') }}
					                </a>


					                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					                        @csrf
					                  </form>
            			</div>
									</li>
								</ul>
							</li>
							<!-- <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> </li> -->
						</ul>
					</div>
					<!-- /.navbar-custom-menu -->
				</div>
				<!-- /.container-fluid -->
			</nav>
		</header>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" style="min-height: 333px;">
			
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<!-- left column -->
					<div class="col-md-7">
						<!-- general form elements -->
						<div class="box box-primary">
							<!-- form start -->
							<form class="form-horizontal" id="pos-form">
								<div class="box-header with-border" style="padding-bottom: 3px;">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-6" style="display: flex;">
												
												<select class="form-control _main_branch" name="_main_branch" >
													@forelse($permited_branch as $branch)
													<option value="{{$branch->id}}">{{$branch->_name ?? ''}}</option>
													@empty
													@endforelse
												</select>
											</div>
											<div class="col-md-6" style="display: flex;">
												
												<select class="form-control _main_store" name="_main_store" >
													@forelse($store_houses as $store)
													<option value="{{$store->id}}">{{$store->_name ?? ''}}</option>
													@empty
													@endforelse
												</select>
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-header -->
								
								<input type="hidden" value="0" id="hidden_rowcount" name="hidden_rowcount">
								<input type="hidden" value="" id="hidden_invoice_id" name="hidden_invoice_id">
								
								<input type="hidden" value="" id="temp_customer_id" name="temp_customer_id">
								<!-- **********************MODALS***************** -->
								<div class="modal fade" id="multiple-payments-modal">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header header-custom">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
												<h4 class="modal-title text-center">Payments</h4> </div>
											<div class="modal-body">
												<div class="row">
													<!-- LEFT HAND -->
													<div class="col-md-8">
														<div>
															<input type="hidden" data-var="inside_else" name="payment_row_count" id="payment_row_count" value="1">
															<div class="col-md-12  payments_div">
																<div class="box box-solid">
																	<div class="box-body">
																		<div class="row">
																			<div class="col-md-6">
																				<div class="">
																					<label for="amount_1">Amount</label>
																					<input type="text" class="form-control text-right payment" id="amount_1" name="amount[]" placeholder="" onkeyup="calculate_payments()"> <span id="amount_1_msg" style="display:none" class="text-danger"></span> </div>
																			</div>
			<div class="col-md-6">
				<div class="">
					<label for="payment_type_1">Payment </label>
					@php
					$payment_accounts = \DB::select(" SELECT id,_name FROM account_ledgers WHERE _account_group_id IN($settings->_bank_group,$settings->_cash_group) order by id ASC ");
					@endphp
					<select class="form-control payment_group_change" id="payment_type_1" name="payment_type[]">
						@php
						$first_id = 0;
						@endphp
						@forelse($payment_accounts as $key=> $account)
						@php
						if($key ===0){
							$first_id = $account->id;
						}
						
						
						@endphp
						<option attr_value="{{$account->id}}" value="{{$account->id}}">{{$account->_name}}</option>
						@empty
						@endforelse
						
						<input type="hidden" class="payment_group" name="payment_group[]" id="payment_group_1" value="{{$first_id}}" /> 
					</select> <span id="payment_type_1_msg" style="display:none" class="text-danger"></span> </div>
			</div>
				<div class="clearfix"></div>
			</div>
								<div class="row">
									<div class="col-md-12">
										<div class="">
											<label for="payment_note_1">Payment Note</label>
											<textarea type="text" class="form-control" id="payment_note_1" name="payment_note[]" placeholder=""></textarea> <span id="payment_note_1_msg" style="display:none" class="text-danger"></span> </div>
									</div>
									<div class="clearfix"></div>
								</div>
																	</div>
																</div>
															</div>
															<!-- col-md-12 -->
														</div>
														<div class="row">
															<div class="col-md-12">
																<div class="col-md-12">
																	<div class="col-md-12">
																		<button type="button" class="btn btn-primary btn-block" id="add_payment_row">Add Payment Row</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!-- col-md-9 -->
													<!-- RIGHT HAND -->
													<div class="col-md-4">
														<div class="col-md-12">
															<div class="box box-solid bg-blue">
																<div class="box-body">
																	<div class="row ">
																		<div class="col-md-12 border-custom-bottom"> <span class="col-md-6 text-right text-bold ">Total Items:</span> <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_qty">0.00</span> </div>
																	</div>
																	<div class="row ">
																		<div class="col-md-12 border-custom-bottom"> <span class="col-md-6 text-right text-bold ">Total:</span> <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_amt">0.00</span> </div>
																	</div>
																	<!--  -->
																	<div class="row ">
																		<div class="col-md-12 border-custom-bottom"> <span class="col-md-6 text-right text-bold ">Discount(-):</span> <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_discount">0.00</span> </div>
																	</div>
																	<!--  -->
																	<div class="row bg-red">
																		<div class="col-md-12 border-custom-bottom"> <span class="col-md-6 text-right text-bold ">Total Payable:</span> <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_payble">0.00</span> </div>
																	</div>
																	<!--  -->
																	<div class="row ">
																		<div class="col-md-12 border-custom-bottom"> <span class="col-md-6 text-right text-bold ">Total Paying:</span> <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_paid">0.00</span> </div>
																	</div>
																	<!--  -->
																	<!--  -->
																	<div class="row ">
																		<div class="col-md-12 border-custom-bottom"> <span class="col-md-6 text-right text-bold ">Balance:</span> <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_balance">0.00</span> </div>
																	</div>
																	<!--  -->
																	<div class="row ">
																		<div class="col-md-12 bg-orange"> <span class="col-md-6 text-right text-bold ">Change Return:</span> <span class="col-md-6 text-right text-bold  custom-font-size sales_div_change_return">0.00</span> </div>
																	</div>
																	<!--  -->
																</div>
																<!-- /.box-body -->
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
												<button type="button" class="btn bg-maroon btn-lg make_sale btn-lg" onclick="save()"><i class="fa  fa-save "></i> Save</button>
												<button type="button" class="btn btn-success btn-lg make_sale btn-lg" onclick="save(true)"><i class="fa  fa-print "></i> Save &amp; Print</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- **********************MODALS END***************** -->
								<!-- **********************MODALS***************** -->
								<div class="modal fade" id="discount-modal">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
												<h4 class="modal-title">Set Discount</h4> </div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-6">
														<div class="box-body">
															<div class="form-group">
																<label for="discount_input">Discount</label>
																<input type="text" class="form-control" id="discount_input" name="discount_input" placeholder="" value="0"> </div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="box-body">
															<div class="form-group">
																<label for="discount_type">Discount Type</label>
																<select class="form-control" id="discount_type" name="discount_type">
																	<option value="in_percentage">Per%</option>
																	<option value="in_fixed">Fixed</option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary discount_update">Update</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->
								<!-- **********************MODALS END***************** -->
								<div class="box-body">
									<div class="row">
										<div class="col-md-6">
											
											<div class="from-group" style="display: flex;"> 
												
												<span style="width: 40px;" class="input-group-addon" title="Customer"><i class="fa fa-user"></i></span>
												
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',_ledger_name($_defaut_customer))}}" placeholder="Customer" required>
                            <span style="width: 40px;" class="input-group-addon pointer" data-toggle="modal" data-target="#exampleModalLong" title="New Customer?"><i class="fa fa-user-plus text-green fa-lg"></i></span>



                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$_defaut_customer)}}" placeholder="Customer" required>

                            <div class="search_box_main_ledger" style="margin-top: 40px;"> </div>
											
											</div> 
										</div>
										<div class="col-md-6">
											<div class="input-group"> <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode text-green"></i></span> <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
												<input type="text" class="form-control" placeholder="Item Search with Barcode" id="barcodeSearch" autocomplete="off"> </div>
										</div>
									</div>
									<!-- row end -->
									<br>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="col-sm-12" style="overflow-y: auto; height:291px;">
													<table class="table table-condensed table-bordered table-striped table-responsive items_table" style="">
														<thead class="bg-primary">
															<tr>
																<th width="22%">Item Name</th>
																<th width="7%">Stock</th>
																<th width="15%">Quantity</th>
																<th width="15%">Price</th>
																<th width="10%">Discount</th>
																<th width="10%">VAT</th>
																<th width="16%">Subtotal</th>
																<th width="5%"><i class="fa fa-close"></i></th>
															</tr>
														</thead>
														<tbody id="pos-form-tbody" style="font-size: 14px;overflow: scroll;"> </tbody>
														<tfoot>
															<!-- footer code -->
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
									<!-- SMS Sender while saving -->
									<div class="row" style="background: #ecf0f5;
    padding-top: 15px;
    margin-left: -10px;
    margin-right: -10px;
    border-right: 2px solid #FFF;
    border-left: 2px solid #fff;">
										<div class="col-xs-12 ">
											<div class="col-md-4">
												<div class="form-group">
													<label for="_line_total_discount" class="col-sm-6 control-label">Discount
														<label class="text-danger">*</label>
													</label>
													<div class="col-sm-6">
														<input type="text" class="form-control text-right" id="_line_total_discount" name="_line_total_discount" value="0.00" readonly> </div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="_line_vat_total" class="col-sm-6 control-label">VAT Total
														<label class="text-danger">*</label>
													</label>
													<div class="col-sm-6">
														<input type="text" class="form-control text-right" id="_line_vat_total" name="_line_vat_total" value="0.00" readonly> </div>
												</div>
											</div>
											<div class="col-md-4" style="display: none;">
												<div class="form-group">
													<label for="other_charges" class="col-sm-7 control-label">Other Charges
														<label class="text-danger">*</label>
													</label>
													<div class="col-sm-5">
														<input type="text" class="form-control text-right" id="other_charges" name="other_charges" placeholder="0.00" value=""> <span id="other_charges_msg" style="display:none" class="text-danger"></span> </div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
								<div class="box-footer " 
								style="margin-top: -10px;
								    background-color: #ecf0f5;
								    border-right: 2px solid #FFF;
								    border-bottom: 2px solid #fff;
								    border-left: 2px solid #fff;">
									<div class="row">
										<div class="col-md-3 text-right">
											<label> Quantity:</label>
											<br> <span class="text-bold tot_qty"></span> </div>
										<div class="col-md-3 text-right">
											<label>Sub Total Amount:</label>
											<br> TK <span style="font-size: 19px;" class="tot_amt text-bold"></span> </div>
										<div class="col-md-3 text-right">
											<label>Total Discount:
												<a class="fa fa-pencil-square-o cursor-pointer" data-toggle="modal" data-target="#discount-modal"></a>
											</label>
											<br> TK <span style="font-size: 19px;" class="tot_disc text-bold">0.00</span> </div>
										<div class="col-md-3 text-right">
											<label>Net Total:</label>
											<br> TK <span style="font-size: 19px;" class="tot_grand text-bold"></span> </div>
									</div>
									<div class="row">
										<div class="col-md-12 text-right">
											<div class="col-sm-4">
												<button type="button" id="hold_invoice" name="" class="btn bg-maroon btn-block btn-flat btn-lg" title="Hold Invoice [Ctrl+H]"> <i class="fa fa-hand-paper-o" aria-hidden="true"></i> Hold </button>
											</div>
											<div class="col-sm-3">
												<button type="button" id="" name="" class="btn btn-primary btn-block btn-flat btn-lg show_payments_modal" title="Multiple Payments [Ctrl+M]"> <i class="fa fa-credit-card" aria-hidden="true"></i> Payment </button>
											</div>
											<!-- <div class="col-sm-4">
												<button type="button" id="show_cash_modal" name="" class="btn btn-success btn-block btn-flat btn-lg ctrl_c" title="By Cash &amp; Save [Ctrl+C]"> <i class="fa fa-money" aria-hidden="true"></i> Cash </button>
											</div> -->
											<div class="col-sm-4">
												<button type="button" id="pay_all" name="" class="btn btn-success btn-block btn-flat btn-lg ctrl_a" title="By Cash &amp; Save [Ctrl+A]"> <i class="fa fa-money" aria-hidden="true"></i> Cash & Save </button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						<!-- /.box -->
					</div>
					<!--/.col (left) -->
					<!-- right column -->
					<div class="col-md-5">
						<!-- Horizontal Form -->
						<div class="box box-info">
							<!-- form start -->
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										@php
										$parent_category = \DB::table("item_categories")->where('_parent_id',0)->get();
										@endphp
										<select class="form-control select2 select2-hidden-accessible" id="category_id" name="category_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
											<option value="ALL">ALL</option>
											@forelse($parent_category as $category)
											<option value="{{$category->id}}">{{$category->_name ?? ''}}</option>
											@empty
											@endforelse
										</select>
									</div>
									<div class="col-md-6">
										<div class="input-group input-group-md">
											<input type="text" id="search_it" class="form-control" placeholder="Filter Items" autocomplete="off"> <span class="input-group-btn">
                          <!--  <button type="button" class="btn btn-info btn-flat show_all">All</button> -->
								<button type="button" class="btn btn-success" title="Add Product" data-toggle="modal" data-target="#exampleModalLong_item"><span class="fa fa-plus" aria-hidden="true"></span></button>
											<br> </span>
										</div>
									</div>
								</div>
								<!-- row end -->
								<div class="row">
									<div class="col-md-12">
										<section class="content" >
											<div class="row search_div" style="overflow-y: scroll;min-height: 100px;height: 84vh;"> </div>
											<h3 class="text-danger text-center error_div" style="display: none;">Sorry! No Records Found</h3> </section>
										<!-- </div> -->
										<!-- </div> -->
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
							<!-- /.box -->
						</div>
						<!--/.col (right) -->
					</div>
					<!-- /.row -->
			</section>
			<!-- /.content -->
			</div>
			<!--Product Add Modal -->
			@include('backend.common-modal.item_ledger_modal')
			<div class="sales_item_modal">
				<div class="modal fade" id="sales_item" style="display: none;">
					<div class="modal-dialog ">
						<div class="modal-content">
							<div class="modal-header header-custom">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								<h4 class="modal-title text-center">Manage Sales Item</h4> </div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<div class="row invoice-info">
											<div class="col-sm-6 invoice-col"> <b>Item Name : </b> <span id="popup_item_name"></span></div>
											<!-- /.col -->
										</div>
										<!-- /.row -->
									</div>
									<div class="col-md-12">
										<div>
											<div class="col-md-12 ">
												<div class="box box-solid ">
													<div class="box-body">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="popup_tax_type">VAT Type</label>
																	<select class="form-control select2-hidden-accessible" id="popup_tax_type" name="popup_tax_type" style="width: 100%;" tabindex="-1" aria-hidden="true">
																		<option value="Exclusive">Exclusive</option>
																		<option value="Inclusive">Inclusive</option>
																	</select>
																</div>
															</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="popup_tax_id">VAT</label>
												
												<select class="form-control select2-hidden-accessible" id="popup_tax_id" name="popup_tax_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
													
								@php
								$vat_rules = \DB::table('vat_rules')->orderBy('_rate','ASC')->get();
								@endphp
								@forelse($vat_rules as $vat)
								<option data-tax="{{$vat->_rate}}" data-tax-value="{{$vat->_rate}}" 
									value="{{$vat->_rate}}">{{$vat->_rate}}</option>
										
								@empty
								@endforelse
												</select>
											</div>
										</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="item_discount_type"></label>
																	<select class="form-control select2-hidden-accessible" id="item_discount_type" name="item_discount_type" style="width: 100%;" tabindex="-1" aria-hidden="true">
																		<option value="Percentage">Percentage(%)</option>
																		<option value="Fixed">Fixed(TK)</option>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="item_discount_input">Discount</label>
																	<input type="text" class="form-control only_currency" id="item_discount_input" name="item_discount_input" placeholder="" value="0"> </div>
															</div>
															<div class="col-md-12">
																<div class="form-group">
																	<label for="popup_tax_type">Description</label>
																	<textarea type="text" class="form-control" id="popup_description" placeholder=""></textarea>
																</div>
															</div>
													
															<div class="clearfix"></div>
														</div>
													</div>
												</div>
											</div>
											<!-- col-md-12 -->
										</div>
									</div>
									<!-- col-md-9 -->
									<!-- RIGHT HAND -->
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" id="popup_row_id" value="4">
								<button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
								<button type="button" onclick="set_info()" class="btn bg-green btn-lg place_order btn-lg">Set<i class="fa  fa-check "></i></button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
			</div>
			<!-- **********************MODALS END***************** -->
			
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs"> <b>Version 3.1 </b> </div> <strong>Copyright © sohoz-hisab.com<a href="http://sohoz-hisab.com/" target="_blank">sohoz-hisab </a></strong>All rights reserved</footer>
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Create the tabs -->
				<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
					<li> </li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane" id="control-sidebar-home-tab"> </div>
					<div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
						<div>
							<h4 class="control-sidebar-heading">Skins</h4>
							<ul class="list-unstyled clearfix">
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin">Blue</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin">Black</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin">Purple</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin">Green</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin">Red</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin">Yellow</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin" style="font-size: 12px">Black Light</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin" style="font-size: 12px">Green Light</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin" style="font-size: 12px">Red Light</p>
								</li>
								<li style="float:left; width: 33.33333%; padding: 5px;">
									<a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
										<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
										<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
									</a>
									<p class="text-center no-margin" style="font-size: 12px;">Yellow Light</p>
								</li>
							</ul>
						</div>
					</div>
					<!-- /.tab-pane -->
				</div>
			</aside>
		</div>

		<div class="modal fade" id="invoicePrint-modal" style="display: none;">
				
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header ">
								<button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
								<button onclick="javascript:printDiv('printablediv')" type="button" class="btn btn-danger "><span class="fa fa-print text-white"></span></button>
								<button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								
							 </div>
							<div class="modal-body" id="_salesInvoicePrint">
									
										 

										  
									  
							</div>
						
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
								<button onclick="javascript:printDiv('printablediv')" type="button" class="btn btn-danger "><span class="fa fa-print text-white"></span></button>

							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				
			</div>
		<!-- ./wrapper -->
		<!-- SOUND CODE -->
		<!-- Notification sound -->
		<audio id="failed">
			<source src="{{asset('backend/pos-template/failed.mp3')}}" type="audio/mpeg">
			<source src="{{asset('backend/pos-template/failed.ogg')}}" type="audio/ogg"> </audio>
		<audio id="success">
			<source src="{{asset('backend/pos-template/success.mp3')}}" type="audio/mpeg">
			<source src="{{asset('backend/pos-template/success.ogg')}}" type="audio/ogg"> </audio>
		<script type="text/javascript">
		var failed_sound = document.getElementById("failed");
		var success_sound = document.getElementById("success");
		</script>
		<script src="{{asset('backend/pos-template/js/bootstrap.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script>
		var AdminLTEOptions = {
			sidebarExpandOnHover: true,
			navbarMenuHeight: "200px", //The height of the inner menu
			animationSpeed: 250,
		};
		</script>
		<script src="{{asset('backend/pos-template/js/app.js')}}"></script>
		<!-- FastClick -->
		<script src="{{asset('backend/pos-template/js/fastclick.js')}}"></script>
		<!-- Select2 -->
		<script src="{{asset('backend/pos-template/js/select2.full.min.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{asset('backend/pos-template/js/demo.js')}}"></script>
		<!--Toastr notification -->
		<script src="{{asset('backend/pos-template/js/toastr.js')}}"></script>
		<script src="{{asset('backend/pos-template/js/toastr_custom.js')}}"></script>
		<!-- bootstrap datepicker -->
		<script src="{{asset('backend/pos-template/js/moment.min.js')}}"></script>
		<script src="{{asset('backend/pos-template/js/daterangepicker.js')}}"></script>
		<!-- bootstrap datepicker -->
		<script src="{{asset('backend/pos-template/js/bootstrap-datepicker.js')}}"></script>
		<!-- Sweet alert -->
		<script src="{{asset('backend/pos-template/js/sweetalert.min.js')}}"></script>
		<!-- Custom JS -->
		<script src="{{asset('backend/pos-template/js/special_char_check.js')}}"></script>
		<!-- sweet alert -->
		<script src="{{asset('backend/pos-template/js/sweetalert.min.js')}}"></script>
		<!-- Autocomplete -->
		<script src="{{asset('backend/pos-template/js/autocomplete.js')}}"></script>
		<!-- Pace Loader -->
		<script src="{{asset('backend/pos-template/js/pace.min.js')}}"></script>
		<!-- iCheck -->
		<script src="{{asset('backend/pos-template/js/icheck.min.js')}}"></script>
		<script>


		$(function() {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-orange',
				radioClass: 'iradio_square-orange',
				increaseArea: '10%' // optional
			});
		});

		function xss_validation(data) {
			if(typeof data == 'object') {
				for(var value of data.values()) {
					if(typeof value != 'object' && (value.trim() != '' && value.indexOf("<script>") != -1)) {
						toastr["error"]("Failed!! to Continue! XSS Code found as Input!");
						return false;
					}
				}
				return true;
			} else {
				if(typeof value != 'object' && (data.trim() != '' && data.indexOf("<script>") != -1)) {
					toastr["error"]("Failed!! to Continue! XSS Code found as Input!");
					return false;
				}
				return true;
			}
		}
		//end
		function calculate_inclusive(amount, tax) {
			amount = parseFloat(amount);
			tax = parseFloat(tax);
			return(amount * tax / (100 + tax)).toFixed(2); //By tally
		}

		function calculate_exclusive(amount, tax) {
			amount = parseFloat(amount);
			tax = parseFloat(tax);
			return((amount * tax) / parseFloat(100)).toFixed(2);
		}

		function app_number_format(num = 0) {
			return num.toLocaleString('en-US', {
				minimumFractionDigits: 1,
				maximumFractionDigits: 2
			});
		}
		</script>
		<!-- CSRF Token Protection -->
		<!-- Initialize Select2 Elements -->
<script type="text/javascript">
		$(".select2").select2({});
		$(".product_category").select2({
			tags: true
		});
		$(".product_unit").select2({
			tags: true
		});
		</script>
		<!-- Initialize date with its Format -->
		<script type="text/javascript">
		//Date picker
		$('.datepicker').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			todayHighlight: true
		});
		</script>
		<!-- DATE RANGE PICKER -->
		<script>
		var delete_rows = [];
		var barcode_product_list = [];
		$(function() {
			//Date range as a button
			$('.daterange-btn').daterangepicker({
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: moment().subtract(29, 'days'),
				endDate: moment()
			}, function(start, end) {
				$('.daterange-btn span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'))
			});
		});

		function get_start_date(input_id) {
			return $('#' + input_id).data('daterangepicker').startDate.format('DD-MM-YYYY');
			var end_date = $('#' + input_id).data('daterangepicker').endDate.format('DD-MM-YYYY');
		}

		function get_end_date(input_id) {
			return $('#' + input_id).data('daterangepicker').endDate.format('DD-MM-YYYY');
		}
		</script>
		<!-- Initialize toggler -->
		<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle="popover"]').popover();
		});
		</script>
		<!-- start pace loader -->
		<script type="text/javascript">
		$(document).ajaxStart(function() {
			Pace.restart();
		});
		</script>
		<script type="text/javascript">
		$(document).ready(function() {
			setTimeout(function() {
				$(".alert-dismissable").fadeOut(1000, function() {});
			}, 10000);
		});
		</script>
		<script type="text/javascript">
		function round_off(input = 0) {
			return input;
		}
		</script>
		<!-- iCheck -->
		
		<script src="{{asset('backend/pos-template/js/fullscreen.js')}}"></script>
		<script src="{{asset('backend/pos-template/js/modals.js')}}"></script>
		
		<!-- <script src="{{asset('backend/pos-template/js/mousetrap.min.js')}}"></script>
		<script src="{{asset('backend/pos-template/js/bootstrap3-typeahead.min.js')}}"></script>
		<script src="{{asset('backend/pos-template/js/jquery.validate.js')}}"></script>
		<script src="{{asset('backend/pos-template/js/additional-methods.min.js')}}"></script> -->
		
		<script>
		var typingTimer; //timer identifier
		var doneTypingInterval = 1000; //time in ms (5 seconds)
		//on keyup, start the countdown
		$('#search_it').keyup(function() {
			clearTimeout(typingTimer);
			if($('#search_it').val()) {
				typingTimer = setTimeout(doneTyping, doneTypingInterval);
			}
		});
		//user is "finished typing," do something
		function doneTyping() {
			var name = $("#search_it").val().trim();
			$.ajax({
				type: "GET",
				url: "{{url('item-sales-barcode-search')}}",
				data: {
					method: '__item_search',
					_text_val: name,
					_pos_sales:1
				},
				async: false,
				cache: false,
				success: function(response) {
					var data = JSON.parse(response);
					var product_list = data['datas'];
					console.log(data)
					var product_list_html = ``;
					if(product_list.length > 0) {
						for(let i = 0; i < product_list.length; i++) {
							var data = product_list[i];
							product_list_html += `<div class="col-md-4 col-xs-6 " id="item_parent_${i}" disabled="disabled" data-toggle="tooltip" title="" style="padding-left: 5px; padding-right: 5px; display: block;" data-original-title="${data._item}">
													<div class="box box-default item_box" id="div_${data._row_id}" onclick="addrow(${data._row_id})" data-item-id="${data._row_id}" data-item-name="${data._item}" data-item-available-qty="${data.available_qty}" 
													data-item-discount="${data._sales_discount}" 
													data-item-sales-price="${data._saleprice}" data-item-cost="${data._purprice}" data-item-tax-id="${data._vatnote}" data-item-tax-type="Exclusive" data-item-tax-value="${data._vat}" data-item-tax-name="${data._vatnote}" data-item-tax-amt="0" 
													style="max-height: 200px;
    min-height: 150px;
    cursor: pointer;
    background-color: #fff;
   box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
    padding: 2px;">
													 <span class="label label-success push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="${data.available_qty} Quantity in Stock">Qty: ${parseFloat(data.available_qty).toFixed(2)}</span>
														<div class="">
															<center> <img class=" img-responsive item_image" src="{{asset('/')}}{{$default_image ?? ''}}" alt="Item picture"> </center>
															<lable class="text-center search_item" style="font-weight: bold; font-family: sans-serif; display: -webkit-box;" id="item_${i}">
															${data._row_id} || ${data._id} <br>
															${data._item}
																<br> <span class="" style="font-family: sans-serif;font-size:150%; ">TK ${parseFloat(data._saleprice).toFixed(2)}</span> </lable>
														</div>
													</div>
												</div>`;
						}
					} else {
						product_list_html += `<div class="col-md-12 ">

													 

													<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-ship"></i> 
                </button>

												</div>`;
					}
					$(".search_div").html('');
					$(".search_div").html(product_list_html);
					$(".overlay").remove();
				}
			});
		}
		$(document).ready(function() {
			get_details()
		})
		$("#other_charges").keyup(function(event) {
			final_total();
		});
		//RIGHT SIT DIV:-> FILTER ITEM INTO THE ITEMS LIST
		function search_it() {
			var input = $("#search_it").val().trim();
			var item_count = $(".search_div .search_item").length;
			var error_count = item_count;
			for(i = 0; i < item_count; i++) {
				if($("#item_" + i).html().toUpperCase().indexOf(input.toUpperCase()) > -1) {
					$("#item_" + i).show();
					$("#item_parent_" + i).show();
				} else {
					$("#item_" + i).hide();
					$("#item_parent_" + i).hide();
					error_count--;
				}
				if(error_count == 0) {
					$(".error_div").show();
				} else {
					$(".error_div").hide();
				}
			}
		}
		$(document).on('click','.sub_category',function(){
			var _category_id= $(this).attr('attr_cat_id');
			var branch_id = $(document).find("._main_branch").val();
			var store_id = $(document).find("._main_store").val();
			get_details(_category_id,branch_id,store_id) 
			
		})
		//REMOTELY FETCH THE ALL ITEMS OR CATEGORY WISE ITEMS.
		function get_details(_category_id="",branch_id=1,store_id=1) {
			//$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

			if(_category_id !=""){
				var id = _category_id;
			}else{
				var id = $("#category_id").val();
				if(id == "") {
					id = "ALL";
				}
			}
			

			 $.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });

        $.ajax({
           type: "POST",
				url: "{{url('category-wise-item')}}",
				data: {
					method: '_item_category',
					_item_category: id,
					branch_id,
					store_id
				},
				async: false,
				cache: false,
				success: function(response) {
					var data = JSON.parse(response);
					var product_list = data['items'];
					var _sub_category_list = data['category'];
					console.log(product_list)
					var product_list_html = ``;

					if(_sub_category_list.length > 0){
							for(let i = 0; i < _sub_category_list.length; i++) {

								product_list_html += `<div class="col-md-4 " >

						<div 
						style="cursor: pointer;
						min-height: 150px;
   						text-align: center;
  						box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
					    padding: 2px;
					    border-radius: 5px;
					    margin-bottom: 5px;"  class="sub_category"
													attr_cat_id= "${_sub_category_list[i].id}"
															title="${_sub_category_list[i]._name}" 
															>`;
															
															if(_sub_category_list[i]._image !==null){
product_list_html += `<img class=" img-responsive " src="{{asset('/')}}${_sub_category_list[i]._image}" alt="Item picture" style="height:100px;width:100%;"> `;
															}else{
product_list_html += `<img class=" img-responsive " src="{{asset('/')}}{{$default_image}}" alt="Item picture" style="height:100px;width:100%;"> `;
															}
															
															product_list_html +=`
															<b>${_sub_category_list[i]._name}</b>
															</div>

												</div>`;

							}

							
							}

					if(product_list.length > 0) {
						for(let i = 0; i < product_list.length; i++) {
							var data = product_list[i];
							product_list_html += `<div class="col-md-4 col-xs-6 " id="item_parent_${i}" disabled="disabled" data-toggle="tooltip" title="" 
							style="padding-left: 2px !important; padding-right: 2px !important; display: block;"
							 data-original-title="${data._item}">
													<div class="box box-default item_box" id="div_${data._row_id}" onclick="addrow(${data._row_id})" data-item-id="${data._row_id}" data-item-name="${data._item}" data-item-available-qty="${data.available_qty}" 
													data-item-discount="${data._sales_discount}" 
													data-item-sales-price="${data._saleprice}" data-item-cost="${data._purprice}" data-item-tax-id="${data._vatnote}" data-item-tax-type="Exclusive" data-item-tax-value="${data._vat}" data-item-tax-name="1" data-item-tax-amt="0" 
style="max-height: 200px;
    min-height: 150px;
    cursor: pointer;
    background-color: #fff;
   box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
    padding: 2px;"> <span class="label label-success push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="${data.available_qty} Quantity in Stock">Qty: ${parseFloat(data.available_qty).toFixed(2)}</span>
														<div class="box-body box-profile" style="padding:1px;">
															<center> `;

if( data._image !==null ){
			product_list_html += `<img class=" img-responsive item_image"  src="{{asset('/')}}${data._image}" alt="Item picture">`;
		}else{
		product_list_html += `<img class=" img-responsive item_image"  src="{{asset('/')}}{{$default_image ?? ''}}" alt="Item picture">`;	
		}


													product_list_html += ` </center>
															<lable class="text-center search_item" style="font-weight: bold; font-family: sans-serif; display: -webkit-box;" id="item_${i}">
															${data._row_id} || ${data._id} <br>
															${data._item}
																<br> <span class="" style="font-family: sans-serif;font-size:150%; ">TK ${parseFloat(data._saleprice).toFixed(2)}</span> </lable>
														</div>
													</div>
												</div>`;
						}
					} 

					if(_sub_category_list.length ==0 && product_list.length == 0){
						product_list_html += `<div class="col-md-4 " >

													<div 
													style="cursor: pointer;
						min-height: 150px;
   						text-align: center;
  						box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
					    padding: 2px;
					    border-radius: 5px;
					    margin-bottom: 5px;"  class="sub_category"
													attr_cat_id= "ALL"
															title="ALL CATEGORY" 
															>
															<img class=" img-responsive " src="{{asset('/')}}{{$default_image ?? ''}}" alt="Item picture" style="width:100%;height:100px;"> 
															<b>ALL CATEGORY</b>
															</div>

												</div>`;
					}
					$(".search_div").html('');
					$(".search_div").html(product_list_html);
					$(".overlay").remove();
				}

        });
			
		}
		//LEFT SIDE: ON CLICK ITEM ADD TO INVOICE LIST
		function addrow(id, hold_invoice = false, hold_data = "", row_index = 0, barcode,_add_form_barcode="") {
			//console.log(hold_data)
			var _barcode = "";
			var hold_row_id = "";
			if(hold_invoice = true && hold_data != "" && barcode != "barcode") {
				console.log("rearange")
				console.log(hold_data)
				var hold_row_id = hold_data.row_id;
				var rowcount = row_index; //0,1,2...
				var item_id = hold_data._id;
				var item_name = hold_data._item;
				var tax_type = hold_data._taxtype;
				var tax_id = hold_data._taxid;
				var tax_value = hold_data._taxralue;
				var tax_name = "";
				var stock = hold_data._stock;
				var tax_amt = hold_data._vat;
				var item_cost = 0;
				var sales_price = hold_data._rate;
				var sales_price_temp = sales_price;
				sales_price = (parseFloat(sales_price)).toFixed(2);
				var qty = hold_data._qty;
				console.log(hold_data)
			} else if(hold_invoice = false && hold_data != "", barcode == "barcode") {
				if(barcode_product_list.length > 0) {
					for(var i = 0; i < barcode_product_list.length; i++) {
						if(barcode_product_list[i]._id == hold_data._id) {
							increment_qty(barcode_product_list[i]._id, i)
							return;
						}
					}
				}
				var rowcount = $("#hidden_rowcount").val(); //0,1,2...
				var item_id = hold_data._id;
				var item_name = hold_data._item;
				var tax_type = "";
				var tax_id = hold_data._taxid;
				var tax_value = parseFloat(hold_data._vat);
				var tax_name = "";
				var stock = parseFloat(hold_data._stock);
				var tax_amt = 0;
				var item_cost = parseFloat(hold_data._purprice);
				var sales_price = hold_data._rate;
				var sales_price_temp = sales_price;
				sales_price = (parseFloat(sales_price)).toFixed(2);
				var qty = parseFloat(hold_data._qty);
				if(isNaN(qty)) qty = 1;
			} else {
				console.log('click on image  ')
					//===========================================
					//CHECK SAME ITEM ALREADY EXIST IN ITEMS TABLE 
					//===========================================
				var item_check = check_same_item($('#div_' + id).attr('data-item-id'));
				if(!item_check) {
					return false;
				}
				var rowcount = $("#hidden_rowcount").val(); //0,1,2...
				var item_id = $('#div_' + id).attr('data-item-id');
				var item_name = $('#div_' + id).attr('data-item-name');
				var stock = $('#div_' + id).attr('data-item-available-qty');
				stock = (parseFloat(stock)).toFixed(2);
				var tax_type = $('#div_' + id).attr('data-item-tax-type');
				var tax_id = $('#div_' + id).attr('data-item-tax-id');
				var tax_value = $('#div_' + id).attr('data-item-tax-value');
				var tax_name = $('#div_' + id).attr('data-item-tax-name');
				var tax_amt = $('#div_' + id).attr('data-item-tax-amt');
				//var tax_rate = $('#div_' + id).attr('data-item-tax-rate');
				//var gst_per         =$('#div_'+id).attr('data-item-tax-per');
				//var gst_amt         =$('#div_'+id).attr('data-item-gst-amt');
				var item_cost = $('#div_' + id).attr('data-item-cost');
				var sales_price = $('#div_' + id).attr('data-item-sales-price');
				var _sales_discount = $('#div_' + id).attr('data-item-discount');
				console.log("_sales_discount "+_sales_discount)
				console.log("item_cost" + item_cost)
				var sales_price_temp = sales_price;
				sales_price = (parseFloat(sales_price)).toFixed(2);
				if(stock > 0) {
					if(stock > 1) {
						qty = 1;
					} else {
						qty = stock;
					}
				} else {
					zero_stock();
					return;
				}
			}

			
			var quantity = '<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty(' + item_id + ',' + rowcount + ')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
			quantity += '<input type="text" value="' + qty + '" class="form-control  text-center min_width item_qty" onchange="item_qty_input(' + item_id + ',' + rowcount + ')" id="item_qty_' + item_id + '" name="item_qty_' + item_id + '">';
			quantity += '<span class="input-group-btn"><button onclick="increment_qty(' + item_id + ',' + rowcount + ')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
			var sub_total = (parseFloat(1) * parseFloat(sales_price)).toFixed(2); //Initial
			var remove_btn = '<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow(' + rowcount + ')" title="Delete Item?"></a>';
			var str = ' <tr id="row_' + rowcount + '" data-row="'+rowcount+'" data-item-id=' + item_id + '>'; /*item id*/
			str += '<td id="td_' + rowcount + '_0"><a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_' + rowcount + '_0" onclick="show_sales_item_modal(' + rowcount + ')">' + item_name + '</a> <i onclick="show_sales_item_modal(' + rowcount + ')" class="fa fa-edit pointer"></i></td>'; /* td_0_0 item name*/
			str += '<td id="td_' + rowcount + '_1">' + stock + '</td>'; /* td_0_1 item available qty*/
			str += '<td id="td_' + rowcount + '_2">' + quantity + '</td>'; /* td_0_2 item available qty*/
			info = '<input id="sales_price_' + rowcount + '" onblur="set_to_original(' + rowcount + ',' + item_cost + ')" onkeyup="update_price(' + rowcount + ',' + item_cost + ')" name="sales_price_' + rowcount + '" type="text" class="form-control  min_width item_sales_price" value="' + sales_price + '">';
			str += '<td id="td_' + rowcount + '_3" class="text-right">' + info + '</td>'; /* td_0_3 item sales price*/
			/*Discount*/
			info = '<input data-toggle="tooltip" title="Click to Change" onclick="show_sales_item_modal(' + rowcount + ')" id="item_discount_' + rowcount + '" readonly name="item_discount_' + rowcount + '" type="text" class="form-control  min_width pointer" value="'+_sales_discount+'">';
			str += '<td id="td_' + rowcount + '_6" class="text-right">' + info + '</td>';
			/*Tax amt*/
			str += '<td id="td_' + rowcount + '_11"><input data-toggle="tooltip" title="Click to Change" id="td_data_' + rowcount + '_11" onclick="show_sales_item_modal(' + rowcount + ')" name="td_data_' + rowcount + '_11" type="text" class="form-control  pointer min_width" readonly value="' + tax_amt + '"></td>';
			str += '<td id="td_' + rowcount + '_4" class="text-right"><input data-toggle="tooltip" title="Total" id="td_data_' + rowcount + '_4" name="td_data_' + rowcount + '_4" type="text" class="form-control  pointer" readonly value="' + sub_total + '"></td>'; /* td_0_4 item sub_total */
			str += '<td id="td_' + rowcount + '_5">' + remove_btn + '</td>'; /* td_0_5 item gst_amt */
			str += '<input type="hidden" name="tr_item_id_' + rowcount + '" id="tr_item_id_' + rowcount + '" value="' + item_id + '">';
			str += '<input type="hidden" id="tr_item_cost_' + rowcount + '" name="tr_item_cost_' + rowcount + '" value="' + item_cost + '">';
			str += '<input type="hidden" id="tr_sales_price_temp_' + rowcount + '" name="tr_sales_price_temp_' + rowcount + '" value="' + sales_price_temp + '">';
			str += '<input type="hidden" id="tr_tax_type_' + rowcount + '" name="tr_tax_type_' + rowcount + '" value="' + tax_type + '">';
			str += '<input type="hidden" id="tr_tax_id_' + rowcount + '" name="tr_tax_id_' + rowcount + '" value="' + tax_id + '">';
			str += '<input type="hidden" id="tr_tax_amount_' + rowcount + '" name="tr_tax_amount_' + rowcount + '" value="' + tax_amt + '">';
			str += '<input type="hidden" id="tr_tax_value_' + rowcount + '" name="tr_tax_value_' + rowcount + '" value="' + tax_value + '">';
			str += '<input type="hidden" id="description_' + rowcount + '" name="description_' + rowcount + '" value="">';
			str += '<input id="item_discount_type_' + rowcount + '" name="item_discount_type_' + rowcount + '" type="hidden" value="Percentage">';
			str += '<input id="item_discount_input_' + rowcount + '" name="item_discount_input_' + rowcount + '" type="hidden" value="'+_sales_discount+'">';
			str += '<input id="hold_row_' + rowcount + '" name="hold_row_' + rowcount + '" type="hidden" value="' + hold_row_id + '">';
			str += '<input id="_barcode_' + rowcount + '" name="_barcode_' + rowcount + '" type="hidden" value="' + _barcode + '">';
			str += '</tr>';
			//==================================================
			//LEFT SIDE: ADD OR APPEND TO SALES INVOICE TERMINAL
			//==================================================
			$('#pos-form-tbody').append(str);
			//==============================
			//LEFT SIDE: INCREMANT ROW COUNT
			//==============================
			$("#hidden_rowcount").val(parseFloat($("#hidden_rowcount").val()) + 1);
			failed.currentTime = 0;
			failed.play();
			//===========================================
			//CALCULATE FINAL TOTAL AND OTHER OPERATIONS
			//final_total();
			//===========================================
			make_subtotal(item_id, rowcount);
			barcode_product_list.push({
				row_id: hold_row_id,
				row_index: rowcount,
				_id: item_id,
				_item: item_name,
				_taxtype: tax_type,
				_taxid: tax_id,
				_taxralue: tax_value,
				tax_name: tax_name,
				_stock: stock,
				_vat: tax_value,
				_vat_amount: tax_amt,
				item_cost: item_cost,
				_rate: sales_price,
				_qty: qty,
				sales_price: sales_price
			});
		}
		$(".new_invoice_link").on("click", function() {
			if(barcode_product_list.length > 0) {
				var return_message = `Are you sure ? Your Product Will be Discard`;
				var r = confirm(return_message);
				return(r == true) ? true : false;
			}
			console.log(barcode_product_list)
		})

		function update_price(row_id, item_cost) {
			make_subtotal($("#tr_item_id_" + row_id).val(), row_id);
		}

		function set_to_original(row_id, item_cost) {
			return true;
			/*Input*/
			var sales_price = $("#sales_price_" + row_id).val().trim();
			if(sales_price != '' || sales_price == 0) {
				sales_price = parseFloat(sales_price);
			}
			/*Default set from item master*/
			var item_price = parseFloat($("#tr_sales_price_temp_" + row_id).val().trim());
			if(sales_price < item_cost) {
				toastr["success"]("Default Price Set " + item_price);
				$("#sales_price_" + row_id).parent().removeClass('has-error');
				$("#sales_price_" + row_id).val(item_price);
			}
			make_subtotal($("#tr_item_id_" + row_id).val(), row_id);
		}
		//INCREMENT ITEM
		function increment_qty(item_id, rowcount) {
			var item_qty = $("#item_qty_" + item_id).val();
			var stock = $("#td_" + rowcount + "_1").html();
			if(parseFloat(item_qty) < parseFloat(stock)) {
				new_item_qty = parseFloat(item_qty) + 1;
				if(parseFloat(new_item_qty) > parseFloat(stock)) {
					new_item_qty = stock;
				}
				$("#item_qty_" + item_id).val(parseFloat(new_item_qty).toFixed(2));
				barcode_product_list.filter(function(item, index) {
					if(rowcount == index) barcode_product_list[index]._qty = parseFloat(new_item_qty).toFixed(2);
				})
			}
			make_subtotal(item_id, rowcount);
		}
		//DECREMENT ITEM
		function decrement_qty(item_id, rowcount) {
			var item_qty = parseFloat($("#item_qty_" + item_id).val());
			item_qty = isNaN(item_qty) ? 0 : item_qty;
			var stock = parseFloat($("#td_" + rowcount + "_1").html());
			stock = isNaN(stock) ? 0 : stock;
			if(item_qty < 1) {
				$("#item_qty_" + item_id).val((item_qty).toFixed(2));
				barcode_product_list.filter(function(item, index) {
					if(rowcount == index) barcode_product_list[index]._qty = parseFloat(item_qty).toFixed(2);
				})
				toastr["warning"]("Minimum Stock!");
				return;
			}
			if(item_qty <= 1) {
				$("#item_qty_" + item_id).val((1).toFixed(2));
				barcode_product_list.filter(function(item, index) {
					if(rowcount == index) barcode_product_list[index]._qty = parseFloat(1).toFixed(2);
				})
				toastr["warning"]("Minimum Stock!");
				return;
			}
			$("#item_qty_" + item_id).val((parseFloat(item_qty) - 1).toFixed(2));
			barcode_product_list.filter(function(item, index) {
				if(rowcount == index) barcode_product_list[index]._qty = ((parseFloat(item_qty) - 1).toFixed(2));
			})
			make_subtotal(item_id, rowcount);
		}
		//=========================================
		//LEFT SIDE: IF ITEM QTY CHANGED MANUALLY
		//=========================================
		function item_qty_input(item_id, rowcount) {
			var item_qty = $("#item_qty_" + item_id).val();
			var stock = $("#td_" + rowcount + "_1").html();
			if(stock == 0) {
				toastr["warning"]("item Not Available in stock!");
				//return;  
			}
			if(parseFloat(item_qty) > parseFloat(stock)) {
				$("#item_qty_" + item_id).val(stock);
				toastr["warning"]("Oops! You have only " + stock + " items in Stock");
				// return;
			}
			if(item_qty == 0) {
				$("#item_qty_" + item_id).val(1);
				toastr["warning"]("You must have atlease one Quantity");
				//return; 
			}
			/*else{
			  $("#item_qty_"+item_id).val(1);
			  toastr["warning"]("You must have atlease one Quantity");
			  return; 
			}*/
			make_subtotal(item_id, rowcount);
		}

		function zero_stock() {
			toastr["error"]("Out of Stock!");
			return;
		}
		//========================
		//LEFT SIDE: REMOVE ROW 
		//=========================
		function removerow(id) { //id=Rowid 
			//$(this).remove();
			
			$("#hidden_rowcount").val(0);
			$("#row_" + id).remove();
			$('#pos-form-tbody').empty();
			var new_barcode_product_list = barcode_product_list.filter(function(item, index) {
					return id !== index
				})
				console.log(new_barcode_product_list)
			barcode_product_list = [];
			//console.log(new_barcode_product_list)
			for(var i = 0; i < new_barcode_product_list.length; i++) {
				new_barcode_product_list[i].row_index = i
				var hold_data = new_barcode_product_list[i];
				//console.log("row_"+i);
				addrow(new_barcode_product_list[i]._id, true, hold_data, i);
				//addrow(barcode_product_list[i]._id,hold_invoice=false,new_barcode_product_list[i],i)
			}
			// // console.log(barcode_product_list.length)
			// 	//$("#row_" + id).remove();
			failed.currentTime = 0;
			failed.play();
			final_total();

			// $("#row_" + id).remove();
			// var new_barcode_product_list = [];
			// for(var i=0;i < barcode_product_list.length;i++){
			// 	if(id !=barcode_product_list[i].row_index){
			// 		new_barcode_product_list.push(barcode_product_list[i]);
			// 	}
			// }
			// barcode_product_list =[];
			// barcode_product_list=new_barcode_product_list;
			// failed.currentTime = 0;
			// failed.play();
			// final_total();
		}
		//======================
		//MAKE SUBTOTAL
		//======================
		function make_subtotal(item_id, rowcount) {
			set_tax_value(rowcount);
			//Find the Tax type and Tax amount
			var tax_type = $("#tr_tax_type_" + rowcount).val();
			var tax_amount = $("#td_data_" + rowcount + "_11").val();
			var sales_price = $("#sales_price_" + rowcount).val();
			//var gst_per         =$("#tr_item_per_"+rowcount).val();
			var item_qty = $("#item_qty_" + item_id).val();
			var tot_sales_price = parseFloat(item_qty) * parseFloat(sales_price);
			//var gst_amt=(tot_sales_price * gst_per)/100;
			var subtotal = parseFloat(tot_sales_price);
			/*Discounr*/
			//var discount_amt = $("#item_discount_" + rowcount).val();
			//subtotal = (tax_type == 'Inclusive') ? subtotal : parseFloat(subtotal) + parseFloat(tax_amount);
			//subtotal -= parseFloat(discount_amt);
			$("#td_data_" + rowcount + "_4").val(parseFloat(subtotal).toFixed(2));
			final_total();
		}

		function calulate_discount(discount_input, discount_type, total) {
			if(discount_type == 'in_percentage') {
				return parseFloat((total * discount_input) / 100);
			} else { //in_fixed
				return parseFloat(discount_input);
			}
		}
		//============================
		//LEFT SIDE: FINAL TOTAL
		//===========================
		function final_total() {
			console.log(barcode_product_list)
			var total = 0;
			var item_qty = 0;
			var rowcount = $("#hidden_rowcount").val();
			var discount_input = $("#discount_input").val();
			var discount_type = $("#discount_type").val();
			var other_charges = parseFloat($("#other_charges").val());
			other_charges = (isNaN(other_charges)) ? parseFloat(0) : other_charges;
			var line_discount_amount = 0;
			var line_vat_amount = 0;
			if($(".items_table tr").length > 1) {
				for(i = 0; i < rowcount; i++) {
					if(document.getElementById('tr_item_id_' + i)) {
						// set_tax_value(i);
						//var tax_amt = parseFloat($("#td_data_"+i+"_11").val());
						item_id = $("#tr_item_id_" + i).val();
						total = parseFloat(total) + + +parseFloat($("#td_data_" + i + "_4").val()).toFixed(2);
						//console.log("==>total="+total);
						//console.log("==>tax_amt="+tax_amt);
						// total+=tax_amt;
						//console.log("==>total="+total);
						item_qty = parseFloat(item_qty) + + +parseFloat($("#item_qty_" + item_id).val()).toFixed(2);
						var line_dis = parseFloat($("#item_discount_" + i).val())
						if(isNaN(line_dis)) {
							line_dis = 0
						}
						line_discount_amount += line_dis
						var tax_amt = parseFloat($("#td_data_" + i + "_11").val());
						if(isNaN(tax_amt)) {
							tax_amt = 0
						}
						line_vat_amount += tax_amt;
					}
				} //for end
			} //items_table
			//===================================
			//Discount new Roles by akash bhai
			//====================================
			var row_total_rate_qty = row_total_rate_qty_amount();
			$("#_line_total_discount").val(line_discount_amount)
			$("#_line_vat_total").val(line_vat_amount)
			//total += other_charges;
			total = round_off(total);
			var discount_amt = 0;
			if(total > 0) {
				var discount_amt = calulate_discount(discount_input, discount_type, row_total_rate_qty); //return value 
			}
			var _payable_amount = total - (discount_amt + line_discount_amount) + line_vat_amount
			var total__amt = total 
			//var total__amt = total - (line_discount_amount) + line_vat_amount
			set_total(item_qty, total__amt, discount_amt, _payable_amount);
		}

		function set_total(tot_qty = 0, tot_amt = 0, tot_disc = 0, tot_grand = 0) {
			$(".tot_qty").html(tot_qty);
			$(".tot_amt").html((round_off(tot_amt).toFixed(2)));
			$(".tot_disc").html((round_off(tot_disc).toFixed(2)));
			$(".tot_grand").html((round_off(tot_grand)).toFixed(2));
		}
		//==========================
		//LEFT SIDE: FINAL TOTAL
		//==========================
		function adjust_payments() {
			var total = 0;
			var item_qty = 0;
			var rowcount = $("#hidden_rowcount").val();
			var discount_input = $("#discount_input").val();
			var discount_type = $("#discount_type").val();
			var other_charges = parseFloat($("#other_charges").val());
			other_charges = (isNaN(other_charges)) ? parseFloat(0) : other_charges;
			if($(".items_table tr").length > 1) {
				for(i = 0; i < rowcount; i++) {
					if(document.getElementById('tr_item_id_' + i)) {
						total = parseFloat(total) + + +parseFloat($("#td_data_" + i + "_4").val()).toFixed(2);
						item_id = $("#tr_item_id_" + i).val();
						item_qty = parseFloat(item_qty) + + +parseFloat($("#item_qty_" + item_id).val()).toFixed(2);
					}
				} //for end
			} //items_table
			total += other_charges;
			total = round_off(total);
			//Find customers payment
			var payments_row = get_id_value("payment_row_count");
			console.log("payments_row=" + payments_row);
			var paid_amount = parseFloat(0);
			for(var i = 1; i <= payments_row; i++) {
				if(document.getElementById("amount_" + i)) {
					var amount = parseFloat(get_id_value("amount_" + i));
					amount = isNaN(amount) ? 0 : amount;
					console.log("amount_" + i + "=" + amount);
					paid_amount += amount;
				}
			}
			//===========================================
			//RIGHT SIDE DIV
			//Discount new Roles by akash bhai
			//=============================================
			var row_total_rate_qty = row_total_rate_qty_amount();
			var _save_line_discount_amount = parseFloat($("#_line_total_discount").val())
			var _save_line_vat_amount = parseFloat($("#_line_vat_total").val())
				//var discount_amt = calulate_discount(discount_input, discount_type, total); //return value
			var discount_amt = calulate_discount(discount_input, discount_type, row_total_rate_qty); //return value
			var change_return = 0;
			var total = total - _save_line_discount_amount + _save_line_vat_amount;
			var balance = total - discount_amt - paid_amount;
			if(balance < 0) {
				//console.log("Negative");
				change_return = Math.abs(parseFloat(balance));
				balance = 0;
			}
			balance = round_off(balance);
			$(".sales_div_tot_qty  ").html(item_qty);
			$(".sales_div_tot_amt  ").html((round_off(total)).toFixed(2));
			$(".sales_div_tot_discount ").html((parseFloat(round_off(discount_amt))).toFixed(2));
			$(".sales_div_tot_payble ").html((parseFloat(round_off(total - discount_amt))).toFixed(2));
			$(".sales_div_tot_paid ").html((round_off(paid_amount)).toFixed(2));
			$(".sales_div_tot_balance ").html((parseFloat(round_off(balance))).toFixed(2));
			/**/
			$(".sales_div_change_return ").html((change_return).toFixed(2));
		}

		function row_total_rate_qty_amount() {
			//======================================
			//Discount new Roles by akash bhai
			//=======================================
			var item_qty_list = [];
			var item_rate_list = [];
			var row_total_rate_qty = 0;
			$('.item_qty').each(function(index) {
				console.log($(this).val())
				item_qty_list.push($(this).val());
			})
			$('.item_sales_price').each(function(index) {
				console.log($(this).val())
				item_rate_list.push($(this).val());
			})
			if(parseFloat(item_qty_list.length) > 0) {
				for(var i = 0; i < parseFloat(item_qty_list.length); i++) {
					row_total_rate_qty += parseFloat(parseFloat(item_qty_list[i]) * parseFloat(item_rate_list[i]));
				}
			}
			return row_total_rate_qty;
		}

		function check_same_item(item_id) {
			if($(".items_table tr").length > 1) {
				var rowcount = $("#hidden_rowcount").val();
				for(i = 0; i <= rowcount; i++) {
					if($("#tr_item_id_" + i).val() == item_id) {
						increment_qty(item_id, i);
						failed.currentTime = 0;
						failed.play();
						return false;
					}
				} //end for
			}
			return true;
		}
		$(document).ready(function() {
			var first_div = parseFloat($(".content-wrapper").height());
			var second_div = parseFloat($("section").height());
			var items_table = parseFloat($(".items_table").height());
			//$(".items_table").parent().css("height", (first_div - second_div) + items_table + 250); /**/
			$(".search_div").parent().css("height", "84vh"); /**/
			//FIRST TIME: SET TOTAL ZERO
			set_total();
			//RIGHT DIV: FILTER INPUT BOX
			/*$("#search_it").on("keyup", function() {
				search_it();
			});
			*/
			//CATEGORY WISE ITEM FETCH FROM SERVER
			$("#category_id").change(function() {
				var _category_id = $(this).val();
				var branch_id = $(document).find("._main_branch").val();
				var store_id = $(document).find("._main_store").val();
				get_details(_category_id,branch_id,store_id) 
				
			});
			//DISCOUNT UPDATE
			$(".discount_update").click(function() {
				final_total();
				$('#discount-modal').modal('toggle');
			});
			//RIGHT SIDE: CLEAR SEARCH BOX
			$(".show_all").click(function() {
				$("#search_it").val('').trigger("keyup");
				$("#category_id").val('').trigger("change");
			});
			//UPDATE PROCESS START
			//UPDATE PROCESS END
			// hold_invoice_list();
		}); //ready() end
		$("#item_search").bind("paste", function(e) {
			$("#item_search").autocomplete('search');
		});
		var id = $("#category_id").val()
		$("#item_search").autocomplete({
			source: function(data, cb) {
				$.ajax({
					autoFocus: true,
					url: "sys_entryformadd.php?formid=42",
					method: 'POST',
					dataType: 'json',
					showHintOnFocus: true,
					autoSelect: true,
					selectInitial: true,
					data: {
						name: data.term,
						method: '__item_search'
					},
					success: function(res) {
						console.log(res);
						var result;
						result = [{
							//label: 'No Records Found '+data.term,
							label: 'No Records Found ',
							value: ''
						}];
						if(res.length) {
							result = $.map(res, function(el) {
								return {
									label: el.item_code + '--[Qty:' + el.stock + '] --' + el.label,
									value: '',
									id: el.id,
									item_name: el.label,
									stock: el.stock,
									// mobile: el.mobile,
									//customer_dob: el.customer_dob,
									//address: el.address,
								};
							});
						}
						cb(result);
					}
				});
			},
			response: function(e, ui) {
				/*if(ui.content.length == 1) {
					$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
					$(this).autocomplete("close");
				} */
				//console.log(ui.content[0].id);
			},
			//loader start
			search: function(e, ui) {},
			select: function(e, ui) {
				console.log(ui)
				if(typeof ui.content != 'undefined') {
					console.log("Autoselected first");
					if(isNaN(ui.content[0].id)) {
						return;
					}
					var stock = ui.content[0].stock;
					var item_id = ui.content[0].id;
				} else {
					console.log("manual Selected");
					var stock = parseFloat(ui.item.stock);
					var item_id = ui.item.id;
				}
				console.log(item_id)
				if(parseFloat(stock) == 0) {
					toastr["error"]("Out of Stock!");
					$("#item_search").val('');
					return;
				}
				addrow(item_id);
				$("#item_search").val('');
			},
			//loader end
		});
		//DATEPICKER INITIALIZATION
		$('#order_date,#delivery_date,#cheque_date').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			todayHighlight: true
		});
		$('#customer_dob,#birthday_person_dob').datepicker({
			calendarWeeks: true,
			todayHighlight: true,
			autoclose: true,
			format: 'dd-mm-yyyy',
			startView: 2
		});
		//Sale Items Modal Operations Start
		function show_sales_item_modal(row_id) {
			$('#sales_item').modal('toggle');
			//$("#popup_tax_id").select2();
			//Find the item details
			console.log(row_id)
			var item_name = $("#td_data_" + row_id + "_0").html();
			var tax_type = $("#tr_tax_type_" + row_id).val();
			var tax_id = $("#tr_tax_id_" + row_id).val();
			var description = $("#description_" + row_id).val();
			/*Discount*/
			var item_discount_input = $(document).find("#item_discount_input_" + row_id).val();
			var item_discount_type =  $(document).find("#item_discount_type_" + row_id).val();
			console.log("item_discount_input "+ item_discount_input)
			//Set to Popup
			$("#item_discount_input").val(item_discount_input);
			$("#item_discount_type").val(item_discount_type).select2();
			$("#popup_item_name").html(item_name);
			$("#popup_tax_type").val(tax_type).select2();
			//$("#popup_tax_id").val(tax_id);
			$("#popup_tax_id").val(tax_id).select2();
			$("#popup_row_id").val(row_id);
			$("#popup_description").val(description);
		}

		function set_info() {
			var row_id = $("#popup_row_id").val();
			var tax_type = $("#popup_tax_type").val();
			var tax_id = $("#popup_tax_id").val();
			var description = $("#popup_description").val();
			var tax_name = ($('option:selected', "#popup_tax_id").attr('data-tax-value'));
			var tax = parseFloat($('option:selected', "#popup_tax_id").attr('data-tax'));
			/*Discounr*/
			var item_discount_input = $("#item_discount_input").val();
			var item_discount_type = $("#item_discount_type").val();
			//Set it into row 
			$("#item_discount_input_" + row_id).val(item_discount_input);
			$("#item_discount_type_" + row_id).val(item_discount_type);
			$("#tr_tax_type_" + row_id).val(tax_type);
			$("#tr_tax_id_" + row_id).val(tax_id);
			$("#description_" + row_id).val(description);
			$("#tr_tax_value_" + row_id).val(tax); //%
			//$("#td_data_"+row_id+"_12").html(tax_type+" "+tax_name);
			var item_id = $("#tr_item_id_" + row_id).val();
			make_subtotal(item_id, row_id);
			//calculate_tax(row_id);
			$('#sales_item').modal('toggle');
		}

		function set_tax_value(row_id) {
			//get the sales price of the item
			var tax_type = $("#tr_tax_type_" + row_id).val();
			var tax = $("#tr_tax_value_" + row_id).val(); //%
			var item_id = $("#tr_item_id_" + row_id).val();
			var qty = ($("#item_qty_" + item_id).val());
			qty = (isNaN(qty)) ? 0 : qty;
			var sales_price = parseFloat($("#sales_price_" + row_id).val());
			sales_price = (isNaN(sales_price)) ? 0 : sales_price;
			sales_price = sales_price * qty;
			/*Discount*/
			var item_discount_type = $("#item_discount_type_" + row_id).val();
			var item_discount_input = parseFloat($("#item_discount_input_" + row_id).val());
			item_discount_input = (isNaN(item_discount_input)) ? 0 : item_discount_input;
			//Calculate discount      
			var discount_amt = (item_discount_type == 'Percentage') ? ((sales_price) * item_discount_input) / 100 : item_discount_input;
			//sales_price -= parseFloat(discount_amt);
			var tax_amount = (tax_type == 'Inclusive') ? calculate_inclusive(sales_price, tax) : calculate_exclusive(sales_price, tax);
			$("#item_discount_" + row_id).val(discount_amt);
			$("#td_data_" + row_id + "_11").val(tax_amount);
		}
		//Sale Items Modal Operations End
		</script>
		<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-1" tabindex="0" style="display: none;"></ul>
		<script>
		$(function() {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});
		});
		</script>
		<script type="text/javascript">
		// Mousetrap.bind('ctrl+m', function(e) {
		// 	e.preventDefault();
		// 	$(".show_payments_modal").trigger('click');
		// });
		// Mousetrap.bind('ctrl+h', function(e) {
		// 	e.preventDefault();
		// 	$("#hold_invoice").trigger('click');
		// });
		// Mousetrap.bind('ctrl+c', function(e) {
		// 	e.preventDefault();
		// 	$(".ctrl_c").trigger('click');
		// });
		</script>
		<script type="text/javascript">
		</script>
		<div class="swal-overlay" tabindex="-1">
			<div class="swal-modal" role="dialog" aria-modal="true">
				<div class="swal-icon swal-icon--warning"> <span class="swal-icon--warning__body">
      <span class="swal-icon--warning__dot"></span> </span>
				</div>
				<div class="swal-title" style="">Are you sure?</div>
				<div class="swal-footer">
					<div class="swal-button-container">
						<button class="swal-button swal-button--cancel" tabindex="0">Cancel</button>
						<div class="swal-button__loader">
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<div class="swal-button-container">
						<button class="swal-button swal-button--confirm swal-button--danger">OK</button>
						<div class="swal-button__loader">
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
		//On Enter Move the cursor to desigtation Id
		function shift_cursor(kevent, target) {
			if(kevent.keyCode == 13) {
				$("#" + target).focus();
			}
		}
		/*Email validation code*/
		function validateEmail(sEmail) {
			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			if(filter.test(sEmail)) {
				return true;
			} else {
				return false;
			}
		}
		$("#pay_all").click(function() {
			save(print = true, pay_all = true);
		});

		function save(print = false, pay_all = false, _reference = "N/A", _f_status = "sales") {
			//$('.make_sale').click(function (e) {
			var customer_id = $("#_main_ledger_id").val();
			console.log(customer_id)
			if(customer_id == "") {
				alert("please Select Customer ");
				return false;
			}
			//var base_url = $("#base_url").val().trim();
			if($(".items_table tr").length == 1) {
				toastr["warning"]("Empty Sales List!!");
				return;
			}
			var row_numbers = $(".items_table tr").length;
			var line_discount_total = 0;
			var line_vat_total = 0;
			for(var i = 0; i < row_numbers; i++) {
				var __item_discount = parseFloat($("#item_discount_" + i).val());
				if(isNaN(__item_discount)) {
					__item_discount = 0
				}
				line_discount_total += __item_discount;
				var __line_vat = parseFloat($(`#td_data_${i}_11`).val());
				if(isNaN(__line_vat)) {
					__line_vat = 0
				}
				line_vat_total += __line_vat
			}
			//RETRIVE ALL DYNAMIC HTML VALUES
			var tot_qty = $(".tot_qty").text();
			var tot_amt = $(".tot_amt").text();
			var tot_disc = $(".tot_disc").text();
			var tot_grand = $(".tot_grand").text();
			var _line_total_discount = $("#_line_total_discount").val();
			var _line_vat_total = $("#_line_vat_total").val();
			var sub_total = parseFloat(tot_grand) + parseFloat(line_discount_total) - parseFloat(line_vat_total)
			var paid_amt = (pay_all) ? tot_grand : $(".sales_div_tot_paid").text();
			var balance = (pay_all) ? 0 : parseFloat($(".sales_div_tot_balance").text());
			var hidden_invoice_id = $("#hidden_invoice_id").val();
			if(customer_id == 121 && balance != 0) {
				toastr["warning"]("Walk-in Customer Should Pay Complete Amount!!");
				return;
			}
			if(document.getElementById("sales_id")) {
				var command = 'update';
			} else {
				var command = 'save';
			}
			var this_btn = 'make_sale';
			//swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			//  if(sure) {//confirmation start
			var reference_id = _reference;
			$("#" + this_btn).attr('disabled', true); //Enable Save or Update button
			//e.preventDefault();
			var data = new Array(2);
			data = new FormData($('#pos-form')[0]); //form name
			if(pay_all == true) {
				paid_amt = tot_amt;
				data.append("payment_type_1", 1);
				data.append("payment_note_1", 'Sales And receive full amount');
				data.append("amount_1", paid_amt);
				data.append("payment_row_count", 1);
			}
			data.append("tot_qty", tot_qty);
			data.append("tot_amt", tot_amt);
			data.append("tot_disc", tot_disc);
			data.append("tot_grand", tot_grand);
			data.append("paid_amt", paid_amt);
			data.append("balance", balance);
			data.append("pay_all", pay_all);
			data.append("_status", _f_status);
			data.append("sub_total", sub_total);
			data.append("method", 'pos_sales_layout_2');
			data.append("_reference", reference_id);
			data.append("_line_total_discount", _line_total_discount);
			data.append("_line_vat_total", _line_vat_total);
			data.append("hidden_invoice_id", hidden_invoice_id);
			
			data.append("pay_all", pay_all);
			/*Check XSS Code*/
			if(!xss_validation(data)) {
				return false;
			}
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

			var request = $.ajax({
				 	type: 'POST',
					url: "{{url('pos-sales-save')}}",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					
				});
				 
				request.done(function( response ) {
					var data = JSON.parse(response);
					var _master_id = data._master_id;
				  	success.currentTime = 0;
					success.play();
					toastr['success']("Invoice Saved Successfully!");
							
					$(".items_table > tbody").empty();
					$(".discount_input").val(0);
					$('#multiple-payments-modal').modal('hide');
					var rc = $("#payment_row_count").val();
					while(rc > 1) {
						remove_row(rc);
						rc--;
					}
					console.log('inside form');
					$("#pos-form")[0].reset();
					
					$("#hidden_rowcount").val(0);
					final_total();
					get_details();
					hold_invoice_list();
					barcode_product_list = [];
					$("." + this_btn).attr('disabled', false); //Enable Save or Update button
					$(".overlay").remove();
					var print_done =window.open("sales/print/"+_master_id+"", "_blank", "scrollbars=1,resizable=1,height=300,width=450");
					//$('#invoicePrint-modal').modal('toggle');

					//$("#_salesInvoicePrint").html(result);
				});
				 
				request.fail(function( jqXHR, textStatus ) {
				  toastr['error']("Sorry! Failed to save Record.Try again");
				      $(".overlay").remove();
				});

			
		} //Save End
		/* *********************** HOLD INVOICE START****************************/
		$('#hold_invoice').click(function(e) {
			//table should not be empty
			if($(".items_table tr").length == 1) {
				toastr["error"]("Please Select Items from List!!");
				failed.currentTime = 0;
				failed.play();
				return;
			}
			swal({
					title: "Hold Invoice ? Same Reference will replace the old list if exist!!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
					content: {
						element: "input",
						attributes: {
							placeholder: "Please Enter Reference Number!",
							type: "text",
							inputAttributes: {
								maxlength: '5'
							}
						},
					},
				}).then(name => {
					//If input box blank Throw Error
					if(!name.trim()) {
						throw null;
						return false;
					}
					var reference_id = name;
					save(print = false, pay_all = false, reference_id, _f_status = "hold");
				}) //name end
				.catch(err => {
					toastr['error']("Failed!! Invoice Not Saved! <br/>Please Enter Reference Number");
					failed.currentTime = 0;
					failed.play();
				}); //swal end
		}); //hold_invoice end
		function hold_invoice_list() {
			$.ajax({
				type: "POST",
				url: "{{url('hold-invoice-list')}}",
				data: {
					method: 'hold_invoice_list'
				},
				async: false,
				cache: false,
				success: function(response) {
					var data = JSON.parse(response);
					var hold_invoice_list = ``;
					var invoice_list = data.invoice_list;
					console.log(invoice_list)
					if(invoice_list.length > 0) {
						for(var i = 0; i < invoice_list.length; i++) {
							hold_invoice_list += `<tr><td><a  style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete(${invoice_list[i]._id})" title="Delete Invoive?">${invoice_list[i]._id}</a></td>
											<td><a  style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete(${invoice_list[i]._id})" title="Delete Invoive?">${invoice_list[i]._date}</a></td>
											<td><a  style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete(${invoice_list[i]._id})" title="Delete Invoive?">${invoice_list[i].customer}</a></td>
											<td><a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete(${invoice_list[i]._id})" title="Delete Invoive?"></a>
												<a class="fa fa-fw fa-edit text-success" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_edit(${invoice_list[i]._id})" title="Edit Invoive?"></a>
											</td>
										</tr>`
						}
					}
					$("#hold_invoice_list").html('').html(hold_invoice_list);
					$(".hold_invoice_list_count").html('').html(invoice_list.length);
				}
			});
		}

		function hold_invoice_delete(invoice_id) {
			console.log(invoice_id)
			swal({
				title: "Are you sure?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((sure) => {
				if(sure) { //confirmation start
					var base_url = $("#base_url").val().trim();
					$.ajax({
						type: "POST",
						url: "sys_entryformadd.php?formid=42",
						data: {
							method: 'hold_invoice_delete',
							invoice_id: invoice_id,
							token: EW_TOKEN
						},
						async: false,
						cache: false,
						success: function(response) {
							var data = JSON.parse(response);
							console.log(data)
							var result = data.success;
							if(result == "success") {
								toastr["success"]("Success! Invoice Deleted!!");
								success.currentTime = 0;
								success.play();
								hold_invoice_list();
							} else {
								toastr['error']("Failed to Delete Invoice! Try again!!");
								failed.currentTime = 0;
								failed.play();
							}
							$(".overlay").remove();
						}
					});
				} //confirmation sure
			}); //confirmation end
		}

		function hold_invoice_edit(id) {
			swal({
				title: "Are you sure?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((sure) => {
				if(sure) { //confirmation start
					var base_url = $("#base_url").val().trim();
					var order_id = id;
					$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
					if(order_id != "") {
						$.ajax({
							type: "POST",
							url: "sys_entryformadd.php?formid=42",
							data: {
								method: 'hold_order',
								order_id: order_id,
								token: EW_TOKEN
							},
							async: false,
							cache: false,
							success: function(response) {
								delete_rows = [];
								$('#pos-form-tbody').empty();
								var data = JSON.parse(response);
								console.log(data)
								var cus_possales = data['cus_possales'];
								var cus_possalesdetail = data['cus_possalesdetail'];
								var customer_balance = data['customer_balance'];
								var master_data = cus_possales[0];
								var balance = customer_balance[0];
								$('#customer_id').val(master_data._leader).select2();
								$("#hidden_invoice_id").val(master_data._id);
								console.log(cus_possalesdetail)
								if(cus_possalesdetail.length > 0) {
									for(var i = 0; i < cus_possalesdetail.length; i++) {
										cus_possalesdetail[i].row_index = i
										addrow(cus_possalesdetail[i]._id, hold_invoice = true, cus_possalesdetail[i], i)
									}
								}
								$(".overlay").remove();
							}
						});
					}
				} //confirmation sure
			}); //confirmation end
		}
		/* *********************** HOLD INVOICE END****************************/
		/* *********************** ORDER INVOICE START****************************/
		function get_id_value(id) {
			return $("#" + id).val().trim();
		}
		$('#collect_customer_info').click(function(e) {
			//table should not be empty
			if($(".items_table tr").length == 1) {
				toastr["error"]("Please Select Items from List!!");
				failed.currentTime = 0;
				failed.play();
				return;
			}
			if(get_id_value('customer_id') == 1) {
				//$('#customer-modal').modal('toggle');
				toastr["error"]("Please Select Customer!!");
				failed.currentTime = 0;
				failed.play();
				return false;
			} else {
				$('#delivery-info').modal('toggle');
			}
		}); //hold_invoice end
		$('.show_payments_modal').click(function(e) {
			//table should not be empty
			if($(".items_table tr").length == 1) {
				toastr["error"]("Please Select Items from List!!");
				failed.currentTime = 0;
				failed.play();
				return;
			} else {
				adjust_payments();
				$("#add_payment_row,#payment_type_1").parent().show();
				$("#amount_1").parent().parent().removeClass('col-md-12').addClass('col-md-6');
				$('#multiple-payments-modal').modal('toggle');
			}
		}); //hold_invoice end
		$('#show_cash_modal').click(function(e) {
			//table should not be empty
			if($(".items_table tr").length == 1) {
				toastr["error"]("Please Select Items from List!!");
				failed.currentTime = 0;
				failed.play();
				return;
			} else {
				adjust_payments();
				$("#add_payment_row,#payment_type_1").parent().hide();
				$("#amount_1").focus();
				$("#amount_1").parent().parent().removeClass('col-md-6').addClass('col-md-12');
				$('#multiple-payments-modal').modal('toggle');
			}
		}); //hold_invoice end
		$('#add_payment_row').click(function(e) {
			//var base_url = $("#base_url").val().trim();
			//table should not be empty
			if($(".items_table tr").length == 1) {
				toastr["error"]("Please Select Items from List!!");
				failed.currentTime = 0;
				failed.play();
				return;
			} else {
				/*BUTTON LOAD AND DISABLE START*/
				var this_id = this.id;
				var this_val = $(this).html();
				$("#" + this_id).html('<i class="fa fa-spinner fa-spin"></i> Please Wait..');
				$("#" + this_id).attr('disabled', true);
				/*BUTTON LOAD AND DISABLE END*/
				var payment_row_count = parseFloat(get_id_value("payment_row_count"));
				//var payment_row_count=$("#payment_row_count").val();
				$.post("{{url('pos-payment-row')}}", {
					payment_row_count: payment_row_count
				}, function(result) {
					$('.payments_div').parent().append(result);
					$("#payment_row_count").val(parseFloat(payment_row_count) + 1);
					/*BUTTON LOAD AND DISABLE START*/
					$("#" + this_id).html(this_val);
					$("#" + this_id).attr('disabled', false);
					/*BUTTON LOAD AND DISABLE END*/
					failed.currentTime = 0;
					failed.play();
					adjust_payments();
				});
			}
			console.log(payment_row_count)
			check_payment_row(payment_row_count)
		}); //hold_invoice end
		function remove_row(id) {
			$(".payments_div_" + id).html('');
			var payment_row_count = parseFloat(get_id_value("payment_row_count"));
			$("#payment_row_count").val(parseFloat(payment_row_count) - 1);
			failed.currentTime = 0;
			failed.play();
			adjust_payments();
			check_payment_row()
		}

		function check_payment_row(payment_row_count) {
			/* if(payment_row_count ==1){
				$("#add_payment_row").hide();
			}else{
				$("#add_payment_row").show();
			} */
		}

		function calculate_payments() {
			adjust_payments();
		}
		$(document).find(".payment_group_change").on('change', function() {
			var group_name = $('option:selected', this).attr('attr_value');
			$(this).parent().find('.payment_group').val(group_name);
			console.log(group_name)
		})

		function payment_group_change() {
			console.log($(this))
			var payment_type_name = $(this).attr('attr_value');
			var payment_type_name = $('option:selected', this).attr('attr_value');
			console.log(payment_type_name)
			$("#payment_group_" + row_id).val(payment_type_name);
		}
		$("#newCustomerSave").on("click", function(e) {
			//alert(4);
			e.preventDefault();
			var _group = $("#_group").val();
			var _ledger = $("#_ledger").val();
			var _alias = $("#_alias").val();
			var _address = $("#_address").val();
			var _bin = $("#_bin").val();
			var _phone = $("#_phone").val();
			var _email = $("#_email").val();
			var _creditlimit = $("#_creditlimit").val();
			var _balance = $("#_balance").val();
			var error_group = "";
			var error_ledger = "";
			var error_alias = "";
			var error_address = "";
			var error_bin = "";
			var error_phone = "";
			var error_email = "";
			var error_creditlimit = "";
			var error_balance = "";
			var errors = [];
			if(_group == "") {
				$("#error_group").text("Group is required");
				errors.push(1);
			} else {
				$("#error_group").text("");
			}
			if(_ledger == "") {
				$("#error_ledger").text("Ledger is required");
				errors.push(1);
			} else {
				$("#error_ledger").text("");
			}
			if(_alias == "") {
				$("#error_alias").text("Alias is required");
				errors.push(1);
			} else {
				$("#error_alias").text("");
			}
			if(_address == "") {
				$("#error_address").text("Address is required");
				errors.push(1);
			} else {
				$("#error_address").text("");
			}
			if(_bin == "") {
				$("#error_bin").text("BIN is required");
				errors.push(1);
			} else {
				$("#error_bin").text("");
			}
			if(_phone == "") {
				$("#error_phone").text("Phone is required");
				errors.push(1);
			} else {
				$("#error_phone").text("");
			}
			if(_email == "") {
				$("#error_email").text("Email is required");
				errors.push(1);
			} else {
				$("#error_email").text("");
			}
			if(_creditlimit == "") {
				$("#error_creditlimit").text("Credit limit is required");
				errors.push(1);
			} else {
				$("#error_creditlimit").text("");
			}
			if(_balance == "") {
				$("#error_balance").text("Balance is required");
				errors.push(1);
			} else {
				$("#error_balance").text("");
			}
			if(errors.length > 0) {
				return false;
			}
			console.log(errors)
			$.ajax({
				url: "sys_entryformadd.php?formid=42",
				type: "POST",
				data: {
					method: 'customer_save',
					_group: _group,
					_ledger: _ledger,
					_alias: _alias,
					_address: _address,
					_bin: _bin,
					_phone: _phone,
					_email: _email,
					_creditlimit: _creditlimit,
					_balance: _balance,
					token: EW_TOKEN
				},
				async: false,
				cache: false,
				success: function(response) {
					//  $("#addNewCustomer").trigger("reset");
					$('#customer-modal').modal('toggle');
					var data = JSON.parse(response);
					//console.log(data)
					var customer = data['customer'];
					/// product_display(product_list)
					var newStateVal = customer[0]._id;
					// Set the value, creating a new option if necessary
					if($("#customer_id").find("option[value=" + newStateVal + "]").length) {
						$("#customer_id").val(newStateVal).trigger("change");
					} else {
						// Create the DOM option that is pre-selected by default
						var newState = new Option(_ledger, newStateVal, true, true);
						// Append it to the select
						$("#customer_id").append(newState).trigger('change');
					}
				}
			});
		})
		$('#barcodeSearch').keypress(function(event) {
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13') {
				var barcode = $(this).val();
				console.log(barcode)
				$.ajax({
					type: "GET",
					url: "{{url('item-sales-barcode-search')}}",
					data: {
						method: 'barcode_item',
						_text_val: barcode,
						_pos_sales:1
					},
					async: false,
					cache: false,
				}).done(function(response) {
					var data = JSON.parse(response);
					var customer_info = data.datas;
					
					var data = customer_info[0];
					console.log(customer_info)
					var __id = parseFloat(data._id);
					if(!isNaN(__id)) {
						//console.log(Object.entries(data));
						var _id = data._id;
						var _row_id = data._row_id;
						var _item = data._item;
						var _qty = 1;
						var _rate = parseFloat(data._saleprice);
						if(_rate == 0) { data._saleprice = data._saleprice; }
						
						var _barcode = data._barcode;
						var id = data._id;
						var hold_invoice = false;
						var hold_data = data;
						
						var row_index = $("#hidden_rowcount").val(); //0,1,2...
						var barcode = "barcode";
					var product_list_html = ``;
					if(customer_info.length > 0) {
						
						for(let i = 0; i < customer_info.length; i++) {
							var data = customer_info[i];
							var tax_amount= (data._saleprice*data._vat)/100;
							product_list_html += `<div class="col-md-4 col-xs-6 " id="item_parent_${i}" disabled="disabled" data-toggle="tooltip" title="" style="padding-left: 5px; padding-right: 5px; display: block;" data-original-title="${data._item}">
													<div class="box box-default item_box" id="div_${data._row_id}" onclick="addrow(${data._row_id})" data-item-id="${data._row_id}" data-item-name="${data._item}" data-item-available-qty="${data.available_qty}" 
													data-item-discount="${data._sales_discount}" 
													data-item-sales-price="${data._saleprice}" 
													data-item-cost="${data._purprice}"
													data-item-tax-id="${data._vatnote}" 
													data-item-tax-type="Exclusive" 
													data-item-tax-value="${data._vat}" 
													data-item-tax-name="${data._vatnote}" 
													data-item-tax-amt="${tax_amount}" 
													style="
    max-height: 200px;
    min-height: 150px;
    cursor: pointer;
    background-color: #fff;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
    padding: 2px;
"> <span class="label label-success push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="${data.available_qty} Quantity in Stock">Qty: ${parseFloat(data.available_qty).toFixed(2)}</span>
														<div class="box-body box-profile">
															<center> <img class=" img-responsive item_image" src="{{asset('/')}}{{$default_image ?? ''}}" alt="Item picture"> </center>
															<lable class="text-center search_item" style="font-weight: bold; font-family: sans-serif; display: -webkit-box;" id="item_${i}">
															${data._row_id} || ${data._id} <br>
															${data._item}
																<br> <span class="" style="font-family: sans-serif;font-size:150%; ">TK ${parseFloat(data._saleprice).toFixed(2)}</span> </lable>
														</div>
													</div>
												</div>`;
						}


					$(".search_div").html('');
					$(".search_div").html(product_list_html);
					$(".overlay").remove();
					addrow(_row_id);

					}
						$("#barcodeSearch").val("");
					} else {
						alert("please input valid barcode");
						$("#barcodeSearch").val("");
					}
				});
			}
			event.stopPropagation();
		})
		if($("#addNewProduct").length > 0) {
			$("#addNewProduct").validate({
				rules: {
					_item: {
						required: true,
						maxlength: 150
					},
					_itemcode: {
						required: true
					},
					_description: {
						required: true
					},
					_category: {
						required: true
					},
					_unit: {
						required: true
					},
					_purchasevatnote: {
						required: true
					},
					_vatnote: {
						required: true
					},
				},
				messages: {
					_item: {
						required: "Please enter name",
						maxlength: "Name should be 150 characters long."
					},
					_itemcode: {
						required: "Please Enter Item Code"
					},
					_description: {
						required: "Please enter contact Description"
					},
					_category: {
						required: "Please Select Category"
					},
					_unit: {
						required: "Please Enter Unit"
					},
					_purchasevatnote: {
						required: "Please Select Purchase VAT Rules"
					},
					_vatnote: {
						required: "Please Select Sales VAT Rules"
					},
				},
				submitHandler: function(form) {
					var form = $("#addNewProduct").closest("form");
					var formData = new FormData(form[0]);
					var _item = $("#addNewProduct").find("#_item").val();
					var _itemcode = $("#addNewProduct").find("#_itemcode").val();
					var _description = $("#addNewProduct").find("#_description").val();
					var _category = $("#addNewProduct").find("#_category").val();
					var _unit = $("#addNewProduct").find("#_unit").val();
					var _orderpoint = $("#addNewProduct").find("#_orderpoint").val();
					var _orderqty = $("#addNewProduct").find("#_orderqty").val();
					var _saleprice = $("#addNewProduct").find("#_saleprice").val();
					var _purprice = $("#addNewProduct").find("#_purprice").val();
					var _sd = $("#addNewProduct").find("#_sd").val();
					var _vat = $("#addNewProduct").find("#_vat").val();
					var _purchasevatnote = $("#addNewProduct").find("#_purchasevatnote").val();
					var _vatnote = $("#addNewProduct").find("#_vatnote").val();
					var user = `farhad`
					$("._item_category").val(_category);
					$.ajax({
						url: "sys_entryformadd.php?formid=42",
						type: "POST",
						data: {
							method: 'item_save',
							user: user,
							_item: _item,
							_itemcode: _itemcode,
							_description: _description,
							_category: _category,
							_unit: _unit,
							_orderpoint: _orderpoint,
							_orderqty: _orderqty,
							_purchasevatnote: _purchasevatnote,
							_vatnote: _vatnote,
							_saleprice: _saleprice,
							_purprice: _purprice,
							_sd: _sd,
							_vat: _vat,
							token: EW_TOKEN
						},
						async: false,
						cache: false,
						success: function(response) {
							console.log(response)
							$("#addNewProduct").trigger("reset");
							$('#exampleModalCenter').modal('toggle');
							var data = JSON.parse(response);
							var product_list = data['items'];
							var product_list_html = ``;
							if(product_list.length > 0) {
								for(let i = 0; i < product_list.length; i++) {
									var data = product_list[i];
									product_list_html += `<div class="col-md-3 col-xs-6 " id="item_parent_${i}" disabled="disabled" data-toggle="tooltip" title="" style="padding-left: 5px; padding-right: 5px; display: block;" data-original-title="${data._item}">
													<div class="box box-default item_box" id="div_${data._id}" onclick="addrow(${data._id})" data-item-id="${data._id}" data-item-name="${data._item}" data-item-available-qty="${data.available_qty}" data-item-sales-price="${data._saleprice}" data-item-cost="${data._purprice}" data-item-tax-id="${data._vatnote}" data-item-tax-type="Exclusive" data-item-tax-value="${data._vat}" data-item-tax-name="${data._vatnote}" data-item-tax-amt="0" style="max-height: 150px;min-height: 150px;cursor: pointer;background-color:#a1db75"> <span class="label label-success push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="${data.available_qty} Quantity in Stock">Qty: ${parseFloat(data.available_qty).toFixed(2)}</span>
														<div class="box-body box-profile">
															<center> <img class=" img-responsive item_image" style="border: 1px solid gray;" src="sys_imageview.php?id=${(data._image) ? data._image : 55}" alt="Item picture"> </center>
															<lable class="text-center search_item" style="font-weight: bold; font-family: sans-serif; display: -webkit-box;" id="item_${i}">${data._item.substring(0, 20)}
																<br> <span class="" style="font-family: sans-serif;font-size:150%; ">TK ${parseFloat(data._saleprice).toFixed(2)}</span> </lable>
														</div>
													</div>
												</div>`;
								}
							}
							$(".search_div").html('');
							$(".search_div").html(product_list_html);
							$(".overlay").remove();
						}
					});
				}
			})
		}



		$(document).on('keyup','._search_main_ledger_id',delay(function(e){
    $(document).find('._search_main_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $("._search_form_value").val();
  var request = $.ajax({
      url: "{{url('main-ledger-search')}}",
      method: "GET",
      data: { _text_val,_form },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                  
                                   </td>
                                   <td>${data[i]._balance}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

 $(document).on("click",'.search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $("._main_ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);
    $("._phone").val(_phone_main_ledger);
    $("._address").val(_address_main_ledger);

    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })

 $(document).on('click','.save_item',function(){
    var _category_id = $("._category_id").val();
    var _item_item = $("._item_item").val();
    var _item_code = $("._item_code").val();
    var _item_unit_id = $("._item_unit_id").val();
    var _item_barcode = $("._item_barcode").val();
    var _item_discount = $("._item_discount").val();
    var _item_vat = $("._item_vat").val();
    var _item_pur_rate = $("._item_pur_rate").val();
    var _item_sale_rate = $("._item_sale_rate").val();
    var _item_manufacture_company = $("._item_manufacture_company").val();
    var _item_status = $("._item_status").val();
    var _item_unique_barcode = $("._item_unique_barcode").val();
    
    var reqired_fields = 0;
    if(_category_id ==""){
       $(document).find('._category_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._category_id').removeClass('required_border');
    }
    if(_item_item ==""){
       $(document).find('._item_item').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._item_item').removeClass('required_border');
    }
    if(_item_unit_id ==""){
       $(document).find('._item_unit_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._item_unit_id').removeClass('required_border');
    }
    
    if(reqired_fields ==1){
      return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $.ajax({
           type:'POST',
           url:"{{ url('ajax-item-save') }}",
           data:{_category_id,_item_item,_item_code,_item_unit_id,_item_barcode,_item_discount,_item_vat,_item_pur_rate,_item_sale_rate,_item_manufacture_company,_item_status,_item_unique_barcode
           },
           success:function(data){
              if(data !=""){
                alert("Information Save Successfully");
                $(document).find("._item_modal_form").trigger('reset');
                $(document).find(".modal_close").click();
                
              }else{
                alert("Information Not Save");
              }

           }

        });

  })

  $(document).on('click','.save_ledger',function(){
    var _account_head_id = $("._account_head_id").val();
    var _account_groups = $("._account_groups").val();
    var _ledger_branch_id = $("._ledger_branch_id").val();
    var _ledger_name = $("._ledger_name").val();
    var _ledger_address = $("._ledger_address").val();
    var _ledger_code = $("._ledger_code").val();
    var _ledger_short = $("._ledger_short").val();
    var _ledger_nid = $("._ledger_nid").val();
    var _ledger_phone = $("._ledger_phone").val();
    var _ledger_email = $("._ledger_email").val();
    var _ledger_credit_limit = $("._ledger_credit_limit").val();
    var _ledger_is_user = $("._ledger_is_user").val();
    var _ledger_is_sales_form = $("._ledger_is_sales_form").val();
    var _ledger_is_purchase_form = $("._ledger_is_purchase_form").val();
    var _ledger_is_all_branch = $("._ledger_is_all_branch").val();
    var _ledger_status = $("._ledger_status").val();
    var reqired_fields = 0;
    if(_account_head_id ==""){
       $(document).find('._account_head_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._account_head_id').removeClass('required_border');
    }
    if(_account_groups ==""){
       $(document).find('._account_groups').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._account_groups').removeClass('required_border');
    }
    if(_ledger_name ==""){
       $(document).find('._ledger_name').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._ledger_name').removeClass('required_border');
    }
    if(reqired_fields ==1){
      return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $.ajax({
           type:'POST',
           url:"{{ url('ajax-ledger-save') }}",
           data:{_account_head_id,_account_groups,_ledger_branch_id,_ledger_name,_ledger_address,_ledger_code,_ledger_short,_ledger_nid,_ledger_phone,_ledger_email,_ledger_credit_limit,_ledger_is_user,_ledger_is_sales_form,_ledger_is_purchase_form,_ledger_is_all_branch,_ledger_status
           },
           success:function(data){
              if(data !=""){
                alert("Information Save Successfully");
                $(document).find("._ledger_modal_form").trigger('reset');
                $(document).find(".modal_close").click();
                
              }else{
                alert("Information Not Save");
              }

           }

        });

  })

  $("._account_head_id").on('change',function(){
  var _account_head_id = $(this).val();
  var request = $.ajax({
      url: "{{url('type_base_group')}}",
      method: "GET",
      data: { id : _account_head_id },
      dataType: "html"
    });
     
    request.done(function( msg ) {
      $( "._account_groups" ).html( msg );
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

})
function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

 
		/* *********************** ORDER INVOICE END****************************/
		</script>
</body>

</html>
<div class="ewMessageDialog"></div>