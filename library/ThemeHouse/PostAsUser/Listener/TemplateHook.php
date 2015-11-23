<?php

class ThemeHouse_PostAsUser_Listener_TemplateHook extends ThemeHouse_Listener_TemplateHook
{

    protected function _getHooks()
    {
        return array(
            'thread_create_fields_extra',
            'thread_reply',
            'message_user_info_avatar'
        );
    } /* END _getHooks */

    public static function templateHook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template)
    {
        $templateHook = new ThemeHouse_PostAsUser_Listener_TemplateHook($hookName, $contents, $hookParams, $template);
        $contents = $templateHook->run();
    } /* END templateHook */

    protected function _threadCreateFieldsExtra()
    {
        /* @var $userModel XenForo_Model_User */
        $userModel = XenForo_Model::create('XenForo_Model_User');
        
        if ($userModel->canPostAsDifferentUsers()) {
            $viewParams = $this->_fetchViewParams();
            if (ThemeHouse_Listener_ControllerPreDispatch::isAddOnEnabled('ThemeHouse_AutoCombo', 'load_class_controller')) {
                $viewParams['useAutoCombo'] = true;
            }
            $this->_appendTemplate('th_post_as_user_field_postasuser', $viewParams);
        }
    } /* END _threadCreateFieldsExtra */

    protected function _threadReply()
    {
        /* @var $userModel XenForo_Model_User */
        $userModel = XenForo_Model::create('XenForo_Model_User');
        
        if ($userModel->canPostAsDifferentUsers()) {
            $viewParams = $this->_fetchViewParams();
            if (ThemeHouse_Listener_ControllerPreDispatch::isAddOnEnabled('ThemeHouse_AutoCombo', 'load_class_controller')) {
                $viewParams['useAutoCombo'] = true;
            }
            $this->_appendTemplate('th_post_as_user_field_postasuser', $viewParams);
        }
    } /* END _threadReply */

    protected function _messageUserInfoAvatar()
    {
        $hookParams = $this->_hookParams;
        if (!empty($hookParams['user']['original_poster_array']) && XenForo_Application::get('options')->th_postAsUser_hideLink) {
            $pattern = '#(<a href=")(.*)("\sclass="avatar)#Us';
            $replacement = '';
            $this->_contents = preg_replace($pattern, '$1' . $replacement . '$3', $this->_contents);
        }
    } /* END _messageUserInfoAvatar */
}