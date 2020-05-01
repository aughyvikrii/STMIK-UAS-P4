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
            <div class="col-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <strong class="text-center">
                            <?= heading($judulapp,4); ?>
                        </strong>
                        <br>
                        <div class="col-12">
                            <form method="post" action="<?= base_url('/calendar/tambah_agenda/'.$year.'/'.$month.'/'.$day) ?>" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="nama_agenda" class="">Nama Agenda</label>
                                    <div class="col-sm-9">
                                        : <?= $data[0]->nama ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nama_agenda" class="">Nama File</label>
                                    <div class="col-sm-9">
                                        : <a href="<?= base_url('assets/upload/'. $data[0]->file ) ?>"><?= $data[0]->file ?></a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nama_agenda" class="">
                                    <a href="<?= base_url("/calendar/agenda/{$year}/{$month}/{$day}?edit=true") ?>" class="btn btn-sm btn-warning">Edit Data</a>
                                    </label>
                                </div>

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('/assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>