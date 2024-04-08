CKEDITOR.editorConfig = function( config ) {
	config.autoParagraph = false;
	config.extraPlugins = 'wordcount,notification'; 
	config.wordcount = {

	    // Whether or not you want to show the Word Count
	    showWordCount: false,

	    // Whether or not you want to show the Char Count
	    showCharCount: true,
	    
	    // Maximum allowed Word Count
	    //maxWordCount: 4,

	    // Maximum allowed Char Count
	    maxCharCount: 200,
	};
	config.toolbar = [
	{ name: 'notepad', items: [ 'Undo', 'Redo', 'Save', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Find', 'Replace', 'SelectAll', 'Link', 'Unlink', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'NumberedList', 'BulletedList', 'Indent', 'Outdent', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor', 'Smiley'] }
	];
	
	config.smiley_path=CKEDITOR.basePath+'plugins/smiley/images/';
	config.smiley_images=['s01.png',
	's02.png',
	's03.png',
	's04.png',
	's05.png',
	's06.png',
	's07.png',
	's08.png',
	's09.png',
	's10.png',
	's11.png',
	's12.png',
	's13.png',
	's14.png',
	's15.png',
	's16.png',
	's17.png',
	's18.png',
	's19.png',
	's20.png',
	's21.png',
	's22.png',
	's23.png',
	's24.png',
	's25.png',
	's26.png',
	's27.png',
	's28.png',
	's29.png',
	's30.png',
	's31.png',
	's32.png',
	's33.png',
	's34.png',
	's35.png',
	's36.png',
	'a.png',
	'love.png',
	'gift.png',
	'h01.png',
	'h02.png',
	'h03.png',
	'h04.png',
	'h05.png',
	'h06.png',
	'h07.png',
	'f04.png',
	'f05.png',
	'f06.png',
	'p01.png',
	'p02.png',
	'tr01.png',
	'tr02.png',
	'tr03.png',
	'tr04.png',
	'sy04.png',
	'sy08.png',
	'sy09.png',
	'sy01.png',
	'sy16.png',
	'sy17.png',
	'sy18.png',
	'sy19.png',
	'sy20.png',
	'sy21.png',
	'sy22.png',
	'sy23.png',
	'sy24.png',
	'sy25.png',
	'sy26.png',
	'sy27.png',
	'sy28.png',
	
	];
};