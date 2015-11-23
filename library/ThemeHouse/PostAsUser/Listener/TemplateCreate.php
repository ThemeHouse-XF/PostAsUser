<?php

class ThemeHouse_PostAsUser_Listener_TemplateCreate extends ThemeHouse_Listener_TemplateCreate
{

    protected function _getTemplates()
    {
        return array(
            'thread_create',
            'thread_view'
        );
    } /* END _getTemplates */

    public static function templateCreate(&$templateName, array &$params, XenForo_Template_Abstract $template)
    {
        $templateCreate = new ThemeHouse_PostAsUser_Listener_TemplateCreate($templateName, $params, $template);
        list($templateName, $params) = $templateCreate->run();
    } /* END templateCreate */

    protected function _threadCreate()
    {
        $this->_preloadTemplate('th_post_as_user_field_postasuser');
    } /* END _threadCreate */

    protected function _threadView()
    {
        $this->_preloadTemplates(
            array(
                'th_quick_reply_prepend_postasuser',
                'th_post_as_user_field_postasuser'
            ));
    } /* END _threadView */
}