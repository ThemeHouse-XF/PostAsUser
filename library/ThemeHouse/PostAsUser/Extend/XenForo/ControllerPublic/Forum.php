<?php

/**
 *
 * @see XenForo_ControllerPublic_Forum
 */
class ThemeHouse_PostAsUser_Extend_XenForo_ControllerPublic_Forum extends XFCP_ThemeHouse_PostAsUser_Extend_XenForo_ControllerPublic_Forum
{

    /**
     *
     * @see XenForo_ControllerPublic_Forum::actionCreateThread()
     */
    public function actionCreateThread()
    {
        $response = parent::actionCreateThread();

        if ($response instanceof XenForo_ControllerResponse_View) {
            /* @var $xenOptions XenForo_Options */
            $xenOptions = XenForo_Application::get('options');

            if ($xenOptions->th_postAsUser_useComboBox) {
                $response->params['useAutoCombo'] = ThemeHouse_Listener_ControllerPreDispatch::isAddOnEnabled(
                    'ThemeHouse_AutoCombo', 'load_class_controller');
            } else {
                /* @var $userModel XenForo_Model_User */
                $userModel = XenForo_Model::create('XenForo_Model_User');
                $response->params['postAsUsers'] = $userModel->getPostAsDifferentUsers();
            }
        }

        return $response;
    } /* END actionCreateThread */

    /**
     *
     * @see XenForo_ControllerPublic_Forum::actionAddThread()
     */
    public function actionAddThread()
    {
        $GLOBALS['XenForo_ControllerPublic_Forum'] = $this;

        return parent::actionAddThread();
    } /* END actionAddThread */
}