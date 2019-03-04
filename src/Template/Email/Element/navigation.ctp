<!-- Navigation -->
<style media="screen">
li.active>a
{
font-weight: bold;
}
</style>
<nav role="navigation">
    <ul class="side-nav" id="list">
        <?php
            $title = $this->fetch('title');
            $seg = $this->request->getParam('action');
            $filter = $this->request->getQuery('filter');
            $operation = $this->request->getQuery('operation');
            $actions = ["index", "add", "edit", "view"];
            $objs = ['MANAGEMENT' => ['Browse' => ['controllers' => ['Ranges'], 'action' => $actions],
                                      'Traysizes' => ['controllers' => ['Traysizes'], 'action' => $actions]],
                     'SCANNING' => ['Scan a Tray' => ['controllers' => ['Trays', 'Books'], 'action' => ['scanInit', 'scan']],
                                    'Verify a Tray' => ['controllers' => ['Trays', 'Books'], 'action' => ['index', 'scan-list'], 'filter' => 'validate'],
                                    'Review Incompleted Trays' => ['controllers' => ['Trays', 'Books'], 'action' => ['index', 'scan'], 'filter' => 'incompleted']
                                                                 ]];
            foreach ($objs as $heading => $items) {
                echo "<li class='heading'>$heading</li>";
                foreach ($items as $titleStr => $contents) {
                    $route['controller'] = $contents['controllers'][0];
                    $route['action'] = $contents['action'][0];
                    if (isset($contents['filter'])) $route['filter'] = $contents['filter'];
                    echo "<li>";
                    echo $this->Html->link(__($titleStr), $route);
                    echo "</li>";
                }
            }
        ?>
    </ul>
</nav>
