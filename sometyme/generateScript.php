<?php

$data = '<script type="text/javascript">
(function(){var m, g = ["https://hm.sometyme.com/mg/script.js", "'.$_GET['smscript'].'", "script"], 
 n = document, s = n.createElement(g[2]); s.async = !0, s.id = g[1], s.src = g[0],
(m = n.getElementsByTagName(g[2])[0]).parentNode.insertBefore(s, m)})();
</script>';
$fileCreated = file_put_contents('sometyme.js', $data);
if($fileCreated == false){
	echo $message = "Can't generate script. give read write access to plugin directory.";
	
}else{
	echo "Sometyme tools added to your website successfully";
}

?>
