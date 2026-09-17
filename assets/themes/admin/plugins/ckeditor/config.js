/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	/*config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];*/

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';

};

CKEDITOR.editorConfig = function( config )
{
    config.allowedContent = true;
    // Define changes to default configuration here. For example:
    config.language = 'pt';
    // config.uiColor = '#AADC6E';

    config.removeButtons = 'help';
	config.height = '300px';
	config.toolbar = 'Full';

  	config.format_tags = 'p;h4;h5;h6';

	// config.image2_alignClasses = [ 'image-left', 'image-center', 'image-right' ];
	// config.image2_captionedClass = 'image-captioned';

  config.image2_alignClasses = [ 'img-align-left', 'img-align-center', 'img-align-right' ];
  // config.image2_captionedClass = 'image-captioned';

	config.toolbar_Basic = [
		['PasteText','PasteFromWord', '-', 'Bold', 'Italic', 'Underline', 'Indent', 'Outdent', 'TextColor', '-', 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Link', 'Unlink','-','Source','Image','Table', 'Smiley', 'Maximize', '-', 'Format']
	];

	/* http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.toolbar_Basic */


	config.toolbar_Full = [
	{ name: 'restore', items : ['Undo','Redo'] },
    
    { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','-' ] },
    { name: 'editing',     items : [ 'Find','Replace'] },
    { name: 'document',    items : [ 'Source' ] },
    '/',
    { name: 'styles',      items : [ 'Font', 'FontSize' ] },
    { name: 'colors',      items : [ 'TextColor','BGColor' ] },
    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
    '/',
    { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
    { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
    { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
    
    { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-' ] }
	];

};
