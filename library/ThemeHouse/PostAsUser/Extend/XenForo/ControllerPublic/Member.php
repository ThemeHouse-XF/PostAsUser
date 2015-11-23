<?php

/**
 *
 * @see XenForo_ControllerPublic_Member
 */
class ThemeHouse_PostAsUser_Extend_XenForo_ControllerPublic_Member extends XFCP_ThemeHouse_PostAsUser_Extend_XenForo_ControllerPublic_Member
{

    public function actionFindPostAsUserAutoCombo()
    {
        $q = $this->_input->filterSingle('q', XenForo_Input::STRING);

        $users = array();
        if ($this->_getUserModel()->canPostAsDifferentUsers()) {
            $conditions = array();
            if ($q) {
                $conditions['username'] = array(
                    $q,
                    'r'
                );
            }
            $users = $this->_getUserModel()->getPostAsDifferentUsers($conditions);
        }

        $viewParams = array(
            'users' => $users
        );

        return $this->responseView('XenForo_ViewPublic_Member_Find', 'member_autocomplete', $viewParams);
    } /* END actionFindPostAsUserAutoCombo */

    public function actionFindPostAsUser()
    {
        $q = $this->_input->filterSingle('q', XenForo_Input::STRING);

        $users = array();
        if ($this->_getUserModel()->canPostAsDifferentUsers()) {
            if ($q !== '' && utf8_strlen($q) >= 2) {
                $conditions = array(
                    'username' => array(
                        $q,
                        'r'
                    )
                );
                $users = $this->_getUserModel()->getPostAsDifferentUsers($conditions);
            }
        }

        $viewParams = array(
            'users' => $users
        );

        return $this->responseView('XenForo_ViewPublic_Member_Find', 'member_autocomplete', $viewParams);
    } /* END actionFindPostAsUser */
}