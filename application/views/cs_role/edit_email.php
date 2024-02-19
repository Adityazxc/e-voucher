<div class="col d-flex justify-content-center">
    <div class="card" style="width:18rem;">
        <div class="card-body">
        <form action="<?php echo base_url('cs/update_email'); ?>" method="post">
                <div class="form-group">
                    <h5 class="card-title"><label for="customerID">Add Email</label></h5>
                    <input type="hidden" class="form-control" value="<?= $customerId ?>" name="customerId" id="customerId">
                </div>
                <div class="form-group">                    
                    <input type="email" class="form-control" name="newEmail" id="newEmail" required>
                </div>
                <center><button type="submit" class="btn btn-primary">Add Email</button></center>
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
                url: "<?= base_url('cs/update_email') ?>",
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
