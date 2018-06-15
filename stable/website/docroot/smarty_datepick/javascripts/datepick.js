var argDate;
var argYear;
var argMonth;
var argDay;
function datepick(theme,field) {
	argYear = '';
	argMonth = '';
	argDay = '';
	argDate = field;
	open('smarty_datepick/index.php?type=textfield&theme='+theme+'&date='+argDate.value,'datepick','width=200,height=200');
}
function datepick3(theme,field1,field2,field3) {
	argYear = field1;
	argMonth = field2;
	argDay = field3;
	argDate = '';
	open('smarty_datepick/index.php?type=dropdown&theme='+theme+'&date='+argYear.options[argYear.selectedIndex].value+'-'+argMonth.options[argMonth.selectedIndex].value+'-'+argDay.options[argDay.selectedIndex].value,'datepick','width=200,height=200');
}
