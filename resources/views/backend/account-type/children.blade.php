@if ($children->isNotEmpty())
    <ul class="indent">
        @foreach ($children as $child)
            <li class="list_li">
                         @can('account-type-edit')
                                  <a  
                                  href="{{ route('account-type.edit',$child->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-type-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-type.destroy', $child->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan 
                               
                {{ $child->_name ?? '' }}
                @include('backend.account-type.children', ['children' => $child->children])
            </li>
        @endforeach
    </ul>
@endif