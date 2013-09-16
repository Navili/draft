<?
function GetNSymb($source, $n)
{
	if($source == "")
		return false;
	$dist = "";
	for ($i = 0; $i < $n; $i++)
		$dist .=  $source[$i];
	return $dist;
}
function DirUp ($path)
{
	$temp_arr = explode('/', $path);
	if(($count = count($temp_arr)) < 2)
		return false;
	return GetNSymb($path, strlen($path) - strlen($temp_arr[$count-2]) - 1);
}

global $APPLICATION;
$dir = $APPLICATION->GetCurDir();
$page = $APPLICATION->GetCurPage();
$file_name = ".template_param";
echo "<p><pre>";
echo "$dir<br />$page<br />";
				if(file_exists($_SERVER['DOCUMENT_ROOT'].$dir.$file_name))
{
	echo "Exists!";
	if($bitrix_likes_choko)
	echo "Choko";
}
while ($dir!=="/")		// Serching file-config
{
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$dir.$file_name))
		break;
	$dir = DirUp($dir);
}
echo "<br />$dir";
echo "</pre></p>";
?>
