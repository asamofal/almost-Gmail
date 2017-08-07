 <div class="modal fade" id="create_msg" tabindex="-1" role="dialog" aria-labelledby="Create message">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title">Новое сообщение</h4>
       </div>
       <form action="resources/insert.php" method="POST" id="create_msg">
         <div class="modal-body">
           <div class="form-group" id="destination_form">
             <label for="destination">Получатель</label>
             <input type="email" class="form-control" id="destination" name="destination" placeholder="Введите Email получателя" minlength="4" maxlength="254">
           </div>
           <div class="form-group">
               <label for="subject">Тема письма</label>
               <input type="text" class="form-control" id="subject" name="subject" placeholder="Введите тему сообщения" maxlength="70">
           </div>
           <div class="form-group">
               <label for="text_message">Текст сообщения</label>
               <textarea class="form-control" id="text_message" name="text_message" rows="5" placeholder="Введите текст сообщения"></textarea>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">Отменить</button>
           <button type="submit" class="btn btn-primary" id="send">Отправить</button>
         </div>
       </form>
     </div>
   </div>
 </div>