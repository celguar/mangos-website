var xmlHttp
function showResult(parameters,file)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url=file;
url=url+parameters;
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}
function stateChanged()
{
if (xmlHttp.readyState==4)
{
document.getElementById('ajaxResult').innerHTML=xmlHttp.responseText;
document.getElementById('loadingDiv').style.visibility='hidden';
}
else
{
document.getElementById('loadingDiv').style.visibility='visible';
}
}
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  //FF, Opera, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}
