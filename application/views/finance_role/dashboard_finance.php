

<div class="row">

   

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 mb-4">
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

    <div class="col-xl-3 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 totalstatus5">Tunggu.</div>
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Voucher Data</h6>
    </div>
    <div class="card-body">
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
        };

        // BOX 1 
        $('.totalstatus1').text('Tunggu.');
        $('.totalstatus2').text('Tunggu.');
        $('.totalstatus3').text('Tunggu.');
        $('.totalstatus4').text('Tunggu.');
        $('.totalstatus5').text('Tunggu.');
        $.ajax({
            url: "<?= base_url('ccc/summary_customer') ?>",
            dataType: "JSON",
            type: "POST",
            data: formData,
            success: (r) => {
                // BOX 1              
                $('.totalstatus2').text(r.sum_status2);
            
                
             
            }
        });
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
                }
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6,7,8],
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



    function btnstatus2() {
        $('#status').val('status2');
        table.ajax.reload();
        jumlah();
    }
   

</script>