<?php

class ThemeHouse_PostAsUser_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_PostAsUser' => array(
                'controller' => array(
                    'XenForo_ControllerPublic_Forum',
                    'XenForo_ControllerPublic_Thread',
                    'XenForo_ControllerPublic_Member'
                ), /* END 'controller' */
                'datawriter' => array(
                    'XenForo_DataWriter_Discussion_Thread',
                    'XenForo_DataWriter_DiscussionMessage_Post'
                ), /* END 'datawriter' */
                'model' => array(
                    'XenForo_Model_User',
                    'XenForo_Model_Ip'
                ), /* END 'model' */
            ), /* END 'ThemeHouse_PostAsUser' */
        );
    } /* END _getExtendedClasses */

    public static function loadClassController($class, array &$extend)
    {
        $loadClassController = new ThemeHouse_PostAsUser_Listener_LoadClass($class, $extend, 'controller');
        $extend = $loadClassController->run();
    } /* END loadClassController */

    public static function loadClassDataWriter($class, array &$extend)
    {
        $loadClassDataWriter = new ThemeHouse_PostAsUser_Listener_LoadClass($class, $extend, 'datawriter');
        $extend = $loadClassDataWriter->run();
    } /* END loadClassDataWriter */

    public static function loadClassModel($class, array &$extend)
    {
        $loadClassModel = new ThemeHouse_PostAsUser_Listener_LoadClass($class, $extend, 'model');
        $extend = $loadClassModel->run();
    } /* END loadClassModel */
}