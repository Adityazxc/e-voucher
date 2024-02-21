<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title?></title>

    <?php include 'template/header.php' ?>

</head>
<style>
    .hover-effect:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease; /* Menambahkan transisi agar efek lebih halus */
}
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'widgets/sidebar.php'?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'widgets/topbar.php'?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- create session web -->
                    <?php include $this->session->userdata('pages').'/'.$page_name.'.php'?>

                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; E-Voucher 2024 version 1.1</span>
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

<?php include 'template/bottom.php' ?>

<script>
    var idleTime=0;
    var logoutTime=1800;

    function countdown(){
        idleTime++;
        if(idleTime === logoutTime){
            alert("Anda telah logout otomatis karena tidak aktif.");
            window.location.href='<?= base_url("auth/logout")?>';
        }
    }

    function resetTimer(){
        idleTime =0;
    }

    
    // Atur timer untuk menghitung mundur
    var countdownInterval = setInterval(countdown, 1000);
    
    document.addEventListener('mousemove',resetTimer);
    document.addEventListener('keydown',resetTimer);
</script>
</html>