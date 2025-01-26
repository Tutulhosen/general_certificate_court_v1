<legend>খারিজের আবেদন </legend>

    <div class="border-0 bg-white">
        <div class="form-group mb-2" id="deleteFile">
            <div class="input-group">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="col" class="align-middle">
                                    {{ $kharijTemplete->template_name }}
                                </th>
                                <th width="100">

                                    <a  href="{{ route('appeal.getKharijApplicationSheets', $appeal->id) }}" target="_blank">
                                        <span class="btn btn-primary btn-link"
                                            type="button"><i class="flaticon2-print"></i> দেখুন
                                        </span>
                                    </a>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
