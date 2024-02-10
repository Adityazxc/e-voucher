<?php if (isset($response_message)): ?>
    <div class="alert alert-info" role="alert">
        <?php echo $response_message; ?>
    </div>
<?php endif; ?>

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
<div id="searchResult" class="mt-3">
    <?php
    $search_keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';

    if (!empty($search_keyword)) {
        if (isset($search_result) && !empty($search_result)) {
            $status = $search_result[0]->status;

            if (date('Y-m-d') <= $search_result[0]->expired_date) {
                if ($status == 'Y') {
                    echo '<div class="alert alert-info" role="alert">';
                    echo 'Voucher ' . $search_keyword . ' telah digunakan';
                    echo '</div>';
                } else {
                    // Continue with the rest of your code for valid vouchers
                    ?>
                    <div class="col-md-6 ml-auto mr-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Voucher ditemukan<br>
                                    atas nama <?= $search_result[0]->customer_name ?> <br>
                                    Sebesar <?= 'Rp ' . number_format($search_result[0]->harga, 0, ',', '.') ?><br>                                
                                    <small>Berlaku hingga <?= date('d-m-Y', strtotime($search_result[0]->expired_date)) ?></small>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('agen/redeem_voucher') ?>" method="POST">
                                    <label>Nomor Resi</label>                            
                                    <input type="text" class="form-control" pattern="[A-Za-z0-9]{16}" maxlength="16" id="awb_no" title="Please enter a 16-character alphanumeric code"  name="resi" class="form-control" placeholder="Masukan Nomor Resi" required>
                                    <br>
                                    <input type="hidden" name="id" value="<?= $search_result[0]->id ?>">
                                    <button type="submit" class="btn btn-block btn-primary" name="gunakan_btn">Gunakan</button>
                                </form>

                                <?php if (isset($otp) && !empty($otp)): ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        OTP: <?= $otp; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>Kadaluarsa<p/>';
            }
        } else {
            // Tidak ada data ditemukan        
            echo '<div class="alert alert-info" role="alert">';
            echo '<center><span style="color: red;">Voucher </span>' . $search_keyword . '<span style="color: red;"> tidak Ditemukan atau sudah hangus</span></center>';
            echo '</div>';
        }
    }
    ?>
</div>
</div>
<script>
    function clearSearch() {
        document.getElementsByName("search_keyword")[0].value = '';
    }
</script>




<script>
    function hapus() {
        $('#search_keyword').val('');
    }
</script>

<!-- Bootstrap Notify -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
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