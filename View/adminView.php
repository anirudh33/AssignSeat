<title>Assign Seat</title>
<script src="assets/js/jquery.tools.min.js"></script>

<link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="assets/css/adminPage.css" />
<link rel="stylesheet" type="text/css" href="assets/css/adminView.css" />

<div id="adminHeader"> 

	<span id='adminMenu'>
	
	<ul class="adminallMenues">
	<li><a href="index.php">Home</a></li>
	<li><a href="#" onclick="getUsersPanal()">Users</a></li>
	</ul>
	</span>
</div>

<div id='leftAdminMenu'>
<h3><a href="#" onclick="uploadcsv()">Upload CSV File</a></h3>
<h3><a href="javascript:void(0);" onclick="deptcolor()">Dept Color</a></h3>
 <h3>Employees</h3>
	<div id="allEmployee">
	<?php include_once 'allEmployee.php';?>
	</div>
	<h3>Rooms</h3>
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

function getUsersPanal()
{
	$.post('index.php?controller=MainController&method=getUsersView',function(data){
		if(data.indexOf('Reset') != -1)
		{
			location.reload();
		}
		$('#adminPanal').html(data);
		})
}

$(function(){
	getData();
});

function showRoomDetails(id) {
	$.post('index.php?controller=MainController&method=getRoomDetails',
			{
				'roomId':id
			},
			function(data){
				if(data.search('roomDetail') != -1)
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
function uploadcsv() {
	$.post('index.php?controller=MainController&method=loadUploadView',
			{
				
			},
			function(data){
				$("#adminPanal").html(data);
			}	);
}

function deptcolor()
{
	$.ajax
	({
		type: "POST",
		url: 'index.php?controller=MainController&method=deptColor',
		success: function(data)
		{
			$("#adminPanal").html(data);
		}
		
	});
}
</script>


<style>
.adminallMenues {
	list-style-type:none;
}
.adminallMenues li{
	display: inline;
}
.adminallMenues  a
{
	width:60px;
	font-size: 20px !important;
	padding: 5px;
}
#adminMenu {
	float:left;
	margin-top: 40px;	
}
#adminMenu a{
	color: #F4EEEA;
    font-size: 1.2em;
    text-decoration: none;
    text-shadow: 0 1px 1px #32251B;
	
}
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
	box-shadow: -17px -12px 11px #DEB887;
	background: url("assets/images/shadow.png") repeat-x scroll left top transparent;
	width: 100%;
	height: 163px;
	
}
#leftAdminMenu {
	background: none repeat scroll 0 0 #32251B;
	box-shadow: -17px -12px 11px #DEB887;
	float:left;
	border: 2px solid black;
	padding-left: 2%;
	padding-right: 2%;
	margin-top: 2%;
	width: 16%;
	height : auto;
	color:white;
	
}
#allRooms {
	height: 40%;
	overflow : scroll ;
}
#adminPanal {
	box-shadow: -17px -12px 11px #DEB887;
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
 	color: black;
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
	margin-top: 61%
}
</style>
