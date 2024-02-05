
<h1>Voucher Data</h1>

<!-- <label for="fromDate">From:</label>
<input type="date" id="fromDate" name="fromDate">
<label for="thruDate">Thru:</label>
<input type="date" id="thruDate" name="thruDate"> -->
<div class="md-form md-outline input-with-post-icon datepicker" id="customDays">
    <input placeholder="Select date" name="fromDate" type="date" id="fromDate" class="form-control">
    <label for="thruDate">Thru:</label>
    <input placeholder="Select date" name="thruDate" type="date" id="thruDate" class="form-control">
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>
<script>
    $('.datepicker').datepicker({
      weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
      showMonthsShort: true
    })
</script>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Voucher Data</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Urut</th>
                        <th>Nama Pengirim</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Harga</th>
                        <th>AWB no</th>
                        <th>Service</th>
                    </tr>
                </thead>
                <tbody>
                <?php $counter = 1; ?>
        <?php foreach ($voucher_data as $voucher): ?>
        <tr>
            <td></td> <!-- No Urut column will be filled dynamically in JavaScript -->
            <td>
                <?php 
                                        echo $voucher->customer_name                                         
                                        ?>
            </td>
            <td>
                <?php
                                         echo $voucher->email;                                         
                                          ?>
            </td>
            <td>
                <?php 
                                        echo $voucher->no_hp;                                         
                                        ?>
            </td>
            <td>
                <?php 
                                        echo $voucher->harga; 
                                        ?>
            </td>
            <td>
                <?php 
                                        echo $voucher->awb_no; 
                                        ?>
            </td>
            <td>
                <?php 
                                        echo $voucher->service; 
                                        ?>
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
$(document).ready(function() {
    // Initialize DataTable with options
    var table = $('#voucherTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "responsive": true
    });

    // Custom rendering for No Urut column
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Add date range filtering functionality
    $('#fromDate, #thruDate').on('change', function() {
        var fromDate = $('#fromDate').val();
        var thruDate = $('#thruDate').val();

        // Convert the format of fromDate and thruDate to match the database format
        fromDate = fromDate.split('/').reverse().join('-');
        thruDate = thruDate.split('/').reverse().join('-');

        // Change the column index to match the correct column for date filtering
        table.columns(3).search(fromDate + '|' + thruDate, true, false).draw();
    });
});
</script>