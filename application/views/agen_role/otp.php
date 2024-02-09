<style>
    body {
        background: #a569bd;
    }

    .text-color {
        color: #145a32;
    }

    .card {
        width: 350px;
        padding: 10px;
        border-radius: 20px;
        background: #d4efdf;
        border: none;
        position: relative;
    }

    .container {
        height: 100vh;
    }

    .mobile-text {
        color: #cd5c5c;
        font-size: 15px;
    }

    .form-control {
        margin-right: 12px;
    }

    .form-control:focus {
        color: #495057;
        background-color: #d4efdf;
        border-color: #c0392b;
        outline: 0;
        box-shadow: none;
    }

    .cursor {
        cursor: pointer;
    }
</style>
<html>



<div class="d-flex justify-content-center align-items-center continer">
    <div class="card py-5 px-3">
        <h5 class="m-0">Email verification</h5>
        <span class="mobile-text"><b>Masukan verification yang dikirimkan ke customer</b>
            <b class="text-color">adityaads623@gmail.com</b>
        </span>
        <div class="d-flex flex-row mt-5">

            <input type="text" id="first" class="form-control" autofocus="" />
            <input type="text" id="second" class="form-control" />
            <input type="text" id="third" class="form-control" />
            <input type="text" id="fourth" class="form-control" />
            <input type="text" id="fifth" class="form-control" />
            <input type="text" id="sixth" class="form-control" />
        </div>
        <div class="text-center mt-5">
            <button type="button" class="btn btn-primary" onclick="validateOTP()">Verifikasi</button>
            <span class="d-block mobile-text" id="countdown"></span>
            <span class="d-block mobile-text" id="resend"></span>
        </div>
    </div>
    id anda <?= $customer_id ?>
</div>



<!-- otp -->
<script>
    function validateOTP() {
        var firstDigit = $('#first').val();
        var secondDigit = $('#second').val();
        var thirdDigit = $('#third').val();
        var fourthDigit = $('#fourth').val();
        var fifthDigit = $('#fifth').val();
        var sixthDigit = $('#sixth').val();

        var enteredOTP = firstDigit + secondDigit + thirdDigit + fourthDigit + fifthDigit + sixthDigit;
        var id_customer = <?= $customer_id ?>;
        $.ajax({
            type: 'POST',
            url: '<?= base_url('agen/validate_otp') ?>',
            data: { id: id_customer, entered_otp: enteredOTP },
            success: function (response) {
                if (response == 'true') {
                    alert('OTP Valid!');
                    // Lakukan tindakan setelah validasi sukses (tutup modal, redirect, dll.)
                } else {
                    alert('OTP Invalid!');
                    // Lakukan tindakan setelah validasi gagal (mungkin menampilkan pesan kesalahan, dll.)
                }           
            },
            error: function (error) {
                // Tindakan yang dilakukan jika terjadi kesalahan
                console.error('Error validating OTP:', error);
                alert('Error validating OTP. Please try again.');
            }
        });
    }
</script>
<script>
    let timerOn = true;
    function timer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;
        m = m < 10 ? "0" + m : m;
        s = s < 10 ? "0" + s : s;
        document.getElementById("countdown").innerHTML = `Time left: ${m} : ${s}`;
        remaining -= 1;
        if (remaining >= 0 && timerOn) {
            setTimeout(function () {
                timer(remaining);
            }, 1000);
            document.getElementById("resend").innerHTML = '';
            return;
        }
        if (!timerOn) {
            return;
        }
        document.getElementById("resend").innerHTML = `Don't receive the code? 
        <span class="font-weight-bold text-color cursor" onclick="timer(60)">Resend
        </span>`;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const inputs = document.querySelectorAll('.form-control');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (event) => {
                const value = event.target.value.replace(/\D/g, '');
                event.target.value = value;
                if (value.length === 1) {
                    // Pindah fokus ke input berikutnya
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });

            // Tambah event listener untuk menghindari kursor bergerak ke belakang
            input.addEventListener('keydown', (event) => {
                if (event.key === 'Backspace' && index > 0) {
                    // Pindah fokus ke input sebelumnya saat tombol Backspace ditekan
                    inputs[index - 1].focus();
                }
            });
        });
    });

    timer(300);
</script>