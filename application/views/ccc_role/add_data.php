<!-- script untuk no urut -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<form method="get" action="<?= base_url('ccc/view_add_data'); ?>">
    <label for="dateFrom">From:</label>
    <input type="date" id="dateFrom" name="dateFrom">

    <label for="dateThru">Thru:</label>
    <input type="date" id="dateThru" name="dateThru">

    <button type="submit">Filter</button>
</form>

<form action="<?php echo base_url('ccc/importData'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-5 mb-4"><button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#addCustomerModal">
                Add Customer
            </button></div>
        <div class="col mb-4"><input type="file" class="form-control mx-2" name="excel_file" id="excel_file" required>
        </div>
        <div class="col mb-4"><button type="submit" class="btn btn-primary mx-2">Import Data</button></div>
    </div>
</form>


<!-- Modal -->
<?php $this->load->view('ccc_role/modal_add_data'); ?>
<!-- end Modal -->

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Voucher Data</h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered" width="100%" border="1" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengirim</th>
                        <th>Email</th>
                        <th>No Tlp</th>
                        <th>Harga Ongkir</th>
                        <th>AWB no</th>
                        <th>Service</th>
                        <th>E-Voucher</th>                        
                        <th>Date</th>                        
                    </tr>
                </thead>
                <tbody id="dataBody">
                    <?php $counter = 1; ?>
                    <?php foreach ($voucher_data as $voucher): ?>
                        <tr>
                            <td></td> <!-- No Urut column will be filled dynamically in JavaScript -->
                            <td>
                                <?php echo $voucher->customer_name ?>

                            </td>
                            <td>
                                <?php echo $voucher->email; ?>
                            </td>
                            <td>
                                <?php echo $voucher->no_hp; ?>

                            </td>
                            <td>
                                <?php echo $voucher->harga; ?>
                            </td>
                            <td>
                                <?php echo $voucher->awb_no; ?>


                            </td>
                            <td>
                                <?php echo $voucher->service; ?>

                            </td>
                            <td>
                                <?php echo $voucher->voucher; ?>

                            </td>
                            <td>
                                <?php echo $voucher->date; ?>

                            </td>
                         
                        </tr>
                        <?php $counter++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Initialize DataTable with options
        var table = $('#dataTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true
        });
        // Custom rendering for No Urut column
        table.on('order.dt search.dt', function () {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    });
</script>