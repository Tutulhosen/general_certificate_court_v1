<div>
    <select name="is_attendence_required" id="is_attendence_required" class="form-control">
        <option value="attendence_required_not">উপস্থিতি ( হাজিরা ) দেখা প্রয়োজন নেই</option>
        <option value="attendence_required">উপস্থিতি ( হাজিরা ) দেখা প্রয়োজন</option>
    </select>
<div id="is_attendence_required_div" style="display: none">
    <br>
@if(!empty($applicantCitizen))
<h3>ধারকের বিবরণ</h3>
@php $i=1; @endphp
@foreach($applicantCitizen as $key=>$value)
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="applicantName" class="control-label">
              নাম
            </label>
            <span id="applicantName"
                class="form-control form-control-sm">{{ $value->citizen_name ?? '' }}</span>
            <input type="hidden" name="citizenAttendance[citizen_name][{{ $i }}]"  value="{{ $value->citizen_name}}">
            <input type="hidden" name="citizenAttendance[appealId][{{ $i }}]" value="{{ $appeal->id }}">
            <input type="hidden" name="citizenAttendance[citizenId][{{ $i }}]" value="{{ $value->id}}">
            <input type="hidden" name="citizenAttendance[attendanceDate][{{ $i }}]" value="{{ now() }}">
            <input type="hidden" name="citizenAttendance[citizen_role][{{ $i }}]" value="ধারক">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group"><label for="applicantDesignation" class="control-label"><span
                    style="color: rgb(255, 0, 0);"></span>
                পদবি </label> <span id="applicantDesignation"
                class="form-control form-control-sm">{{ $value->designation ?? '' }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="applicantAttendance" class="control-label">
                <span style="color: rgb(255, 0, 0);">* </span> হাজিরা
            </label>
            <div class="radio">
                <label>
                    <input onchange="AttPrintHideShow({{ $i }})" id="applicantAttendancePresent" type="radio"
                        name="citizenAttendance[attendance][{{ $i }}]" value="PRESENT" checked="checked" class="show_hide_attendence_btn">
                    উপস্থিত
                </label>
                <label class="ml-2">
                    <input onchange="AttPrintHideShow({{ $i }})" id="applicantAttendanceAbsent" type="radio"
                        name="citizenAttendance[attendance][{{ $i }}]" value="ABSENT" class="show_hide_attendence_btn">
                    অনুপস্থিত
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group" id="attVic_{{ $i }}">
            <label for="attendance" class="control-label">
                হাজিরা প্রিন্ট
            </label>
            <div>
                <a target="_blank" class="btn btn-info"
                    href="{{route('get.attendence.print', ['appeal_id'=>$appeal->id,'citizen_id'=>$defaulterCitizen->id,'citizen_type_id'=>1,'citizen_name'=>$value->citizen_name,'citizen_designation'=>$value->designation]) }}">হাজিরা প্রিন্ট </a>
            </div>
        </div>
    </div>
</div>
    <span class="d-none">{{ ++$i }}</span>
@endforeach
@endif


@if(!empty($nomineeCitizen))
<h3>উত্তরাধিকারীর বিবরণ</h3>
@foreach($nomineeCitizen as $key=>$value)
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="applicantName" class="control-label">
              নাম
            </label>
            <span id="applicantName"
                class="form-control form-control-sm">{{ $value->citizen_name ?? '' }}</span>
            <input type="hidden" name="citizenAttendance[citizen_name][{{ $i }}]"  value="{{ $value->citizen_name}}">
            <input type="hidden" name="citizenAttendance[appealId][{{ $i }}]" value="{{ $appeal->id }}">
            <input type="hidden" name="citizenAttendance[citizenId][{{ $i }}]" value="{{ $value->id}}">
            <input type="hidden" name="citizenAttendance[attendanceDate][{{ $i }}]" value="{{ now() }}">
            <input type="hidden" name="citizenAttendance[citizen_role][{{ $i }}]" value="ধারক">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group"><label for="applicantDesignation" class="control-label"><span
                    style="color: rgb(255, 0, 0);"></span>
                পদবি </label> <span id="applicantDesignation"
                class="form-control form-control-sm">{{ $value->designation ?? 'উত্তরাধিকারী' }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="applicantAttendance" class="control-label">
                <span style="color: rgb(255, 0, 0);">* </span> হাজিরা
            </label>
            <div class="radio">
                <label>
                    <input onchange="AttPrintHideShow({{ $i }})" id="applicantAttendancePresent" type="radio"
                        name="citizenAttendance[attendance][{{ $i }}]" value="PRESENT" checked="checked" class="show_hide_attendence_btn">
                    উপস্থিত
                </label>
                <label class="ml-2">
                    <input onchange="AttPrintHideShow({{ $i }})" id="applicantAttendanceAbsent" type="radio"
                        name="citizenAttendance[attendance][{{ $i }}]" value="ABSENT" class="show_hide_attendence_btn">
                    অনুপস্থিত
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group" id="attVic_{{ $i }}">
            <label for="attendance" class="control-label">
                হাজিরা প্রিন্ট
            </label>
            <div>
                <a target="_blank" class="btn btn-info"
                    href="{{route('get.attendence.print', ['appeal_id'=>$appeal->id,'citizen_id'=>$defaulterCitizen->id,'citizen_type_id'=>5,'citizen_name'=>$value->citizen_name,'citizen_designation'=>'উত্তরাধিকারী']) }}">হাজিরা প্রিন্ট </a>
            </div>
        </div>
    </div>
</div>
<span class="d-none">{{ ++$i }}</span>
@endforeach
@endif



@if(!empty($defaulterCitizen)&&empty($nomineeCitizen))
<h3>খাতকের বিবরণ</h3>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="applicantName" class="control-label">
              নাম
            </label>
            <span id="applicantName"
                class="form-control form-control-sm">{{ $defaulterCitizen->citizen_name ?? '' }}</span>
            <input type="hidden" name="citizenAttendance[citizen_name][{{ $i  }}]"  value="{{ $defaulterCitizen->citizen_name}}">
            <input type="hidden" name="citizenAttendance[appealId][{{ $i  }}]" value="{{$appeal->id}}">
            <input type="hidden" name="citizenAttendance[citizenId][{{ $i  }}]" value="{{ $defaulterCitizen->id}}">
            <input type="hidden" name="citizenAttendance[attendanceDate][{{ $i  }}]" value="{{ now() }}">
            <input type="hidden" name="citizenAttendance[citizen_role][{{ $i  }}]" value="খাতক">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group"><label for="applicantDesignation" class="control-label"><span
                    style="color: rgb(255, 0, 0);"></span>
                পদবি </label> <span id="applicantDesignation"
                class="form-control form-control-sm">{{ $defaulterCitizen->designation ?? '' }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="applicantAttendance" class="control-label">
                <span style="color: rgb(255, 0, 0);">* </span> হাজিরা
            </label>
            <div class="radio">
                <label>
                    <input onchange="AttPrintHideShow({{ $i }})" id="applicantAttendancePresent" type="radio"
                        name="citizenAttendance[attendance][{{ $i  }}]" value="PRESENT" checked="checked" class="show_hide_attendence_btn">
                    উপস্থিত
                </label>
                <label class="ml-2">
                    <input onchange="AttPrintHideShow({{ $i }})" id="applicantAttendanceAbsent" type="radio"
                        name="citizenAttendance[attendance][{{ $i  }}]" value="ABSENT" class="show_hide_attendence_btn">
                    অনুপস্থিত
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group" id="attVic_{{ $i }}">
            <label for="attendance" class="control-label">
                হাজিরা প্রিন্ট
            </label>
            <div>
                <a target="_blank" class="btn btn-info"
                    href="{{ route('get.attendence.print', ['appeal_id'=>$appeal->id,'citizen_id'=>$defaulterCitizen->id,'citizen_type_id'=>2,'citizen_name'=>$defaulterCitizen->citizen_name,'citizen_designation'=>$defaulterCitizen->designation]) }}">হাজিরা প্রিন্ট </a>
            </div>
        </div>
    </div>
</div>
@endif
</div>    
</div>