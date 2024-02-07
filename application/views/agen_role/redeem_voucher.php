<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Script lainnya -->
</head>


<?php if (isset($response_message)): ?>
    <div class="alert alert-info" role="alert">
        <?php echo $response_message; ?>
    </div>
<?php endif; ?>
<!-- Modal OTP Verification -->
<div class="modal fade" id="otpVerificationModal" tabindex="-1" role="dialog" aria-labelledby="otpVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpVerificationModalLabel">OTP Verification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container height-100 d-flex justify-content-center align-items-center">
                    <div class="position-relative">
                        <div class="card p-2 text-center">
                            <h6>Please enter the one-time password to verify your account</h6>
                            <div>
                                <span>A code has been sent to</span>
                                <small>*******9897</small>
                            </div>
                            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-danger px-4 validate" onclick="validateOTP()">Validate</button>
                            </div>
                        </div>
                        <div class="card-2">
                            <div class="content d-flex justify-content-center align-items-center">
                                <span>Didn't get the code</span>
                                <a href="#" class="text-decoration-none ms-3">Resend(1/3)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="col-md-6 ml-auto mr-auto">
    <form action="<?php echo base_url('agen/search_customer'); ?>" method="post">
        <div class="form-group">
            <input type="text" class="form-control form-control-user" name="search_keyword" id="search_keyword"
                placeholder="Masukan Kode Voucher" style="border-radius: 1rem;"
                value="<?= isset($search_keyword) ? $search_keyword : ''; ?>" required>
        </div>
        <center>
            <button class="col-md-3 btn btn-primary">Gunakan</button>
            <button class="col-md-3 btn btn-danger" onclick="hapus()">Hapus</button>
        </center>
    </form>
</div>
<!-- Block untuk menampilkan hasil pencarian -->
<div id="searchResult" class="mt-3">
    <?php
    $search_keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';
    if (!empty($search_keyword)) {

        if (isset($search_result) && !empty($search_result)) {
            if (date('Y-m-d') <= $search_result[0]->expired_date) {
                ?>
                <div class="col-md-6 ml-auto mr-auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Voucher ditemukan
                                <?= $search_result[0]->customer_name ?> <br><small>Berlaku hingga
                                    <?= date('d-m-Y', strtotime($search_result[0]->expired_date)) ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('agen/reedem_voucher') ?>" method="POST">
                                <label>Nomor Resi</label>
                                <input type="text" name="resi" class="form-control" placeholder="Masukan Nomor Resi" required>                                
                                <br>
                                <input type="hidden" name="id" value="<?= $search_result[0]->id ?>">
                                <button type="submit" class="btn btn-block btn-primary" name="gunakan_btn">Gunakan</button>
                            </form>

                            <?php if (isset($otp) && !empty($otp)) : ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    OTP: <?= $otp; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                        
                    </div>
                </div>
            <?php } else {
                echo '<p>Kadaluarsa<p/>';
            }
        } else {
            // Tidak ada data ditemukan        
            // Tidak ada data ditemukan        
            echo '<div class="alert alert-info" role="alert">';
            echo '<center><span style="color: red;">Voucher </span>' . $search_keyword . '<span style="color: red;"> tidak Ditemukan atau sudah hangus</span></center>';
            echo '</div>';
        }
    }
    ?>
</div>
<script>
    function clearSearch() {
        document.getElementsByName("search_keyword")[0].value = '';
    }
</script>


<!--Model Popup starts-->

<script>
    function hapus() {
        $('#search_keyword').val('');
    }
</script>

<!-- Bootstrap Notify -->
<script src="https://css.jne.co.id/mysales/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script>
    <?php if ($this->session->flashdata('success')) { ?>
        var content = {};
        content.message = '<?php echo $this->session->flashdata("success") ?>';
        content.title = 'Berhasil ';
        content.icon = 'la la-check-circle';

        $.notify(content, {
            type: 'success',
            placement: {
                from: 'top',
                align: 'right'
            },
            time: 1000,
        }); <?php } ?>
</script>


<!-- otp -->
<script type="text/javascript">
    function validateOTP() {
        var firstDigit = $('#first').val();
        var secondDigit = $('#second').val();
        var thirdDigit = $('#third').val();
        var fourthDigit = $('#fourth').val();
        var fifthDigit = $('#fifth').val();
        var sixthDigit = $('#sixth').val();

        var enteredOTP = firstDigit + secondDigit + thirdDigit + fourthDigit + fifthDigit + sixthDigit;

        // Lakukan pemrosesan validasi OTP sesuai kebutuhan Anda
        // Anda dapat menggunakan AJAX untuk memverifikasi OTP di sisi server

        // Contoh AJAX untuk memanggil fungsi di controller dan memverifikasi OTP
        $.ajax({
            type: 'POST',
            url: '<?= base_url('agen/verify_otp') ?>',
            data: { entered_otp: enteredOTP },
            success: function (response) {
                // Tindakan yang dilakukan setelah OTP divalidasi
                // Misalnya, menutup modal dan menampilkan pesan sukses
                $('#otpVerificationModal').modal('hide');
                alert('OTP Validated successfully!');
            },
            error: function (error) {
                // Tindakan yang dilakukan jika terjadi kesalahan
                console.error('Error validating OTP:', error);
                alert('Error validating OTP. Please try again.');
            }
        });
    }
</script>
