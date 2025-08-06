<script>
	

	  $(document).on('keyup','._value',function(){
    console.log($(this).val())
    var _qty = $(this).closest('tr').find('._qty').val();
 //   console.log()
    var _value = $(this).closest("tr").find("._value").val();
    if(isNaN(_value)){_value = 0}
    if(isNaN(_qty)){_qty = 1}
    var _rate = parseFloat(parseFloat(_value)/parseFloat(_qty));
    if(isNaN(_rate)){_rate = 0}
    $(this).closest("tr").find("._rate").val(_rate);
   
_lc_total_calculation();
  });

  $(document).on('keyup','._common_keyup',function(event){
  event.preventDefault();
  var __this = $(this);
  var _vat_amount =0;
  var _qty = parseFloat($(this).closest('tr').find('._qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._rate').val());
  var conversion_qty = parseFloat($(this).closest('tr').find('.conversion_qty').val());

  var _base_rate =(_rate/conversion_qty);
  console.log(_base_rate + " _base_rate")
  console.log(conversion_qty + " conversion_qty")
   __this.closest('tr').find('._base_rate').val(_base_rate);

   // if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }

  $(this).closest('tr').find('._value').val((_qty*_rate));
_lc_total_calculation();
    
})


  function _lc_total_calculation(){
  console.log('calculation here')
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
    var _total_discount_amount = 0;
      $(document).find("._value").each(function() {
            var _s_value =parseFloat($(this).val());
            if(isNaN(_s_value)){_s_value = 0}
          _total__value +=parseFloat(_s_value);
      });
      $(document).find("._qty").each(function() {
            var _s_qty =parseFloat($(this).val());
            if(isNaN(_s_qty)){_s_qty = 0}
          _total_qty +=parseFloat(_s_qty);
      });
  
      $(document).find("._total_qty_amount").val(_total_qty);
      $(document).find("._total_value_amount").val(_total__value);
     
  }
</script>