
                      <div class="card">
                        <div class="card-body">
                        <form id="archiveCase" action="{{ route('appeal.causelist.case.update') }}" class="form" method="POST"
                            enctype="multipart/form-data">
                            {{-- @dd($lastorder) --}}
                            @csrf
                            <input type="hidden" value="{{ $lastorder->causelist_id }}" name="id">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="causeTitle" class="control-label"><span style="color:#FF0000">*
                                            </span>মামলার সর্বশেষ আদেশের শিরোনাম</label>
                                        <input name="causeTitle" id="causeTitle" class="form-control form-control-sm"
                                            value="{{ $lastorder->short_order_name }}" />
                                        
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label><span class="text-danger">*</span> মামলার অবস্থা </label>
                                        <select class="form-control form-control-sm" name="appeal_status">
                                            <option value="ON_TRIAL" <?php if($lastorder->appeal_status=="ON_TRIAL"){ echo "Selected";}?>>চলমান</option>
                                            <option value="CLOSED" <?php if($lastorder->appeal_status=="CLOSED"){ echo "Selected";}?>>নিষ্পন্ন</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label><span class="text-danger">*</span> পরবর্তী তারিখ </label>
                                        <input type="text" name="next_date" id="next_date" class="form-control form-control-sm common_datepicker" value="{{ $classEditdata->next_date }}" placeholder="সাল/মাস/দিন" autocomplete="off">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                
                                        <label><span class="text-danger">*</span>সর্বশেষ আদেশের তারিখ </label>
                                        <input type="text" name="lastorderDate" id="lastorderDate"
                                            class="form-control form-control-sm common_datepicker"
                                            value="{{ $classEditdata->last_order_date }}" placeholder="সাল/মাস/দিন" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
                                <button type="submit" class="btn btn-primary">সংরক্ষণ</button>
                            </div>
                        </form>
                        </div>
                    </div>
      <script>
            $('.common_datepicker').datepicker({
        format: "yyyy/mm/dd",
        todayHighlight: true,
        orientation: "bottom left"
    });
      </script>
     