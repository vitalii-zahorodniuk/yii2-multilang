<?php
namespace xz1mefx\multilang\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer       $id
 * @property string        $language
 * @property string        $translation
 *
 * @property SourceMessage $id0
 */
class Message extends ActiveRecord
{

    const TABLE_NAME = '{{%ml_message}}';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id', 'language'];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['id', 'language'], 'unique', 'targetAttribute' => ['id', 'language'], 'message' => Yii::t('multilang-tools', 'The combination of ID and Language has already been taken.')],
            [['id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => SourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->multilangCache->flush();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        Yii::$app->multilangCache->flush();
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('multilang-tools', 'ID'),
            'language' => Yii::t('multilang-tools', 'Language'),
            'translation' => Yii::t('multilang-tools', 'Translation'),
        ];
    }
}
