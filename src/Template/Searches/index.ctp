<?php
use Cake\Core\Configure;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf[]|\Cake\Collection\CollectionInterface $shelves
 */
?>
<div class="searches index content">
    <h3 class="page-title"><?= __('Search for ') ?><span><?= "\"".$keyword."\""?></span></h3>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <?php if(is_numeric($keyword)) {
                        echo "<th scope='col'>".$this->Paginator->sort('book_barcode')."</th>";
                        echo "<th scope='col' class='actions'>".__('Actions')."</th>";
                    } else {
                        if (strpos($keyword, 'T')) {
                            echo "<th scope='col'>".$this->Paginator->sort('tray_barcode')."</th>";
                            echo "<th scope='col'>".$this->Paginator->sort('created')."</th>";
                            echo "<th scope='col'>".$this->Paginator->sort('modified')."</th>";
                            echo "<th scope='col'>".$this->Paginator->sort('modified_user', 'Modified By')."</th>";
                            echo "<th scope='col' class='actions'>".__('Actions')."</th>";
                        } else {
                            echo "<th scope='col'>".$this->Paginator->sort('shelf_barcode')."</th>";
                            echo "<th scope='col' class='actions'>".__('Actions')."</th>";
                        }
                    }?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                <tr>
                    <?php
                        if (is_numeric($keyword)) {
                            echo "<td>".h($result->book_barcode)."</td>";
                            echo "<td>".(isset($result->tray_id) ? $this->Html->link('View tray', ['controller' => 'Trays', 'action' => 'view', $result->tray_id]) : '')."</td>";
                        } else {
                            if (strpos($keyword, 'T')) {
                                echo "<td>".h($result->tray_barcode)."</td>";
                                echo "<td>".h($result->created)."</td>";
                                echo "<td>".h($result->modified)."</td>";
                                echo "<td>".h($result->modified_user)."</td>";
                                echo "<td class='actions'>";
                                $filter = $this->request->getQuery('filter');
                                switch ($filter) {
                                    case 'incompleted':
                                        echo '<span>|</span>';
                                        echo $this->Html->link(__('Review'), ['action' => 'incompleted', $result->tray_id]);
                                        echo '<span>|</span>';
                                        break;
                                    case 'validate':
                                        if ($result->modified_user != $cur_user['username']) {
                                            echo '<span>|</span>';
                                            echo $this->Html->link(__('Validate'), ['action' => 'validate', $result->tray_id]);
                                            echo '<span>|</span>';
                                        }
                                        break;
                                    default:
                                        echo '<span>|</span>';
                                        echo $this->Html->link(__('Check Inventory'), ['controller' => 'Trays', 'action' => 'shelflist', $result->tray_id]);
                                        echo '<span>|</span>';
                                        echo $this->Html->link(__('View'), ['controller' => 'Trays', 'action' => 'view', $result->tray_id]);
                                        echo '<span>|</span>';
                                        //this will turn the tray status over to incomplete so that more items can be scanned into it
                                        echo $this->Html->link(__('Add Items'), ['controller' => 'Trays', 'action' => 'addOne', $result->tray_id]);
                                        echo '<span>|</span>';
                                        break;
                                }
                                echo "</td>";
                            } else {
                                echo "<td>".h($result->shelf_barcode)."</td>";
                                echo "<td class='actions'>";
                                echo '<span>|</span>';
                                echo $this->Html->link(__('View'), ['controller' => 'Shelves', 'action' => 'view', $result->shelf_id]);
                                echo '<span>|</span>';
                                echo $this->Html->link(__('Print'), ['controller' => 'Shelves', 'action' => 'printLabel', $result->shelf_id]);
                                echo '<span>|</span>';
                                if($cur_user['permission_id'] == Configure::read('Managers')) echo $this->Html->link(__('Edit'), ['controller' => 'Shelves', 'action' => 'edit', $result->shelf_id]);
                                echo "</td>";
                            }
                        }
                    ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
            <?= $this->Paginator->options([ 'url'=> ['action' => 'index', 'keyword' => $keyword]])?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
