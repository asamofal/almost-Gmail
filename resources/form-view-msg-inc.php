<?php
require_once dirname(__FILE__) . '/db.php';

$current_msg = '';
if (!empty($_POST['CurrentMsgIdInc'])) {
    $current_msg_id_inc = $_POST['CurrentMsgIdInc'];
    if (is_numeric($current_msg_id_inc)) {
        $current_msg_fetch = $conn->query("SELECT * FROM incoming WHERE uid = $current_msg_id_inc");
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
                <h5><strong>Отправитль</strong></h5>
                <div class="well well-sm">
                    <span><?php echo $current_msg['sender']; ?></span>
                </div>
                
                <h5><strong>Тема письма</strong></h5>
                <div class="well well-sm">
                    <span><?php echo $current_msg['subject'] ?></span>
                </div>
                
                <h5><strong>Текст сообщения</strong></h5>
                <?php
                if (empty($current_msg['text_message'])) : ?>
                    <div class="alert alert-danger" role="alert">Упс! HTML формат письма не обрабатывается...</div>
                <?php else : ?>
                <div class="well text-justify">
                    <span><?php echo $current_msg['text_message']; ?></span>
                </div>
                <?php endif; ?>
                <div class="text-right">
                    <small><em>Получено: <?php echo $current_msg['receiving_date'] ?></em></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel">Закрыть</button>
            </div>
        </div>
    </div>
</div>