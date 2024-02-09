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

    .card.py-5.px-3 {
        border: none;
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

<head>



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<!-- The Modal -->

<div class="modal" id="myModal">
    <div class="modal-dialog" style="max-width : 350px;">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body d-flex justify-content-center align-items-center continer">
                <div class="card py-5 px-3">
                    <h5 class="m-0">Email verification</h5>
                    <span class="mobile-text"><b>Masukan verification yang dikirimkan ke customer</b>
                        <b class="text-color">adityaads623@gmail.com</b>
                    </span>
                    <div class="d-flex flex-row mt-5">
                        <input type="text" class="form-control" id="first" autofocus="" />
                        <input type="text" class="form-control" id="second" />
                        <input type="text" class="form-control" id="third" />
                        <input type="text" class="form-control" id="fourth" />
                        <input type="text" class="form-control" id="fifth" />
                        <input type="text" class="form-control" id="sixth" />

                    </div>
                    <div class="text-center mt-5">
                        <button type="button" class="btn btn-primary" onclick="submitAndShowModal()">Gunakan</button>
                        <span class="d-block mobile-text" id="countdown"></span>
                        <span class="d-block mobile-text" id="resend"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


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
        const inputs = document.querySelectorAll('.modal .form-control');

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

    timer(100);
</script>

<script>
    function submitAndShowModal() {
        // Mengumpulkan data dari form atau sesuaikan sesuai kebutuhan
        var formData = {
            id: $('#id').val(), // Sesuaikan dengan ID input form
            // ... tambahkan data lain yang diperlukan
        };

        // Mengirim data ke server menggunakan AJAX
        $.ajax({
            type: 'POST',
            url: '<?= base_url('agen/reedem_voucher') ?>',
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Menampilkan modal setelah submit
                    $('#myModal').modal('show');
                } else {
                    // Handle kasus gagal jika diperlukan
                    alert('Gagal redeem voucher. ' + response.message);
                }
            },
            error: function (error) {
                console.error('Error submitting form:', error);
                alert('Error submitting form. Please try again.');
            }
        });
    }
</script>