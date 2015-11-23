<?php

/**
 *
 * @see XenForo_Model_User
 */
class ThemeHouse_PostAsUser_Extend_XenForo_Model_User extends XFCP_ThemeHouse_PostAsUser_Extend_XenForo_Model_User
{

    /**
     *
     * @param array $userGroupIds
     * @param array $conditions
     * @param array $fetchOptions
     */
    public function getUsersByUserGroupIds(array $userGroupIds, $conditions = array(), $fetchOptions = array())
    {
        $whereClause = $this->prepareUserConditions($conditions, $fetchOptions);

        $db = $this->_getDb();
        $groupConds[] = 'user.user_group_id IN (' . $db->quote($userGroupIds) . ')';
        foreach ($userGroupIds as $groupId) {
            $groupConds[] = 'FIND_IN_SET(' . $db->quote($groupId) . ', user.secondary_group_ids)';
        }
        return $this->fetchAllKeyed(
            '
			SELECT user.*
			FROM xf_user AS user
			WHERE ' . $whereClause . '
			    AND (' . implode(' OR ', $groupConds) . ')
		    ORDER BY username ASC
		', 'user_id');
    } /* END getUsersByUserGroupIds */

    /**
     * Determines if the viewing user can post as the specified user.
     *
     * @param array $user
     * @param string $errorPhraseKey
     *            By ref. More specific error, if available.
     * @param array|null $viewingUser
     *            Viewing user reference
     *
     * @return boolean
     */
    public function canPostAsDifferentUser(array $user, &$errorPhraseKey = '', array $viewingUser = null)
    {
        $this->standardizeViewingUserReference($viewingUser);
        if ($viewingUser['user_id'] &&
             XenForo_Permission::hasPermission($viewingUser['permissions'], 'general', 'postAsDifferentUser')) {
            if (empty($user) || !$user['user_id']) {
                return true;
            }

            $userGroupIds = XenForo_Application::get('options')->th_postAsUser_userGroups;

            if (is_array($userGroupIds)) {
                foreach (array_keys($userGroupIds) as $userGroupId) {
                    if ($this->isMemberOfUserGroup($user, $userGroupId)) {
                        return true;
                    }
                }
            }
        }
        return false;
    } /* END canPostAsDifferentUser */

    /**
     * Determines if the viewing user can post as a different user.
     *
     * @param string $errorPhraseKey
     *            By ref. More specific error, if available.
     * @param array|null $viewingUser
     *            Viewing user reference
     *
     * @return boolean
     */
    public function canPostAsDifferentUsers(&$errorPhraseKey = '', array $viewingUser = null)
    {
        $this->standardizeViewingUserReference($viewingUser);
        return ($viewingUser['user_id'] &&
             XenForo_Permission::hasPermission($viewingUser['permissions'], 'general', 'postAsDifferentUser'));
    } /* END canPostAsDifferentUsers */

    public function getPostAsDifferentUsers(array $conditions = array(), array $viewingUser = null)
    {
        $this->standardizeViewingUserReference($viewingUser);

        $users = array();
        if ($viewingUser['user_id'] &&
             XenForo_Permission::hasPermission($viewingUser['permissions'], 'general', 'postAsDifferentUser')) {
            $userGroupIds = array_keys(XenForo_Application::get('options')->th_postAsUser_userGroups);

            if (!empty($userGroupIds)) {
                $users = $this->getUsersByUserGroupIds($userGroupIds, $conditions);
                unset($users[XenForo_Visitor::getUserId()]);
            }
        }

        return $users;
    } /* END getPostAsDifferentUsers */ /* END getLoginAsUsers */
}