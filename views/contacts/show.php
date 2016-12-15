<div>
<form>
    <div>
    <table id="index_table">
        <tr>
            <th></th>
            <th> <button type="button" class="sort">Last Name</button>
            <th> <button type="button" class="sort">First Name</button>
            <th> E-mail </th>
            <th> Cellular </th>
            <th> Actions </th>
        </tr>

        <?php
        $number =1;
            foreach ($this->data['contacts_data'] as $item => $value){
                    echo
                        '<tr>
                            <td><span>' . $number . '.</span></td>
                            <td><span>' . $value['last_name'] . '</span></td>
                            <td><span>' . $value['first_name'] . '</span></td>
                            <td><span>' . $value['email'] . '</span></td>
                            <td><span>' . $value['cell_phone'] . '</span></td>
                            <td>' . '<div><a href="'.URL.'Contacts/editContact/' . $value["id"] . '/"><div class="edit_button">edit</div></a>'
                                  . '   '
                                  . '<a href="'.URL.'Contacts/viewContact/' . $value["id"] . '/"><div class="view_button">view</div></a>
                                     <div class="delete_button"><a href="'.URL.'Contacts/deleteContact/' . $value["id"] . '/">&#10005</a></div>
                                     </div></td>
                          
                        </tr>';
                    $number++;
            }
        ?>
        <tr><td colspan="6"></td></tr>
    </table>
    </div>
</form>
    <div class="pagination" id="pagination_id">
        <div class="pagination_button_previous">
            <button type="button" id="prev_page" class="page">< prev</button>
        </div>
        <div class="pagination_button_123">
            <h8>page:</h8>
            <?php
            for ($i=1; $i<=$this->data['pagination_params']['var'] ; $i++) {
               ?>
              <button type="button" class="page" name=""><?=$i?></button>
            <?php
            }
            ?>
        </div>
        <div class="pagination_button_next">
            <button type="button" id="next_page" class="page">next ></button>
        </div>
<!--
    <div class="action_buttons">
        <a href="../../../../Contacts/randomContacts/<?=SORTING_PARAM_LAST?>/<?=SORTING_PARAM_FIRST?>/1/"> Random</a>
    </div>
-->
    </div>

</div>
