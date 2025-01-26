<fieldset class="mb-8 p-7" style="background: none;">
                            <legend>আদেশের তালিকা </legend>
                            <div class="panel panel-info radius-none ">
                                <div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
                                    <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                                        <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                            @forelse ($shortoder_array as $key => $item)
                                                @php
                                                    $count = ++$key;
                                                    // with('noteCauseList', 'attachments')
                                                @endphp
                                                <div id="cloneNomenee" class="card">
                                                    <div class="card-header" id="headingOne3">
                                                        <div class=" bg-gray-300 card-title h4 {{ $count == 1 ? '' : 'collapsed' }}"
                                                            data-toggle="collapse"
                                                            data-target="#collapseOne3{{ $count }}">
                                                            <span
                                                                id="spannCount">{{ en2bn($item['gcc_order_date'] ?? '') }}</span>&nbsp;
                                                            তারিখ এর আদেশ
                                                        </div>
                                                    </div>
                                                    <div id="collapseOne3{{ $count }}"
                                                        class="collapse {{ $count == 1 ? 'show' : '' }} "
                                                        data-parent="#accordionExample3">
                                                        <div class="card-body border-secondary">
                                                            <div class="clearfix ">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h4 class="text-right">সার্টিফিকেট সহকারী কর্তৃক গৃহীত ব্যবস্থা ,
                                                                            {{ en2bn($item['order_date_certificate_asst'] ?? '') }}
                                                                        </h4>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div
                                                                                    class="bg-gray-100 rounded-md rounded-right-0">
                                                                                    <div class="p-4 h5">
                                                                                        {!! nl2br($item['certificate_asst_order']) !!}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @if (!empty($item['certificate_asst_files_files']))
                                                                            <div class="row">
                                                                                <fieldset
                                                                                    class="col-md-12 border-0 bg-white">
                                                                                    @forelse (json_decode($item['certificate_asst_files_files'],true) as $key => $row)
                                                                                        <div class="form-group mb-2"
                                                                                            id="">
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <button
                                                                                                        class="btn bg-success-o-75"
                                                                                                        type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                                                                </div>
                                                                                                <input readonly
                                                                                                    type="text"
                                                                                                    class="form-control-md form-control "
                                                                                                    value="{{ $row['file_category'] ?? '' }}" />
                                                                                                <div
                                                                                                    class="input-group-append">
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
                                                                      @php
                                                                        if(globalUserInfo()->role_id == 28 || globalUserInfo()->role_id == 27)
                                                                        {
                                                                            $em_text='জিসিও';
                                                                        }elseif(globalUserInfo()->role_id == 39 || globalUserInfo()->role_id == 38)
                                                                        {
                                                                            $em_text='অতিরিক্ত জেলা ম্যাজিস্ট্রেট এর';
                                                                        } 
                                                                        @endphp

                                                                        <div class="col-md-12 mt-3">
                                                                            <h4 class="text-right">{{ $em_text }} আদেশ
                                                                                , {!! en2bn($item['gcc_order_date']) !!}
                                                                                
                                                                            </h4>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div
                                                                                        class="bg-gray-100 rounded-md rounded-right-0">
                                                                                        <div class="p-4 h5">
                                                                                            
                                                                                            {!! nl2br($item['gcc_order']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @if (!empty($item['gcc_files']))
                                                                            <div class="row">
                                                                                <fieldset
                                                                                    class="col-md-12 border-0 bg-white">
                                                                                    @forelse (json_decode($item['gcc_files'],true) as $key => $row)
                                                                                        <div class="form-group mb-2"
                                                                                            id="">
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <button
                                                                                                        class="btn bg-success-o-75"
                                                                                                        type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                                                                </div>
                                                                                                <input readonly
                                                                                                    type="text"
                                                                                                    class="form-control-md form-control "
                                                                                                    value="{{ $row['file_category'] ?? '' }}" />
                                                                                                <div
                                                                                                    class="input-group-append">
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

                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="border">
                                                    <p class="h5 text-center mt-3"> <span
                                                            class="svg-icon svg-icon-primary svg-icon-2x">
                                                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Search.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
                                                                    <path
                                                                        d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        opacity="0.3" />
                                                                    <path
                                                                        d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                                        fill="#000000" fill-rule="nonzero" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        তথ্য খুঁজে পাওয়া যায়নি... &nbsp;
                                                    </p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </fieldset>