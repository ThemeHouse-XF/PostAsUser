<?php

/**
 *
 * @see XenForo_DataWriter_Discussion_Thread
 */
class ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_Discussion_Thread_Base extends XFCP_ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_Discussion_Thread
{

    const OPTION_POSTED_AS_USER = 'postedAsUser';

    protected function _getDefaultOptions()
    {
        $default = parent::_getDefaultOptions();
        $default[self::OPTION_POSTED_AS_USER] = 0;
        
        return $default;
    } /* END _getDefaultOptions */
    
    /**
     *
     * @see XenForo_DataWriter_Discussion_Thread::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();
    
        $fields['xf_thread']['original_creator_th'] = array(
            'type' => self::TYPE_SERIALIZED,
            'default' => 'a:0:{}'
        );
    
        return $fields;
    } /* END _getFields */

    /**
     *
     * @see XenForo_DataWriter_Discussion_Thread::_discussionPreSave()
     */
    protected function _discussionPreSave()
    {
        if (isset($GLOBALS['XenForo_ControllerPublic_Forum'])) {
            /* @var $controller XenForo_ControllerPublic_Forum */
            $controller = $GLOBALS['XenForo_ControllerPublic_Forum'];
            
            $this->set('original_creator_th',
                array(
                    'user_id' => $this->get('user_id'),
                    'username' => $this->get('username')
                )
            );
            
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
                $this->set('last_post_user_id', $user['user_id']);
                $this->set('last_post_username', $user['username']);
                
                $this->setOption(self::OPTION_POSTED_AS_USER, true);
                
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
        
        parent::_discussionPreSave();
    } /* END _discussionPreSave */
}

if (XenForo_Application::$versionId < 1020000) {

    class ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_Discussion_Thread extends ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_Discussion_Thread_Base
    {

        /**
         *
         * @see XenForo_DataWriter_Discussion_Thread::_discussionPostSave()
         */
        protected function _discussionPostSave(array $messages)
        {
            if ($this->getOption(self::OPTION_POSTED_AS_USER)) {
                if (XenForo_Application::get('options')->th_postAsUser_addToModeratorLog) {
                    XenForo_Model_Log::logModeratorAction('thread', $this->getMergedData(), 'post_as_user');
                }
            }
            
            parent::_discussionPostSave($messages);
        }
    } /* END _discussionPostSave */
} else {

    class ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_Discussion_Thread extends ThemeHouse_PostAsUser_Extend_XenForo_DataWriter_Discussion_Thread_Base
    {

        /**
         *
         * @see XenForo_DataWriter_Discussion_Thread::_discussionPostSave()
         */
        protected function _discussionPostSave()
        {
            if ($this->getOption(self::OPTION_POSTED_AS_USER)) {
                if (XenForo_Application::get('options')->th_postAsUser_addToModeratorLog) {
                    XenForo_Model_Log::logModeratorAction('thread', $this->getMergedData(), 'post_as_user');
                }
            }
            
            parent::_discussionPostSave();
        }
    } /* END _discussionPostSave */
}