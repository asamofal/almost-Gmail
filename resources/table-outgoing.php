<?php
require_once 'db.php';

$outgoing_fetch = $conn->query("SELECT * FROM outgoing");
$conn->close();

$outgoing_mails = [];
while ($row_email = mysqli_fetch_assoc($outgoing_fetch)) {
    $outgoing_mails[] = $row_email;
}
?>
<section class="email_list tab-pane" id="content_outgoing" role="tabpanel">
    <table class="table table-bordered table-hover sortable-theme-bootstrap" id="table_outgoing" data-sortable>
        <thead>
        <tr>
            <th class="text-center" data-sortable="false">
                <input type="checkbox" id="selectAll">
            </th>
            <th class="text-center">Получатель</th>
            <th class="text-center">Тема письма</th>
            <th class="text-center">Дата отправки</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($outgoing_mails)) :
            foreach ($outgoing_mails as $outgoing_mail) { ?>
                <tr id="row-<?php echo $outgoing_mail['id']; ?>">
                    <td class="text-center">
                        <input type="checkbox" name="email_row[]" form="delete"
                               value="<?php echo $outgoing_mail['id']; ?>">
                    </td>
                    <td class="view-msg-link" data-toggle="modal" data-target="#view_msg">
                        <span><?php echo $outgoing_mail['destination']; ?></span>
                    </td>
                    <td class="view-msg-link" data-toggle="modal" data-target="#view_msg">
                        <span><?php echo $outgoing_mail['subject']; ?></span>
                    </td>
                    <td class="view-msg-link text-center" data-toggle="modal" data-target="#view_msg">
                        <span><?php echo $outgoing_mail['departure_date']; ?></span>
                    </td>
                </tr>
            <?php }
        else: ?>
            <tr class="info">
                <td colspan="4"><h4 class="text-center">Архив отправленных писем пуст :(</h4></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</section>