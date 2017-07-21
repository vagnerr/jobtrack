<!-- $Id: adddata.tpl,v 1.1.1.1 2003/06/02 21:40:11 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>

<form method="post" action="adddata.php" enctype="multipart/form-data">
 <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
 <input type="hidden" name="action" value="upload">
 <input type="hidden" name="ID" value="{$ID}">
 <table border="1">
  <tr>
   <td>Description: </td>
   <td><input type="text" name="Description" size="50"></td>
  </tr>
   <td>JobDataTypeID: </td>
   <td>
     <select name="JobDataType_ID">
       {section name=datatype loop=$JobDataTypeList}
       {strip}
         <option value="{$JobDataTypeList[datatype].ID}">
           {$JobDataTypeList[datatype].Description}
         </option>
       {/strip}
       {/section}
     </select>
   </td>
  </tr>
  <tr>
   <td>File: </td>
   <td><input type="file" name="FileName"></td>
  </tr>
  <tr>
   <td>Paste Content: </td>
   <td><textarea name="Data" rows="10" cols="50"></textarea></td>
  </tr>
  <tr>
   <TD colspan="2"><input type="submit" value="Upload"></td>
  </tr>
 </table>
</form>

{include file="skin:footer.tpl"}
