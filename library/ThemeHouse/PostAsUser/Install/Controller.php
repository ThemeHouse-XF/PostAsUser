<?php

class ThemeHouse_PostAsUser_Install_Controller extends ThemeHouse_Install
{

    protected $_resourceManagerUrl = 'http://xenforo.com/community/resources/post-as-user.1150/';

    protected $_minVersionId = 1010000;

    protected $_minVersionString = '1.1.0';

    protected function _getTableChanges()
    {
        return array(
            'xf_post' => array(
                'original_poster_th' => 'TEXT', /* END 'original_poster_th' */
            ), /* END 'xf_post' */
            'xf_thread' => array(
                'original_creator_th' => 'TEXT', /* END 'original_creator_th' */
            ), /* END 'xf_thread' */
        );
    } /* END _getTableChanges */


    protected function _postInstall()
    {
        $addOn = $this->getModelFromCache('XenForo_Model_AddOn')->getAddOnById('YoYo_');
        if ($addOn) {
            $db->query("
                UPDATE xf_post
                    SET original_poster_th=original_poster_waindigo");
            $db->query("
                UPDATE xf_thread
                    SET original_creator_th=original_creator_waindigo");
        }
    }
}