<?php
require_once dirname(__FILE__) . '/db.php';

$current_msg = '';
if (!empty($_POST['CurrentMsgIdOut'])) {
    $current_msg_id_out = $_POST['CurrentMsgIdOut'];
    if (is_numeric($current_msg_id_out)) {
        $current_msg_fetch = $conn->query("SELECT * FROM outgoing WHERE id = $current_msg_id_out");
        $current_msg = mysqli_fetch_assoc($current_msg_fetch);
    }
}
$conn->close();
?>
<!-- Form for view message  -->
<div class="modal fade" id="view_msg" tabindex="-1" role="dialog" aria-labelledby="View message">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Просмотр сообщения</h4>
            </div>
            <div class="modal-body">
                <h5><strong>Получатель</strong></h5>
                <div class="well well-sm">
                    <span><?php echo $current_msg['destination']; ?></span>
                </div>

                <h5><strong>Тема письма</strong></h5>
                <div class="well well-sm">
                    <span><?php echo $current_msg['subject'] ?></span>
                </div>

                <h5><strong>Текст сообщения</strong></h5>
                <?php
                if (empty($current_msg['text_message'])) : ?>
                    <div class="alert alert-info" role="alert">Текст письма не был указан...</div>
                <?php else : ?>
                    <div class="well text-justify">
                        <span><?php echo $current_msg['text_message']; ?></span>
                    </div>
                <?php endif; ?>

                <div class="text-right">
                    <small><em>Отправлено: <?php echo $current_msg['departure_date'] ?></em></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel">Закрыть</button>
            </div>
        </div>
    </div>
</div>