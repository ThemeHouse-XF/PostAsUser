<?php

class ThemeHouse_PostAsUser_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/PostAsUser/Extend/XenForo/ControllerPublic/Forum.php' => '3f0841d5a3827def6e2bc393d216934a',
                'library/ThemeHouse/PostAsUser/Extend/XenForo/ControllerPublic/Member.php' => '9d768de91d760f2819ebe925f9fa3461',
                'library/ThemeHouse/PostAsUser/Extend/XenForo/ControllerPublic/Thread.php' => 'eec1790de529b940d1a79ea8cf6d7056',
                'library/ThemeHouse/PostAsUser/Extend/XenForo/DataWriter/Discussion/Thread.php' => 'a72fe3ec6fc33c6cb103819ee1c698dc',
                'library/ThemeHouse/PostAsUser/Extend/XenForo/DataWriter/DiscussionMessage/Post.php' => '15b82d44f944697ab31b2707d722fb2c',
                'library/ThemeHouse/PostAsUser/Extend/XenForo/Model/Ip.php' => 'e239e819b513efcf21c55cee57782c6e',
                'library/ThemeHouse/PostAsUser/Extend/XenForo/Model/User.php' => 'f86040d6cca5fb7e12834824a4a9e77c',
                'library/ThemeHouse/PostAsUser/Install/Controller.php' => '4abd75ed7b49540d3c74532a781843b3',
                'library/ThemeHouse/PostAsUser/Listener/LoadClass.php' => 'd53762d3ebb50be315463340f3fa83a1',
                'library/ThemeHouse/PostAsUser/Listener/TemplateCreate.php' => '3c7f80c0340818254e4a2a271a4ca9f2',
                'library/ThemeHouse/PostAsUser/Listener/TemplateHook.php' => 'b01ea73358cb284d7f56d266271adcb0',
                'library/ThemeHouse/PostAsUser/Listener/TemplatePostRender.php' => 'c683040c94e6e9b50507eb0ec904be06',
                'library/ThemeHouse/PostAsUser/Option/UserGroups.php' => '4e2bf8f72d188ebcb1f695fe972ce2c1',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
                'library/ThemeHouse/Listener/Template.php' => '0aa5e8aabb255d39cf01d671f9df0091',
                'library/ThemeHouse/Listener/Template/20150106.php' => '8d42b3b2d856af9e33b69a2ce1034442',
                'library/ThemeHouse/Listener/TemplateCreate.php' => '6bdeb679af2ea41579efde3e41e65cc7',
                'library/ThemeHouse/Listener/TemplateCreate/20150106.php' => 'c253a7a2d3a893525acf6070e9afe0dd',
                'library/ThemeHouse/Listener/TemplateHook.php' => 'a767a03baad0ca958d19577200262d50',
                'library/ThemeHouse/Listener/TemplateHook/20150106.php' => '71c539920a651eef3106e19504048756',
                'library/ThemeHouse/Listener/TemplatePostRender.php' => 'b6da98a55074e4cde833abf576bc7b5d',
                'library/ThemeHouse/Listener/TemplatePostRender/20150106.php' => 'efccbb2b2340656d1776af01c25d9382',
            ));
    }
}