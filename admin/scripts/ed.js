/*****************************************/
// Name: Javascript Textarea BBCode Markup Editor
// Version: 1.3
// Author: Balakrishnan
// Last Modified Date: 25/jan/2009
// License: Free
// URL: http://www.corpocrat.com
/******************************************/

var textarea;
var content;
document.write("<link href=\"/styles/bbeditor.css\" rel=\"stylesheet\" type=\"text/css\">");


function edToolbar(obj) {
    document.write("<div class=\"toolbar\">");
	document.write("<img class=\"button\" src=\"/admin/img/bbeditor/bold.gif\" name=\"btnBold\" title=\"Полужирный\" onClick=\"doAddTags('[b]','[/b]','" + obj + "')\">");
        document.write("<img class=\"button\" src=\"/admin/img/bbeditor/italic.gif\" name=\"btnItalic\" title=\"Курсив\" onClick=\"doAddTags('[i]','[/i]','" + obj + "')\">");
	document.write("<img class=\"button\" src=\"/admin/img/bbeditor/underline.gif\" name=\"btnUnderline\" title=\"Подчеркнутый\" onClick=\"doAddTags('[u]','[/u]','" + obj + "')\">");
        document.write("<img class=\"button\" src=\"/admin/img/bbeditor/strikethrough.gif\" name=\"btnStrikethrough\" title=\"Перечеркнутый\" onClick=\"doAddTags('[s]','[/s]','" + obj + "')\">");
        document.write("<img class=\"button\" src=\"/admin/img/bbeditor/left.gif\" name=\"btnLeft\" title=\"Выравнивание по левому краю\" onClick=\"doAddTags('[left]','[/left]','" + obj + "')\">");
        document.write("<img class=\"button\" src=\"/admin/img/bbeditor/center.gif\" name=\"btnCenter\" title=\"Выравнивание по центру\" onClick=\"doAddTags('[center]','[/center]','" + obj + "')\">");
        document.write("<img class=\"button\" src=\"/admin/img/bbeditor/right.gif\" name=\"btnRight\" title=\"Выравнивание по правому краю\" onClick=\"doAddTags('[right]','[/right]','" + obj + "')\">");
	document.write("<img class=\"button\" src=\"/admin/img/bbeditor/link.gif\" name=\"btnLink\" title=\"Вставить ссылку\" onClick=\"doURL('" + obj + "')\">");
	document.write("<img class=\"button\" src=\"/admin/img/bbeditor/picture.gif\" name=\"btnPicture\" title=\"Вставить изображение\" onClick=\"doImage('" + obj + "')\">");
	document.write("<img class=\"button\" src=\"/admin/img/bbeditor/unordered.gif\" name=\"btnList\" title=\"Маркированный список\" onClick=\"doList('[list-basic]','[/list]','" + obj + "')\">");
	// document.write("<img class=\"button\" src=\"/admin/img/bbeditor/ordered.gif\" name=\"btnList\" title=\"Список без маркеров\" onClick=\"doList('[list-nomarker]','[/list]','" + obj + "')\">");
	// document.write("<img class=\"button\" src=\"/admin/img/bbeditor/tariffgroup.gif\" name=\"btnTariffgroup\" title=\"Вывести группу тарифов\" onClick=\"doAddTags('[tariffgroup]','[/tariffgroup]','" + obj + "')\">");
        // document.write("<img class=\"button\" src=\"/admin/img/bbeditor/footnote.gif\" name=\"btnFootnote\" title=\"Сноска\" onClick=\"doAddTags('[footnote]','[/footnote]','" + obj + "')\">");
        // document.write("<img class=\"button\" src=\"/admin/img/bbeditor/hr.gif\" name=\"btnHr\" title=\"Вставить разделитель\" onClick=\"doAddTags('[hr]','','" + obj + "')\">");
        document.write("<img class=\"button\" src=\"/admin/img/bbeditor/color.gif\" name=\"btnColor\" title=\"Цвет\" onClick=\"doColor('" + obj + "')\">");
  	document.write("<img class=\"button\" src=\"/admin/img/bbeditor/code.gif\" name=\"btnCode\" title=\"Присвоить класс\" onClick=\"doClass('" + obj + "')\">");
        document.write("</div>");
	//document.write("<textarea id=\""+ obj +"\" name = \"" + obj + "\" cols=\"" + width + "\" rows=\"" + height + "\"></textarea>");
				}

