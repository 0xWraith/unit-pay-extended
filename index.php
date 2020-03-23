<?php

error_reporting(E_ALL);

include 'config.php';
include 'lib/UnitPayModel.php';
include 'lib/UnitPay.php';

class UnitPayEvent
{
    public function check($params)
    {
        try 
        {
            $unitPayModel = UnitPayModel::getInstance();

            $server = -1;
            preg_match_all("/\d+/", $params['account'], $matches);
            $account = preg_replace('/\d/', '', $params['account']);

            if(isset($matches[0])) 
            {
                foreach($matches[0] as $number) 
                {
                    $server = (int)$number;
                    break;
                }
            }

            if($server < 1 || $server > 4)
                return 'Ошибка при парсинге сервера в файле index.php в функции check()!';


            if ($unitPayModel->getAccountByName($account, $server)) {
                return true;
            }
            else return 'Аккаунт '. $account. ' не найден в Базе Данных!';
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function pay($params)
    {
        $server = -1;
        preg_match_all("/\d+/", $params['account'], $matches);
        $account = preg_replace('/\d/', '', $params['account']);

        if(isset($matches[0])) 
        {
            foreach($matches[0] as $number) 
            {
                $server = (int)$number;
                break;
            }
        }

        if($server < 1 || $server > 4)
            return 'Ошибка при парсинге сервера в файле index.php в функции pay()!';

        $unitPayModel = UnitPayModel::getInstance();
        $countItems = floor($params['sum'] / Config::ITEM_PRICE);
        $unitPayModel->donateForAccount($account, $countItems, $server);
    }
}

$payment = new UnitPay(
    new UnitPayEvent()
);

echo $payment->getResult();
