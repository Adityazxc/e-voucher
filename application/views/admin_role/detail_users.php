<div class="col d-flex justify-content-center">
    <div class="card">
        <div class="card-body">
            <form action="<?php echo base_url('admin/reset_password'); ?>" method="post">
                <table id="tableUsers" class="table table-bordered">
                    <input type="hidden" class="form-control" value="<?= $userData->id_user ?>" name="customerId"
                        id="customerId">
                    <tr>
                        <th>Account Name</th>
                        <td>
                            <?= $userData->account_name ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>
                            <span id="passwordDisplay">
                                <?= $userData->password ?>
                            </span>
                            <button type="button" id="editPasswordBtn" onclick="editPassword()"
                                class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</button>
                            <!-- Hidden input field for the new password -->
                            <input type="password" name="new_password" id="newPasswordInput" style="display: none;"
                                required>
                        </td>

                    </tr>
                    <?php if ($userData->agent_area !== null) {                                         
                        echo "   <tr>
                                    <th>Agent Area</th>
                                    <td>" . $userData->agent_area . "</td>
                                </tr>";
                    }
                    ?>
                    <tr>
                        <th>Role</th>
                        <td>
                            <?= $userData->role ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Account Number</th>
                        <td>
                            <?= $userData->account_number ?>
                        </td>
                    </tr>
                </table>
                <center><button type="submit" class="btn btn-primary">Edit</button></center>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function editPassword() {
        // Toggle the display of the password and input field
        var passwordDisplay = document.getElementById("passwordDisplay");
        var newPasswordInput = document.getElementById("newPasswordInput");
        var editPasswordBtn = document.getElementById("editPasswordBtn");

        if (passwordDisplay.style.display === "none") {
            passwordDisplay.style.display = "inline";
            newPasswordInput.style.display = "none";
            editPasswordBtn.innerText = "Edit";
        } else {
            passwordDisplay.style.display = "none";
            newPasswordInput.style.display = "inline";
            editPasswordBtn.innerText = "Cancel";
        }
    }
</script>
<script>
    $(document).ready(function () {
        $('#editEmailForm').submit(function (e) {
            e.preventDefault();

            var customer_id = $('#customerId').val(); // Corrected the ID here
            var newPassword = $('#newPasswordInput').val();

            $.ajax({
                type: 'POST',
                url: "<?= base_url('admin/reset_password') ?>",
                data: { customer_id: customer_id, newPassword: newPassword },
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