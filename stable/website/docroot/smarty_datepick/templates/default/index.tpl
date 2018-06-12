{* Smarty *}
<html>
<body bgcolor="#bbbbbb" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<center>
<form name=datepick method=get action="index.php" onSubmit="javascript:submitform();">
<table border=0 cellspacing=0 bgcolor=#d3d3d3>
<tr bgcolor=#bbbbbb>
	<td nowrap align=center colspan=7>
		<select name=curr_month onChange="javascript:submitform();">
			{html_options values=$month_vals selected=$curr_date|safe_date_format:"%m" output=$month_names}
		</select>
		<input type=text name=curr_year value="{$curr_date|safe_date_format:"%Y"}" size=4
			onBlur="javascript:submitform();">
		<input type=hidden name=date value="">
	</td>
</tr>
<tr bgcolor=#d3d3d3>
	<td>
		<TT>Su</TT>
	</td>
	<td>
		<TT>Mo</TT>
	</td>
	<td>
		<TT>Tu</TT>
	</td>
	<td>
		<TT>We</TT>
	</td>
	<td>
		<TT>Th</TT>
	</td>
	<td>
		<TT>Fr</TT>
	</td>
	<td>
		<TT>Sa</TT>
	</td>
</tr>
{foreach from=$cal_array item=row}
	<tr bgcolor=#e0e0e0>
	{foreach name=row_loop from=$row item=col}
		{if $curr_date|safe_date_format:"%m" eq $col|safe_date_format:"%m"}
			{assign var="bgcolor" value="#e0e0e0"}
		{else}
			{assign var="bgcolor" value="#bbbbbb"}
		{/if}
		<td bgcolor="{$bgcolor}" valign=top>
			{if $type eq "dropdown"}
				<TT><a href="javascript:populateDate(parseInt('{$col|safe_date_format:"%Y"}'), parseInt('{$col|safe_date_format:"%m"}',10), parseInt('{$col|safe_date_format:"%d"}',10)); window.close();">{$col|safe_date_format:"%d"}</a></TT>
			{else}
				<TT><a href="javascript:window.opener.argDate.value='{$col|safe_date_format:"%Y-%m-%d"}'; window.close();">{$col|safe_date_format:"%d"}</a></TT>			
			{/if}
		</td>		
	{/foreach}
	</tr>
{/foreach}
</table>
<input type=hidden name=type value="{$type}">
<input type=hidden name=theme value="{$theme}">
</form>
</center>
</body>
{literal}
<script language="javascript">
<!--
function submitform() {
document.datepick.date.value=document.datepick.curr_year.value + '-' + document.datepick.curr_month.options[document.datepick.curr_month.selectedIndex].value + '-01';
document.datepick.submit();
}
// -->
</script>
{/literal}
{if $type eq "dropdown"}
{literal}
<script language="javascript">
<!--
function populateDate(year, month, day) {
	wo = window.opener;
	selectDropDown(wo.argYear, year);
	selectDropDown(wo.argMonth, month);
	selectDropDown(wo.argDay, day);
}

function selectDropDown(control,value) {
	if(control) {
		for(i=0; i < control.options.length;i++) {
			if(control.options[i].value == value)
				control.selectedIndex = i;
		}
	}
}
// -->
</script>
{/literal}
{/if}
</html>
