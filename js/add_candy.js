function add_qual()
{
	var qualif=document.add_candy.qualif.checked;
    if(qualif==true)
    {
        document.add_candy.addqualif.readOnly=false;
    }
    else
    {
        alert('Choose Others to add.');
    }
}
function add_org()
{
	var org=document.add_candy.org.value;
		if(org==2)
		{
				document.add_candy.cur_org.readOnly=false;
		}
		else
		{
				alert('You have to be working in order to add.');
		}
}
function check_exp()
{
	var exprnc=document.add_candy.exprnc.value;
	if(!(exprnc))
		alert('Add Experince');
}
function add_ctc()
{
	var org=document.add_candy.org.value;
		if(org==2)
		{
				document.add_candy.cur_ctc.readOnly=false;
		}
		else
		{
				alert('You have to be working in order to add.');
		}
}function add_nop()
{
	var org=document.add_candy.org.value;
		if(org==2)
		{
				document.add_candy.not_period.readOnly=false;
		}
		else
		{
				alert('You have to be working in order to add.');
		}
}
