<?php

// week starts on Sunday
define('DATE_CALC_BEGIN_WEEKDAY', 0);
require("../../configs/common_setup.php");

require("Date/Calc.php");
//require("Smarty.class.php");

if(empty($_GET['date']) || !preg_match('!^\d{4}\-\d{1,2}\-\d{1,2}$!',$_GET['date'])) {
	$date = Date_Calc::dateNow("%Y-%m-%d");
} else {
	$date = $_GET['date'];
}

$month = substr($date,5,2);
$year = substr($date,0,4);

$cal_array = Date_Calc::getCalendarMonth($month,$year,"%Y-%m-%d");

$smarty = new Smarty;
$smarty->assign('cal_array',$cal_array);
$smarty->assign('curr_date',$date);
$smarty->assign('type',$_REQUEST['type']);
$theme = (isset($_REQUEST['theme']) && is_dir($smarty->template_dir.'/'.$_REQUEST['theme'])) ? $_REQUEST['theme'] : 'default';

$smarty->assign('theme',$theme);
$month_names = get_month_names('%b');
// fix array index numbers
array_unshift($month_names,'foo');
array_shift($month_names);
$smarty->assign('month_names',$month_names);
$smarty->assign('month_vals',array('01','02','03','04','05','06','07','08','09','10','11','12'));

$smarty->assign('last_month',Date_Calc::beginOfPrevMonth(1,$month,$year,"%Y-%m-%d"));
$smarty->assign('next_month',Date_Calc::beginOfNextMonth(1,$month,$year,"%Y-%m-%d"));
$smarty->assign('last_year',Date_Calc::dateFormat(1,$month,$year-1,"%Y-%m-%d"));
$smarty->assign('next_year',Date_Calc::dateFormat(1,$month,$year+1,"%Y-%m-%d"));

$smarty->register_modifier('safe_date_format','datepick_date_format');

$smarty->display("$theme/index.tpl");

function get_month_names($format='%B') {
	for($i=1;$i<13;$i++){
    	$months[$i-1] = strftime($format, mktime(0, 0, 0, $i, 1, 2001));
	}
	return($months);	
}

function datepick_date_format($date,$format) {
	$date_array = explode('-',$date);
	return Date_Calc::dateFormat($date_array[2],$date_array[1],$date_array[0],$format);
}

?>
