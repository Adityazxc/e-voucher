<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" action="<?php echo base_url()?>" method="post" enctype="multipart/form-data" role="form">
            <div class="modal-body">
                <!-- Form to add customer data -->
                <form id="addCustomerForm">
                  

                    <!-- Add more form fields as needed -->
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- <script>
$(document).ready(function() {
    // Menangani klik tombol "Add"
    $('#btnAddCustomer').click(function() {
        // Mengambil data dari form
        var formData = $('#addCustomerForm').serialize();

        // Mengirim data ke server menggunakan Ajax
        $.ajax({
            url: 'ccc/add_customer', // Ganti dengan URL controller Anda
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle response dari server (jika perlu)
                console.log(response);

                // Refresh halaman atau lakukan operasi lain sesuai kebutuhan
                window.location.reload();
            },
            error: function(error) {
                // Handle error (jika perlu)
                console.log(error);
            }
        });
    });
});
</script> -->

<!-- format rupiah -->
<!-- <script type="text/javascript">
var rupiah = document.getElementById('ongkir');
rupiah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, 'Rp. ');
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script> -->

  <!-- Add your form fields here (e.g., name, email, etc.) -->
                    <!-- <div class="form-group">
                        <label for="customerName">Name Pengirim:</label>
                        <input type="text" class="form-control" id="customerName" name="customerName" required>
                    </div>
                    <div class="form-group">
                        <label for="id_customer">Id Customer:</label>
                        <input type="text" class="form-control" id="id_customer" name="id_customer" required>
                    </div>
                    <div class="form-group">
                        <label for="awb_no">No Awb:</label>
                        <input type="text" class="form-control" id="awb_no" name="awb_no" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="no_tlp">No Telepon</label>
                        <input type="number" class="form-control" id="no_tlp" name="no_tlp" required>
                    </div>
                    <div class="form-group">
                        <label for="ongkir">Harga Ongkir</label>
                        <input type="text" class="form-control" id="ongkir" name="ongkir" required>
                    </div>

                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" required min="1">
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <input type="number" class="form-control" id="weight" name="weight" required min="1">
                    </div>
                    <div class="form-group">
                        <label for="service">Service</label>
                        <select class="form-control" id="service" name="service" required>
                            <option value="ctc">CTC</option>
                            <option value="ctc_yes">CTC Yes</option>
                        </select>
                    </div> -->
