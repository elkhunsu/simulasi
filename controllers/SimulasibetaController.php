<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use app\models\MobilForm;
use app\models\MotorForm;

/**
 * Description of SimulasiController
 *
 * @author elkinpk
 */
class SimulasibetaController extends \yii\base\Controller {

    public function beforeAction($action) {
        if (isset(Yii::$app->request->csrfTokenFromHeader)) {
            return parent::beforeAction($action);
        } else {
            return parent::beforeAction($action);
        }
    }

    public function actions() {
        return [
            // ...
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $model = new \app\models\MobilForm();
        $tahun = [
            '2017' => '2017',
            '2016' => '2016',
            '2015' => '2015',
            '2014' => '2014',
            '2013' => '2013',
            '2012' => '2012',
        ];
        $tenor = [
            '12' => '1 Tahun',
            '24' => '2 Tahun',
            '36' => '3 Tahun',
            '48' => '4 Tahun'
        ];
        return $this->render('mobil', ['model' => $model, 'tahun' => $tahun, 'tenor' => $tenor]);
    }

    public function actionMotor() {
        $model = new MotorForm();
        $tenor = [
            0 => ['5 Bulan', '6 Bulan']
        ];
        return $this->render('motor', ['model' => $model, 'tenor' => $tenor]);
    }

    public function actionHitung() {
//        $model = new MobilForm();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            if (isset($data)) {
                $harga = (int) $data['harga'] ? (int) $data['harga'] : 0;
                $tahun = (int) $data['tahun'] ? (int) $data['tahun'] : 0;
                $tenor = (int) $data['tenor'] ? (int) $data['tenor'] : 0;
                $funding = (int) $data['funding'] ? (int) $data['funding'] : 0;
                /*
                 * admin biaya
                 */
                $asuransiJiwa = $this->asuransiJiwa($harga, $tenor);
                $asuransiKend = $this->asuransiMobil($tenor);
                $provisi = $funding * (2.25 / 100 );
                $fidusia = $this->fidusia($funding);
                $biayaAdmin = $this->biayaAdmin($funding);
                $totalAdmin = $provisi + $fidusia + $biayaAdmin;

                /*
                 * ntf
                 */
                $ntf = $asuransiJiwa + $asuransiKend + $totalAdmin + $funding;

                /*
                 * angsuran
                 */
                $pmt = $this->PMT(21 / 1200, $tenor, -$ntf);
                $result = round($pmt, -2);
                $result = 'Rp. ' . number_format($result);

                return [
//                    'fidusia' => $fidusia,
//                    'provisi' => $provisi,
//                    'biayaAdmin' => $biayaAdmin,
//                    'asuransiKend' => $asuransiKend,
//                    'asuransiJiwa' => $asuransiJiwa,
//                    'totalAdmin' => $totalAdmin,
//                    'ntf' => $ntf,
                    'data' => $result,
                ];
            }
        } else {
            return false;
        }
    }

    public function actionHitungmotor() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (isset($data)) {
                $funding = $data['funding'];
                $bulan = $data['tenor'];
                $tenor = $this->tenorAlt($bulan);
                $admin = $this->adminMotor($funding, $tenor);
                $rateProvisi = $this->rateProvisiMotor($tenor);
                $effRate = $this->rateEffMotor($funding, $tenor);

                /*
                 * NTF
                 */
                $ntf = ($funding + 175000 + $admin);
                $hasilNtf = round(($ntf / $rateProvisi) * 100);

                /*
                 * hasil
                 */
                $pmt = $this->PMT($effRate / 1200, $bulan, -$hasilNtf);
                $result = round($pmt, -2);
                $result = 'Rp. ' . number_format($result);
                return $result;
            } else {
                return false;
            }
        }
    }

    private function PMT($i, $n, $p) {
        return $i * $p * pow((1 + $i), $n) / (1 - pow((1 + $i), $n));
    }

    private function biayaAdmin($funding) {
        if ($funding <= 75000000) {
            return 750000;
        } else if ($funding < 75000000 && $funding <= 150000000) {
            return 1000000;
        } else if ($funding > 150000000) {
            return 1250000;
        }
    }

    private function fidusia($funding) {
        if ($funding <= 50000000) {
            return 175000;
        } else if ($funding > 50000000 && $funding <= 100000000) {
            return 250000;
        } else if ($funding > 100000000 && $funding <= 250000000) {
            return 400000;
        } else if ($funding > 250000000 && $funding <= 500000000) {
            return 575000;
        } else if ($funding > 500000000 && $funding <= 1000000000) {
            return 1025000;
        }
    }

    private function asuransiJiwa($harga, $tenor) {
        if (isset($harga) && isset($tenor)) {
            $array = [
                '0.15' => 12,
                '0.33' => 24,
                '0.535' => 36,
                '0.755' => 48,
            ];
            $pengali = array_search($tenor, $array);
            $hasil = $harga * (floatval($pengali) / 100);
            return $hasil;
        } else {
            return false;
        }
    }

    private function asuransiMobil($tenor) {
        if (isset($tenor)) {
            $array = [
                750000 => 12,
                1352500 => 24,
                1857500 => 36,
                2362500 => 48,
            ];
            $cekHarga = array_search($tenor, $array);
            return $cekHarga;
        } else {
            return false;
        }
    }

    private function adminMotor($param, $tenor) {
        if (isset($param) && isset($tenor)) {
            $array = [
                    [585, 435, 485, 0],
                    [585, 485, 535, 585],
                    [635, 635, 685, 735],
            ];
            if (($param == 1000000 && $param <= 2500000)) {
                return $array[0][$tenor];
            } else if ($param > 2500000 && $param <= 5000000) {
                return $array[1][$tenor];
            } else if ($param > 5000000) {
                return $array[2][$tenor];
            }
        }
    }

    private function rateProvisiMotor($tenor) {
        if ($tenor == 0) {
            return 99;
        } else if ($tenor == 1) {
            return 98;
        } else if ($tenor == 2) {
            return 97;
        } else if ($tenor == 3) {
            return 96;
        }
    }

    private function rateEffMotor($fund, $tenor) {
        $array = [
                [53.2, 51.6, 52, 0],
                [53.2, 46.3, 46.7, 47.2],
                [53.2, 45.25, 45.8, 46.2]
        ];
        if ($fund <= 2500000) {
            return $array[0][$tenor];
        } else if ($fund > 2500000 && $fund <= 5000000) {
            return $array[1][$tenor];
        } else if ($fund > 5000000) {
            return $array[2][$tenor];
        }
    }

    private function tenorAlt($bulan) {
        if ($bulan == 5 || $bulan == 6) {
            return 0;
        } else if ($bulan == 11 || $bulan == 12) {
            return 1;
        } else if ($bulan == 17 || $bulan == 18) {
            return 2;
        } else if ($bulan == 23 || $bulan == 24) {
            return 3;
        }
    }

    public function actionTime() {
        return $this->renderPartial('newEmptyPHP', ['response' => date('H:i:s')]);
    }

    public function actionDate() {
        return $this->render('time-date', ['response' => date('Y-M-d')]);
    }

}
