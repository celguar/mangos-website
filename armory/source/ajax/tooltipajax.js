var activerequests = 0;
var itemTooltips = new Array()
function showTooltip(itemIdorGuid, dbkey, owned)
{
owned = typeof(owned) != 'undefined' ? owned : 2;

var iscached = -1;
for( var i = 0 ; i < itemTooltips.length ; i ++ )
{
if( itemTooltips[i][0] == itemIdorGuid )
{
iscached = i;
}
}
if( iscached != -1 )
{
showTip(itemTooltips[iscached][1]);
iscached = -1;
}
else
if( activerequests <= 2 )
{
activerequests += 1;
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  return;
  }
var url='source/ajax/ajax-itemtooltip-get.php?item=' + itemIdorGuid + '&dbkey=' + dbkey + '&owned=' + owned;
xmlHttp.onreadystatechange = function(){ currentItem = itemIdorGuid; updateItemTooltip() };
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}
}
function updateItemTooltip()
{
if (xmlHttp.readyState==4)
{
activerequests = 0;
tooltipResult = xmlHttp.responseText;
tooltipResult = tooltipResult.replace(/'/g,'\'');
thisTooltip = new Array();
thisTooltip[0]=currentItem;
thisTooltip[1]=tooltipResult;
itemTooltips.push(thisTooltip);
showTooltip(currentItem);
}
}