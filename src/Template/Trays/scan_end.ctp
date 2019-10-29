<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>

<div class="trays form columns content"  id="app-end">
    <?= $this->Form->create($tray, ['ref' => 'form']) ?>
    <fieldset>
        <legend><?= __('Wrap up this tray') ?></legend>
        <?php
            echo 'Please scan the tray barcode again to complete this process.';
            echo $this->Form->control('tray_barcode',  ['autofocus' => 'autofocus', 'value' => '','ref' => 'inputValue']);
        ?>
    </fieldset>
    
    <?= $this->Form->end() ?>
    <?= $this->Form->button(__('Submit')) ?> 
    <!--only show the 'add more' button in the validate step -->
    <?php if ($this->request->getQuery('source')=="validate"):?>
    <div id="example-1">
        
        <!--Button should kick off a controller action that resets the current tray to Incomplete,
        allowing us to redeclare the number of books it contains and scan in any extras-->
        <?= $this->Form->postButton('Add More Items', ['controller' => 'Trays', 'action' => 'addOne',$tray->tray_id]) ?>
        
    </div>
    <?php endif; ?>
</div>

<!--<script type="text/javascript">
    new Vue({
        el: '#app-end',
        data: {
            counter: 0,
        },
        methods: {
            wrapUp: function(e) {
                counter++;
                console.log(this.$refs.inputValue.value);
//                let val = this.refs.inputValue.value;
//                let userKeyRegExp = /^[R][0-9]{2}\-[M][0-9]{2}\-[S][0-9]{2}\-[T][0-9]{2}?$/;
//                if (userKeyRegExp.test(val)) {
//                    console.log("send the form");
////                    this.refs.submit();
//                } else {
//                    if (!isNaN(val) && val.substring(0, 6) === '317350' && val.length === 14) {
//                        if (confirm("Do you want to put this extra book into this tray? And please scanning the tray barcdoe again to wrap up the process.")) {
//                            console.log("eeeeeeeeeeeeee");
//                        }
//                    } else {
//                        alert("The input value is either tray barcode nor book barcode.");
//                    }
//                }
            }
        },
        mounted() {
            console.log("1111111111111");
        }
    })
</script>-->