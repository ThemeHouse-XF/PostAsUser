<?php

/**
 *
 * @see XenForo_DataWriter_DiscussionMessage_Post
 */
class ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_DiscussionMessage_Post extends XFCP_ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_DiscussionMessage_Post
{

    /**
     *
     * @see XenForo_DataWriter_Discussion_Thread::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();
        
        $fields['xf_post']['original_poster_th'] = array(
            'type' => self::TYPE_SERIALIZED,
            'default' => 'a:0:{}'
        );
        
        return $fields;
    } /* END _getFields */

    /**
     *
     * @see XenForo_DataWriter_DiscussionMessage_Post::_messagePreSave()
     */
    protected function _messagePreSave()
    {
        if ($this->isDiscussionFirstMessage() && isset($GLOBALS['XenForo_ControllerPublic_Forum'])) {
            $visitor = XenForo_Visitor::getInstance();
            $this->set('original_poster_th',
                array(
                    'user_id' => $visitor->user_id,
                    'username' => $visitor->username,
                ));
        }
        if (!empty($GLOBALS['XenForo_ControllerPublic_Thread'])) {
            /* @var $controller XenForo_ControllerPublic_Thread */
            $controller = $GLOBALS['XenForo_ControllerPublic_Thread'];
            
            $this->set('original_poster_th',
                array(
                    'user_id' => $this->get('user_id'),
                    'username' => $this->get('username')
                ));
            
            /* @var $userModel XenForo_Model_User */
            $userModel = XenForo_Model::create('XenForo_Model_User');
            
            $input = $controller->getInput()->filter(
                array(
                    'post_as_user_id' => XenForo_Input::UINT,
                    'post_as_username' => XenForo_Input::STRING
                ));
            if ($input['post_as_username']) {
                $user = $userModel->getUserByName($input['post_as_username']);
                $input['post_as_user_id'] = $user['user_id'];
            }
            if (!isset($user) && $input['post_as_user_id']) {
                $user = $userModel->getUserById($input['post_as_user_id']);
            }
            
            if (isset($user) && $userModel->canPostAsDifferentUser($user)) {
                $this->set('user_id', $user['user_id']);
                $this->set('username', $user['username']);
                
                if (XenForo_Application::get('options')->th_postAsUser_updateLastActivity) {
                    /* @var $userModel XenForo_Model_User */
                    $userModel = $this->getModelFromCache('XenForo_Model_User');
                    $request = $controller->getRequest();
                    $routeMatch = $controller->getRouteMatch();
                    $userModel->updateSessionActivity($user['user_id'], $request->getClientIp(false), 
                        $routeMatch->getControllerName(), $routeMatch->getAction(), 'valid', $request->getUserParams());
                }
            }
        }
        
        parent::_messagePreSave();
    } /* END _messagePreSave */
}