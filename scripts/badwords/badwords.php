<?
//Don't forget to set the PATH of badwords.txt, since this file
//will be included in scripts, and not called on its own.


function striReplace($find,$replace,$string){
$i=0;
$exploded=explode(strtolower($find),strtolower($string));
foreach($exploded as $key=>$bit){
$exploded[$key]=substr($string,$i,strlen($bit));
$i+=strlen($find)+strlen($bit);
}
return implode($replace,$exploded);
}


function badWords($text){
//***Configure***

$replacement='*';
$fp=fopen('badwords.txt',"r");
$badAr=fread($fp,filesize('badwords.txt'));
$badAr=str_replace("\r",'',$badAr);
$badAr=explode("\n",$badAr);
for($i=0;$i<sizeof($badAr);$i++){
if(@stristr($text,$badAr[$i])){
for($n=1;$n<strlen($badAr[$i]);$n++) $replacement.='*';
$text=striReplace($badAr[$i],$replacement,$text);
$replacement='*';
}
}
return $text;
}

?>
