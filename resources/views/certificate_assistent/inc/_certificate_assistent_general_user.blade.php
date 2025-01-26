<form action="" method="POST" enctype="multipart/form-data">
    @php 
   
   
        $designation="sdkjh";

    @endphp

    @csrf
    <input type="hidden" name="role_id" value="39">
    <input type="hidden" name="court_id" value="{{ $available_court->id }}">
    <input type="hidden" name="office_id" id="office_id" value="{{ $office->id }}">


    <div class="card-body">
        <fieldset>
           

          

            <div class="row" id="nothiCheck" style="display: none">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <input  type="text" id="nothiID" class="form-control"
                            style="argin-left: 14px" placeholder="উদাহরণ- 19825624603112948" name="nothiID">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="button" id="peshkarCheck" name="investigatorCheck"
                            onclick="checkPeskarADM()" class="btn btn-danger" value="সন্ধান করুন"> <span
                            class="ml-5" id="res_applicant_1"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class=" form-control-label">পুরো নাম <span
                                class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" placeholder="পুরো নাম লিখুন"
                            class="form-control" value="" required>
                        <span style="color: red">
                            {{ $errors->first('name') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="username" class=" form-control-label">ইউজারনেম <span
                                class="text-danger">*</span></label>
                        <input type="text" id="username" name="username"
                            placeholder="ব্যবহারকারীর নাম লিখুন" class="form-control "
                            value="" required>
                        <span style="color: red">
                            {{ $errors->first('username') }}
                        </span>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mobile_no" class=" form-control-label">মোবাইল নাম্বার </label>
                        <input type="text" name="mobile_no" id="mobile_no" placeholder="মোবাইল নাম্বার লিখুন"
                            class="form-control" value="" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email" class=" form-control-label">ইমেইল এড্রেস </label>
                        <input type="email" name="email" id="email" placeholder="ইমেইল এড্রেস লিখুন"
                            class="form-control" value="" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>পদবি নথি </label>
                        <input type="text" name="designation_nothi" id="designation_nothi" class="form-control" placeholder=""
                            value="" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="role_id" class=" form-control-label">পদবি <span
                                class="text-danger">*</span></label>
                        <input type="text" name="designation" class="form-control" placeholder=""
                            value="{{ $designation }}" readonly />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="office_id" class=" form-control-label">অফিস <span
                                class="text-danger">*</span></label>
                        <input type="text" name="office_name" id="office_name" class="form-control"
                            value="{{ $office->office_name_bn }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="court_id" class=" form-control-label">আদালত <span
                                class="text-danger">*</span></label>
                        <input type="text" name="court_name" class="form-control"
                            value="{{ $available_court->court_name }}" readonly>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class=" form-control-label">পাসওয়ার্ড <span
                                class="text-danger">*</span></label>
                                <input type="text" id="password" name="password"
                                    placeholder="ব্যবহারকারীর পাসওয়ার্ড লিখুন"
                                    class="form-control" value="" id="password" required>
                            <span style="color: red">
                                {{ $errors->first('password') }}
                            </span>
                    </div>
                </div>
            </div>
    </div>

            
        </fieldset>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-primary font-weight-bold mr-2">সংরক্ষণ করুন</button>
                </div>
            </div>
        </div>

</form>