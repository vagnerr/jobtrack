<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     datepick
 * Purpose:  for use with datepick miniapp.
 *			 pick dates from calendar and populate forms.
 * Input:	form: the name of the form (required)
 *			field: the name of the form field(s) to populate.
 *			This can be one of two formats: a single text field,
 *			or a triple year/month/day dropdown created by
 *			{html_select_date}. If left blank, it is assumed that
 *			that it will use the default format of {html_select_date}
 *	Examples:
 *			<form name="myForm">
 *
 *			{html_select_date}
 *			{datepick form="myForm"}
 *
 *			{html_select_date prefix="myDate"}
 *			{datepick form="myForm" field="myDate_Year,myDate_Month,myDate_Day"}
 *
 *			<input type=text name="curr_date" size=10>
 *			{datepick form="myForm" field="curr_date"} {* single text field *}
 *
 *			</form>
 * -------------------------------------------------------------
 */
function smarty_function_datepick($params, &$smarty)
{
    // be sure equation parameter is present
    if (empty($params["form"])) {
        $smarty->trigger_error("datepick: missing form parameter");
        return;
    }
	extract($params);

	if(empty($theme)) {
		$theme = 'default';
	}
		
	if(strstr($field,',')) {
		// dropdown fields
		$date_fields = explode(',',$field);
		echo '<a href="javascript:void(0)" onclick="javascript:datepick3(\''.$theme.'\',document.'.$form.'.'.$date_fields[0].',document.'.$form.'.'.$date_fields[1].',document.'.$form.'.'.$date_fields[2].')"><img src="smarty_datepick/images/'.$theme.'/cal_icon.gif" width="21" height="22" border="0"></a>';
	} elseif ( empty($field)) {
		// dropdown default
		echo '<a href="javascript:void(0)" onclick="javascript:datepick3(\''.$theme.'\',document.'.$form.'.Date_Year,document.'.$form.'.Date_Month,document.'.$form.'.Date_Day)"><img src="smarty_datepick/images/'.$theme.'/cal_icon.gif" width="21" height="22" border="0"></a>';		
	} else {
		// text field
		echo '<a href="javascript:void(0)" onclick="javascript:datepick(\''.$theme.'\',document.'.$form.'.'.$field.')"><img src="smarty_datepick/images/'.$theme.'/cal_icon.gif" border=0></a>';
	}
}

/* vim: set expandtab: */

?>
