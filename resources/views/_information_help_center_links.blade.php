<div class="py-1 py-lg-5 " id="startSection">
        <!--begin::Container-->
        <div class="container">
            <h2 style="color: green;">সহায়ক তথ্য ও সেবা</h2>
            <!--end::Heading-->
            <!--begin::Row-->
            <div class="row mt-5 g-lg-10 mb-5">
                <!--begin::Col-->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom mb-8 bg-dark-o-10 card_home mb-lg-0">
                        <div class="card-body text-center py-15"><img src="{{ asset('images/report.png') }}" alt="Girl in a jacket" width="60" height="70">
                            <div class="align-items-center pt-5">
                                <div class="flex-column icon-card-hm">
                                    <strong>কজ <span>লিস্ট</span></strong>
                                    <a href="{{ route('cause_list') }}" class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        মামলার তথ্য জানুন
                                    </a>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--begin::Col-->
                {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom mb-8 bg-dark-o-10 card_home mb-lg-0">
                        <div class="card-body text-center py-15"><img src="{{ asset('images/causelist.png') }}" alt="Girl in a jacket" width="60" height="70">
                            <div class="align-items-center pt-12">
                                <div class="flex-column icon-card-hm">
                                    <a href="#" class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3 ">
                                        তদন্ত প্রতিবেদন
                                    </a>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!--begin::Col-->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom mb-8 bg-dark-o-10 card_home mb-lg-0">
                        <div class="card-body text-center py-15"><img src="{{ asset('images/support.png') }}" alt="Girl in a jacket" width="60" height="70">
                            <div class="align-items-center pt-12">
                                <div class="flex-column icon-card-hm">
                                    <a href="{{ route('support.center.citizen.no.auth') }}" class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3 ">
                                        সাপোর্ট সেন্টার </a>
                                   
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Col-->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom mb-8 bg-dark-o-10 card_home card_home mb-lg-0">
                        <div class="card-body text-center py-15"><img src="{{ asset('images/bangladesh.png') }}" alt="Girl in a jacket" width="60" height="70">
                            <div class="align-items-center pt-12">
                                <div class="flex-column icon-card-hm">
                                    <a href="http://bdlaws.minlaw.gov.bd/laws-of-bangladesh-alphabetical-index.html?lang=bn" target="_blank" class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3 ">
                                        ল’জ অব বাংলাদেশ </a>
                                  
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>

        <div class="container">
            <h2 class="mb-6" style="color: green;">জনপ্রিয় খবর</h2>
            @include('_sliders')
        </div>

    </div>