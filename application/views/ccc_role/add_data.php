<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard Adit</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url('public/vendor/fontawesome-free/css/all.min.css'); ?>">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/sb-admin-2.min.css'); ?>">

    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    <!-- Modal-->    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php $this->load->view('widgets/sidebar'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                <?php $this->load->view('widgets/topbar'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Data</h1>
                    </div>


                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">
                        Add Customer
                    </button>

                    <button>import excel</button>

                    <!-- Modal -->
                    <?php $this->load->view('ccc_role/modal_add_data'); ?>

                    <table id="voucherTable" class="table table-striped table-bordered" border="1">
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
                                        // echo $voucher->customer_name 
                                        echo $voucher->id_customer 
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        //  echo $voucher->email;
                                         echo $voucher->name;
                                          ?>
                                    </td>
                                    <td>
                                        <?php 
                                        // echo $voucher->no_hp; 
                                        echo $voucher->age; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        // echo $voucher->harga; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        // echo $voucher->awb_no; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        // echo $voucher->service; 
                                        ?>
                                    </td>
                                </tr>
                                <?php $counter++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

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

                    });
                    </script>

                </div>
                <!--end Data Table  -->

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>




</body>

</html>