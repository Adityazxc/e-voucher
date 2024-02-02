<thead>
    <tr>
        <th>No</th>
        <th>Nama Pengirim</th>
        <th>Email</th>
        <th>No. Telepon</th>
        <th>Harga</th>
        <th>AWB no</th>
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

<script>
    $(document).ready(function () {
        // Initialize DataTable with options
        var table = $('#dataTable').DataTable({
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