<?php
/** @var $generator mgcode\gii\generators\abstractModel\Generator */
/** @var $relations array */
/** @var $tableName string full table name */
echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
<?php if (!empty($relations) && $generator->relationsInMain){
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
class <?= $className ?> extends <?= 'Abstract'.$className. "\n" ?>
{
<?php if($generator->relationsInMain): ?>
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
}