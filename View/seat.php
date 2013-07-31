<!-- Updated By Amber Sharma -->
<script type="text/javascript" src="assets/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.droppable.js"></script>
<!-- Updated By Amber Sharma -->
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
				if(val['id']=='NA')
				{
					totalRow=val['name'];
				}
				else
				{
					/* Updated By Amber Sharma */
					$("#result").append("<div class='SearchedEmp' id = 'emp"+val['id']+"'><span id='"+val['id']+"' style='width:20px;height:16px;' class='dragable'>"+val['name']+"</span><input name = 'empId' type = 'hidden' value='"+val['id']+"'></div>");
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
  		}); 
}

/* Updated By Amber Sharma */
function dragdropevent()
{
	
	/** we set the dragable class to be dragable, we add the containment which will be #boxdemo, so dropable and dragable object cant pass out of this box **/
     $( ".dragable" ).draggable({
       		
         revert: "invalid",
	start: function(event, ui) {    
    		draggedElement = this.id;
		moveid = $(this).parent('div').attr('id');
		//alert(moveid);
		dragdropevent();
	//alert(parentid);
    	}
    });
 
    $( ".droppable" ).droppable({
        /** tolerance:fit means, the moveable object has to be inside the dropable object area **/
        tolerance: 'fit',
        over: function(event, ui) {
      	thisid = this.id;
	
	//alert(thisid);
            /** We add the hoverClass when the moveable object is inside of the dropable object **/
            $('.ui-draggable-dragging').addClass('hoverClass');
        },
        out: function(event, ui) {
        	prevthisid = this.id;
            /** We remove the hoverClass when the moveable object is outside of the dropable object area **/
            $('.ui-draggable-dragging').removeClass('hoverClass');
            $('#'+prevthisid).removeClass('dropClass');
        },
        /** This is the drop event, when the dragable object is moved on the top of the dropable object area **/
        drop: function( event, ui ) {
		alert(thisid);
		$.post('index.php?controller=MainController&method=assignSeat',{roomid:thisid},function(data,status){
			//window.location.href = 'index.php';
			});
		$("#"+thisid ).html(' ');
		$( "#"+thisid ).html('<img src="images/red_chair.png" id=' + draggedElement + ' height="30" width="30" class="dragable dragged" />');
		$("#"+thisid).removeClass('droppable ui-droppable dropped');
		$( "#"+moveid ).html(' ');
		if(moveid.indexOf("emp") == -1)
		{
			$( "#"+moveid ).html('<img src="images/green_chair.png" height="18" width="30"  />');
			$("#"+moveid).addClass('droppable ui-droppable dropped');
		}
	
		dragdropevent();
        	
        }
    });
}

/* Updated By Amber Sharma */
</script>
<lable>Name:</lable> <input type="text" id="searchtxt" onkeyup="getData()"/>
<div id="result"></div>
<div id="pager"></div>
