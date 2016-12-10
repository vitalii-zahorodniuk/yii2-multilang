<?php
namespace xz1mefx\multilang\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%source_message}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%source_message}}';
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
            [['message'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('xz1mefx-multilang', 'ID'),
            'category' => Yii::t('xz1mefx-multilang', 'Category'),
            'message' => Yii::t('xz1mefx-multilang', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }
}
