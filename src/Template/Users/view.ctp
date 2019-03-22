<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users view columns content">
    <h3><?= __('User detail') ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Permission') ?></th>
            <td><?= $user->has('permission') ? $this->Html->link($user->permission->permission_title, ['controller' => 'Permissions', 'action' => 'view', $user->permission->permission_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Create Time') ?></th>
            <td><?= h($user->create_time) ?></td>
        </tr>
    </table>
</div>
