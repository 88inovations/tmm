"use strict";
//Role and permission section
var $ = jQuery;

  function _lock_action(_id,_action,_table_name,url){
       $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
        $.ajax({
           type:'POST',
           url:url,
           data:{_id,_action,_table_name},
           success:function(data){
              console.log(data);
           }
        });
    } 



     $(document).on('change','.item_category_id',function(){
      var category_id = $(this).val();
      var url = $(this).attr('attr_url');
      
       var request = $.ajax({
          url: url,
          method: "GET",
          data: {category_id },
          async:false,
        });
         
        request.done(function( response ) {
         console.log(response)
         var data = response;
         var _search_main_ledger_id = data?.category_ledger?._name;
         var asset_ledger_id = data?.asset_ledger_id;
         var dep_rate = data?.dep_rate;
         $(document).find(".dep_rate").val(dep_rate);
         $(document).find("._search_main_ledger_id").val(_search_main_ledger_id);
         $(document).find(".asset_ledger_id").val(asset_ledger_id);

         var _search_asset_dep_ledger_id = data?.acc_dep_category_ledger?._name;
         var asset_dep_ledger_id = data?.asset_dep_ledger_id;
         $(document).find("._search_asset_dep_ledger_id").val(_search_asset_dep_ledger_id);
         $(document).find(".asset_dep_ledger_id").val(asset_dep_ledger_id);

         var _search_asset_dep_exp_ledger_id = data?.dep_exp_category_ledger?._name;
         var asset_dep_exp_ledger_id = data?.asset_dep_exp_ledger_id;
         $(document).find("._search_asset_dep_exp_ledger_id").val(_search_asset_dep_exp_ledger_id);
         $(document).find(".asset_dep_exp_ledger_id").val(asset_dep_exp_ledger_id);



        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });


    })




$(document).on('change','[name="group_check"]',function(){
    var class_name = $(this).attr('class');
    if ($(this).is(':checked')) {
      $(document).find(`.${class_name}`).attr('checked',true);
    }else{
      $(document).find(`.${class_name}`).attr('checked',false);
    }
})

$(document).on('change','[name="all_all_check"]',function(){
    var class_name = 'all_check';
    if ($(this).is(':checked')) {
      $(document).find(`.${class_name}`).attr('checked',true);
    }else{
      $(document).find(`.${class_name}`).attr('checked',false);
    }
})

var loadFile = function(event,_id) {
              var ids = `output_${_id}`;
              var output = document.getElementById('output_'+_id);
              output.src = URL.createObjectURL(event.target.files[0]);
              console.log(event.target.files[0])
              output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
              }
            };

      function updateCheckboxValue(__this) {
    
    
    if (__this.is(":checked")) {
        __this.closest('td').find(".display_checkbox").val(1);
    } else {
        __this.closest('td').find(".display_checkbox").val(0);
    }
}

 function printDiv(divID) {
            var divElements = document.getElementById(divID).innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML ="<html><head><title></title></head><body>" +
                divElements + "</body>";
            window.print();
            document.body.innerHTML = oldPage;
           // location.reload();
        }
     function fnExcelReport() {
      var tab_text= $("#printablediv").html();
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE "); 
      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
      {
        document.open("txt/html","replace");
        document.write(tab_text);
        document.close(); 
        sa=document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
      }  
      else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

      return (sa);
    }


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

$(document).on('click',function(){
    _common_click_function();
})

