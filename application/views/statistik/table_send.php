<thead>
    <tr>
        <th>No</th>
        <th>Nama Pengirim</th>
        <th>Email</th>
        <th>No. Telepon</th>
        <th>Harga</th>
        <th>AWB no</th>
        <th>Service</th>
        <th>Voucher</th>
        <th>Diskon</th>
        <th>Expired</th>
        <th>status</th>
    </tr>
</thead>
<tbody id="dataBody">
    <?php $counter = 1; ?>
    <?php foreach ($voucher_data as $voucher): ?>
        <tr>
            <td></td> <!-- No Urut column will be filled dynamically in JavaScript -->
            <td>
                <?php echo $voucher->customer_name ?>

            </td>
            <td>
                <?php echo $voucher->email; ?>
            </td>
            <td>
                <?php echo $voucher->no_hp; ?>

            </td>
            <td>
                <?php echo $voucher->harga; ?>
            </td>
            <td>
                <?php echo $voucher->awb_no; ?>


            </td>
            <td>
                <?php echo $voucher->service; ?>

            </td>
            <td>
                <?php echo $voucher->voucher; ?>

            </td>
            <td>
                <?php echo $voucher->value_voucher; ?>

            </td>
            <td>
                <?php echo $voucher->expired_date; ?>

            </td>
            <td>
                <?php
                if ($voucher->status == 'N') {
                    echo 'Belum Dipakai';
                } else if ($voucher->status == 'Y') {
                    echo 'Telah dipakai';
                }
                ?>

            </td>
        </tr>
        <?php $counter++; ?>
    <?php endforeach; ?>
</tbody>

