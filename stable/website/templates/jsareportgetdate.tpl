<!-- $Id: jsareportgetdate.tpl,v 1.1.1.1 2003/06/02 21:35:38 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>
<script src="smarty_datepick/javascripts/datepick.js" language="javascript"></script>
<form name="dateform" action="jsareport.php">
	Enter Date of last signon Session:
	<input type="text" name="Date">{datepick form="dateform" field="Date"}
	<input type="submit" value="Get Report">
</form>


{include file="skin:footer.tpl"}		
