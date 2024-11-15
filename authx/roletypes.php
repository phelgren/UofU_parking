<?php
  function listtypes($value){

  $selected = "";
  // So this is basically a "cheat".  We know there are only 4 role types but the better solution would be a role type table we read through to get the list
  $roles = array('student','faculty','admin','guest');

  $content = "";

  foreach($roles as $role)
  {

    if($role != '' && $role== $value) 
        $selected = "selected";
    else
        $selected = "";

     $content = $content. "<option name='roleType' value='$role' $selected > $role </option>";

  }

  return $content;

}
  ?>