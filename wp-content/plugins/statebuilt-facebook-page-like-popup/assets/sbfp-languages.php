<?php 

// Set up Language Options
function sbfp_language_options() {
	$options  	= (array)get_option('sbfp');
	$language 	= $options['sbfp_language']; // Facebook Page Language Option
?>
	<p class="settings-field-desc">Enter the Language you would like to display on your Popup.</p>
	<select name="sbfp[sbfp_language]" id="sbfp_language">
		<option <?php if($language === 'af_ZA'){ echo 'selected'; } ?> value="af_ZA">Afrikaans</option>
		<option <?php if($language === 'ar_AR'){ echo 'selected'; } ?> value="ar_AR">Arabic</option>
		<option <?php if($language === 'az_AZ'){ echo 'selected'; } ?> value="az_AZ">Azerbaijani</option>
		<option <?php if($language === 'be_BY'){ echo 'selected'; } ?> value="be_BY">Belarusian</option>
		<option <?php if($language === 'bg_BG'){ echo 'selected'; } ?> value="bg_BG">Bulgarian</option>
		<option <?php if($language === 'bn_IN'){ echo 'selected'; } ?> value="bn_IN">Bengali</option>
		<option <?php if($language === 'br_FR'){ echo 'selected'; } ?> value="br_FR">Breton</option>
		<option <?php if($language === 'bs_BA'){ echo 'selected'; } ?> value="bs_BA">Bosnian</option>
		<option <?php if($language === 'ca_ES'){ echo 'selected'; } ?> value="ca_ES">Catalan</option>
		<option <?php if($language === 'zh_CN'){ echo 'selected'; } ?> value="zh_CN">Chinese (China)</option>
		<option <?php if($language === 'zh_HK'){ echo 'selected'; } ?> value="zh_HK">Chinese (Hong Kong)</option>
		<option <?php if($language === 'zh_TW'){ echo 'selected'; } ?> value="zh_TW">Chinese (Taiwan)</option>
		<option <?php if($language === 'cb_IQ'){ echo 'selected'; } ?> value="cb_IQ">Sorani Kurdish</option>
		<option <?php if($language === 'cs_CZ'){ echo 'selected'; } ?> value="cs_CZ">Czech</option>
		<option <?php if($language === 'cx_PH'){ echo 'selected'; } ?> value="cx_PH">Cebuano</option>
		<option <?php if($language === 'cy_GB'){ echo 'selected'; } ?> value="cy_GB">Welsh</option>
		<option <?php if($language === 'da_DK'){ echo 'selected'; } ?> value="da_DK">Danish</option>
		<option <?php if($language === 'de_DE'){ echo 'selected'; } ?> value="de_DE">German</option>
		<option <?php if($language === 'el_GR'){ echo 'selected'; } ?> value="el_GR">Greek</option>
		<option <?php if($language === 'en_US'){ echo 'selected'; } ?> value="en_US">English (U.S.)</option>
		<option <?php if($language === 'en_GB'){ echo 'selected'; } ?> value="en_GB">English (U.K.)</option>
		<option <?php if($language === 'eo_EO'){ echo 'selected'; } ?> value="eo_EO">Esperanto</option>
		<option <?php if($language === 'es_LA'){ echo 'selected'; } ?> value="es_LA">Spanish</option>
		<option <?php if($language === 'et_EE'){ echo 'selected'; } ?> value="et_EE">Estonian</option>
		<option <?php if($language === 'eu_ES'){ echo 'selected'; } ?> value="eu_ES">Basque</option>
		<option <?php if($language === 'fa_IR'){ echo 'selected'; } ?> value="fa_IR">Persian</option>
		<option <?php if($language === 'fi_FI'){ echo 'selected'; } ?> value="fi_FI">Finnish</option>
		<option <?php if($language === 'fo_FO'){ echo 'selected'; } ?> value="fo_FO">Faroese</option>
		<option <?php if($language === 'fr_CA'){ echo 'selected'; } ?> value="fr_CA">French (Canada)</option>
		<option <?php if($language === 'fr_FR'){ echo 'selected'; } ?> value="fr_FR">French (France)</option>
		<option <?php if($language === 'fy_NL'){ echo 'selected'; } ?> value="fy_NL">Frisian</option>
		<option <?php if($language === 'ga_IE'){ echo 'selected'; } ?> value="ga_IE">Irish</option>
		<option <?php if($language === 'gl_ES'){ echo 'selected'; } ?> value="gl_ES">Galician</option>
		<option <?php if($language === 'gn_PY'){ echo 'selected'; } ?> value="gn_PY">Guarani</option>
		<option <?php if($language === 'gu_IN'){ echo 'selected'; } ?> value="gu_IN">Gujarati</option>
		<option <?php if($language === 'he_IL'){ echo 'selected'; } ?> value="he_IL">Hebrew</option>
		<option <?php if($language === 'hi_IN'){ echo 'selected'; } ?> value="hi_IN">Hindi</option>
		<option <?php if($language === 'hr_HR'){ echo 'selected'; } ?> value="hr_HR">Croatian</option>
		<option <?php if($language === 'hu_HU'){ echo 'selected'; } ?> value="hu_HU">Hungarian</option>
		<option <?php if($language === 'hy_AM'){ echo 'selected'; } ?> value="hy_AM">Armenian</option>
		<option <?php if($language === 'id_ID'){ echo 'selected'; } ?> value="id_ID">Indonesian</option>
		<option <?php if($language === 'is_IS'){ echo 'selected'; } ?> value="is_IS">Icelandic</option>
		<option <?php if($language === 'it_IT'){ echo 'selected'; } ?> value="it_IT">Italian</option>
		<option <?php if($language === 'ja_JP'){ echo 'selected'; } ?> value="ja_JP">Japanese</option>
		<option <?php if($language === 'ja_KS'){ echo 'selected'; } ?> value="ja_KS">Japanese (Kansai)</option>
		<option <?php if($language === 'jv_ID'){ echo 'selected'; } ?> value="jv_ID">Javanese</option>
		<option <?php if($language === 'ka_GE'){ echo 'selected'; } ?> value="ka_GE">Georgian</option>
		<option <?php if($language === 'kk_KZ'){ echo 'selected'; } ?> value="kk_KZ">Kazakh</option>
		<option <?php if($language === 'km_KH'){ echo 'selected'; } ?> value="km_KH">Khmer</option>
		<option <?php if($language === 'kn_IN'){ echo 'selected'; } ?> value="kn_IN">Kannada</option>
		<option <?php if($language === 'ko_KR'){ echo 'selected'; } ?> value="ko_KR">Korean</option>
		<option <?php if($language === 'ku_TR'){ echo 'selected'; } ?> value="ku_TR">Kurdish (Kurmanji)</option>
		<option <?php if($language === 'la_VA'){ echo 'selected'; } ?> value="la_VA">Latin</option>
		<option <?php if($language === 'lt_LT'){ echo 'selected'; } ?> value="lt_LT">Lithuanian</option>
		<option <?php if($language === 'lv_LV'){ echo 'selected'; } ?> value="lv_LV">Latvian</option>
		<option <?php if($language === 'mk_MK'){ echo 'selected'; } ?> value="mk_MK">Macedonian</option>
		<option <?php if($language === 'ml_IN'){ echo 'selected'; } ?> value="ml_IN">Malayalam</option>
		<option <?php if($language === 'mn_MN'){ echo 'selected'; } ?> value="mn_MN">Mongolian</option>
		<option <?php if($language === 'mr_IN'){ echo 'selected'; } ?> value="mr_IN">Marathi</option>
		<option <?php if($language === 'ms_MY'){ echo 'selected'; } ?> value="ms_MY">Malay</option>
		<option <?php if($language === 'my_MM'){ echo 'selected'; } ?> value="my_MM">Burmese</option>
		<option <?php if($language === 'nb_NO'){ echo 'selected'; } ?> value="nb_NO">Norwegian (bokmal)</option>
		<option <?php if($language === 'ne_NP'){ echo 'selected'; } ?> value="ne_NP">Nepali</option>
		<option <?php if($language === 'nl_BE'){ echo 'selected'; } ?> value="nl_BE">Dutch (België)</option>
		<option <?php if($language === 'nl_NL'){ echo 'selected'; } ?> value="nl_NL">Dutch</option>
		<option <?php if($language === 'nn_NO'){ echo 'selected'; } ?> value="nn_NO">Norwegian (nynorsk)</option>
		<option <?php if($language === 'or_IN'){ echo 'selected'; } ?> value="or_IN">Oriya</option>
		<option <?php if($language === 'pa_IN'){ echo 'selected'; } ?> value="pa_IN">Punjabi</option>
		<option <?php if($language === 'pl_PL'){ echo 'selected'; } ?> value="pl_PL">Polish</option>
		<option <?php if($language === 'ps_AF'){ echo 'selected'; } ?> value="ps_AF">Pashto</option>
		<option <?php if($language === 'pt_BR'){ echo 'selected'; } ?> value="pt_BR">Portuguese (Brazil)</option>
		<option <?php if($language === 'pt_PT'){ echo 'selected'; } ?> value="pt_PT">Portuguese (Portugal)</option>
		<option <?php if($language === 'ro_RO'){ echo 'selected'; } ?> value="ro_RO">Romanian</option>
		<option <?php if($language === 'ru_RU'){ echo 'selected'; } ?> value="ru_RU">Russian</option>
		<option <?php if($language === 'rw_RW'){ echo 'selected'; } ?> value="rw_RW">Kinyarwanda</option>
		<option <?php if($language === 'si_LK'){ echo 'selected'; } ?> value="si_LK">Sinhala</option>
		<option <?php if($language === 'sk_SK'){ echo 'selected'; } ?> value="sk_SK">Slovak</option>
		<option <?php if($language === 'sl_SI'){ echo 'selected'; } ?> value="sl_SI">Slovenian</option>
		<option <?php if($language === 'sq_AL'){ echo 'selected'; } ?> value="sq_AL">Albanian</option>
		<option <?php if($language === 'sr_RS'){ echo 'selected'; } ?> value="sr_RS">Serbian</option>
		<option <?php if($language === 'sv_SE'){ echo 'selected'; } ?> value="sv_SE">Swedish</option>
		<option <?php if($language === 'sw_KE'){ echo 'selected'; } ?> value="sw_KE">Swahili</option>
		<option <?php if($language === 'ta_IN'){ echo 'selected'; } ?> value="ta_IN">Tamil</option>
		<option <?php if($language === 'te_IN'){ echo 'selected'; } ?> value="te_IN">Telugu</option>
		<option <?php if($language === 'tg_TJ'){ echo 'selected'; } ?> value="tg_TJ">Tajik</option>
		<option <?php if($language === 'th_TH'){ echo 'selected'; } ?> value="th_TH">Thai</option>
		<option <?php if($language === 'tl_PH'){ echo 'selected'; } ?> value="tl_PH">Filipino</option>
		<option <?php if($language === 'tr_TR'){ echo 'selected'; } ?> value="tr_TR">Turkish</option>
		<option <?php if($language === 'uk_UA'){ echo 'selected'; } ?> value="uk_UA">Ukrainian</option>
		<option <?php if($language === 'ur_PK'){ echo 'selected'; } ?> value="ur_PK">Urdu</option>
		<option <?php if($language === 'uz_UZ'){ echo 'selected'; } ?> value="uz_UZ">Uzbek</option>
		<option <?php if($language === 'vi_VN'){ echo 'selected'; } ?> value="vi_VN">Vietnamese</option>
	</select>
<?php 
}
?>