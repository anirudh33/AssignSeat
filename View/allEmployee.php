
<script>


function getData(page) {

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
				if(val['id']=='NA')
				{
					totalRow=val['name'];
				}
				else
				{
					$("#result").append("<div class='SearchedEmp' id = 'emp"+val['id']+"'><lable>"+val['name']+
							"</lable></div>");

				}

				});
			if(page==0 && totalRow < 11)
			{
				$("#pager").html("");
			}
			else if(page==0 && totalRow >= 11)
			{
			   $("#pager").html("");
			   $("#pager").append("<a href=# onClick=getData("+(page+1)+
					   ")>Next</a> <a href=# onClick=getData("+Math.floor((totalRow-1)/10)+")>Last</a>");
			}
			else if(Math.floor((totalRow-1)/10)==page)
			{
			   $("#pager").html("");
			   $("#pager").append("<a href=# onClick=getData('0')>First</a> <a href=# onClick=getData("+(page-1)+")>Prev</a>");
			}
			else
			{
			   $("#pager").html("");
			   $("#pager").append("<a href=# onClick=getData('0')>First</a> <a href=# onClick=getData("+(page-1)+
					   ")>Prev</a> <a href=# onClick=getData("+(page+1)+
					   ")>Next</a> <a href=# onClick=getData("+Math.floor((totalRow-1)/10)+")>Last</a>");
			}
  		}); 
}


</script>

<label><?php echo $lang->NAME?></label>
<input type="text" id="searchtxt" onkeyup="getData()" />
<div id="result"></div>
<div id="pager"></div>
