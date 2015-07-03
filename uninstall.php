<?php if(!defined('WP_UNINSTALL_PLUGIN')) { exit(); }

// Delete options for mediaqueries -------------------------------------------------------------------------------------------------------------------------
delete_option('mis_imgWidth_firstMq');
delete_option('mis_imgWidth_secondMq');
delete_option('mis_imgWidth_thirdMq');
delete_option('mis_imgWidth_fourthMq');

// Delete options for image sizes -------------------------------------------------------------------------------------------------------------------------
delete_option('mis_imgWidth_noMq');
delete_option('mis_imgWidth_noMq_R');
delete_option('mis_imgWidth_fatscreen');

// Delete options for srcset-sizes -------------------------------------------------------------------------------------------------------------------------
delete_option('mis_srcsetSize_noMq');
delete_option('mis_srcsetSize_firstMq');
delete_option('mis_srcsetSize_secondMq');
delete_option('mis_srcsetSize_thirdMq');
delete_option('mis_srcsetSize_fourthMq');

// Delete options for images pulled by WYSIWYG-editor -------------------------------------------------------------------------------------------------------------------------
delete_option('mis_contentFilter');
delete_option('mis_shortcode');

// Delete options for JS-libraries -------------------------------------------------------------------------------------------------------------------------
delete_option('mis_picturefill');
delete_option('mis_userpathPicturefill');
delete_option('mis_lazyload');
delete_option('mis_userpathLazyload');

// Delete options for Styles -------------------------------------------------------------------------------------------------------------------------
delete_option('mis_preventDuplicates');