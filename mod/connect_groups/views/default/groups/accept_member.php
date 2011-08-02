<div class="contentWrapper">

    <?php
    $group = $vars['entity'];
    $user = $vars['user'];
    ?>

    <p>Accepting the membership request of user <a href="/pg/profile/<?php echo $vars['user']->username ?>"><?php echo $vars['user']->username ?></a>
        (<?php echo $vars['user']->name ?>) to the group
        <a href="/pg/groups/<?php echo $vars['entity']->guid ?>"><?php echo $vars['entity']->name ?></a>.</p>


    <?php
    if ($group->joinrequestvote_enable == 'yes') {
        $annotations = $user->getAnnotations('join_vote_' . ($group->guid));
        $vote_up = array();
        $vote_down = array();
        $already_voted = false;
        if ($annotations) {
            foreach ($annotations as $ann) {
                if (substr($ann->value, 0, 3) == 'up:') {
                    $vote_up[] = $ann;
                } else
                if (substr($ann->value, 0, 3) == 'dn:') {
                    $vote_down[] = $ann;
                }
            }
        }
    ?>

        <p><b>Comments: (+<?php echo count($vote_up) . ' / -' . count($vote_down) ?>)</b></p>

    <?php
        // show voters-avatars (pro vote)
        foreach ($vote_up as $ann) {
            echo '<p>' . elgg_view("profile/icon", array('entity' => get_entity($ann->owner_guid), 'size' => 'small', 'override' => 'true')) . ' ';
            echo ' ' . substr($ann->value, 3);
            echo ' (+)</p>';
        }
        foreach ($vote_down as $ann) {
            echo '<p>' . elgg_view("profile/icon", array('entity' => get_entity($ann->owner_guid), 'size' => 'small', 'override' => 'true')) . ' ';
            echo ' ' . substr($ann->value, 3);
            echo ' (-)</p>';
        }
    ?>

    <?php } ?>


    <?php $url = elgg_add_action_tokens_to_url("{$vars['url']}action/groups/accept_member"); ?>
        <form action="<?php echo $url ?>" method="post">

        <p><b>Email text: </b></p>
        <p><textarea name="notification" style="width: 700px; height: 350px"><?php echo $vars['template'] ?></textarea></p>

        <p><b>Settings: </b></p>
        <p><i>Configuring the openSUSE mail alias here. After accepting this can be changed upon request to admin@opensuse.org.</i></p>
        <table><tr><td width="200">openSUSE email alias (nick): </td>
                <td><input type="text" size="40" value="<?php echo $vars['user']->username ?>@opensuse.org" name="alias_nick"> </td></tr>
            <tr><td>openSUSE email alias (fullname): </td>
                <td><input type="text" size="40" value="" name="alias_full"> </td></tr>
            <tr><td>Target email: </td>
                <td><input type="text" size="40" value="<?php echo $vars['user']->email ?>" name="target_email"></td>
            <tr><td>Freenode IRC nick: </td>
                <td><input type="text" size="40" value="" name="irc_nick"> </td></tr>
            <tr><td>Freenode IRC cloak: </td>
                <td><input type="text" size="40" value="opensuse/member/<?php echo $vars['user']->username ?>" name="irc_cloak"></td></tr>
        </tr></table>

        <p>
            <input type="hidden" value="<?php echo $user->guid ?>" name="user_guid">
            <input type="hidden" value="<?php echo $group->guid ?>" name="group_guid">
            <input type="submit" value="Accept membership request">
        </p>

    </form>

</div>