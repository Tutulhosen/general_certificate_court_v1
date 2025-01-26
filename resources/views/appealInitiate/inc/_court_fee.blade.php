

<div class="card card-custom mb-5 shadow">
    <div class="card-header bg-primary-o-50">
        <div class="card-title">
            <span class="card-icon">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                                d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                fill="#000000" opacity="0.3" />
                            <path
                                d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                fill="#000000" />
                            <path
                                d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </span>
            <h3 class="card-label">কোর্ট ফি আদায় এবং ম্যানুয়াল মামলা নং
        </div>
    </div>
    <div class="card-body">
        <div class="panel panel-info">

            <div class="panel-body">

                <fieldset class="col-md-12 border-0  bg-success-o-50">
                    <div class="row">
                        @php
                            if (!empty($appeal->manual_case_no) && in_array(globalUserInfo()->role_id,[27] )) {
                                $readonly = 'disabled';
                                $already_manual_case_no="yes";
                            }elseif(!empty($appeal->manual_case_no) && in_array(globalUserInfo()->role_id,[28] ))
                            {
                                $readonly = 'readonly';
                                $already_manual_case_no="yes";
                            }
                             else {
                                $readonly = '';
                                $already_manual_case_no="no";
                            }
                            
                            if (!empty($appeal->court_fee_amount) && in_array(globalUserInfo()->role_id,[27] )) {
                                $court_fee_amount_disalbe = 'disabled';
                                $already_court_fee="yes";
                            }elseif(!empty($appeal->court_fee_amount) && in_array(globalUserInfo()->role_id,[28] ))
                            {
                                $court_fee_amount_disalbe = 'readonly';
                                $already_court_fee="yes";
                            }
                             else {
                                $court_fee_amount_disalbe = '';
                                $already_court_fee="no";
                            }

                        @endphp
                        <input type="hidden" name="already_court_fee" value="{{ $already_court_fee }}">
                        <input type="hidden" name="already_manual_case_no" value="{{ $already_manual_case_no }}">

                        <div class="col-md-12" id="nextDatePublish" style="display: block;">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">ম্যানুয়াল মামলা নং</label>
                                        <input type="text" class="form-control" name="manual_case_no"
                                            {{ $readonly }} value="{{ $appeal->manual_case_no }}"
                                            id="manual_case_no" >

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="form-label">কোর্ট ফি পরিমাণ</label>
                                            <input type="text" class="form-control" name="court_fee_amount"
                                                {{ $court_fee_amount_disalbe }} value="{{ en2bn($appeal->court_fee_amount) }}"
                                                id="court_fee_amount" >
                                                
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-md-4">
                                    @if(!empty($appeal->court_fee_file))
                                     
                                    <label class="form-label">কোর্ট ফি আদায় রশিদ এর স্ক্যান </label>
                                    <div class="mt-4">
                                        @forelse (json_decode($appeal->court_fee_file,true) as $key => $row)
                                     <a href="{{ asset($row['file_path'] . $row['file_name']) }}"
                                     target="_blank"
                                     class="btn btn-sm btn-success font-size-h5 float-left">
                                     <i
                                         class="fa fas fa-file-pdf"></i>
                                     <b>দেখুন</b>
                                   </a>
                                    </div>                            
                                     @empty
                                    @endforelse
                                    @else
                                    <label class="form-label">কোর্ট ফি আদায় রশিদ এর স্ক্যান </label>
                                        <input type="file" name="court_fee_file">
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
