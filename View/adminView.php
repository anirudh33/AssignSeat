
<script type="text/javascript" src="assets/js/jquery-1.9.1.min.js"></script>  
<link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="assets/css/adminPage.css" />
<link rel="stylesheet" type="text/css" href="assets/css/adminView.css" />

<div id="adminHeader"></div>
<div id='leftAdminMenu'>
 <h3>Employees</h3>
	<div id="allEmployee">
	<input type="button" value="Add Employee" onclick="showEmpDetails(0)"><br/><br/>
	<?php include_once 'allEmployee.php';?>
	</div>
	<h3>Rooms</h3>
	<input type="button" value="Add Room" onclick="" ><br/><br/>
	<div id="allRooms">           
                <ul class="ca-menu">
                <?php foreach($data as $key=>$val) {?>
                    <li>
                        <a href="#" onclick="showRoomDetails(<?php echo $val['id'];?>)">
                            <span class="ca-icon">L</span>
                            <div class="ca-content" >                             
                                <h3 class="ca-sub"><?php echo $val['name'];?></h3>
                            </div>
                        </a>
                    </li>
                    <?php }?>
                    
                </ul>
	</div>
           
  </div>   
<div id="adminPanal"></div>
<div id="adminFooter"></div>
<script>
$(function(){
	getData();
});

function showRoomDetails(id) {
	$.post('index.php?controller=MainController&method=getRoomDetails',
			{
				'roomId':id
			},
			function(data){
				if(data.search('password') == -1)
				{
					$("#adminPanal").html(data);
				}
				else
				{
			        location.reload();
				}
				
			}
		);
	
}

</script>


<style>
#newRowEntry {
	margin: 2%;
}
#newRowEntry label {
	font-size: 20px;
	
}
.editComputer {
	cursor: pointer;
}
#roomRowTable td{
	border: 1px solid black;
	width: 130px;
	text-align: center;
}
#roomDetail ,#empDetails {
	margin-left: 20%;
}
#allEmployee {
	height:auto;
	
	
}
#adminHeader {
	width: 100%;
	height: 10%;
	border: 2px solid black;
}
#leftAdminMenu {
	float:left;
	border: 2px solid black;
	padding-left: 2%;
	padding-right: 2%;
	margin-top: 2%;
	width: 16%;
	height : auto;
	
}
#allRooms {
	height: 40%;
	overflow : scroll ;
}
#adminPanal {
	width: 75%;
	height : 100%;
	margin-left: 2%;
	margin-top: 2%;
	border: 2px solid black;
	float: left;
}
 #result div {
	margin-left: 2%;
	margin-top: 2%;
	/*border: 1px solid black;*/
	cursor: pointer;
	background-color: #FFFFFB;
	text-shadow: 0px 0px 13px #fff;
	font-family: 'Terminal Dosis',Arial,sans-serif;
	padding: 1%;
	padding-left: 5%;
}
.SearchedEmp lable:hover {

	background-color: #e1f0fa;
}
#pager a{
	color : red;
}
#pager {
	margin-left: 2%;
	margin-top: 7%;
	/*float: right;*/
	color : red;
}
#allEmployee input[type=text] {
	width: 81%;
}
#adminFooter {
	clear: both;
	width: 100%;
	height: 10%;
	border: 2px solid black;
	margin-top: 61%
}
</style>
