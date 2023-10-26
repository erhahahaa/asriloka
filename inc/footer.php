<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-6 p-4">
            <a href="https://kampusmerdeka.kemdikbud.go.id/ "><img class="me-4" src="./assets/images/logoKM.png"
                    width="20%" alt=""></a>
            <a href="https://www.upnjatim.ac.id/"><img src="./assets/images/logoUpn.png" width="20%" alt=""></a>
            <a href="https://asriloka.my.id/"><img src="./assets/images/logoAW.png" width="20%" alt=""></a>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>

<p class="text-center bg-dark text-white p-3 m-0">Copyright &copy;2023; Designed by <span class="designer">XXXXXX</span>
</p>

<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php if (@$_SESSION['sukses']) { ?>
    <script>
        swal("Berhasil!", "<?php echo $_SESSION['sukses']; ?>", "success");
    </script>
    <?php unset($_SESSION['sukses']);
} ?>
<?php if (@$_SESSION['gagal']) { ?>
    <script>
        swal("Gagal!", "<?php echo $_SESSION['gagal']; ?>", "error");
    </script>
    <?php unset($_SESSION['gagal']);
} ?>