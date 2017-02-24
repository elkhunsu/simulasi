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

    public $pinjaman;
    public $tenor;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // name, email, subject and body are required
                [['pinjaman', 'tenor'], 'required'],
            // email has to be a valid email address
//            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

}
