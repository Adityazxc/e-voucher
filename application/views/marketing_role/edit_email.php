<?= $customerId ?>
<div class="col d-flex justify-content-center">
    <div class="card" style="width:18rem;">
        <div class="card-body">
            <form id="editEmailForm" method="POST">
                <div class="form-group">
                    <h5 class="card-title"><label for="customerID">Edit Email</label></h5>
                    <input type="hidden" class="form-control" value="<?= $customerId ?>" id="customerId" readonly>
                </div>
                <div class="form-group">
                    <label for="newEmail">New Email:</label>
                    <input type="email" class="form-control" id="newEmail" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#editEmailForm').submit(function (e) {
            e.preventDefault();

            var customer_id = $('#customerId').val(); // Corrected the ID here
            var newEmail = $('#newEmail').val();

            $.ajax({
                type: 'POST',
                url: "<?= base_url('marketing/update_email') ?>",
                data: { customer_id: customer_id, newEmail: newEmail },
                success: function (data) {
                    console.log('Email update successfully:', data);
                },
                error: function (error) {
                    console.log('Error updating email:', error);
                }
            });
        });
    });
</script>
