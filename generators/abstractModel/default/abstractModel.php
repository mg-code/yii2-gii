<?php
/**
 * This is the template for generating the model class of a specified table.
 */

use yii\helpers\ArrayHelper;

/** @var $this yii\web\View */
/** @var $generator mgcode\gii\generators\abstractModel\Generator */
/** @var $tableName string full table name */
/** @var $className string class name */
/** @var $queryClassName string query class name */
/** @var $tableSchema yii\db\TableSchema */
/** @var $labels string[] list of attribute labels (name => label) */
/** @var $rules string[] list of validation rules */
/** @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations) && !$generator->relationsInMain){
    echo " *\n";
    foreach($relations as $name => $relation) {
        $relationClass = $relation[1];
        if($relation[2]) {
            $relationClass .= '[]';
        }
        $relationName = '$'.lcfirst($name);
        echo " * @property {$relationClass} {$relationName} \n";
    }
}
?>
 */
abstract class Abstract<?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    /** @inheritdoc */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . ",\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php
    foreach($labels as $name => $label) {
        echo "            '{$name}' => {$generator->generateString($label)}, \n";
    }
?>
        ];
    }
<?php if(!$generator->relationsInMain): ?>
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php endif; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
