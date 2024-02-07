

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



<!-- Modal -->
<?php $this->load->view('ccc_role/modal_add_data'); ?>
<!-- end Modal -->


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
        <!-- Tambahkan ini di atas tabel -->
        <form action="<?php echo base_url('ccc/importData'); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">
                        Add Customer
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <input type="file" class="form-control" name="excel_file" id="excel_file" required>
                </div>
                <div class="col-md-4 mb-2">
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </div>
        </form>

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
       

      

    });

    $('[name="dateFrom"]').on('change', (e) => {
        $('#status').val('status1');
        table.ajax.reload();

    });
    $('[name="dateThru"]').on('change', (e) => {
        $('#status').val('status1');
        table.ajax.reload();

    });


</script>