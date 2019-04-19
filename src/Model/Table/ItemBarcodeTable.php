<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemBarcode Model
 *
 * @method \App\Model\Entity\ItemBarcode get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemBarcode newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemBarcode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemBarcode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemBarcode saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemBarcode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemBarcode[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemBarcode findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemBarcodeTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ITEM_BARCODE');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('ITEM_ID')
            ->allowEmptyString('ITEM_ID');

        $validator
            ->scalar('ITEM_BARCODE')
            ->maxLength('ITEM_BARCODE', 30)
            ->allowEmptyString('ITEM_BARCODE');

        $validator
            ->integer('BARCODE_STATUS')
            ->allowEmptyString('BARCODE_STATUS');

        $validator
            ->dateTime('BARCODE_STATUS_DATE')
            ->allowEmptyDateTime('BARCODE_STATUS_DATE');

        return $validator;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName()
    {
        return 'voyager';
    }
}
