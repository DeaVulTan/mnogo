<?php
$codepage = "utf8";

$SoftDB = mysql_connect("localhost", "softstream", "cjanbyf");
mysql_select_db("softstream", $SoftDB);
/*mysql_query("SET NAMES '".$codepage."'", $SoftDB);
mysql_query("SET character_set_client = '".$codepage."'", $SoftDB);
mysql_query("SET character_set_results = '".$codepage."'", $SoftDB);*/
$DateCurrent['m'] = date('m');
$DateCurrent['y'] = date('Y');

$DateReport['m'] = $DateCurrent['m'] - 1;
$DateReport['y'] = $DateCurrent['y'];
if ($DateReport['m'] == "0") {
    $DateReport['m'] = "12";
    $DateReport['y'] = $DateReport['y'] - 1;
}
if (strlen($DateReport['m']) == 1) {
    $DateReport['m'] = "0".$DateReport['m'];
}

switch ($DateReport['m']) {
    case "1":
    case "01":
        $DateReport['month'] = "январь";
        break;
    
    case "2":
    case "02":
        $DateReport['month'] = "февраль";
        break;
    
    case "3":
    case "03":
        $DateReport['month'] = "март";
        break;
    
    case "4":
    case "04":
        $DateReport['month'] = "апрель";
        break;
    
    case "5":
    case "05":
        $DateReport['month'] = "май";
        break;
    
    case "6":
    case "06":
        $DateReport['month'] = "июнь";
        break;
    
    case "7":
    case "07":
        $DateReport['month'] = "июль";
        break;
    
    case "8":
    case "08":
        $DateReport['month'] = "август";
        break;
    
    case "9":
    case "09":
        $DateReport['month'] = "сентябрь";
        break;
    
    case "10":
        $DateReport['month'] = "октябрь";
        break;
    
    case "11":
        $DateReport['month'] = "ноябоь";
        break;
    
    case "12":
        $DateReport['month'] = "декабрь";
        break;
}

$num = 1;
$out = "";
$empty = "";

$replaces = array("/'/", "/\"/", "/\&/", "/\</", "/\>/", "/\?/");

