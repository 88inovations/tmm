<table class="table table-bordered _list_table" >
                      <thead>
                        <tr>
                         <th>SL</th>
                         <th class="">Action</th>
                         <th>Type</th>
                         <th>Group</th>
                         <th>{{__('label._branch_id')}}</th>
                         <th>Ledger ID</th>
                         <th>Ledger Name</th>
                         <th>Code</th>
                         
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Credit Limit</th>
                         <th>Balance</th>
                         <th>Note</th>
                         <th>Possition</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                       $_new_datas=array();
                        foreach ($datas as $value) {
                            $_new_datas[$value->_account_head_id ?? ''."-".$value->account_type->_name ?? ''][$value->_account_group_id ?? ''."-".$value->account_group->_name ?? ''][]=$value;
                        }
                      @endphp
                        
                           @forelse($datas as $key3=>$data)

                        <tr>
                           <td>{{($key3+1)}}</td>
                           <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('account-ledger.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                     <button type="button" 
       class="btn btn-sm btn-info active attr_base_edit_url" 
       data-toggle="modal" data-target="#commonEntryModal_item" 
      attr_base_edit_url="{{ route('account-ledger.edit',$data->id) }}">
        <i class="fa fa-pen "></i>
       </button>
                                  

                                    
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                          
                             
                            <td>{{ $data->account_type->_name ?? '' }}</td>
                            <td>{{ $data->account_group->_name ?? '' }}</td>
                            <td>{{ $data->_entry_branch->id ?? '' }}-{{ $data->_entry_branch->_name ?? '' }}</td>
                            <td><b>{{ $data->id }}</b></td>
                            <td><b>{{ $data->_name }}</b></td>
                            <td>{{ $data->_code ?? '' }}</td>
                            
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{{ _report_amount($data->_credit_limit)  }}</td>
                            <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_short ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>
                        @empty
                        @endforelse
                       
                        </tbody>
                    </table>
                    <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
                </div>