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
            <form class="form-horizontal" id='addCustomer' action="<?php echo base_url('ccc/add_data');?>" method="post" enctype="multipart/form-data"
                role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customerName">Name Pengirim:</label>
                        <input type="text" class="form-control" id="customerName" name="customerName" required>
                    </div>                             
                    <div class="form-group">
                        <label for="awb_no">No Awb:</label>
                        <input type="text" class="form-control" pattern="\d{16}" id="awb_no" title="Please enter a 16-digit number"name="awb_no" required>
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
                        <label for="service">Service</label>
                        <select class="form-control" id="service" name="service" required>
                            <option value="ctc">CTC</option>
                            <option value="ctc_yes">CTC Yes</option>
                        </select>
                    </div>


                    <!-- Add more form fields as needed -->
                    <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
</div>
</div>



<!-- format rupiah -->
 <script type="text/javascript">
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
</script> 

