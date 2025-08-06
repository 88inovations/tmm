 <div class="col-12 col-sm-6 col-xl-12">
                          @php
                      $languages = \DB::table('languages')->get();
                      $_lan_key = $_GET['_lang_ref'] ?? _default_language(); 
                      @endphp
                      
                          <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                              <h5 class="mb-0 text-1000 me-2">{{__('label.language')}}</h5>
                            </div>
                             <select  name="lang_code" class="form-select" id="lang_code">
                              @forelse($languages as $language)
                                 <option value="{!! $language->lang_code !!}" @if($language->lang_code==$_lan_key) selected @endif >{!! $language->lang_name ?? '' !!}</option value="{!! $language->lang_code !!}">
                            @empty
                            @endforelse
                            </select>
                          </div>
                        </div>