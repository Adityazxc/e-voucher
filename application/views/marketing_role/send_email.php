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
<!-- Tambahkan modal ke halaman HTML -->
<div class="modal fade" id="editEmailModal" tabindex="-1" role="dialog" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmailModalLabel">Edit Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEmailForm">
                    <div class="form-group">
                        <label for="new_email">New Email:</label>
                        <input type="email" class="form-control" id="new_email" name="new_email" required>
                    </div>
                    <input type="hidden" id="customer_id" name="customer_id">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
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
        <!-- Tambahkan ini di atas tabel -->

        <div class="mb-3">
            <button type="button" class="btn btn-primary" id="getSelectedEmails" data-email="example@email.com">
                Kirim Email</button>
        </div>
        <div class="table-responsive">
            <table id="voucher" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                                <label class="form-check-label" for="selectAll"></label>
                            </div>
                        </th>
                        <th>No</th>
                        <th>Nama Pengirim</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Harga</th>
                        <th>AWB no</th>
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
                "url": "<?= base_url('marketing/getdatatables_send_email') ?>",
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
        $('#selectAll').change(function () {
            var checked = $(this).prop('checked');
            $('input:checkbox.data-check').prop('checked', checked);
        });

        // Tambahkan ini untuk menangani checkbox all
        $('#voucher tbody').on('change', 'input:checkbox.data-check', function () {
            $('#selectAll').prop('checked', false);
        });

      
        $(document).on('click', '#getSelectedEmails', function () {
            var selectedEmails = getSelectedEmails();

            if (selectedEmails.length > 0) {
                sendEmails(selectedEmails);
            } else {
                alert('Tidak ada email yang dipilih.');
            }
        });


        function getSelectedEmails() {
            var selectedEmails = [];
            $('#voucher tbody').find('input:checkbox.data-check:checked').each(function () {
                var email = $(this).closest('tr').find('.email-cell').text();
                selectedEmails.push(email);
            });
            return selectedEmails;
        }

        function sendEmails(emails) {
            $.ajax({
                url: "<?= base_url('marketing/send_emails_dummy') ?>",
                type: "POST",
                data: {
                    selectedEmails: emails
                },
                success: function (response) {
                    alert(response);
                    reloadData();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        $('[name="dateFrom"]').on('change', (e) => {
            $('#status').val('status1');
            table.ajax.reload();
        });

        $('[name="dateThru"]').on('change', (e) => {
            $('#status').val('status1');
            table.ajax.reload();
        });
    });
</script>

<!-- Add this script in your HTML file or view -->
<script>
    function editEmail(customerId, currentEmail) {
        $('#editEmailModal').modal('show');
        $('#customer_id').val(customerId);
        $('#current_email').val(currentEmail);
    }
</script>
<!-- Add this script in your HTML file or view -->
<script>
    // Fungsi untuk menangani form edit email
    $(document).ready(function () {
        $('#editEmailForm').submit(function (e) {
            e.preventDefault();
            
            // Dapatkan data formulir
            var customerId = $('#customer_id').val();
            var newEmail = $('#new_email').val();

            // Lakukan permintaan AJAX untuk memperbarui email
            $.ajax({
                type: 'POST',
                url: "<?= base_url('marketing/update_email') ?>",
                data: {customer_id: customerId, new_email: newEmail},
                success: function (data) {
                   
                    $('#editEmailModal').modal('hide');
                    reloadData();
                    
                },
                error: function (error) {
                    // Handle kesalahan
                    console.error('Error updating email:', error);
                }
            });
        });
    });
</script>