function doImage(obj)
{
textarea = document.getElementById(obj);
var url = prompt('Enter the Image URL:','http://');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

if (url != '' && url != null) {

	if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				sel.text = '[img]' + url + '[/img]';
			}
   else 
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		var rep = '[img]' + url + '[/img]';
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
			
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
}

}

function doURL(obj)
{
textarea = document.getElementById(obj);
var url = prompt('Enter the URL:','http://');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

if (url != '' && url != null) {

	if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				
			if(sel.text==""){
					sel.text = '[url=' + url + ']'  + url + '[/url]';
					} else {
					sel.text = '[url=' + url + ']' + sel.text + '[/url]';
					}			

				//alert(sel.text);
				
			}
   else 
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
        var sel = textarea.value.substring(start, end);
		
		if(sel==""){
				var rep = '[url=' + url + ']' + url + '[/url]';
				} else
				{
				var rep = '[url=' + url + ']' + sel + '[/url]';
				}
	    //alert(sel);
		
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
			
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
 }
}

function doClass(obj)
{
textarea = document.getElementById(obj);
var url = prompt('Enter class name:','');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

if (url != '' && url != null) {

	if (document.selection)
			{
				textarea.focus();
				var sel = document.selection.createRange();

			if(sel.text==""){
					sel.text = '[class=' + url + '][/class]';
					} else {
					sel.text = '[class=' + url + ']' + sel.text + '[/class]';
					}

				//alert(sel.text);

			}
   else
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;

        var sel = textarea.value.substring(start, end);

		if(sel==""){
				var rep = '[class=' + url + '][/class]';
				} else
				{
				var rep = '[class=' + url + ']' + sel + '[/class]';
				}
	    //alert(sel);

        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);


		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
 }
}

function doColor(obj)
{
textarea = document.getElementById(obj);
var url = prompt('Enter color code:','#');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

if (url != '' && url != null) {

	if (document.selection)
			{
				textarea.focus();
				var sel = document.selection.createRange();

			if(sel.text==""){
					sel.text = '[color=' + url + '][/color]';
					} else {
					sel.text = '[color=' + url + ']' + sel.text + '[/color]';
					}

				//alert(sel.text);

			}
   else
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;

        var sel = textarea.value.substring(start, end);

		if(sel==""){
				var rep = '[color=' + url + '][/color]';
				} else
				{
				var rep = '[color=' + url + ']' + sel + '[/color]';
				}
	    //alert(sel);

        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);


		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
 }
}

function doAddTags(tag1,tag2,obj)
{
textarea = document.getElementById(obj);
	// Code for IE
		if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				//alert(sel.text);
				sel.text = tag1 + sel.text + tag2;
			}
   else 
    {  // Code for Mozilla Firefox
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
		
		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;

		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		var rep = tag1 + sel + tag2;
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
		
		
	}
}

function doList(tag1,tag2,obj){
textarea = document.getElementById(obj);
// Code for IE
		if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				var list = sel.text.split('\n');
		
				for(i=0;i<list.length;i++) 
				{
				list[i] = '[*]' + list[i];
				}
				//alert(list.join("\n"));
				sel.text = tag1 + '\n' + list.join("\n") + '\n' + tag2;
			} else
			// Code for Firefox
			{

		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var i;
		
		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;

		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		
		var list = sel.split('\n');
		
		for(i=0;i<list.length;i++) 
		{
		list[i] = '[*]' + list[i];
		}
		//alert(list.join("<br>"));
        
		
		var rep = tag1 + '\n' + list.join("\n") + '\n' +tag2;
		textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
 }
}