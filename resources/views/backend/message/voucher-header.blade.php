              
                
                @can('voucher-create')
               
                        <a title="Journal Voucher" class="btn  btn-sm btn-default" href="{{ route('voucher.create') }}"> <i class="nav-icon fas fa-plus"></i> JV </a>
                        
                @endcan 
                @can('cash-receive')
                   
                        <a title="Cash Receive" class="btn  btn-sm btn-default" href="{{ url('cash-receive') }}"> <i class="nav-icon fas fa-plus"></i> CR </a>
                  
                @endcan 
                @can('cash-payment')
                   
                        <a title="Cash payment" class="btn  btn-sm btn-default" href="{{ url('cash-payment') }}"> <i class="nav-icon fas fa-plus"></i> CP </a>
                   
                @endcan 
                @can('petty-cash')
                   
                        <a title="Petty Cash" class="btn  btn-sm btn-default" href="{{ url('petty-cash') }}"> <i class="nav-icon fas fa-plus"></i> PC </a>
                   
                @endcan 
                @can('bank-receive')
                    
                        <a title="Bank Receive" class="btn  btn-sm btn-default" href="{{ url('bank-receive') }}"> <i class="nav-icon fas fa-plus"></i> BR </a>
                   
                @endcan 
                @can('bank-payment')
                     
                        <a title="Bank Payment" class="btn  btn-sm btn-default" href="{{ url('bank-payment') }}"> <i class="nav-icon fas fa-plus"></i> BP </a>
                   
                @endcan 
                
                
                