<thead>
    <tr>
        <th>No</th>
        <th>Nama Pengirim</th>
        <th>Email</th>
        <th>No Telepon</th>
        <th>Harga</th>
        <th>AWB no</th>
        <th>Service</th>
        <th>E-Voucher</th>

    </tr>
</thead>
<tbody id="dataBodyClaimed">
    <?php $counter = 1; ?>
    <?php foreach ($used_vouchers as $voucher): ?>
        <tr>
            <td>
                <?php echo $counter; ?>
            </td>
            <td>
                <?php echo $voucher->customer_name; ?>
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
        </tr>
        <?php $counter++; ?>
    <?php endforeach; ?>
</tbody>

<script>
    $(document).ready(function () {
        // Initialize DataTable with options
        var table = $('#tableDigunakan').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true
        });
        // Custom rendering for No Urut column
        table.on('order.dt search.dt', function () {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    });
</script>