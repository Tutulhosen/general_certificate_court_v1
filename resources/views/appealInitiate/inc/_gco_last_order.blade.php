<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            @php
    
            if(globalUserInfo()->role_id == 28 || globalUserInfo()->role_id == 27)
            {
                $em_text='জিসিও এর';
            }elseif(globalUserInfo()->role_id == 39 || globalUserInfo()->role_id == 38)
            {
                $em_text='অতিরিক্ত জেলা ম্যাজিস্ট্রেট এর';
            } 
            @endphp
               
            <div class="form-group">
                <h4 class="bg-gray-300 card-title h4 py-3 text-center">{{ $em_text }} শেষ আদেশ, {{ en2bn($gcc_last_order['order_date_gcc'] ?? '') }}</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bg-gray-100 rounded-md rounded-right-0">
                                    <div class="p-4 h5">
                                        {!! nl2br($gcc_last_order['gcc_order'] ?? '') !!}</div>
                                </div>
                            </div>
                        </div>
                        @if(!empty($gcc_last_order['gcc_files']))
                        <div class="row">
                            <fieldset class="col-md-12 border-0 bg-white">
                                @forelse (json_decode($gcc_last_order['gcc_files'],true) as $key => $row)
                                    <div class="form-group mb-2"
                                        id="">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn bg-success-o-75"
                                                    type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                            </div>
                                            <input readonly type="text"
                                                class="form-control-md form-control "
                                                value="{{ $row['file_category'] ?? '' }}" />
                                            <div class="input-group-append">
                                                <a href="{{ asset($row['file_path'] . $row['file_name']) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-success font-size-h5 float-left">
                                                    <i
                                                        class="fa fas fa-file-pdf"></i>
                                                    <b>দেখুন</b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </fieldset>
                        </div>
                        @endif

                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>