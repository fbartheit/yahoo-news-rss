<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "static_pages".
 *
 * @property integer $static_page_id
 * @property string $static_page_title
 * @property string $static_page_type
 * @property string $static_page_content
 *
 */
class StaticPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['static_page_id', 'static_page_title', 'static_page_type', 'static_page_content'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'static_page_id' => 'ID',
            'static_page_title' => 'Title',
            'static_page_type' => 'Type',
            'static_page_content' => 'Content',
        ];
    }

}
