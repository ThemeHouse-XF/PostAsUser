<?php

/**
 *
 * @see XenForo_Model_Ip
 */
class ThemeHouse_PostAsUser_Extend_XenForo_Model_Ip extends XFCP_ThemeHouse_PostAsUser_Extend_XenForo_Model_Ip
{

    /**
     *
     * @see XenForo_Model_Ip::getSharedIpUsers()
     */
    public function getSharedIpUsers($userId, $logDays)
    {
        $users = parent::getSharedIpUsers($userId, $logDays);

        $db = $this->_getDb();

        $ipLogs = $db->fetchCol(
            $db->limit(
                '
				SELECT DISTINCT ip_address
				FROM xf_moderator_log
				WHERE content_type IN (\'thread\', \'post\')
                    AND action = \'post_as_user\'
                    AND log_date > ?
			', 500), XenForo_Application::$time - $logDays * 86400);

        foreach ($ipLogs as $key => $ipLog) {
            $ipLogs[$key] = XenForo_Helper_Ip::convertIpBinaryToString($ipLog);
        }

        foreach ($users as $userId => $user) {
            foreach ($user['ipLogs'] as $key => $ipLog) {
                if (in_array($ipLog['ip_address'], $ipLogs)) {
                    unset($user['ipLogs'][$key]);
                }
            }
            if (empty($user['ipLogs'])) {
                unset($users[$userId]);
            }
        }

        return $users;
    } /* END getSharedIpUsers */
}