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


<div class="card card-raised">
    <div class="card-header bg-primary text-white px-4">
        <div class="d-flex justify-content-between align-item-center">
            <div class="me-4">
                <h2 class="card-title text-white mb-0 ">Customers</h2>
                <div class="card-subtitile">Details and history</div>
            </div>

        </div>
    </div>
    <div class="card-body p-4">
        <input type="hidden" name="status" id="status" value="">
        <!-- Tambahkan ini di atas tabel -->

        <form action="<?= base_url('cs/test_checkbox') ?>" method="POST">
            <div class="table-responsive">
                <table id="voucher" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Shipper Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Amount</th>
                            <th>AWB No</th>
                            <th>Status</th>
                            <th>Service</th>
                            <th>E-Voucher</th>
                            <th>Status Email</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>

        </form>
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
                "url": "<?= base_url('cs/getdatatables_send_email') ?>",
                "type": "POST",
                "data": function (data) {
                    data.status = $('[name="status"]').val();
                    data.dateFrom = $('[name="dateFrom"]').val();
                    data.dateThru = $('[name="dateThru"]').val();
                }
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                "orderable": false
            },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                "className": 'text-center'
            },
            {
                "targets": 3, // Targeting the Email column
                "render": function (data, type, row, meta) {
                    return '<small style="font-size:12px" class="email-cell">' + data + '</small>';
                }
            }
            ]
        });

        // checkbox
        $('#selectAll').change(function () {
            var checked = $(this).prop('checked');
            $('input:checkbox.data-check').prop('checked', checked);
        });

        // Tambahkan ini untuk menangani checkbox all
        $('#voucher tbody').on('change', 'input:checkbox.data-check', function () {
            $('#selectAll').prop('checked', false);
        });
        // end checkbox

        $(document).on('click', '#getSelectedEmails', function () {
            var selectedEmails = getSelectedEmails();

            if (selectedEmails.length > 0) {
                sendEmails(selectedEmails);
            } else {
                alert('Tidak ada email yang dipilih.');
            }
        });

        // datefrom and date thru
        $('[name="dateFrom"]').on('change', (e) => {
            $('#status').val('status1');
            table.ajax.reload();
        });

        $('[name="dateThru"]').on('change', (e) => {
            $('#status').val('status1');
            table.ajax.reload();
        });

        // end datefrom and date thru

    });
</script>

<script>
    function editEmail(id) {
        // Fetch the ID and name of the selected customer
        var customerId = id;

        console.log(customerId);
        // Redirect to the edit_email_page with customerId as a query parameter
        window.location.href = "<?= base_url('cs/edit_send_email') ?>?customerId=" + customerId;
    }


</script>

<!-- Modal -->
<div class="modal fade" id="ModalEditEmail" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ccc') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="ModaleditForm row"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary col-md-3" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary col-md-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#ModalEditEmail').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('ccc/modaledit') ?>',
                data: {
                    id: id,
                },
                success: function (data) {
                    $('.ModaleditForm').html(data); //menampilkan data ke dalam modal
                }
            });
        });

    });
</script>