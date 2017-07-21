<!-- $Id: jsareport.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

<html>
        <head>
                <title>Intranet Site / Job Applications / {$PageTitle|default:""}</title>
        </head>
        <body>
<h1>{$PageTitle}</h1>

</table>                                                      
<center>                                                      
<strong>Dates:</strong>{$StartDate} -&gt; {$CurrentDate}&nbsp;&nbsp;&nbsp;&nbsp;
<strong>New Applications:</strong>{$total_record}                
</center>
<hr />

{include file="skin:jsajobtable.tpl"}

	</body>
</html>

