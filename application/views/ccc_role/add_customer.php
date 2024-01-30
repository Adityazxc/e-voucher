<!-- views/add_customer.php -->
<form action="<?php echo base_url('customer/add'); ?>" method="post">
    <label for="nama">Nama:</label>
    <input type="text" name="nama" required>

    <label for="age">Usia:</label>
    <input type="text" name="age" required>

    <button type="submit">Tambah Data</button>
</form>
