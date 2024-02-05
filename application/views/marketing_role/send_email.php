<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
<!-- select table -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Voucher Data</h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table id="emailTable" class="display" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>No</th>
                        <th>Nama Pengirim</th>
                        <th>Email</th>
                        <th>No Tlp</th>
                        <th>Harga Ongkir</th>
                        <th>AWB no</th>
                        <th>Service</th>
                        <th>E-Voucher</th>
                    </tr>
                </thead>
                <tbody id="dataBody">
                    <?php $counter = 1; ?>
                    <?php foreach ($voucher_data as $voucher): ?>
                        <tr>
                            <td></td> <!-- No Urut column will be filled dynamically in JavaScript -->
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

                        </tr>
                        <?php $counter++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Initialize DataTable with options
        var table = $('#dataTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,            
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

        // checkbox
        columnDefs: [
        {
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }
    ],
    select: {
        style: 'os',
        selector: 'td:first-child'
    },
    order: [[1, 'asc']]

    });
    
</script>

<!-- <script>

    let example = $('#emailTable').DataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        order: [
            [1, 'asc']
        ]
    });
    example.on("click", "th.select-checkbox", function () {
        if ($("th.select-checkbox").hasClass("selected")) {
            example.rows().deselect();
            $("th.select-checkbox").removeClass("selected");
        } else {
            example.rows().select();
            $("th.select-checkbox").addClass("selected");
        }
    }).on("select deselect", function () {
        ("Some selection or deselection going on")
        if (example.rows({
            selected: true
        }).count() !== example.rows().count()) {
            $("th.select-checkbox").removeClass("selected");
        } else {
            $("th.select-checkbox").addClass("selected");
        }
    });

</script> -->