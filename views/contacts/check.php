<table id="check_table">
 <tr>
  <th> </th>
  <th> <input type="checkbox"  id="check_all">
  <th> <button type="button" class="sort">last name</button>
  <th> <button type="button" class="sort">first name</button>
  <th> E-Mail </th>
 </tr>
  <?php
  $number =1;
  $check ="";
  foreach ($this->data['contacts']['contacts_data'] as $item => $value){
   echo
       '<tr>  
                        <td><span>' . $number . '.</span></td>
                        <td><span>    <input type="checkbox" class="checkboxes" value="' . $value['id'] . '"></span></td>
                        <td><span>' . $value['last_name'] . '</span></td>
                        <td><span>' . $value['first_name'] . '</span></td>
                        <td><span>' . $value['email'] . '</span></td>'.
       '</tr>';
   $number++;
  }
  ?>
    <tr><td colspan="5"></td></tr>
</table>
 <div class="pagination" id="pagination_id">
  <div class="pagination_button_previous">
      <button type="button" id="prev_page" class="page">< prev</button>
  </div>
  <div class="pagination_button_123">
      <h8>page:</h8>
      <?php
      for ($i=1; $i<=$this->data['contacts']['pagination_params']['var'] ; $i++) {
          ?>
          <button type="button" class="page" name=""><?=$i?></button>
          <?php
      }
      ?>
  </div>
  <div class="pagination_button_next">
      <button type="button" id="next_page" class="page">next ></button>
  </div>
 </div>
</form>
