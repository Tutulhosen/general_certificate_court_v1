
<?php if(!empty($hearings)){ ?>
    <table class="table table-hover mb-6 font-size-h5">
        <thead class="thead-light  font-size-h3">
            <tr>
                <th scope="col" width="30">#</th>
                <th scope="col" width="200">শুনানির তারিখ</th>
                <th scope="col" width="200">সংযুক্তি</th>
                <th scope="col">মন্তব্য</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($hearings as $row)
                <tr>
                    <td scope="row">{{ en2bn(++$i) }}.</td>
                    <td>{{ $row->hearing_date }}</td>
                    <td>
                        <a href="#" class="btn btn-success btn-shadow" data-toggle="modal"
                            data-target="#orderAttachmentModal">
                            <i class="fa fas fa-file-pdf icon-md"></i> সংযুক্তি
                        </a>

                        <!-- Modal-->
                        <div class="modal fade" id="orderAttachmentModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bolder font-size-h3"
                                            id="exampleModalLabel">সংযুক্তি</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <embed src="{{ asset('uploads/order/' . $row->hearing_file) }}"
                                            type="application/pdf" width="100%" height="400px" />

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class="btn btn-light-primary font-weight-bold font-size-h5"
                                            data-dismiss="modal">বন্ধ করুন</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /modal -->
                    </td>
                    <td>{{ $row->hearing_comment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <?php }else{ ?>
    <!--begin::Notice-->
    <div class="alert alert-custom alert-light-success fade show mb-9" role="alert">
        <div class="alert-icon">
            <i class="flaticon-warning"></i>
        </div>
        <div class="alert-text font-size-h3">কোন শুনানির নোটিশ পাওয়া যাইনি</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                    <i class="ki ki-close"></i>
                </span>
            </button>
        </div>
    </div>
    <!--end::Notice-->
    <?php } ?>
