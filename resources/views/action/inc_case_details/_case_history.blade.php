    <div class="container">
        <!-- <div class="separator separator-dashed my-10"></div> -->
        <?php if(!empty($logs)){ ?>
        <!--begin::Timeline-->
        <div class="timeline timeline-3">
            <div class="timeline-items">
                <?php foreach ($logs as $row) { ?>
                <div class="timeline-item">
                    <div class="timeline-media">
                        <i class="fa fas fa-angle-double-up text-warning"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="mr-2">
                                <a href="javascript:void(0)"
                                    class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5"><?= $row->status_name ?></a>
                                <span class="text-muted ml-2 font-size-h6 "><?= en2bn($row->created_at) ?> |
                                    <?= $row->name ?> | <?= $row->role_name ?></span>
                            </div>
                        </div>
                        <p class="p-0 font-italic font-size-h5"><?=nl2br($row->comment)?></p>
                    </div>
                </div>
                <?php } ?>



             {{--   <div class="timeline-item">
                    <div class="timeline-media">
                        <i class="fa fas fa-angle-double-up text-warning"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <div class="mr-2">
                                <a href="javascript:void(0)"
                                    class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">মামলা
                                    রেজিস্টার করা হয়েছে</a>
                                <span class="text-muted ml-2 font-size-h6 ">
                                    @php
                                        $user = App\Models\User::select('name', 'role_id')
                                            ->where('id', $info->user_id)
                                            ->first();
                                        $role = App\Models\Role::select('role_name')
                                            ->where('id', $user->role_id)
                                            ->first();
                                    @endphp
                                    {{ en2bn($info->created_at) }} |
                                    {{ $user->name }} |
                                    {{ $role->role_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <!--end::Timeline-->
        <?php } else { ?>
        <!--begin::Notice-->
        {{-- <div class="timeline timeline-3">
            <div class="timeline-items">
                <div class="timeline-item">
                    <div class="timeline-media">
                        <i class="fa fas fa-angle-double-up text-warning"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <div class="mr-2">
                                <a href="javascript:void(0)"
                                    class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">মামলা
                                    রেজিস্টার করা হয়েছে</a>
                                <span class="text-muted ml-2 font-size-h6 ">
                                    @php
                                        $user = App\Models\User::select('name', 'role_id')
                                            ->where('id', $info->user_id)
                                            ->first();
                                        $role = App\Models\Role::select('role_name')
                                            ->where('id', $user->role_id)
                                            ->first();
                                    @endphp
                                    {{ en2bn($info->created_at) }} |
                                    {{ $user->name }} |
                                    {{ $role->role_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="alert alert-custom alert-light-success fade show mb-9" role="alert">
            <div class="alert-icon">
                <i class="flaticon-warning"></i>
            </div>
            <div class="alert-text font-size-h3">কোন তথ্য পাওয়া যাইনি</div>
        </div> 
        <!--end::Notice-->
        <?php } ?>
    </div>
    <!--end::Container-->
