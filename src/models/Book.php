<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $main_photo
 * @property string|null $uploadImagePath
 * @property string|null $imageUrl
 * @property Author[] $authors
 */
class Book extends \yii\db\ActiveRecord
{

    public  $authorIds = [];

    public $mainImage;

    public $processCreate = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['name', 'year', 'isbn'], 'required'],
            ['isbn', 'unique', 'targetClass' => static::class],
            [['year'], 'integer', 'min' => -2000, 'max' => 3000],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            [['authorIds'], 'each', 'rule' => ['integer']],
            [['mainImage'], 'file', 'extensions' => 'png, jpg, jpeg'],
            ['authorIds', 'required', 'message' => 'Нужен минимум 1 автор книги']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'year' => 'Год',
            'description' => 'Описние',
            'isbn' => 'Isbn',
            'authorIds' => 'Авторы',
            'main_photo'    => 'Изображение'
        ];
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('authors_books', ['book_id' => 'id']);
    }

    public function getImageUrl():? string
    {
        if (empty($this->main_photo)) {
            return null;
        }

        return Yii::getAlias(Yii::$app->params['uploadsUrl']) . $this->main_photo;
    }

    public function getUploadImagePath()
    {
        return \Yii::getAlias(\Yii::$app->params['uploadsPath']) . $this->main_photo;
    }
}
