<?php

class ThemeHouse_PostAsUser_Listener_TemplatePostRender extends ThemeHouse_Listener_TemplatePostRender
{

    protected function _getTemplates()
    {
        return array(
            'thread_view',
        );
    } /* END _getTemplates */

    public static function templatePostRender($templateName, &$content, array &$containerData,
        XenForo_Template_Abstract $template)
    {
        $templatePostRender = new ThemeHouse_PostAsUser_Listener_TemplatePostRender($templateName, $content,
            $containerData, $template);
        list($content, $containerData) = $templatePostRender->run();
    } /* END templatePostRender */

    protected function _threadView()
    {
        /* @var $userModel XenForo_Model_User */
        $userModel = XenForo_Model::create('XenForo_Model_User');

        if ($userModel->canPostAsDifferentUsers()) {
            $viewParams = $this->_fetchViewParams();
            if (ThemeHouse_Listener_ControllerPreDispatch::isAddOnEnabled('ThemeHouse_AutoCombo', 'load_class_controller')) {
                $viewParams['useAutoCombo'] = true;
            }
            $viewParams['showMoreOptions'] = true;
            $codeSnippet = $this->_render('th_quick_reply_prepend_postasuser', $viewParams);
            $prepend = "<div class='xenForm'>" . $this->_render('th_post_as_user_field_postasuser') . "</div>";
            $this->_appendAtCodeSnippet($codeSnippet, $prepend, $this->_contents, false);
        }
    } /* END _threadView */
}