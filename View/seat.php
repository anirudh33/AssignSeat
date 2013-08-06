<!-- Updated By Amber Sharma -->

<!-- Updated By Amber Sharma -->
<script>

function searchlocation(id)
{
    if($('img[id='+id+']').length > 0){
        $scrollId = $('img[id='+id+']').parent().attr("id");
        document.getElementById($scrollId).scrollIntoView();
    	$('img[id='+id+']').hide(1000);
    	$('img[id='+id+']').trigger("click");
    	$('img[id='+id+']').show(1000);	
        $(window).mouseover(function() {
            $('img[id='+id+']').tooltip("close");
         });
    }
}

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
				if(data.indexOf('password') != -1)
				{
					location.reload();
				}
				if(val['id']=='NA')
				{
					totalRow=val['name'];
				}
				else
				{
					/* Updated By Amber Sharma */
					$("#result").append("<div class='SearchedEmp' id = 'emp"
	                        + val['id']
	                        + "'>"
	                        + val['name']
	                        + "   <span id='"
	                        + val['id']
	                        + "' style='width:20px;height:16px;' class='dragable mouseFetch'>"
	                        + "<img src='./assets/images/human.jpeg' onClick='searchlocation("
	                        + val['id'] + ");' width='15px' /></span></div>");
					//$("#result").append(val['Name']+"<br>");
					dragdropevent();
					/* Updated by Amber Sharma*/
				}

				});
			if(page==0 && totalRow < 11)
			{
				$("#pager").html("");
			}
			else if(page==0 && totalRow >= 11)
			{
				//alert(totalRow);
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

function getLocation()
{


	
}

/* Updated By Amber Sharma */

/* Updated By Amber Sharma */
</script>

<label><?php echo $lang->NAME?></label>
<input type="text" id="searchtxt" onkeyup="getData()" />
<a id="changeCommentLink" href="#detailDiv">

	<div id="detailDiv" style="display: none">
		<h3 class="customHeading"><?php echo $lang->CHANGEREASON?></h3>
		<section>
			<label><?php echo $lang->COMMENT?></label><br>
			<textarea rows="10" cols="15" id="changeComment" style = "width : 100%" name="changeComment"></textarea>
		</section>
		<input type="button" id="commentSubmit" onClick="closeFancyBox()"
			name="commentSubmit" value="<?php echo $lang->POSTIT?>" />
		<div id="commentError"></div>
	</div>
</a>
<div id="result"></div>
<div id="pager"></div>
