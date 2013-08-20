<script>
function searchlocation(id)
{
    if($('img[id='+id+']').length > 0){
        $scrollId = $('img[id='+id+']').parent().attr("id");
        document.getElementById($scrollId).scrollIntoView();
        window.scrollBy(0, -50);
    	$('img[id='+id+']').trigger("click");
    }
}
function getData(page) {
var name = document.getElementById("searchtxt").value;
if(page == undefined)
{
page=<?php echo isset($_SESSION['SearchEmpPage'])? $_SESSION['SearchEmpPage']: '0';?>;
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
					$tickDiv = "";				
					$tickDiv += "<div class='SearchedEmp customId' id = 'emp"
                        + val['id']
                    + "'>"
                    + val['name'];
					if($('img[id='+val['id']+']').attr("id") == val['id'] ) {
						$tickDiv +=  "<img src=\"assets/images/tick.png\" height=20 width=30 />";
					}                    
					$tickDiv += "   <span id='"
                    + val['id']
                    + "' style='width:20px;height:16px;' class='dragable mouseFetch'>"
                    + "<img src='./assets/images/human.jpeg' onClick='searchlocation("
                    + val['id'] + ");' width='15px' /></span></div>";				
					$("#result").append($tickDiv);
					dragdropevent();
				}

				});
			if(page==0 && totalRow < 11)
			{
				$("#pager").html("");
			}
			else if(page==0 && totalRow >= 11)
			{
			   $("#pager").html("");
			   $("#pager").append("<input type = \"button\" class = 'customButton' onClick=getData("+(page+1)+
					   ") value = \"Next\"/><input type = \"button\" class = 'customButton' "+
					   "onClick=getData("+Math.floor((totalRow-1)/10)+") value = \"Last\" />");			}
			else if(Math.floor((totalRow-1)/10)==page)
			{
			   $("#pager").html("");
			   $("#pager").append("<input type = \"button\" class = 'customButton' onClick=getData('0') value = \"First\" />"+
					   "<input type = \"button\" class = 'customButton' onClick=getData("+(page-1)+") value = \"Prev\" />");
			}
			else
			{
			   $("#pager").html("");
			   $("#pager").append(""+
					   "<input type = \"button\" class = 'customButton' onClick=getData('0') value = \"First\" />"+
					   "<input type = \"button\" class = 'customButton' onClick=getData("+(page-1)+") value = \"Prev\" />"+
					   "<input type = \"button\" class = 'customButton' onClick=getData("+(page+1)+") value = \"Next\" />"+
					   "<input type = \"button\" class = 'customButton' onClick=getData("+Math.floor((totalRow-1)/10)+") value = \"Last\" />");
			}
  		}); 
}
</script>

<!-- <label><?php echo $lang->NAME?></label>  -->
<input type="text" id="searchtxt" onkeyup="getData()" />
<a id="changeCommentLink" href="#detailDiv">

	<div id="detailDiv" style="display: none">
		<h3 class="customHeading"><?php echo $lang->CHANGEREASON?></h3>
		<section>
			<label><?php echo $lang->COMMENT?></label><br>
			<textarea rows="15" cols="45" id="changeComment" style="width: 100%"
				name="changeComment"></textarea>
			<div id="commentCount"></div>
		</section>
		<input type="button" id="commentSubmit" onClick="closeFancyBox()"
			name="commentSubmit" value="<?php echo $lang->POSTIT?>" />
		<div id="commentError"></div>
	</div>
</a>
<div id="result"></div>
<div id="pager"></div>