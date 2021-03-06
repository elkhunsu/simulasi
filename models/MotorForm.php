<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use yii\base\Model;

class MotorForm extends Model {

    public $verifyCode;
    public $jumlah;
    public $tenor;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
                [['tenor', 'jumlah'], 'required'],
                [['tenor', 'jumlah'], 'number'],
                [['verifyCode'], 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'captcha' => 'Verification Code',
            'tenor' => 'Tenor *',
            'jumlah' => 'Jumlah Pinjaman *',
        ];
    }

}
