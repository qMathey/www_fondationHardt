(function () {
	tinymce.create('tinymce.plugins.custom_text_separator', {

		init: function (ed, url) {
			ed.addButton('custom_text_separator', {
				title : 'Séparer le texte en 2 colonnes',
				cmd : 'showrecent',
				image : url + '/../css/img/icon_columns_hardt.png'
			});

			ed.addCommand('showrecent', function() {
				var return_text = '';
				return_text = '[create_second_col]';
				ed.execCommand('mceInsertContent', 0, return_text);
			});

			ed.onBeforeSetContent.add(function (ed, o) {
				if (typeof window.CrayonTinyMCE !== "undefined" && window.CrayonTinyMCE != null)
				{
					return false;
				}
			});
		},
		getInfo : function() {
			return {
				longname : 'Separation du texte en deux colonne',
				author : 'Damien Fayet',
				version : "1.0"
			};
		}
	});
	
	tinymce.PluginManager.add( 'custom_text_separator', tinymce.plugins.custom_text_separator );
})();


