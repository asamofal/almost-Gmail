<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>almost Gmail</title>
    <link href="inc/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" id="buttons-group">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create_msg">Написать
                    письмо
                </button>
                <form action="resources/delete.php" method="POST" id="delete">
                    <button type="submit" class="btn btn-danger" id="btn_delete">Удалить выбранные письма</button>
                </form>
                <button type="button" class="btn btn-default" id="refresh" title="Синхронизировать ящик">
                    <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                </button>
                
              <?php include "resources/form-create-msg.php"; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <aside id="nav">
                    <h4 class="text-center">Почта</h4>
                    <hr>
                    <ul class="nav nav-sidebar nav-pills nav-stacked" role="tablist">
                        <li class="active"><a href="#" role="tab" id="btn_nav_incoming">Входящие</a></li>
                        <li><a href="#" role="tab" id="btn_nav_outgoing">Исходящие</a></li>
                    </ul>
                </aside>
            </div>
            <div class="col-md-9" id="main_content">
                <?php include "resources/table-incoming.php"; ?>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="inc/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <!-- https://github.com/HubSpot/sortable  -->
    <script src="inc/sortable-0.8.0/js/sortable.min.js"></script>
    <!-- https://github.com/malsup/blockui -->
    <script src="inc/jquery.blockUI/jquery.blockUI.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>