<?php

/**
 *
 * @see XenForo_ControllerPublic_Thread
 */
class ThemeHouse_PostAsUser_Extend_XenForo_ControllerPublic_Thread extends XFCP_ThemeHouse_PostAsUser_Extend_XenForo_ControllerPublic_Thread
{

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();
        
        /* @var $response XenForo_ControllerResponse_View */
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
            
            if ($xenOptions->th_postAsUser_hideLink || $xenOptions->th_postAsUser_showOriginalAuthor) {
                foreach ($response->params['posts'] as &$post) {
                    $postInfo = unserialize($post['original_poster_th']);
                    $post['original_poster_array'] = array(
                        'user_id' => $postInfo['user_id'],
                        'username' => $postInfo['username']
                    );
                }
                $threadInfo = unserialize($response->params['thread']['original_creator_th']);
                if (!empty($threadInfo)) {
                    $response->params['thread']['original_creator_array'] = $threadInfo;
                }
            }   
        }
        
        return $response;
    } /* END actionIndex */

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionReply()
     */
    public function actionReply()
    {
        $response = parent::actionReply();
        
        if ($response instanceof XenForo_ControllerResponse_View) {
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
    } /* END actionReply */

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionAddReply()
     */
    public function actionAddReply()
    {
        $GLOBALS['XenForo_ControllerPublic_Thread'] = $this;
        
        return parent::actionAddReply();
    } /* END actionAddReply */
}