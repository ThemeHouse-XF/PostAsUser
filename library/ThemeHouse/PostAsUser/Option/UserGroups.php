<?php

class ThemeHouse_PostAsUser_Option_UserGroups
{

    public static function renderOption(XenForo_View $view, $fieldPrefix, array $preparedOption, $canEdit)
    {
        /* @var $userGroupModel XenForo_Model_UserGroup */
        $userGroupModel = XenForo_Model::create('XenForo_Model_UserGroup');

        $preparedOption['formatParams'] = array();

        foreach ($userGroupModel->getAllUserGroupTitles() as $userGroupId => $userGroupName) {
            $preparedOption['formatParams'][] = array(
                'name' => "{$fieldPrefix}[{$preparedOption['option_id']}][$userGroupId]",
                'label' => $userGroupName,
                'selected' => !empty($preparedOption['option_value'][$userGroupId])
            );
        }

        return XenForo_ViewAdmin_Helper_Option::renderOptionTemplateInternal('option_list_option_checkbox', $view,
            $fieldPrefix, $preparedOption, $canEdit, array(
                'class' => 'checkboxColumns'
            ));
    } /* END renderOption */
}