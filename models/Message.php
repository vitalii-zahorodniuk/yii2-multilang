<?php
namespace xz1mefx\multilang\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property SourceMessage $id0
 */
class Message extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
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
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['id', 'language'], 'unique', 'targetAttribute' => ['id', 'language'], 'message' => 'The combination of ID and Language has already been taken.'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('xz1mefx-multilang', 'ID'),
            'language' => Yii::t('xz1mefx-multilang', 'Language'),
            'translation' => Yii::t('xz1mefx-multilang', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }
}
