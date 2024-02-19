<!-- Modal -->
<?php $this->load->view('admin_role/modal_add_data'); ?>
<!-- end Modal -->

<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white px-4">
        <div class="d-flex justify-content-between align-item-center">
            <div class="me-4">
                <h2 class="card-title text-white mb-0 ">User Status</h2>
                <div class="card-subtitile">Details and history</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5 mb-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">
                    Add User
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="voucher" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Area</th>
                        <th>role</th>
                        <th>Account ID</th>
                        <th>Status</th>
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
                "url": "<?= base_url('admin/view_users') ?>",
                "type": "POST",
            }, "columnDefs": [{
                "targets": [0, 2, 3, 4, 5],
                "orderable": false
            },
            {
                "targets": [0, 1, 2, 3, 4, 5],
                "className": 'text-center'
            }
            ],
        });

    });

    function detailUsers(id) {
        var encryptedId = encryptFunction(id);

        console.log(encryptedId);
        var url = "<?= base_url('admin/detailUsers') ?>?idUser=" + encryptedId;
        window.location.href = url;
    }

    // Your encryption function (implemented on the server side)
    function encryptFunction(value) {

        var encodedValue = btoa(value); // Base64 encoding

        return encodedValue;
    }

    // function detailUsers(id){
    //     var id_user=id;

    //     console.log(id_user);
    //     window.location.href = "<?= base_url('admin/detailUsers') ?>?idUser="+id_user;
    // }

</script>