<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use yii\base\Model;

class sample extends Model {

    public $captcha;
    public $pinjaman;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
                [['pinjaman'], 'string', 'max' => 255],
                [['pinjaman'], 'trim'],
                [['pinjaman'], 'required'],
                [['captcha'], 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'captcha' => 'Verification Code',
        ];
    }
    
    
    public function isNewRecord()
    {
        return $this->pinjaman->isNewRecord;
    }

}
