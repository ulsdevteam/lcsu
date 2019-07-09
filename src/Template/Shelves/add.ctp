<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf $shelf
 */
?>
<div class="shelves form content" id="app">
    <?= $this->Form->create($shelf, ['id' => 'add_shelf', 'ref' => 'form']) ?>
    <fieldset>
        <legend><?= __('Add Shelf') ?></legend>
        <?php
            echo $this->Form->control('shelf_title');
            echo $this->Form->control('shelf_height', ['id' => 'shelf_height_input']);
            if ($this->request->getQuery('module_id')) {
                echo $this->Form->control('module_id', ['options' => $modules, 'empty' => true, 'default' => $this->request->getQuery('module_id'), 'readonly' => 'readonly']);
            } else {
                echo $this->Form->control('module_id', ['options' => $modules, 'empty' => true]);
            }
            $this->Form->unlockField('traysize_id');
        ?>
        <div class="input select">

              <?php echo $this->Form->control('Tray Size',
  ['type'=>'select',
   'name' =>'traysize_id',
   ]);?>
        </div>
        
    </fieldset>
    
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script>
    //Display valid Tray Size options based on the value in the Shelf Height field
    document.getElementById('shelf_height_input').addEventListener("change", function() {
       var size = document.getElementById('shelf_height_input').value;
        var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                //4=Request Done
                var xhttpRequestReady = 4;
                if (this.readyState == xhttpRequestReady && this.status == 200) {
                    //clear the Tray Size field
                    var child = document.getElementById('tray-size').lastElementChild;  
                    while (child) { 
                    document.getElementById('tray-size').removeChild(child); 
                    child = document.getElementById('tray-size').lastElementChild; 
                    } 
                    //the traysize/shelf-height mappings 
                    var response= JSON.parse(this.responseText);
                    //create Tray Size dropdown choices 
                    for (i=0;i<response.length;i++){
                        //if the shelf height matches
                        if (response[i].shelf_height==size){
                            //create dropdown options with the corresponding tray letters
                            var option = document.createElement('option');
                            var attribute = document.createAttribute("value");
                            attribute.value=response[i].tray_category;
                            option.setAttributeNode(attribute);
                            document.getElementById('tray-size').appendChild(option).innerHTML=response[i].tray_category;                                    
                        }
                    }
                }
            }
            //send the request
            xhttp.open("GET", '<?=  $this->Url->build(["controller" => "Traysizes","action" => "listAllTraysizes"]); ?>');
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send();                    
    });
</script>
