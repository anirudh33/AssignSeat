
<script type="text/javascript" src="assets/js/jquery-1.9.1.min.js" >
</script>
<script>
function getData(page) {
//alert("hello");
var name = document.getElementById("searchtxt").value;
if(page == undefined)
{
page=0;
}
	$.getJSON("index.php",
		{"name":name,"page":page,"controller":"MainController","method":"searchEmployee"},
		function(data,status) {
			$("#result").html("");
			var totalRow;
			$.each(data,function(index,val){
				if(val['ID']=='NA')
				{
					totalRow=val['Name'];
				}
				else
				{
					$("#result").append("<div class='SearchedEmp' id = 'emp"+val['ID']+"'>"+val['Name']+"<input name = 'empId' type = 'hidden' value='"+val['ID']+"'></div>");
					//$("#result").append(val['Name']+"<br>");
				}

				});

			if(page==0)
			{
			   $("#pager").html("");
			   $("#pager").append("<a href=# onClick=getData("+(page+1)+")>Next</a> <a href=# onClick=getData("+Math.floor((totalRow-1)/10)+")>Last</a>");
			}
			else if(Math.floor((totalRow-1)/10)==page)
			{
			   $("#pager").html("");
			   $("#pager").append("<a href=# onClick=getData('0')>First</a> <a href=# onClick=getData("+(page-1)+")>Prev</a>");
			}
			else
			{
			   $("#pager").html("");
			   $("#pager").append("<a href=# onClick=getData('0')>First</a> <a href=# onClick=getData("+(page-1)+")>Prev</a> <a href=# onClick=getData("+(page+1)+")>Next</a> <a href=# onClick=getData("+Math.floor((totalRow-1)/10)+")>Last</a>");
			}

			/*$.each(data ,function(key,val){
				$("#result").append(val['Name']+"<br>");
				});*/
  		}); 
}
</script>
<style>
#searchtxt {
	width : 80%;
}
.SearchedEmp {
	border :1px dotted black;
	margin-top: 2px;
}
</style>
Name: <input type="text" id="searchtxt" onkeyup="getData()"/>
<div id="result"></div>
<div id="pager"></div>