$out .= '<?xml version="1.0" encoding="UTF-8"?>
<office:document-content xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:style="urn:oasis:names:tc:opendocument:xmlns:style:1.0" xmlns:text="urn:oasis:names:tc:opendocument:xmlns:text:1.0" xmlns:table="urn:oasis:names:tc:opendocument:xmlns:table:1.0" xmlns:draw="urn:oasis:names:tc:opendocument:xmlns:drawing:1.0" xmlns:fo="urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:meta="urn:oasis:names:tc:opendocument:xmlns:meta:1.0" xmlns:number="urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0" xmlns:presentation="urn:oasis:names:tc:opendocument:xmlns:presentation:1.0" xmlns:svg="urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0" xmlns:chart="urn:oasis:names:tc:opendocument:xmlns:chart:1.0" xmlns:dr3d="urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0" xmlns:math="http://www.w3.org/1998/Math/MathML" xmlns:form="urn:oasis:names:tc:opendocument:xmlns:form:1.0" xmlns:script="urn:oasis:names:tc:opendocument:xmlns:script:1.0" xmlns:ooo="http://openoffice.org/2004/office" xmlns:ooow="http://openoffice.org/2004/writer" xmlns:oooc="http://openoffice.org/2004/calc" xmlns:dom="http://www.w3.org/2001/xml-events" xmlns:xforms="http://www.w3.org/2002/xforms" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:rpt="http://openoffice.org/2005/report" xmlns:of="urn:oasis:names:tc:opendocument:xmlns:of:1.2" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:grddl="http://www.w3.org/2003/g/data-view#" xmlns:tableooo="http://openoffice.org/2009/table" xmlns:field="urn:openoffice:names:experimental:ooo-ms-interop:xmlns:field:1.0" xmlns:formx="urn:openoffice:names:experimental:ooxml-odf-interop:xmlns:form:1.0" xmlns:css3t="http://www.w3.org/TR/css3-text/" office:version="1.2"><office:scripts/><office:font-face-decls><style:font-face style:name="Arial Cyr" svg:font-family="&apos;Arial Cyr&apos;"/><style:font-face style:name="Arial1" svg:font-family="Arial1"/><style:font-face style:name="Cambria" svg:font-family="Cambria" style:font-family-generic="roman"/><style:font-face style:name="Times New Roman" svg:font-family="&apos;Times New Roman&apos;" style:font-family-generic="roman"/><style:font-face style:name="Calibri" svg:font-family="Calibri" style:font-family-generic="swiss"/><style:font-face style:name="Arial" svg:font-family="Arial" style:font-family-generic="swiss" style:font-pitch="variable"/><style:font-face style:name="Arial Unicode MS" svg:font-family="&apos;Arial Unicode MS&apos;" style:font-family-generic="system" style:font-pitch="variable"/><style:font-face style:name="Tahoma" svg:font-family="Tahoma" style:font-family-generic="system" style:font-pitch="variable"/></office:font-face-decls><office:automatic-styles><style:style style:name="co1" style:family="table-column"><style:table-column-properties fo:break-before="auto" style:column-width="1.275cm"/></style:style><style:style style:name="co2" style:family="table-column"><style:table-column-properties fo:break-before="auto" style:column-width="5.383cm"/></style:style><style:style style:name="co3" style:family="table-column"><style:table-column-properties fo:break-before="auto" style:column-width="4.577cm"/></style:style><style:style style:name="co4" style:family="table-column"><style:table-column-properties fo:break-before="auto" style:column-width="4.383cm"/></style:style><style:style style:name="co5" style:family="table-column"><style:table-column-properties fo:break-before="auto" style:column-width="4.745cm"/></style:style><style:style style:name="co6" style:family="table-column"><style:table-column-properties fo:break-before="auto" style:column-width="2.267cm"/></style:style><style:style style:name="ro1" style:family="table-row"><style:table-row-properties style:row-height="0.566cm" fo:break-before="auto" style:use-optimal-row-height="true"/></style:style><style:style style:name="ro2" style:family="table-row"><style:table-row-properties style:row-height="0.651cm" fo:break-before="auto" style:use-optimal-row-height="true"/></style:style><style:style style:name="ro3" style:family="table-row"><style:table-row-properties style:row-height="0.605cm" fo:break-before="auto" style:use-optimal-row-height="true"/></style:style><style:style style:name="ro4" style:family="table-row"><style:table-row-properties style:row-height="1.446cm" fo:break-before="auto" style:use-optimal-row-height="true"/></style:style><style:style style:name="ro5" style:family="table-row"><style:table-row-properties style:row-height="0.478cm" fo:break-before="auto" style:use-optimal-row-height="true"/></style:style><style:style style:name="ta1" style:family="table" style:master-page-name="Default"><style:table-properties table:display="true" style:writing-mode="lr-tb"/></style:style><number:number-style style:name="N3"><number:number number:decimal-places="0" number:min-integer-digits="1" number:grouping="true"/></number:number-style><style:style style:name="ce1" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:background-color="transparent" fo:wrap-option="no-wrap" fo:border="none" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="automatic" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Times New Roman" fo:font-size="13pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="bold" style:font-size-asian="13pt" style:font-style-asian="normal" style:font-weight-asian="bold" style:font-name-complex="Times New Roman" style:font-size-complex="13pt" style:font-style-complex="normal" style:font-weight-complex="bold"/></style:style><style:style style:name="ce2" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:wrap-option="wrap" fo:border="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="middle" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Times New Roman" fo:font-size="13pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="normal" style:font-size-asian="13pt" style:font-style-asian="normal" style:font-weight-asian="normal" style:font-name-complex="Times New Roman" style:font-size-complex="13pt" style:font-style-complex="normal" style:font-weight-complex="normal"/></style:style><style:style style:name="ce3" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:wrap-option="wrap" fo:border="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="automatic" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Times New Roman" fo:font-size="13pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="bold" style:font-size-asian="13pt" style:font-style-asian="normal" style:font-weight-asian="bold" style:font-name-complex="Times New Roman" style:font-size-complex="13pt" style:font-style-complex="normal" style:font-weight-complex="bold"/></style:style><style:style style:name="ce4" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" style:cell-protect="protected" style:print-content="true" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:background-color="transparent" fo:wrap-option="no-wrap" fo:border="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="middle" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Times New Roman" fo:font-size="11pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="bold" style:font-size-asian="11pt" style:font-style-asian="normal" style:font-weight-asian="bold" style:font-name-complex="Times New Roman" style:font-size-complex="11pt" style:font-style-complex="normal" style:font-weight-complex="bold"/></style:style><style:style style:name="ce5" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:wrap-option="wrap" fo:border="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="middle" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Times New Roman" fo:font-size="11pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="normal" style:font-size-asian="11pt" style:font-style-asian="normal" style:font-weight-asian="normal" style:font-name-complex="Times New Roman" style:font-size-complex="11pt" style:font-style-complex="normal" style:font-weight-complex="normal"/></style:style><style:style style:name="ce6" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:background-color="transparent" fo:wrap-option="no-wrap" fo:border="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="middle" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Times New Roman" fo:font-size="11pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="normal" style:font-size-asian="11pt" style:font-style-asian="normal" style:font-weight-asian="normal" style:font-name-complex="Times New Roman" style:font-size-complex="11pt" style:font-style-complex="normal" style:font-weight-complex="normal"/></style:style><style:style style:name="ce7" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" style:cell-protect="protected" style:print-content="true" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:background-color="transparent" fo:wrap-option="no-wrap" fo:border="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="middle" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Times New Roman" fo:font-size="11pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="normal" style:font-size-asian="11pt" style:font-style-asian="normal" style:font-weight-asian="normal" style:font-name-complex="Times New Roman" style:font-size-complex="11pt" style:font-style-complex="normal" style:font-weight-complex="normal"/></style:style><style:style style:name="ce8" style:family="table-cell" style:parent-style-name="Default" style:data-style-name="N3"><style:table-cell-properties style:glyph-orientation-vertical="0" fo:background-color="#ffffff" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="fix" style:repeat-content="false" fo:wrap-option="wrap" fo:border="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" style:vertical-align="top" style:vertical-justify="auto"/><style:paragraph-properties fo:text-align="center" css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#000000" style:text-outline="false" style:text-line-through-style="none" style:font-name="Arial Cyr" fo:font-size="12pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="normal" style:font-size-asian="12pt" style:font-style-asian="normal" style:font-weight-asian="normal" style:font-name-complex="Arial Cyr" style:font-size-complex="12pt" style:font-style-complex="normal" style:font-weight-complex="normal"/></style:style><style:style style:name="ce9" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:glyph-orientation-vertical="0" fo:border-bottom="0.31pt solid #000000" fo:background-color="#ffffff" style:diagonal-bl-tr="none" style:diagonal-tl-br="none" style:text-align-source="value-type" style:repeat-content="false" fo:wrap-option="wrap" fo:border-left="0.31pt solid #000000" style:direction="ltr" fo:padding="0.071cm" fo:border-right="0.06pt solid #000000" style:rotation-angle="0" style:rotation-align="none" style:shrink-to-fit="false" fo:border-top="0.31pt solid #000000" style:vertical-align="top" style:vertical-justify="auto"/><style:paragraph-properties css3t:text-justify="auto" fo:margin-left="0cm" style:writing-mode="page"/><style:text-properties fo:color="#969696" style:text-outline="false" style:text-line-through-style="none" style:font-name="Arial Cyr" fo:font-size="6pt" fo:font-style="normal" fo:text-shadow="none" style:text-underline-style="none" fo:font-weight="normal" style:font-size-asian="6pt" style:font-style-asian="normal" style:font-weight-asian="normal" style:font-name-complex="Arial Cyr" style:font-size-complex="6pt" style:font-style-complex="normal" style:font-weight-complex="normal"/></style:style><style:style style:name="T1" style:family="text"><style:text-properties style:text-underline-style="solid" style:text-underline-width="auto" style:text-underline-color="font-color" fo:font-weight="bold" style:font-weight-asian="bold" style:font-weight-complex="bold"/></style:style></office:automatic-styles><office:body><office:spreadsheet><table:table table:name="Sheet1" table:style-name="ta1"><table:table-column table:style-name="co1" table:default-cell-style-name="Default"/><table:table-column table:style-name="co2" table:default-cell-style-name="Default"/><table:table-column table:style-name="co3" table:default-cell-style-name="Default"/><table:table-column table:style-name="co4" table:default-cell-style-name="Default"/><table:table-column table:style-name="co5" table:default-cell-style-name="Default"/><table:table-row table:style-name="ro1" table:number-rows-repeated="2"><table:table-cell table:number-columns-repeated="5"/></table:table-row><table:table-row table:style-name="ro2"><table:table-cell table:style-name="ce1" office:value-type="string" table:number-columns-spanned="5" table:number-rows-spanned="1"><text:p>';
$out .= 'ПЕРЕЧЕНЬ';
$out .= '</text:p></table:table-cell><table:covered-table-cell table:number-columns-repeated="4" table:style-name="ce1"/></table:table-row><table:table-row table:style-name="ro2"><table:table-cell table:style-name="ce1" office:value-type="string" table:number-columns-spanned="5" table:number-rows-spanned="1"><text:p>';
$out .= 'Размещенного программного обеспечения';
$out .= '</text:p></table:table-cell><table:covered-table-cell table:number-columns-repeated="4" table:style-name="ce1"/></table:table-row><table:table-row table:style-name="ro3"><table:table-cell table:style-name="ce1" office:value-type="string" table:number-columns-spanned="5" table:number-rows-spanned="1"><text:p>';
$out .= 'на сайте <text:span text:style-name="T1">soft.st.uz</text:span>';
$out .= '</text:p></table:table-cell><table:covered-table-cell table:number-columns-repeated="4" table:style-name="ce1"/></table:table-row><table:table-row table:style-name="ro1"><table:table-cell table:number-columns-repeated="5"/></table:table-row><table:table-row table:style-name="ro4"><table:table-cell table:style-name="ce2" office:value-type="string"><text:p>';

