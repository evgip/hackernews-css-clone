<?php

    $this->addTplJSName('jquery-ui');
    $this->addTplCSSName('jquery-ui');

    $this->setPagePatternTitle($profile, 'nickname');
    $this->setPagePatternDescription($profile, 'nickname');

    if($this->controller->listIsAllowed()){
        $this->addBreadcrumb(LANG_USERS, href_to('users'));
    }
    $this->addBreadcrumb($profile['nickname']);

    $this->addToolButtons($tool_buttons);

?>

<div id="user_profile_header">
    <?php $this->renderChild('profile_header', array('profile'=>$profile, 'tabs'=>$tabs)); ?>
</div>
 