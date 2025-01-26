 <div role="tabpanel" aria-labelledby="regTab5" class="tab-pane fade" id="regTab_5">
     <div class="panel panel-info radius-none ">

         {{-- <div class="panel-heading radius-none"> --}}
         {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
         {{-- </div> --}}
         <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
             <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                 <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                     <input type="hidden" id="NomineeCount" value="{{ count($nomineeCitizen) }}">
                     @forelse ($nomineeCitizen as $key => $item)
                         @php
                             $count = ++$key;
                         @endphp
                         <div id="cloneNomenee" class="card">
                             <div class="card-header" id="headingOne3">
                                 <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}" data-toggle="collapse"
                                     data-target="#collapseOne3{{ $count }}">
                                     উত্তরাধিকারীর তথ্য &nbsp; <span id="spannCount">({{ $count }})</span>
                                 </div>
                             </div>
                             <div id="collapseOne3{{ $count }}" class="collapse {{ $count == 1 ? 'show' : '' }} "
                                 data-parent="#accordionExample3">
                                 <div class="card-body">
                                     <div class="clearfix">
                                        <input type="hidden" value="already_nominee" name="already_nominee">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineeName_1" class="control-label"><span
                                                             style="color:#FF0000">*</span>উত্তরাধিকারীর
                                                         নাম</label>
                                                     <input name="nominee[name][]" id="nomineeName_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->citizen_name }}" readonly>
                                                     <input type="hidden" name="nominee[type][]"
                                                         class="form-control form-control-sm" value="5">
                                                     <input type="hidden" name="nominee[id][]" id="nomineeId_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->id }}">

                                                     <input type="hidden" name="nominee[thana][]" id="nomineeThana_1"
                                                         class="form-control form-control-sm" value="">
                                                     <input type="hidden" name="nominee[upazilla][]"
                                                         id="nomineeUpazilla_1" class="form-control form-control-sm"
                                                         value="">
                                                     <input type="hidden" name="nominee[designation][]"
                                                         id="nomineeDesignation_1" class="form-control form-control-sm"
                                                         value="">
                                                     <input type="hidden" name="nominee[organization][]"
                                                         id="nomineeOrganization_1" class="form-control form-control-sm"
                                                         value="">
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineePhn_1" class="control-label"><span
                                                             style="color:#FF0000">*</span>মোবাইল</label>
                                                     <input name="nominee[phn][]" id="nomineePhn_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->citizen_phone_no }}" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineeNid_1" class="control-label"><span
                                                             style="color:#FF0000">*</span>জাতীয়
                                                         পরিচয় পত্র</label>
                                                     <input name="nominee[nid][]" id="nomineeNid_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->citizen_NID }}" readonly>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineeGender_1" class="control-label">নারী /
                                                         পুরুষ</label>
                                                     <select style="width: 100%;"
                                                         class="selectDropdown form-control form-control-sm"
                                                         name="nominee[gender][]" id="nomineeGender_1">

                                                         <option value="MALE"
                                                             {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                             পুরুষ</option>
                                                         <option value="FEMALE"
                                                             {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                             নারী</option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <input name="nominee[organization_id][]" id="nomineeOrganizationID_1"
                                                 type="hidden">
                                         </div>

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineeFather_1" class="control-label"><span
                                                             style="color:#FF0000"></span>পিতার
                                                         নাম</label>
                                                     <input name="nominee[father][]" id="nomineeFather_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->father }}" readonly>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineeMother_1" class="control-label"><span
                                                             style="color:#FF0000"></span>মাতার
                                                         নাম</label>
                                                     <input name="nominee[mother][]" id="nomineeMother_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->mother }}" readonly>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineeAge_1" class="control-label"><span
                                                             style="color:#FF0000"></span>বয়স</label>
                                                     <input name="nominee[age][]" id="nomineeAge_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->age }}" readonly>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="nomineeAge_1" class="control-label"><span
                                                             style="color:#FF0000">*</span>ইমেইল</label>
                                                     <input name="nominee[email][]" id="nomineeAge_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $item->email }}" readonly>
                                                 </div>
                                             </div>

                                         </div>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label for="nomineePresentAddree_1"><span
                                                             style="color:#FF0000">*</span>বর্তমান ঠিকানা</label>
                                                     <textarea id="nomineePresentAddree_1" name="nominee[present_address][]" rows="3"
                                                         class="form-control form-control-sm element-block blank" aria-describedby="note-error" aria-invalid="false"
                                                         readonly>{{ $item->present_address }}</textarea>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nomineePresentAddree_1"><span style="color:#FF0000">*
                                                        </span>স্থায়ী ঠিকানা</label>
                                                    <textarea id="nomineePermanentAddress_1" name="nominee[permanentAddress][]" rows="3"
                                                    class="form-control form-control-sm element-block blank" aria-describedby="note-error" aria-invalid="false"
                                                    readonly>{{ $item->present_address }}</textarea>
                                            
                                                </div>
                                            </div>
                                        </div>

                                     </div>
                                 </div>
                             </div>
                         </div>
                     @empty
                        
                 @endforelse


         </div>
         </section>
     </div>


 </div>
 </div>
