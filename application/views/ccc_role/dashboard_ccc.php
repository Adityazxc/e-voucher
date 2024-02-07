<form id="filterForm">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="dateFrom">From:</label>
            <input type="date" class="form-control" id="dateFrom" name="dateFrom" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="form-group col-md-5">
            <label for="dateThru">Thru:</label>
            <input type="date" class="form-control" id="dateThru" name="dateThru" value="<?= date('Y-m-d') ?>">
        </div>
        <!-- <div class="form-group col-md-2">                
                <button type="button" class="btn btn-primary" onclick="filterData()">Filter</button>
            </div> -->
    </div>
</form>


<div class="row">
    <!-- Filter Form -->
    <!-- Earnings (Monthly) Card Example -->
    <div class="col mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Dikirim</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 totalstatus1"></div>
                    </div>
                    <button class="btn btn-default btn-icon" onclick="btnstatus1()">
                        <div class="col-auto">
                            <i class="bi bi-send fa-2x "></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Digunakan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 totalstatus2"></div>
                    </div>
                    <button class="btn btn-default btn-icon" onclick="btnstatus2()">
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Belum digunakan
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 totalstatus3"></div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-default btn-icon" onclick="btnstatus3()">
                        <div class="col-auto">
                            <i class="bi bi-send fa-2x text-gray-300"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Hangus</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 totalstatus4"></div>
                    </div>
                    <button class="btn btn-default btn-icon" onclick="btnstatus4()">
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 totalstatus5"></div>
                    </div>
                    <button class="btn btn-default btn-icon" onclick="btnstatus5()">
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-raised">
    <div class="card-header bg-primary text-white px-4">
        <div class="d-flex justify-content-between align-item-center">
            <div class="me-4">
                <h2 class="card-title text-white mb-0 ">Voucher</h2>
                <div class="card-subtitile">Details and historty</div>
            </div>

        </div>
    </div>
    <div class="card-body p-4">
        <input type="hidden" name="status" id="status" value="">
        <div class="table-responsive">
            <table id="voucher" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengirim</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Harga</th>
                        <th>AWB no</th>
                        <th>Status</th>
                        <th>Service</th>
                        <th>E-Voucher</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>public/vendor/jquery/jquery.min.js"></script>

<script>
    var jumlah = () => {
        var formData = {
            status: $('#status').val(),
            dateFrom: $('[name="dateFrom"]').val(),
            dateThru: $('[name="dateThru"]').val(),
        };

        // BOX 1 
        $('.totalstatus1').text('Tunggu.');
        $('.totalstatus2').text('Tunggu.');
        $('.totalstatus3').text('Tunggu.');
        $('.totalstatus4').text('Tunggu.');
        $('.totalstatus5').text('Rp 0');
        $.ajax({
            url: "<?= base_url('ccc/summary_customer') ?>",
            dataType: "JSON",
            type: "POST",
            data: formData,
            success: (r) => {
                // BOX 1              
                $('.totalstatus1').text(r.sum_status1);
                $('.totalstatus2').text(r.sum_status2);
                $('.totalstatus3').text(r.sum_status3);
                $('.totalstatus4').text(r.sum_status4);
                $('.totalstatus5').text(formatRupiah(r.sum_status5));



            }
        });
    }
    // Fungsi untuk mengubah angka menjadi format rupiah
    function formatRupiah(angka) {
        var number_string = angka.toString();
        var sisa = number_string.length % 3;
        var rupiah = number_string.substr(0, sisa);
        var ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return 'Rp ' + rupiah;
    }
</script>



<script type="text/javascript">
    var table;
    $(document).ready(function () {
        //datatables
        table = $('#voucher').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('ccc/getdatatables_customer') ?>",
                "type": "POST",
                "data": function (data) {
                    data.status = $('[name="status"]').val();
                    data.dateFrom = $('[name="dateFrom"]').val();
                    data.dateThru = $('[name="dateThru"]').val();
                }
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
                "orderable": false
            },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "className": 'text-center'
            }
            ]
        });
        jumlah();
    });
    $('[name="dateFrom"]').on('change', (e) => {
        $('#status').val('status1');
        table.ajax.reload();
        jumlah();

    });
    $('[name="dateThru"]').on('change', (e) => {
        $('#status').val('status1');
        table.ajax.reload();
        jumlah();
    });

    function btnstatus1() {
        $('#status').val('status1');
        table.ajax.reload();
        jumlah();
    }

    function btnstatus2() {
        $('#status').val('status2');
        table.ajax.reload();
        jumlah();
    }

    function btnstatus3() {
        $('#status').val('status3');
        table.ajax.reload();
        jumlah();
    }

    function btnstatus4() {
        $('#status').val('status4');
        table.ajax.reload();
        jumlah();
    }
</script>