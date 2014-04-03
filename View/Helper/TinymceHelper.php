<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Tinymce Helper
 *
 * PHP version 5
 *
 * @category Tinymce.Helper
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class TinymceHelper extends AppHelper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
	public $helpers = array(
		'Html',
		'Js',
	);

/**
 * Actions
 *
 * Format: ControllerName/action_name => settings
 *
 * @var array
 */
	public $actions = array();

/**
 * Default settings for tinymce
 *
 * @var array
 * @access public
 */
	public $settings = array(
		// General options
		'script_url' => '/tinymce/js/tiny_mce.js',	// Location of TinyMCE script
		'theme' => 'advanced',
		'language' => 'en',
		'mode' => 'exact',
		'elements' => '',
		'relative_urls' => false,
		'plugins' => 'youtube,safari,style,table,save,advhr,fullscreen,advimage,advlink,inlinepopups,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,media,gallery',
		'width' => '100%',
		'height' => '250px',

		// allow youtube
		'extended_valid_elements' => 'iframe[src|width|height|name|align], embed[width|height|name|flashvars|src|bgcolor|align|play|loop|quality|allowscriptaccess|type|pluginspage]',

		'theme_advanced_blockformats' => 'p, h2',
		'advlink_styles' => 'lightbox=lightbox',	// wtf?
		'accessibility_warnings' => false,

		// Theme options
		'theme_advanced_buttons1' => 'undo,redo,|,save,newdocument,|,bold,italic,underline,|,forecolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,|,code',
		'theme_advanced_buttons2' => 'pasteword,pastetext,|,bullist,numlist,|,outdent,indent,blockquote,|,sub,sup,|,link,unlink,|,image,gallery,youtube',
		'theme_advanced_buttons3' => 'tablecontrols,|,removeformat,charmap,hr,|,fullscreen',
		//'theme_advanced_buttons4' => 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak',
		'theme_advanced_toolbar_location' => 'top',
		'theme_advanced_toolbar_align' => 'left',
		'theme_advanced_statusbar_location' => 'bottom',
		'theme_advanced_resizing' => true,

		// Example content CSS (should be your site CSS)
		//'content_css' => 'css/content.css',

		// Drop lists for link/image/media/template dialogs
		'template_external_list_url' => 'lists/template_list.js',
		'external_link_list_url' => 'lists/link_list.js',
		'external_image_list_url' => 'lists/image_list.js',
		'media_external_list_url' => 'lists/media_list.js',

		// Attachments browser
		// 'file_browser_callback' => 'fileBrowserCallBack',
		'file_browser_callback' => 'imgLibManager.open',	// sitex
	);

/**
 * getSettings
 *
 * @param array $settings
 * @return array
 */
	public function getSettings($settings = array()) {
		$_settings = $this->settings;
		$action = Inflector::camelize($this->params['controller']) . '/' . $this->params['action'];
		if (isset($this->actions[$action])) {
			$settings = array();
			foreach ($this->actions[$action] as $action) {
				$settings[] = Hash::merge($_settings, $action);
			}
		}
		return $settings;
	}

/**
 * beforeRender
 *
 * @param string $viewFile
 * @return void
 */
	public function beforeRender($viewFile) {
	if (isset($this->request->params['admin'])) {
		$this->Html->script('/tinymce/js/wysiwyg', array('inline' => false));
		if (is_array(Configure::read('Wysiwyg.actions'))) {
			$this->actions = Hash::merge($this->actions, Configure::read('Wysiwyg.actions'));
		}
		$action = Inflector::camelize($this->params['controller']) . '/' . $this->params['action'];
		if (Configure::read('Writing.wysiwyg') && isset($this->actions[$action])) {

			// $this->Html->script('/tinymce/js/tiny_mce', array('inline' => false));
			$this->Html->script('/tinymce/js/jquery.tinymce', array('inline' => false));
			// sitex
			// $this->Html->script('/js/elf/js/imglib_tiny_manager', array('inline' => false));

			$settings = $this->getSettings();

			foreach ($settings as $setting) {
				$elements = 'textarea';
				if ( $setting['elements'] != '' ) $elements = '#'.$setting['elements'];
				$this->Html->scriptBlock(
					'$(document).ready(function(){
						$("' . $elements . '").tinymce(' . $this->Js->object($setting) . ');
						// imgLibManager.init({url: "/admin/users/users/elf", title: "elFinder", width: 800, height: 430});
					})', array('inline' => false)
				);
			}
		}
	}
	}
}