function _common_click_function(){

   
    var search_box_main_ledger= $(document).find('.search_box_main_ledger').hasClass('search_box_show');
    if(search_box_main_ledger ==true){
      $(document).find('.search_box_main_ledger').removeClass('search_box_show').hide();
    }


    var asset_dep_search_box_main_ledger= $(document).find('.asset_dep_search_box_main_ledger').hasClass('search_box_show');
    if(asset_dep_search_box_main_ledger ==true){
      $(document).find('.asset_dep_search_box_main_ledger').removeClass('search_box_show').hide();
    }
    
    var asset_dep_exp_search_box_main_ledger= $(document).find('.asset_dep_exp_search_box_main_ledger').hasClass('search_box_show');
    if(asset_dep_exp_search_box_main_ledger ==true){
      $(document).find('.asset_dep_exp_search_box_main_ledger').removeClass('search_box_show').hide();
    }

    
    var asset_name_box= $(document).find('.asset_name_box').hasClass('search_box_show');
    if(asset_name_box ==true){
      $(document).find('.asset_name_box').removeClass('search_box_show').hide();
    }



    


}




  $(document).on('keyup','._search_main_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');

    if (typeof(attr_url) == "undefined"){
      return false;
    }
    console.log(attr_url)
    $(document).find('._search_main_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3"><button type="button" class="btn btn-sm btn-success new_ledger_button"   attr_base_create_url="{{url('account-type-for-new-ledger')}}"data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-plus"></i> New Ledger 
                </button></th></thead><tbody></tbody></table></div>`;
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
    $(document).find(".asset_ledger_id").val(_id);
    $(document).find("._search_main_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);

    $(document).find('.search_box_main_ledger').hide();
    $(document).find('.search_box_main_ledger').removeClass('search_box_show').hide();
  })





  $(document).on('keyup','._search_expense_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_expense_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_expense_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3"><button type="button" class="btn btn-sm btn-success new_ledger_button"   attr_base_create_url="{{url('account-type-for-new-ledger')}}"data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-plus"></i> New Ledger 
                </button></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('._expense_ledger_search_box').html(search_html);
      _gloabal_this.parent('div').find('._expense_ledger_search_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.search_row_expense_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".asset_dep_ledger_id").val(_id);
    $(document).find("._search_expense_ledger_id").val(_name);
  

    $(document).find('._expense_ledger_search_box').hide();
    $(document).find('._expense_ledger_search_box').removeClass('search_box_show').hide();
  })




  $(document).on('keyup','._search_payable_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_payable_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_payable_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3"><button type="button" class="btn btn-sm btn-success new_ledger_button"   attr_base_create_url="{{url('account-type-for-new-ledger')}}"data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-plus"></i> New Ledger 
                </button></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.payable_ledger_search_box').html(search_html);
      _gloabal_this.parent('div').find('.payable_ledger_search_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.search_row_payable_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find("._payable_ledger_id").val(_id);
    $(document).find("._search_payable_ledger_id").val(_name);
  

    $(document).find('.payable_ledger_search_box').hide();
    $(document).find('.payable_ledger_search_box').removeClass('search_box_show').hide();
  })





  $(document).on('keyup','._search_asset_dep_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_asset_dep_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="asset_dep_search_row_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.asset_dep_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.asset_dep_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.asset_dep_search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".asset_dep_ledger_id").val(_id);
    $(document).find("._search_asset_dep_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.asset_dep_search_box_main_ledger').hide();
    $(document).find('.asset_dep_search_box_main_ledger').removeClass('search_box_show').hide();
  })


  $(document).on('keyup','._search_asset_dep_exp_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_asset_dep_exp_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="asset_dep_exp_search_row_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.asset_dep_exp_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.asset_dep_exp_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.asset_dep_exp_search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".asset_dep_exp_ledger_id").val(_id);
    $(document).find("._search_asset_dep_exp_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.asset_dep_exp_search_box_main_ledger').hide();
    $(document).find('.asset_dep_exp_search_box_main_ledger').removeClass('search_box_show').hide();
  })



  $(document).on('keyup','._search_asset_dep_exp_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_asset_dep_exp_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="asset_dep_exp_search_row_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.asset_dep_exp_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.asset_dep_exp_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.asset_dep_exp_search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".asset_dep_exp_ledger_id").val(_id);
    $(document).find("._search_asset_dep_exp_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.asset_dep_exp_search_box_main_ledger').hide();
    $(document).find('.asset_dep_exp_search_box_main_ledger').removeClass('search_box_show').hide();
  })





  $(document).on('keyup','.search_asset_vendor',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('.search_asset_vendor').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
     

      var search_html =``;
      var data = result.data; 
       console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="asset_vendor_row" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.asset_vendor_box').html(search_html);
      _gloabal_this.parent('div').find('.asset_vendor_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.asset_vendor_row',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();

    $(document).find(".vendor_id").val(_id);
    $(document).find(".search_asset_vendor").val(_name);


    $(document).find('.asset_vendor_box').hide();
    $(document).find('.asset_vendor_box').removeClass('search_box_show').hide();
  })



  $(document).on('keyup','._search_customer_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_customer_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="customer_search_row" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.customer_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.customer_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.customer_search_row',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".customer_ledger_id").val(_id);
    $(document).find("._search_customer_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.customer_search_box_main_ledger').hide();
    $(document).find('.customer_search_box_main_ledger').removeClass('search_box_show').hide();
  })



  $(document).on('keyup','._search__payment_receive_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search__payment_receive_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="cash_bank_row" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.cash_bank_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.cash_bank_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.cash_bank_row',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find("._payment_receive_id").val(_id);
    $(document).find("._search__payment_receive_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.cash_bank_search_box_main_ledger').hide();
    $(document).find('.cash_bank_search_box_main_ledger').removeClass('search_box_show').hide();
  })


  $(document).on('keyup','._search_gain_or_loss_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_gain_or_loss_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="gain_loss_row" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.gain_loss_box').html(search_html);
      _gloabal_this.parent('div').find('.gain_loss_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.gain_loss_row',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".gain_or_loss_ledger_id").val(_id);
    $(document).find("._search_gain_or_loss_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.gain_loss_box').hide();
    $(document).find('.gain_loss_box').removeClass('search_box_show').hide();
  })


  $(document).on("keyup",".import_cost_detail_id",function(){
    var text_val = $(this).val();
    var url = $(this).attr('attr_url');
     var request = $.ajax({
          url: url,
          method: "GET",
          data: {text_val },
          async:false,
        });
         
        request.done(function( response ) {
          console.log(response)
          var data = response;
           var search_html =``;




      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>NO</th>
            <th>REF</th>
            <th>Asset Name</th>
            <th>QTY</th>
            <th>Asset Value</th>
            </thead>
            <tbody>`;
          for (var i = 0; i < data.length; i++) {
                    var id = data[i]?.id;
                      var _no = data[i]?._master_id;
                      var _qty = parseFloat(data[i]?._qty);
                      if(isNaN(_qty)){_qty=0}
                      var _asset_name = data[i]?._item;
                    
                      var _asset_value_bdt = data[i]?._pur_rate;
                      var _qty = data[i]?._import_item_detail?._qty;
                      var _depreciable_asset_value = parseFloat((data[i]?._import_item_detail?._depreciable_asset_value)/_qty).toFixed(2);
                      var _salvage_value = parseFloat((data[i]?._import_item_detail?._salvage_value)/_qty).toFixed(2);
                      var _other_cost_bdt = parseFloat((data[i]?._import_item_detail?._other_cost_bdt)/_qty).toFixed(2);

                      var purchase_price_rate=parseFloat(parseFloat(_asset_value_bdt)-parseFloat(_other_cost_bdt)).toFixed(2);

                      var _single_ref_asset_value_bdt = _asset_value_bdt;

                         search_html += `<tr class="_local_import_table_row" >
                                        <td>${data[i]?.id}</td>
                                        <td>${data[i]?._master_id}</td>
                                        <td>${_asset_name}</td>
                                        <td>${data[i]?._qty}</td>
                                       <td>${_single_ref_asset_value_bdt}</td>
                                   <td style="display:none;">

<input type="hidden"  class="_single_ref_id" value="${data[i]?.id}">
<input type="hidden"  class="_single_ref_no" value="${data[i]?._master_id}">
<input type="hidden"  class="_single_item_id" value="${data[i]?._item_id}">
<input type="hidden"  class="_single_ref_asset_name" value="${_asset_name}">
<input type="hidden"  class="_single_ref_qty" value="${data[i]?._qty}">
<input type="hidden"  class="_single_ref_asset_value_bdt" value="${purchase_price_rate}">
<input type="hidden"  class="_depreciable_asset_value" value="${_depreciable_asset_value}">
<input type="hidden"  class="_salvage_value" value="${_salvage_value}">
<input type="hidden"  class="_other_cost_bdt" value="${_other_cost_bdt}">
                                       
                                   </td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      $(document).find('.asset_name_box').html(search_html);
      $(document).find('.asset_name_box').addClass('search_box_show').show();
      
    });
       
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });


   })



$(document).on("click","._local_import_table_row",function(){
    var _single_ref_asset_name =$(this).find('._single_ref_asset_name').val();
    var _single_ref_cfr_value_bdt =$(this).find('._single_ref_cfr_value_bdt').val();
    var _single_ref_other_cost_bdt =$(this).find('._single_ref_other_cost_bdt').val();
    var _single_ref_asset_value_bdt =$(this).find('._single_ref_asset_value_bdt').val();
    var _single_ref_id =$(this).find('._single_ref_id').val();
    var _single_item_id =$(this).find('._single_item_id').val();
    var _salvage_value =$(this).find('._salvage_value').val();
    var _depreciable_asset_value =$(this).find('._depreciable_asset_value').val();
    var _other_cost_bdt =$(this).find('._other_cost_bdt').val();

    $(document).find("._item_id").val(_single_item_id)
    $(document).find(".name_of_asset").val(_single_ref_asset_name)
    $(document).find(".import_cost_detail_id").val(_single_ref_id)
    $(document).find(".purchase_price").val(_single_ref_asset_value_bdt)
    $(document).find(".extra_cost").val(_other_cost_bdt)
    $(document).find(".evaluated_price").val(_depreciable_asset_value)
    $(document).find(".salvage_value").val(_salvage_value)




})


/*Asset name  Search */
  $(document).on('keyup','.asset_name_search',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('.asset_name_search').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _cloumn_name = 'name';
    var _is_sold = $(this).attr("attr_sold");
    if(isNaN(_is_sold)){_is_sold=0}

  asset_search_by_text(_gloabal_this,attr_url,_text_val,_cloumn_name,_is_sold);
}, 500));


/*Asset name  Search */
  $(document).on('keyup','.asset_tag',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('.asset_tag').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _cloumn_name = 'asset_tag';
    var _is_sold = $(this).attr("attr_sold");
    if(isNaN(_is_sold)){_is_sold=0}

  asset_search_by_text(_gloabal_this,attr_url,_text_val,_cloumn_name,_is_sold);
}, 500));

/*Asset name  Search */
  $(document).on('keyup','.asset_code',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('.asset_code').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _cloumn_name = 'asset_code';
    var _is_sold = $(this).attr("attr_sold");
    if(isNaN(_is_sold)){_is_sold=0}

  asset_search_by_text(_gloabal_this,attr_url,_text_val,_cloumn_name,_is_sold);
}, 500));
  
/*Asset name  Search */
  $(document).on('keyup','.model_no',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('.model_no').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _cloumn_name = 'model_no';
    var _is_sold = $(this).attr("attr_sold");
    if(isNaN(_is_sold)){_is_sold=0}

  asset_search_by_text(_gloabal_this,attr_url,_text_val,_cloumn_name,_is_sold);
}, 500));


  $(document).on('keyup','.sale_price',function(){
    var book_value = parseFloat($(document).find(".book_value").val());
    if(isNaN(book_value)){ book_value=0 }
    var sale_price = $(document).find(".sale_price").val();
    if(isNaN(sale_price)){ sale_price=0 }
    var gain_loss = parseFloat(book_value-sale_price).toFixed(2);

    $(document).find(".gain_loss").val(gain_loss);

  })


function asset_search_by_text(_gloabal_this,attr_url,_text_val,_cloumn_name,_is_sold){

  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_cloumn_name,_is_sold },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Asset Tag</th>
            <th>Asset Code</th>
            <th>Model No</th>
            <th>Serial No</th>
            <th>Evaluated Price</th>
            <th>Accumulated Dep Val</th>
            <th>Book Value</th>
            <th>Is Sold</th>
            </thead>
            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="asset_row_data" >
                                        <td>${data[i].id}</td>
                                        <td>${data[i]?.name}</td>
                                        <td>${data[i]?.asset_tag}</td>
                                        <td>${data[i]?.asset_code}</td>
                                   <td>${data[i]?.model_no}</td>
                                   <td>${data[i]?.serial_no}</td>
                                   <td>${data[i]?.evaluated_price}</td>
                                   <td>${data[i]?.accumulated_dep_val}</td>
                                   <td>${data[i]?.book_value}</td>
                                   <td>${data[i]?._is_sold}</td>
                                   <td style="display:none;">

<input type="hidden"  class="_id_asset" value="${data[i].id}">
<input type="hidden"  class="_name_asset" value="${data[i]?.name}">
<input type="hidden"  class="_asset_tag_asset" value="${data[i]?.asset_tag}">
<input type="hidden"  class="_asset_code_asset" value="${data[i]?.asset_code}">
<input type="hidden"  class="_model_no_asset" value="${data[i]?.model_no}">
<input type="hidden"  class="_serial_no_asset" value="${data[i]?.serial_no}">
<input type="hidden"  class="_purchase_price_asset" value="${data[i]?.purchase_price}">
<input type="hidden"  class="_evaluated_price_asset" value="${data[i]?.evaluated_price}">
<input type="hidden"  class="_accumulated_dep_val_asset" value="${data[i]?.accumulated_dep_val}">
<input type="hidden"  class="_book_value_asset" value="${data[i]?.book_value}">
<input type="hidden"  class="_extra_cost_asset" value="${data[i]?.extra_cost}">
<input type="hidden"  class="__is_sold_asset" value="${data[i]?._is_sold}">

<input type="hidden"  class="_asset_dep_exp_ledger_name_asset" value="${data[i]?._asset_dep_exp_ledger?._name}">
<input type="hidden"  class="_asset_dep_exp_ledger_id_asset" value="${data[i]?._asset_dep_exp_ledger?.id}">
    
<input type="hidden"  class="_asset_dep_ledger_name_asset" value="${data[i]?._asset_dep_ledger?._name}">
<input type="hidden"  class="_asset_dep_ledger_id_asset" value="${data[i]?._asset_dep_ledger?.id}">
    
<input type="hidden"  class="_asset_ledger_name_asset" value="${data[i]?._asset_ledger?._name}">
<input type="hidden"  class="_asset_ledger_id_asset" value="${data[i]?._asset_ledger?.id}">
                                       
                                   </td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.asset_name_box').html(search_html);
      _gloabal_this.parent('div').find('.asset_name_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }


  $(document).on("click",'.asset_row_data',function(){
    var _id_asset = $(this).children('td').find('._id_asset').val();
    var _name_asset = $(this).find('._name_asset').val();
    var _asset_tag_asset = $(this).find('._asset_tag_asset').val();
    var _asset_code_asset = $(this).find('._asset_code_asset').val();
    var _model_no_asset = $(this).find('._model_no_asset').val();
    var _serial_no_asset = $(this).find('._serial_no_asset').val();
    var _purchase_price_asset = $(this).find('._purchase_price_asset').val();
    var _evaluated_price_asset = $(this).find('._evaluated_price_asset').val();
    var _accumulated_dep_val_asset = $(this).find('._accumulated_dep_val_asset').val();
    var _book_value_asset = $(this).find('._book_value_asset').val();
    var __is_sold_asset = $(this).find('.__is_sold_asset').val();
    var _extra_cost_asset = $(this).find('._extra_cost_asset').val();

    var _asset_dep_exp_ledger_name_asset = $(this).find('._asset_dep_exp_ledger_name_asset').val();
    var _asset_dep_exp_ledger_id_asset = $(this).find('._asset_dep_exp_ledger_id_asset').val();
    var _asset_dep_ledger_name_asset = $(this).find('._asset_dep_ledger_name_asset').val();
    var _asset_dep_ledger_id_asset = $(this).find('._asset_dep_ledger_id_asset').val();
    var _asset_ledger_name_asset = $(this).find('._asset_ledger_name_asset').val();
    var _asset_ledger_id_asset = $(this).find('._asset_ledger_id_asset').val();





    $(document).find("._search_main_ledger_id").val(_asset_ledger_name_asset);
    $(document).find(".asset_ledger_id").val(_asset_ledger_id_asset);
    $(document).find("._search_asset_dep_ledger_id").val(_asset_dep_ledger_name_asset);
    $(document).find(".asset_dep_ledger_id").val(_asset_dep_ledger_id_asset);
    $(document).find("._search_asset_dep_exp_ledger_id").val(_asset_dep_exp_ledger_name_asset);
    $(document).find(".asset_dep_exp_ledger_id").val(_asset_dep_exp_ledger_id_asset);
    $(document).find(".asset_name_search").val(_name_asset);
    $(document).find("._asset_id").val(_id_asset);
    $(document).find(".asset_tag").val(_asset_tag_asset);
    $(document).find(".asset_code").val(_asset_code_asset);
    $(document).find(".model_no").val(_model_no_asset);
    $(document).find(".purchase_price").val(_purchase_price_asset);
    $(document).find(".extra_cost").val(_extra_cost_asset);
    $(document).find(".evaluated_price").val(_evaluated_price_asset);
    $(document).find(".accumulated_dep_val").val(_accumulated_dep_val_asset);
    $(document).find(".book_value").val(_book_value_asset);
    $(document).find('.asset_name_box').hide();
    $(document).find('.asset_name_box').removeClass('search_box_show').hide();
//alert(1)
$(document).find(".asset_row_data").empty();

  })





