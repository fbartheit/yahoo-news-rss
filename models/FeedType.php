<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feed_type".
 *
 * @property integer $id
 * @property string $title
 * @property string $link
 *
 * @property Feed[] $feeds
 */
class FeedType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['title'], 'string', 'max' => 20],
            [['link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeds()
    {
        return $this->hasMany(Feed::className(), ['type_id' => 'id']);
    }
}
