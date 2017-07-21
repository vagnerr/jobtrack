<!-- $Id: header.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

<html>
	<head>
		<title>Intranet Site / Job Applications / {$PageTitle|default:""}</title>
	</head>
	<body>
{include file="skin:menu.tpl"}
{if $LAST_RESULT_MESSAGE}
  {if $LAST_RESULT_TYPE == "OK"}
    <font color=#00FF00>
  {else}
    <font color=#FF0000>
  {/if}
  {$LAST_RESULT_MESSAGE}
  </font>
{/if}
