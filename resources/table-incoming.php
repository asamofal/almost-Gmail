<?php
require_once dirname(__FILE__) . '/db.php';

$incoming_fetch = $conn->query("SELECT * FROM incoming");
$conn->close();

$incoming_mails = [];
while ($row_email = mysqli_fetch_assoc($incoming_fetch)) {
    $incoming_mails[] = $row_email;
}
?>
<section class="email_list tab-pane" id="content_incoming" role="tabpanel">
    <table class="table table-bordered table-hover sortable-theme-bootstrap" id="table_incoming" data-sortable>
        <thead>
        <tr>
            <th class="text-center" data-sortable="false">
                <input type="checkbox" id="selectAll">
            </th>
            <th class="text-center">Отправитель</th>
            <th class="text-center">Тема письма</th>
            <th class="text-center">Дата получения</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($incoming_mails)) :
            foreach ($incoming_mails as $incoming_mail) { ?>
                <tr id="row-<?php echo $incoming_mail['uid']; ?>">
                    <td class="text-center">
                        <input type="checkbox" name="email_row[]" form="delete"
                               value="<?php echo $incoming_mail['uid']; ?>">
                    </td>
                    <td class="view-msg-link" data-toggle="modal" data-target="#view_msg">
                        <span><?php echo $incoming_mail['sender']; ?></span>
                    </td>
                    <td class="view-msg-link" data-toggle="modal" data-target="#view_msg">
                        <span>
                            <?php
                            $subject = $incoming_mail['subject'];
                            if (strlen($subject) > 80) {
                                $subject = mb_substr($subject, 0, 80, 'UTF-8') . '...';
                            }
                            echo $subject;
                            ?>
                        </span>
                    </td>
                    <td class="view-msg-link text-center" data-toggle="modal" data-target="#view_msg">
                        <span><?php echo date('Y-m-d H:i:s', strtotime($incoming_mail['receiving_date'])); ?></span>
                    </td>
                </tr>
            <?php }
        else: ?>
            <tr class="info">
                <td colspan="4"><h4 class="text-center">Архив полученных писем пуст :(</h4></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</section>