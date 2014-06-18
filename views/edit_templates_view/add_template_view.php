<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Example: Basic - jWYSIWYG</title>
<!--<link rel="stylesheet" type="text/css" href="../jwysiwyg-master/lib/screen.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="../jwysiwyg-master/lib/print.css" media="print" />-->
<link rel="stylesheet" href="../../plugs/jwysiwyg-master/jquery.wysiwyg.css" type="text/css"/>
<script type="text/javascript" src="../../plugs/jwysiwyg-master/lib/jquery1.5.js"></script>
<script type="text/javascript" src="../../plugs/jwysiwyg-master/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="../../plugs/jwysiwyg-master/controls/wysiwyg.image.js"></script>
<script type="text/javascript" src="../../plugs/jwysiwyg-master/controls/wysiwyg.link.js"></script>
<script type="text/javascript" src="../../plugs/jwysiwyg-master/controls/wysiwyg.table.js"></script>
<script type="text/javascript">
(function($) {
	$(document).ready(function() {
		$('#wysiwyg').wysiwyg();
	});
})(jQuery);
</script>
<!--<script type="text/javascript" src="../view/js/harveyjs.js"></script>-->



<form method="post" action="http://localhost/more/controllers/edit_templates/save_new_template.php">
    <div>template name: 
    <input type="text" name="filename" /></div>
    <div>
        <textarea name="wysiwyg" id="wysiwyg" rows="15" cols="60"> </textarea>
    </div>
    <div>
        <input name="" type="submit" value="save" onclick="return checkdata(filename);"/>
    </div>
</form>