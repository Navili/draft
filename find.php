<?
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
