<script src="./assets/js/jquery.tools.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
<SCRIPT>
$( document ).ready(function() {
$('#testerror').load(function() {
	
    $(this).data('height', this.height);
}).bind('mouseenter mouseleave', function(e) {
    var enter = e.type === 'mouseenter',
        height = $(this).data('height');
    
    $(this).stop().animate({
        'margin-top': (enter ? 10 : 0),
        opacity: (enter ? 5 : 0.9),
        height: height * (enter ? 1.55 : 1)
        	
    });
});
});
</SCRIPT>
<style>

.errorPagediv
{
	margin: 80px;
padding: 10px;
	
}
#testerror{
	border-radius:10px;
}
</style>


<div class="errorPagediv">
<img src="./images/404.jpg"  width="95%" height="50%" id="testerror">
</div>
</body>
