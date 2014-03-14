<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(CModule::IncludeModule("iblock")) { 													// Если модуль ИБ на месте, работаем, иначе наша работа не имеет смысла — выдаём ошибку

	$arOrder = array("NAME" => "ASC");
	$arFilter = array("IBLOCK_ID"=>5, "ACTIVE"=>"Y");
	$arSelect = array("ID", "NAME");
	$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement()) {
		$arFieldsEl = $ob->GetFields();
		$arResult["specials"][$arFieldsEl["ID"]] = array(
			"NAME"	=> $arFieldsEl["NAME"]
		);
	}

	$arOrder = array("NAME" => "ASC");
	$arFilter = array("IBLOCK_ID"=>10, "ACTIVE"=>"Y");									// Что вытаскиваем из базы битрикса: все активные записи из инфоблока врачей
	$arSelect = array("ID", "NAME", "PROPERTY_*");										// Какие поля нужны: ИД записи, название записи (ФИО) и все дополнительные поля
	// Получаем список врачей в соответствии с порядком записей (сортировка), фильтром, группировать не будем, постраничную навигацию нам не нада, берём инфу из перечисленных полей
	$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement()) {												// Обрабатываем записи одну за другой, пока они не закончатся
		$arFieldsEl = $ob->GetFields();													// Полученные данные о полях перекладываем в массив
		$arResult["doctors"][$arFieldsEl["ID"]] = array(
			"NAME"			=> $arFieldsEl["NAME"],
			"PROPERTY_48"	=> $arFieldsEl["PROPERTY_48"],								// Фамилия
			"PROPERTY_49"	=> $arFieldsEl["PROPERTY_49"],								// Имя
			"PROPERTY_50"	=> $arFieldsEl["PROPERTY_50"],								// Отчество
			"PROPERTY_51"	=> $arFieldsEl["PROPERTY_51"],								// Набор ИД-шников специальностей врача
			"PROPERTY_52"	=> $arFieldsEl["PROPERTY_52"]								// Путь к фотографии
		);
		while(list($key, $spec_id) = each($arFieldsEl["PROPERTY_51"]))					// Составление обратного списка: специальность — врачи
			$arDocSpec[$spec_id][] = $arFieldsEl["ID"];
	}

	while(list($key, $doc_id) = each($arDocSpec))										// Дабавляем списки врачей в список специальностей (объединяем два массива)
	$arResult["specials"][$key]["DOCTORS"] = $doc_id;

} else {

	echo "<p>С модулем инфоблока что-то не получилось =(</p>";
}
$this->IncludeComponentTemplate();
?>
