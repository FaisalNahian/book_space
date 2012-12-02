<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Fancybox packaged for download - WebDesignAndSuch.com</title>
    
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	
	<script type="text/javascript" src="../jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../jquery/fancybox/jquery.fancybox-1.3.4.css" />
    
	<script type="text/javascript">
		$(document).ready(function() {
			$(".pop").fancybox().trigger('click');
			$("a.pop").fancybox({
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.8
			});
		});
	</script>
</head>


<body>
<div id="content">
		
        <a class="pop" href="../images/1.jpg"><img alt="" src="../images/1s.jpg" /></a>
</div>

</body>
</html>