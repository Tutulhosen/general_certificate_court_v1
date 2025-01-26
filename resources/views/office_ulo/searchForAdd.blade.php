<?php 
$roleID = Auth::user()->role_id;
$officeInfo = user_office_info();
?>
<form class="form-inline" method="GET">      
       

@if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4)
   <div class="form-group mb-2 mr-2">
      <select name="division" class="form-control">
         <option value="">-বিভাগ নির্বাচন করুন-</option>
         @foreach ($divisions as $value)
         <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
         @endforeach
      </select>
   </div>
   <div class="form-group mb-2 mr-2">
      <select name="district" id="district_id" class="form-control">
         <option value="">-জেলা নির্বাচন করুন-</option>              
      </select>
   </div>
   <div class="form-group mb-2 mr-2">
      <select name="upazila" id="upazila_id" class="form-control">
         <option value="">-উপজেলা নির্বাচন করুন-</option>               
      </select>
   </div>

@elseif($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13)

   <div class="form-group mb-2 mr-2">
      <select name="upazila"  id="upazila_id" class="form-control">
         <option value="">-উপজেলা নির্বাচন করুন-</option>
         @foreach ($upazilas as $value)
         <option value="{{ $value->id }}"> {{ $value->upazila_name_bn }} </option>
         @endforeach
      </select>
   </div>
   
@endif

   <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
</form>