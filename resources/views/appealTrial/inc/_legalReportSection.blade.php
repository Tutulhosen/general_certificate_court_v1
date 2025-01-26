<legend>জারিকারকের রিপোর্ট </legend>

@if ($legalInfo != null)
    <div class="border-0 bg-white">
        <div class="bg-gray-100 rounded-lg rounded-right-0">
            <div class="p-4 h5">
                {{ $legalInfo->report_details ?? '' }}
            </div>
        </div>
        <div class="form-group mb-2" id="deleteFile">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn bg-success-o-75" type="button">{{ '১ - নম্বর :' }}</button>
                </div>
                <input readonly type="text" class="form-control form-control-sm"
                    value="{{ 'জারিকারকের রিপোর্ট\'র স্ক্যান কপির সংযুক্তি' }}" />
                <div class="input-group-append">
                    <a href="{{ asset($legalInfo->report_file) }}" target="_blank"
                        class="btn btn-sm btn-success font-size-h5 float-left">
                        <i class="fa fas fa-file-pdf"></i>
                        <b>দেখুন</b>
                    </a>
                </div>
            </div>
        </div>
        @if(globalUserInfo()->role_id == 28)
        <p class="h5 mt-3"><br>
            <a href="#" class="h6" data-toggle="modal" data-target="#exampleModalLong">
                <i class="flaticon2-pen text-primary"></i> &nbsp; সংশোধন করুন
            </a>
        </p>
        @endif
    </div>
@else
    <div class="card">
        <p class="h5 text-center mt-3"> তথ্য খুঁজে পাওয়া যায়নি... &nbsp;
            @if(globalUserInfo()->role_id == 28)
            <a href="#" class="text-center h6" data-toggle="modal" data-target="#exampleModalLong">
                রিপোর্ট যুক্ত করুন
            </a>
            @endif
        </p>
    </div>
@endif
