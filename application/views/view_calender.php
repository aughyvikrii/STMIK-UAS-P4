<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judulapp; ?></title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.min.css') ?>">
    <style>
        body,html {
            height: 100%;
        }
    </style>
</head>
<body style="background-repeat: no-repeat;background-size: 100%;background-image:url(<?= base_url('/assets/img/bg.jpg') ?>)">
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-body text-center">
                        <strong>
                            <?= heading($judulapp,4); ?>
                        </strong>
                        <br>
                        <div class="col-12">
                            <?php  if( $this->session->flashdata('success') == TRUE ){ ?>
                                <div class="alert alert-success">
                                    <?php echo $this->session->flashdata('success') ?>
                                </div>
                            <?php } ?>

                            <center>
                                <?= $varkal; ?>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('/assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>