$out .= '№</text:p><text:p>п/п';
$out .= '</text:p></table:table-cell><table:table-cell table:style-name="ce5" office:value-type="string"><text:p>';
$out .= 'Название програмного обеспечения';
$out .= '</text:p></table:table-cell><table:table-cell table:style-name="ce5" office:value-type="string"><text:p>';
$out .= 'Год и страна опубликования';
$out .= '</text:p></table:table-cell><table:table-cell table:style-name="ce5" office:value-type="string"><text:p>';
$out .= 'Наименование правообладателя';
$out .= '</text:p></table:table-cell><table:table-cell table:style-name="ce5" office:value-type="string"><text:p>';
$out .= 'Фамилия, имя и отчество автора';
$out .= '</text:p></table:table-cell></table:table-row>';
$out .= '<table:table-row table:style-name="ro2"><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>[1]</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>[2]</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>[3]</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>[4]</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>[5]</text:p></table:table-cell></table:table-row>';

$Data['Query'] = "
    SELECT 
        `title`, `create_date`
    FROM
        `files`
	WHERE
		`parent_item` = '0'";
$Data['Result'] = mysql_query($Data['Query'], $SoftDB) or die("Error [Data]: " . mysql_error());
while($Row = mysql_fetch_array($Data['Result'])) {
	$Row['title'] = iconv('cp1251', 'utf-8', $Row['title']);
    $Row['title'] = preg_replace($replaces, "`", $Row['title']);
	$Row['title'] = preg_replace("~\ \s+~mu", "", $Row['title']);
    // $out .= '<table:table-row table:style-name="ro1"><table:table-cell table:style-name="ce4" office:value-type="string" table:number-columns-spanned="1" table:number-rows-spanned="2"><text:p>' . $num . '</text:p></table:table-cell><table:table-cell table:style-name="ce6" office:value-type="string" table:number-columns-spanned="1" table:number-rows-spanned="2"><text:p>' . stripslashes($Row['title']) . '</text:p></table:table-cell><table:table-cell table:style-name="ce7" office:value-type="string" table:number-columns-spanned="1" table:number-rows-spanned="2"><text:p>' . date('Y', $Row['create_date']) . '</text:p></table:table-cell><table:table-cell table:style-name="ce7" office:value-type="string" table:number-columns-spanned="1" table:number-rows-spanned="2"><text:p>' . $empty . '</text:p></table:table-cell><table:table-cell table:style-name="ce9" office:value-type="string"><text:p>авт.тек.</text:p></table:table-cell></table:table-row><table:table-row table:style-name="ro1"><table:covered-table-cell table:style-name="ce4"/><table:covered-table-cell table:style-name="ce6"/><table:covered-table-cell table:style-name="ce7"/><table:covered-table-cell table:style-name="ce8"/><table:table-cell table:style-name="ce9" office:value-type="string"><text:p>авт.муз.</text:p></table:table-cell></table:table-row>';
	$out .= '<table:table-row table:style-name="ro2"><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>' . $num . '</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>' . stripslashes($Row['title']) . '</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>' . date('Y', $Row['create_date']) . '</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>' . $empty . '</text:p></table:table-cell><table:table-cell table:style-name="ce3" office:value-type="string"><text:p>' . $empty . '</text:p></table:table-cell></table:table-row>';
    $num++;
}
$out .= '<table:table-row table:style-name="ro1" table:number-rows-repeated="1048565"><table:table-cell table:number-columns-repeated="5"/></table:table-row><table:table-row table:style-name="ro1"><table:table-cell table:number-columns-repeated="5"/></table:table-row></table:table><table:table table:name="Sheet2" table:style-name="ta1"><table:table-column table:style-name="co6" table:default-cell-style-name="Default"/><table:table-row table:style-name="ro5"><table:table-cell/></table:table-row></table:table><table:table table:name="Sheet3" table:style-name="ta1"><table:table-column table:style-name="co6" table:default-cell-style-name="Default"/><table:table-row table:style-name="ro5"><table:table-cell/></table:table-row></table:table></office:spreadsheet></office:body></office:document-content>';

if (file_exists("report/content.xml")) {
    unlink ("report/content.xml");
}
$fp = fopen("report/content.xml", "a+");
fwrite($fp, $out);
fclose($fp);

exec ("cd report && zip -r ../report *");

if (file_exists("report.ods")) {
    unlink("report.ods");
}
rename("report.zip", "report.ods");

mysql_close($SoftDB);
unset ($TopDownloads, $num, $out);

header("Content-Disposition: attachment; filename=\"softreport_".$DateReport['y'].$DateReport['m'].".ods\""); 
header("Content-Length: ".filesize("report.ods")); 
header("Accept-Ranges: bytes"); 
header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
readfile("report.ods");
?>
