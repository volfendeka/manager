<table>
 <tr>
  <th><a href="<?= URL?>Contacts/saveNewEmails/<?= $this->params['checked']['addr']?>">all</a></th>
  <th> <h5>№</h5> </th>
  <th> <h5>E-Mail</h5> </th>
 </tr>
 <form action="" method="post" >
  <?php
  $number =1;
  foreach ($this->data as $value ){
   echo
       '<tr>  
                     <td>' . '<input type="checkbox" name="add[]" value="' .$value. '" '.$this->params['checked']['box'].' > ' . '</td>  
                     <td>' . $number . '</td>
                     <td>' . $value . '</td>'.
       '</tr>';
   $number ++;
  }
  ?>
</table>
<input type="submit" name="insert_email" value="add"> </input>
</form>

<form action="<?= URL?>Contacts/createEvent/" method="post" >
 <input type="submit" name="cancel" value="cancel"> </input>
</form>