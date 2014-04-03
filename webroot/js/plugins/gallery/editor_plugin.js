/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('gallery');

	tinymce.create('tinymce.plugins.GalleryPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceGallery');
			ed.addCommand('mceGallery', function() {
				ed.execCommand('mceInsertContent', false, '[gallery]');
			});

			// Register gallery button
			ed.addButton('gallery', { title : 'gallery.desc', cmd : 'mceGallery', image : url + '/img/gallery.gif' });

		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Gallery plugin',
				author : 'Sitex',
				authorurl : 'http://sitex.kz',
				infourl : 'http://google.com',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('gallery', tinymce.plugins.GalleryPlugin);
})();