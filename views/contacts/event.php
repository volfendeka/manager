<form action="<?= URL?>Contacts/createEvent/no/" method="post">
    <h4 class="inline">To:</h4>
    <input type="textfield" id="send_field" name="send"
           value="<?= isset($this->data['checked_emails']) ? $string = implode(',', $this->data['checked_emails']) : ''?>" >

    <a href="<?= URL?>Contacts/selectEmails/<?=SORTING_PARAM_LAST."/".SORTING_PARAM_FIRST?>/1/no/"> Add contacts from the list</a><br><br> <br>
    <input type="submit" id="send_submit" name="submit_send" value="Send">
</form>
