@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')


<div class="container">
    <h3>Income Ledger Setup Entry</h3>
    <form action="{{ route('stm_income_ledger_setups_store') }}" method="POST">

        <input type="hidden" name="id" value="{{$editData->id ?? ''}}">
        @csrf

        @php
            $fields = [
                '_admission_fee_ledger' => 'Admission Fee Ledger',
                '_tution_fee_ledger' => 'Tuition Fee Ledger',
                '_anual_fee_ledger' => 'Annual Fee Ledger',
                '_exam_fee_ledger' => 'Exam Fee Ledger',
                '_monthly_food_fee_ledger' => 'Monthly Food Fee Ledger',
                '_residential_fee_ledger' => 'Residential Fee Ledger',
                '_other_fee_ledger' => 'Other Fee Ledger',
                '_other_2_fee_ledger' => 'Other 2 Fee Ledger',
                '_other_3_fee_ledger' => 'Other 3 Fee Ledger',
                '_discount_ledger' => 'Discount Ledger',
            ];
        @endphp

        @foreach ($fields as $name => $label)
            <div class="row mb-3">
                <label class="col-md-3" for="{{ $name }}">{{ $label }}</label>
                <div class="col-md-6">
                 <select name="{{$name}}" id="{{ $name }}" class="form-control select2" >

                    @forelse($ledgers as $ledger)
                        <option value="{{ $ledger->id}}" @if($ledger->id==$editData->$name) selected @endif >{{ $ledger->_code ?? ''}} {{ $ledger->_name ?? ''}}</option>
                    @empty
                    @endforelse
                    
                </select>
</div>
            </div>
        @endforeach

     
<div class="col-xs-12 col-sm-12 col-md-12  text-middle p-4">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                           
                        </div>
     
    </form>
</div>
@endsection

@section('script')

<script>

</script>

@endsection