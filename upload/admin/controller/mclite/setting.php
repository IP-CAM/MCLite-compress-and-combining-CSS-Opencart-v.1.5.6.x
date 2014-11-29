<?php
/**
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
class ControllerMcliteSetting extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('mclite/setting'); 

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('mclite/setting');
		// Generate cache list info
		$this->data['cache_list'] = json_decode($this->config->get('mclite_cache_list'), true);
		$cache_list_full = array();

		function HumanBytes($size) {
		    $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		    return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
		}

		if (!empty($this->data['cache_list'])) {
			foreach ($this->data['cache_list'] as $key => $value) {
				$elem = $value;
				$elem['filepath'] = pathinfo($elem['filename']);
				$elem['is_file'] = is_file('../'.$value['filename']);
				if ($elem['is_file']) {
						$elem['last_modified'] = date('Y.m.d [H:i:s]', filemtime('../'.$elem['filename']));
					//Size
	                	preg_match_all('/_\[(.*)?\]_/', file_get_contents('../'.$value['filename']), $files);
		                $sum_filesizes = null;
		                $file = null;
		                foreach ($files['1'] as $key2 => $value2) {
		                	$file['filename'] = $value2;
		                	$file['pathinfo'] = pathinfo($value2);
		                	$file['size'] = filesize('../'.$value2);
		                	$sum_filesizes += $file['size'];
		                	$file['size'] = HumanBytes($file['size']);
							$elem['files'][] = $file;
						}
					$elem['size_orig'] = $sum_filesizes;
					$elem['size_min'] = filesize('../'.$value['filename']);
                	$elem['size_gz'] = filesize('../'.$value['filename'].'gz');
					//Size
                	$one_percent = ($elem['size_orig'] > $elem['size_min'])? $elem['size_orig']/100 : $elem['size_min']/100;
                	$elem['size_p_orig'] = round($elem['size_orig']/$one_percent, 2);
                	$elem['size_p_min'] = round($elem['size_min']/$one_percent, 2);
                	$elem['size_p_gz'] = round($elem['size_gz']/$one_percent, 2);

                	$elem['size_p_inv_min'] = $elem['size_p_orig']-$elem['size_p_min'];
                	$elem['size_p_inv_gz'] = $elem['size_p_orig']-$elem['size_p_gz'];

                	$elem['size_orig'] = HumanBytes($elem['size_orig']);
					$elem['size_min'] = HumanBytes($elem['size_min']);
					$elem['size_gz'] = HumanBytes($elem['size_gz']);
				}
				$this->data['cache_list'][$key] = $elem;
				unset($elem);
			}
		}
		// End
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_mclite_setting->editSetting('mclite', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('mclite/setting', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_author'] = $this->language->get('text_author');
		
		$this->data['tab_common'] = $this->language->get('tab_common');
		$this->data['tab_css'] = $this->language->get('tab_css');
		$this->data['tab_cache_manager'] = $this->language->get('tab_cache_manager');
		$this->data['tab_help'] = $this->language->get('tab_help');
		$this->data['tab_htaccess'] = $this->language->get('tab_htaccess');
		$this->data['tab_tests'] = $this->language->get('tab_tests');
		
		$this->data['text_empty'] 					= $this->language->get('text_empty');
		$this->data['text_not_found'] 				= $this->language->get('text_not_found');
		$this->data['text_column_filename'] 		= $this->language->get('text_column_filename');
		$this->data['text_column_cdate'] 			= $this->language->get('text_column_cdate');
		$this->data['text_column_contain_files'] 	= $this->language->get('text_column_contain_files');
		$this->data['text_column_size'] 			= $this->language->get('text_column_size');
		$this->data['text_column_percent'] 			= $this->language->get('text_column_percent');
		$this->data['text_file_original'] 			= $this->language->get('text_file_original');
		$this->data['text_file_minimized'] 			= $this->language->get('text_file_minimized');
		$this->data['text_file_gzipped'] 			= $this->language->get('text_file_gzipped');
		$this->data['text_average_rating'] 			= $this->language->get('text_average_rating');
		$this->data['text_dir_check_success'] 			= $this->language->get('text_dir_check_success');
		$this->data['text_dir_check_failed'] 			= $this->language->get('text_dir_check_failed');
		$this->data['text_dir_check_demo'] 				= $this->language->get('text_dir_check_demo');
		
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_kb'] = $this->language->get('text_kb');

		$this->data['button_save'] 		= $this->language->get('button_save');
		$this->data['button_cancel'] 	= $this->language->get('button_cancel');
		$this->data['button_delete'] 	= $this->language->get('button_delete');
		$this->data['button_select_css'] 	= $this->language->get('button_select_css');
		
		$this->data['success'] = $this->language->get('text_success');
		$this->data['use_static_gzip'] = $this->language->get('text_use_static_gzip');
		$this->data['use_ultra_cache'] = $this->language->get('text_use_ultra_cache');
		$this->data['minify_html'] = $this->language->get('text_minify_html');
		$this->data['dir_cache_css'] = $this->language->get('text_dir_cache_css');
		$this->data['delivery_systems'] = $this->language->get('text_delivery_systems');
			$this->data['delivery_systems_css'] = 	$this->language->get('text_delivery_systems_css');
			$this->data['delivery_systems_imgs'] = 	$this->language->get('text_delivery_systems_imgs');
			$this->data['delivery_systems_cssurl'] = 	$this->language->get('text_delivery_systems_cssurl');
		
		$this->data['help_file'] = $this->language->get('text_help_file');
		$this->data['help_file_gen'] = $this->language->get('text_help_file_gen');
		$this->data['text_optimize_db'] = $this->language->get('text_optimize_db');
		$this->data['text_optimixe_db_button'] = $this->language->get('text_optimixe_db_button');
		
		$this->data['html_minimize_library'] = $this->language->get('text_html_minimize_library');
		$this->data['html_minimize_library_Minify_HTML'] = $this->language->get('text_html_minimize_library_Minify_HTML');
		$this->data['html_minimize_library_HTMLMinRegex'] = $this->language->get('text_html_minimize_library_HTMLMinRegex');
		$this->data['html_minimize_library_Crunch_HTML'] = $this->language->get('text_html_minimize_library_Crunch_HTML');

		$this->data['css_processing'] = $this->language->get('text_css_processing');
		$this->data['css_not_processing_list'] = $this->language->get('text_css_not_processing_list');
		$this->data['css_merge'] = $this->language->get('text_css_merge');
			$this->data['css_merge_0'] = $this->language->get('text_css_merge_0');
			$this->data['css_merge_1'] = $this->language->get('text_css_merge_1');
			$this->data['css_merge_2'] = $this->language->get('text_css_merge_2');
		$this->data['css_not_merge_list'] = $this->language->get('text_css_not_merge_list');
		$this->data['css_minimize'] = $this->language->get('text_css_minimize');
		$this->data['css_not_minimize_list'] = $this->language->get('text_css_not_minimize_list');
		$this->data['css_stay_position_list'] = $this->language->get('text_css_stay_position_list');
		$this->data['css_minimize_library'] = $this->language->get('text_css_minimize_library');
		$this->data['css_minimize_library_settings'] = $this->language->get('text_css_minimize_library_settings');
		$this->data['css_include_base64_images_into_css'] = $this->language->get('text_css_include_base64_images_into_css');
		$this->data['css_include_base64_images_max_size'] = $this->language->get('text_css_include_base64_images_max_size');
		$this->data['css_include_once_base64_images_list'] = $this->language->get('text_css_include_once_base64_images_list');
		$this->data['css_not_include_base64_images_list'] = $this->language->get('text_css_not_include_base64_images_list');
		
		$this->data['library_css_cssmin'] = $this->language->get('text_library_css_cssmin');
		$this->data['library_css_cssmin_regex'] = $this->language->get('text_library_css_cssmin_regex');
		$this->data['library_css_CssMinRegex'] = $this->language->get('text_library_css_CssMinRegex');
		$this->data['library_css_Minify_YUI_CssCompressor'] = $this->language->get('text_library_css_Minify_YUI_CssCompressor');
		$this->data['library_css_canCSSMini'] = $this->language->get('text_library_css_canCSSMini');
		$this->data['library_css_Crunch_CSS'] = $this->language->get('text_library_css_Crunch_CSS');

		$this->data['htaccess_not_found'] = $this->language->get('htaccess_not_found');
		$this->data['htaccess_not_writable'] = $this->language->get('htaccess_not_writable');
		$this->data['htaccess_havent_gz'] = $this->language->get('htaccess_havent_gz');
		$this->data['htaccess_have_gz'] = $this->language->get('htaccess_have_gz');
		$this->data['htaccess_author'] = $this->language->get('text_htaccess_author');
		$this->data['apache_modules'] = $this->language->get('text_apache_modules');
		
		############## CSSMIN & GCC ##################
			$this->data['text_cssmin_settings'] 							= $this->language->get('text_cssmin_settings');
			$this->data['text_gcc_settings'] 								= $this->language->get('text_gcc_settings');
			$this->data['text_cssmin_plugins'] 								= $this->language->get('text_cssmin_plugins');
			$this->data['text_cssmin_plugin_Variables'] 					= $this->language->get('text_cssmin_plugin_Variables');
			$this->data['text_cssmin_plugin_ConvertFontWeight'] 			= $this->language->get('text_cssmin_plugin_ConvertFontWeight');
			$this->data['text_cssmin_plugin_ConvertHslColors'] 				= $this->language->get('text_cssmin_plugin_ConvertHslColors');
			$this->data['text_cssmin_plugin_ConvertRgbColors'] 				= $this->language->get('text_cssmin_plugin_ConvertRgbColors');
			$this->data['text_cssmin_plugin_ConvertNamedColors'] 			= $this->language->get('text_cssmin_plugin_ConvertNamedColors');
			$this->data['text_cssmin_plugin_CompressColorValues'] 			= $this->language->get('text_cssmin_plugin_CompressColorValues');
			$this->data['text_cssmin_plugin_CompressUnitValues'] 			= $this->language->get('text_cssmin_plugin_CompressUnitValues');
			$this->data['text_cssmin_plugin_CompressExpressionValues'] 		= $this->language->get('text_cssmin_plugin_CompressExpressionValues');
			$this->data['text_cssmin_filters'] 								= $this->language->get('text_cssmin_filters');
			$this->data['text_cssmin_filter_RemoveComments'] 				= $this->language->get('text_cssmin_filter_RemoveComments');
			$this->data['text_cssmin_filter_RemoveEmptyRulesets'] 			= $this->language->get('text_cssmin_filter_RemoveEmptyRulesets');
			$this->data['text_cssmin_filter_RemoveEmptyAtBlocks'] 			= $this->language->get('text_cssmin_filter_RemoveEmptyAtBlocks');
			$this->data['text_cssmin_filter_ConvertLevel3Properties'] 		= $this->language->get('text_cssmin_filter_ConvertLevel3Properties');
			$this->data['text_cssmin_filter_Variables'] 					= $this->language->get('text_cssmin_filter_Variables');
			$this->data['text_cssmin_filter_RemoveLastDelarationSemiColon'] = $this->language->get('text_cssmin_filter_RemoveLastDelarationSemiColon');
			$this->data['text_gcc_compilation_level'] 						= $this->language->get('text_gcc_compilation_level');
			$this->data['text_gcc_compilation_level_1'] 					= $this->language->get('text_gcc_compilation_level_1');
			$this->data['text_gcc_compilation_level_2'] 					= $this->language->get('text_gcc_compilation_level_2');
			$this->data['text_gcc_compilation_level_3'] 					= $this->language->get('text_gcc_compilation_level_3');
		############## CSSMIN & GCC ##################
			$this->data['text_ht_gzip'] 									= $this->language->get('text_ht_gzip');
			$this->data['text_ht_deflate'] 									= $this->language->get('text_ht_deflate');
			$this->data['text_ht_setenvif'] 								= $this->language->get('text_ht_setenvif');
			$this->data['text_ht_headers'] 									= $this->language->get('text_ht_headers');
			$this->data['text_ht_expires'] 									= $this->language->get('text_ht_expires');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('mclite/setting', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('mclite/setting', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['generate_help_file'] = $this->url->link('mclite/setting/generate_help', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('mclite/setting/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['check_rights'] = $this->url->link('mclite/setting/check_rights', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['sort'] = $this->url->link('mclite/setting/sort', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['edit_htaccess'] = $this->url->link('mclite/setting/edit', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['optimize_db_link'] = $this->url->link('mclite/setting/optimize_db', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		//CSSMIN SETTINGS ############################################################################
			//PLUGINS
			if (isset($this->request->post['mclite_cssmin_plugin_Variables'])) {
				$this->data['mclite_cssmin_plugin_Variables'] = $this->request->post['mclite_cssmin_plugin_Variables'];
			} else {
				$this->data['mclite_cssmin_plugin_Variables'] = $this->config->get('mclite_cssmin_plugin_Variables');
			}
			if (isset($this->request->post['mclite_cssmin_plugin_ConvertFontWeight'])) {
				$this->data['mclite_cssmin_plugin_ConvertFontWeight'] = $this->request->post['mclite_cssmin_plugin_ConvertFontWeight'];
			} else {
				$this->data['mclite_cssmin_plugin_ConvertFontWeight'] = $this->config->get('mclite_cssmin_plugin_ConvertFontWeight');
			}
			if (isset($this->request->post['mclite_cssmin_plugin_ConvertHslColors'])) {
				$this->data['mclite_cssmin_plugin_ConvertHslColors'] = $this->request->post['mclite_cssmin_plugin_ConvertHslColors'];
			} else {
				$this->data['mclite_cssmin_plugin_ConvertHslColors'] = $this->config->get('mclite_cssmin_plugin_ConvertHslColors');
			}
			if (isset($this->request->post['mclite_cssmin_plugin_ConvertRgbColors'])) {
				$this->data['mclite_cssmin_plugin_ConvertRgbColors'] = $this->request->post['mclite_cssmin_plugin_ConvertRgbColors'];
			} else {
				$this->data['mclite_cssmin_plugin_ConvertRgbColors'] = $this->config->get('mclite_cssmin_plugin_ConvertRgbColors');
			}
			if (isset($this->request->post['mclite_cssmin_plugin_ConvertNamedColors'])) {
				$this->data['mclite_cssmin_plugin_ConvertNamedColors'] = $this->request->post['mclite_cssmin_plugin_ConvertNamedColors'];
			} else {
				$this->data['mclite_cssmin_plugin_ConvertNamedColors'] = $this->config->get('mclite_cssmin_plugin_ConvertNamedColors');
			}
			if (isset($this->request->post['mclite_cssmin_plugin_CompressColorValues'])) {
				$this->data['mclite_cssmin_plugin_CompressColorValues'] = $this->request->post['mclite_cssmin_plugin_CompressColorValues'];
			} else {
				$this->data['mclite_cssmin_plugin_CompressColorValues'] = $this->config->get('mclite_cssmin_plugin_CompressColorValues');
			}
			if (isset($this->request->post['mclite_cssmin_plugin_CompressUnitValues'])) {
				$this->data['mclite_cssmin_plugin_CompressUnitValues'] = $this->request->post['mclite_cssmin_plugin_CompressUnitValues'];
			} else {
				$this->data['mclite_cssmin_plugin_CompressUnitValues'] = $this->config->get('mclite_cssmin_plugin_CompressUnitValues');
			}
			if (isset($this->request->post['mclite_cssmin_plugin_CompressExpressionValues'])) {
				$this->data['mclite_cssmin_plugin_CompressExpressionValues'] = $this->request->post['mclite_cssmin_plugin_CompressExpressionValues'];
			} else {
				$this->data['mclite_cssmin_plugin_CompressExpressionValues'] = $this->config->get('mclite_cssmin_plugin_CompressExpressionValues');
			}

			//FILTERS
			/*
			if (isset($this->request->post['mclite_cssmin_filter_ImportImports'])) {
				$this->data['mclite_cssmin_filter_ImportImports'] = $this->request->post['mclite_cssmin_filter_ImportImports'];
			} else {
				$this->data['mclite_cssmin_filter_ImportImports'] = $this->config->get('mclite_cssmin_filter_ImportImports');
			}
			*/
			if (isset($this->request->post['mclite_cssmin_filter_RemoveComments'])) {
				$this->data['mclite_cssmin_filter_RemoveComments'] = $this->request->post['mclite_cssmin_filter_RemoveComments'];
			} else {
				$this->data['mclite_cssmin_filter_RemoveComments'] = $this->config->get('mclite_cssmin_filter_RemoveComments');
			}
			if (isset($this->request->post['mclite_cssmin_filter_RemoveEmptyRulesets'])) {
				$this->data['mclite_cssmin_filter_RemoveEmptyRulesets'] = $this->request->post['mclite_cssmin_filter_RemoveEmptyRulesets'];
			} else {
				$this->data['mclite_cssmin_filter_RemoveEmptyRulesets'] = $this->config->get('mclite_cssmin_filter_RemoveEmptyRulesets');
			}
			if (isset($this->request->post['mclite_cssmin_filter_RemoveEmptyAtBlocks'])) {
				$this->data['mclite_cssmin_filter_RemoveEmptyAtBlocks'] = $this->request->post['mclite_cssmin_filter_RemoveEmptyAtBlocks'];
			} else {
				$this->data['mclite_cssmin_filter_RemoveEmptyAtBlocks'] = $this->config->get('mclite_cssmin_filter_RemoveEmptyAtBlocks');
			}
			/*
			if (isset($this->request->post['mclite_cssmin_filter_ConvertLevel3AtKeyframes'])) {
				$this->data['mclite_cssmin_filter_ConvertLevel3AtKeyframes'] = $this->request->post['mclite_cssmin_filter_ConvertLevel3AtKeyframes'];
			} else {
				$this->data['mclite_cssmin_filter_ConvertLevel3AtKeyframes'] = $this->config->get('mclite_cssmin_filter_ConvertLevel3AtKeyframes');
			}
			*/
			if (isset($this->request->post['mclite_cssmin_filter_ConvertLevel3Properties'])) {
				$this->data['mclite_cssmin_filter_ConvertLevel3Properties'] = $this->request->post['mclite_cssmin_filter_ConvertLevel3Properties'];
			} else {
				$this->data['mclite_cssmin_filter_ConvertLevel3Properties'] = $this->config->get('mclite_cssmin_filter_ConvertLevel3Properties');
			}
			if (isset($this->request->post['mclite_cssmin_filter_Variables'])) {
				$this->data['mclite_cssmin_filter_Variables'] = $this->request->post['mclite_cssmin_filter_Variables'];
			} else {
				$this->data['mclite_cssmin_filter_Variables'] = $this->config->get('mclite_cssmin_filter_Variables');
			}
			if (isset($this->request->post['mclite_cssmin_filter_RemoveLastDelarationSemiColon'])) {
				$this->data['mclite_cssmin_filter_RemoveLastDelarationSemiColon'] = $this->request->post['mclite_cssmin_filter_RemoveLastDelarationSemiColon'];
			} else {
				$this->data['mclite_cssmin_filter_RemoveLastDelarationSemiColon'] = $this->config->get('mclite_cssmin_filter_RemoveLastDelarationSemiColon');
			}
		//CSSMIN SETTINGS ############################################################################
		//GCC SETTINGS ############################################################################
		//GCC SETTINGS ############################################################################

		if (isset($this->request->post['mclite_use_static_gzip'])) {
			$this->data['mclite_use_static_gzip'] = $this->request->post['mclite_use_static_gzip'];
		} else {
			$this->data['mclite_use_static_gzip'] = $this->config->get('mclite_use_static_gzip');
		}
		if (isset($this->request->post['mclite_use_ultra_cache'])) {
			$this->data['mclite_use_ultra_cache'] = $this->request->post['mclite_use_ultra_cache'];
		} else {
			$this->data['mclite_use_ultra_cache'] = $this->config->get('mclite_use_ultra_cache');
		}
		if (isset($this->request->post['mclite_minify_html'])) {
			$this->data['mclite_minify_html'] = $this->request->post['mclite_minify_html'];
		} else {
			$this->data['mclite_minify_html'] = $this->config->get('mclite_minify_html');
		}
		if (isset($this->request->post['mclite_html_minimize_library'])) {
			$this->data['mclite_html_minimize_library'] = $this->request->post['mclite_html_minimize_library'];
		} else {
			$this->data['mclite_html_minimize_library'] = $this->config->get('mclite_html_minimize_library');
		}
		
		if (isset($this->request->post['mclite_dir_cache_css'])) {
			$this->data['mclite_dir_cache_css'] = $this->request->post['mclite_dir_cache_css'];
		} else {
			$this->data['mclite_dir_cache_css'] = $this->config->get('mclite_dir_cache_css');
		}
		
		if (isset($this->request->post['mclite_cdn_addr'])) {
			$this->data['mclite_cdn_addr'] = $this->request->post['mclite_cdn_addr'];
		} else {
			$this->data['mclite_cdn_addr'] = $this->config->get('mclite_cdn_addr');
		}
			if (isset($this->request->post['mclite_cdn_css'])) {
				$this->data['mclite_cdn_css'] = $this->request->post['mclite_cdn_css'];
			} else {
				$this->data['mclite_cdn_css'] = $this->config->get('mclite_cdn_css');
			}
			if (isset($this->request->post['mclite_cdn_imgs'])) {
				$this->data['mclite_cdn_imgs'] = $this->request->post['mclite_cdn_imgs'];
			} else {
				$this->data['mclite_cdn_imgs'] = $this->config->get('mclite_cdn_imgs');
			}
			if (isset($this->request->post['mclite_cdn_cssurl'])) {
				$this->data['mclite_cdn_cssurl'] = $this->request->post['mclite_cdn_cssurl'];
			} else {
				$this->data['mclite_cdn_cssurl'] = $this->config->get('mclite_cdn_cssurl');
			}

		if (isset($this->request->post['mclite_css_processing'])) {
			$this->data['mclite_css_processing'] = $this->request->post['mclite_css_processing'];
		} else {
			$this->data['mclite_css_processing'] = $this->config->get('mclite_css_processing');
		}
		if (isset($this->request->post['mclite_css_not_processing_list'])) {
			$this->data['mclite_css_not_processing_list'] = $this->request->post['mclite_css_not_processing_list'];
		} else {
			$this->data['mclite_css_not_processing_list'] = $this->config->get('mclite_css_not_processing_list');
		}
		if (isset($this->request->post['mclite_css_merge'])) {
			$this->data['mclite_css_merge'] = $this->request->post['mclite_css_merge'];
		} else {
			$this->data['mclite_css_merge'] = $this->config->get('mclite_css_merge');
		}
		if (isset($this->request->post['mclite_css_not_merge_list'])) {
			$this->data['mclite_css_not_merge_list'] = $this->request->post['mclite_css_not_merge_list'];
		} else {
			$this->data['mclite_css_not_merge_list'] = $this->config->get('mclite_css_not_merge_list');
		}
		if (isset($this->request->post['mclite_css_minimize'])) {
			$this->data['mclite_css_minimize'] = $this->request->post['mclite_css_minimize'];
		} else {
			$this->data['mclite_css_minimize'] = $this->config->get('mclite_css_minimize');
		}
		if (isset($this->request->post['mclite_css_not_minimize_list'])) {
			$this->data['mclite_css_not_minimize_list'] = $this->request->post['mclite_css_not_minimize_list'];
		} else {
			$this->data['mclite_css_not_minimize_list'] = $this->config->get('mclite_css_not_minimize_list');
		}
		if (isset($this->request->post['mclite_css_stay_position_list'])) {
			$this->data['mclite_css_stay_position_list'] = $this->request->post['mclite_css_stay_position_list'];
		} else {
			$this->data['mclite_css_stay_position_list'] = $this->config->get('mclite_css_stay_position_list');
		}

		if (isset($this->request->post['mclite_css_minimize_library'])) {
			$this->data['mclite_css_minimize_library'] = $this->request->post['mclite_css_minimize_library'];
		} else {
			$this->data['mclite_css_minimize_library'] = $this->config->get('mclite_css_minimize_library');
		}
		if (isset($this->request->post['mclite_css_minimize_library_settings'])) {
			$this->data['mclite_css_minimize_library_settings'] = $this->request->post['mclite_css_minimize_library_settings'];
		} else {
			$this->data['mclite_css_minimize_library_settings'] = $this->config->get('mclite_css_minimize_library_settings');
		}
		if (isset($this->request->post['mclite_css_include_base64_images_into_css'])) {
			$this->data['mclite_css_include_base64_images_into_css'] = $this->request->post['mclite_css_include_base64_images_into_css'];
		} else {
			$this->data['mclite_css_include_base64_images_into_css'] = $this->config->get('mclite_css_include_base64_images_into_css');
		}
		if (isset($this->request->post['mclite_css_include_base64_images_max_size'])) {
			$this->data['mclite_css_include_base64_images_max_size'] = $this->request->post['mclite_css_include_base64_images_max_size'];
		} else {
			$this->data['mclite_css_include_base64_images_max_size'] = $this->config->get('mclite_css_include_base64_images_max_size');
		}
		if (isset($this->request->post['mclite_css_include_once_base64_images_list'])) {
			$this->data['mclite_css_include_once_base64_images_list'] = $this->request->post['mclite_css_include_once_base64_images_list'];
		} else {
			$this->data['mclite_css_include_once_base64_images_list'] = $this->config->get('mclite_css_include_once_base64_images_list');
		}
		if (isset($this->request->post['mclite_css_not_include_base64_images_list'])) {
			$this->data['mclite_css_not_include_base64_images_list'] = $this->request->post['mclite_css_not_include_base64_images_list'];
		} else {
			$this->data['mclite_css_not_include_base64_images_list'] = $this->config->get('mclite_css_not_include_base64_images_list');
		}
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		$this->template = 'mclite/setting.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->data['ht_is_file'] = is_file('../.htaccess');
		if ($this->data['ht_is_file']) {
			$this->data['htaccess_content'] = @file_get_contents('../.htaccess');
			$this->data['htaccess_has_gz'] = ($this->data['ht_is_file']) ? preg_match('/(jsgz|cssgz)/', $this->data['htaccess_content']) : false;
			$this->data['ht_is_writable'] = is_writable('../.htaccess');
		}
		$this->data['apache_m'] = (function_exists('apache_get_modules'))? apache_get_modules() : null;
				
		$this->response->setOutput($this->render());
		
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'mclite/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

	 	// if (!$this->request->post['config_name']) {
	 	// 	$this->error['name'] = $this->language->get('error_name');
	 	// }	
		// if (!$this->request->post['config_name']) {
	 	// 		$this->error['name'] = $this->language->get('error_name');
	 	// 	}
		
		if (!$this->error) {return true;} else {return false;}
	}
	public function delete(){
		$this->load->language('mclite/setting');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('mclite/setting');
		$cache_list = json_decode($this->config->get('mclite_cache_list'), true);

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $name) {
				if (array_key_exists($name, $cache_list)) {
					if (is_file('../'.$cache_list[$name]['filename'])){
						unlink('../'.$cache_list[$name]['filename']);
					}
					if (is_file('../'.$cache_list[$name]['filename'].'gz')) {
						unlink('../'.$cache_list[$name]['filename'].'gz');
					}
						unset($cache_list[$name]);
				}
			}
			$this->model_mclite_setting->saveCache(json_encode($cache_list));
			$this->session->data['success'] = $this->language->get('text_success');
		}
		$this->redirect($this->url->link('mclite/setting', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function edit(){
		$this->load->language('mclite/setting');

		$this->load->model('mclite/setting');
		$this->document->setTitle($this->language->get('heading_title'));
		if (isset($this->request->post['htaccess_text']) && $this->validateDelete() && $this->validateEdit()) {
			file_put_contents('../.htaccess', htmlspecialchars_decode($this->request->post['htaccess_text']));
			$this->session->data['success'] = $this->language->get('text_success');
		}
		$this->redirect($this->url->link('mclite/setting', 'token=' . $this->session->data['token'], 'SSL'));
	}
	private function validateEdit() {
		if(!is_writable('../.htaccess')){
			$this->error['warning'] = $this->language->get('error_permission_edit');
		}
		if (!$this->error) {
			return TRUE; 
		} else {
			return FALSE;
		}		
	}
	
	public function optimize_db(){
		$this->load->language('mclite/setting');

		$this->load->model('mclite/setting');
		$this->document->setTitle($this->language->get('heading_title'));
		//Unset client private parameters
		if ($this->user->hasPermission('modify', 'mclite/setting')) {
			$this->model_mclite_setting->optimizeTables();
			$this->session->data['success'] = $this->language->get('text_success_db_optim');
		}else{
 			$this->session->data['warning']= $this->language->get('error_permission');
		}

		$this->redirect($this->url->link('mclite/setting', 'token=' . $this->session->data['token'], 'SSL'));
	}
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'mclite/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return TRUE; 
		} else {
			return FALSE;
		}
	}
	public function check_rights(){
		$this->load->language('mclite/setting');

		$this->load->model('mclite/setting');
		$this->document->setTitle($this->language->get('heading_title'));
		$result = false;
		if (isset($this->request->post['dir'])){
			if ($this->user->hasPermission('modify', 'mclite/setting')) {
				$result['w'] = (is_writable(trim('../'.$this->request->post['dir'], '/').'/'))?1:2;
			}else{
				$result['w'] = 3;
			}
		}
		$this->data['ajax'] = json_encode($result);
		$this->template = 'mclite/ajax.tpl';
		$this->response->setOutput($this->render());
	}
}
?>