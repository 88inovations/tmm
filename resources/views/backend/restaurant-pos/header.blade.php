<!DOCTYPE html>
<html style="height: auto;" lang="en">

<head>
	@php
	$default_image = $settings->logo;
	@endphp
	<!-- TABLES CSS CODE -->
	<meta charset="UTF-8">
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{$settings->title ?? '' }}</title>
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
		font-size: 18px;
		color: #000000;
		text-align: center;
		text-overflow: hidden;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
		font-weight: bold;
	}
	
.item_image {
    min-width: 70px;
    min-height: 70px;
    max-width: 70px;
    max-height: 70px;
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
.skin-black .main-header .navbar {
    background-color: #0986a2;
    border-bottom: 1px solid forestgreen;
}
.skin-black .main-header .navbar .nav>li>a {
    color: #fff;
    font-weight: bold;
}
.box-header {
    color: #444;
    display: block;
    padding: 0px;
    position: relative;
}

 .form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 18px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
._single_item_area{
	cursor: pointer;		
	text-align: center;
	box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
	padding: 2px;
	border-radius: 5px;
	margin-bottom: 5px;
	background: #fff;
	font-size: 18px;
	font-weight: bold;
	}
	.display_none{
		display: none;
	}

.box-info,.content-wrapper{

    background-color: #7cd58357;

}

.content{
	background: #7cd58357;
}
.recent_invoice_list{
	cursor: pointer;
}
.category_active{
	background: gray !important;
	color:#fff;
}


.item_box {
		border-top: none;
	    cursor: pointer;
	    background-color: #fff;
	   box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
	    padding: 2px;
	    margin-bottom: 5px;
	    min-height: 60px;
	}
.box-body {
    
    padding: 10px;
    padding-top: 0px;
}

.form-group {
    margin-bottom: 1px;
}
.modal {
    z-index: 999099;
}
.free_table{
	background:grey;padding:5px;color:#fff;cursor:pointer;margin-top:0px;
	}
.book_table{
	background:red;padding:5px;color:#fff;cursor:pointer;margin-top:0px;
	}
	</style>


</head>