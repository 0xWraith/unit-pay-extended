<?php

require_once('UnitPayModel.php');

class UnitPay
{
    private $event;

    public function __construct(UnitPayEvent $event)
    {
        $this->event = $event;
    }

    public function getResult()
    {
        $request = $_GET;
        $params = $request['params'];

        if(empty($request['method']) || empty($request['params']) || !is_array($request['params']))
        {
            return $this->getResponseError('Неудачный запрос: Отсутствуют параметры для оплаты!', null);
        }

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
        {
            return $this->getResponseError('Неудачный запрос: Неверный номер сервера!', -1);
        }

        $method = $request['method'];

        if($params['signature'] != $this->getSha256SignatureByMethodAndParams($method, $params, Config::SECRET_KEY))
        {
            return $this->getResponseError('Неверная цифровая подпись при совершении оплаты!', $server);
        }
        $unitPayModel = UnitPayModel::getInstance();
        if($method == 'check')
        {
            $checkResult = $this->event->check($params);
            if ($checkResult !== true)
            {
                return $this->getResponseError($checkResult, $server);
            }

            if ($unitPayModel->getPaymentByUnitpayId($params['unitpayId'], $server))
            {
                // Платеж уже существует
                return $this->getResponseSuccess('Платёж уже существует в Базе Данных сервера!', $server);
            }

            $itemsCount = floor($params['sum'] / Config::ITEM_PRICE);

            if ($itemsCount <= 0)
            {
                return $this->getResponseError('Суммы ' . $params['sum'] . ' руб. не достаточно для оплаты товара ' .
                    'стоимостью ' . Config::ITEM_PRICE . ' руб.', $server);
            }

            if (!$unitPayModel->createPayment($params['unitpayId'], $account, $params['sum'], $itemsCount, $server))
            {
                return $this->getResponseError('Произошла ошибка при создании данных в Базе Данных!', $server);
            }

            return $this->getResponseSuccess('Проверка прошла успешно!', $server);
        }

        if ($method == 'pay')
        {
            $payment = $unitPayModel->getPaymentByUnitpayId($params['unitpayId'], $server);

            if ($payment && $payment->status == 1)
            {
                return $this->getResponseSuccess('Данный платёж был уже оплачен!', $server);
            }

            if (!$unitPayModel->confirmPaymentByUnitpayId($params['unitpayId'], $server))
            {
                return $this->getResponseError('Ошибка при подтверждении платежа!', $server);
            }

            $this->event->pay($params);

            return $this->getResponseSuccess('Платёж прошёл успешно!', $server);
        }

	    return $this->getResponseError('Метод \"'.$method.'\" не поддерживается!', $server);
    }

    private function getResponseSuccess($message, $server)
    {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "result" => array(
                "message" => $message
            ),
            'id' => 1,
            'server' => $server
        ));
    }

    private function getResponseError($message, $server)
    {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "error" => array(
                "code" => -32000,
                "message" => $message
            ),
            'id' => 1,
            'server' => $server
        ));
    }

    private function getMd5Sign($params, $secretKey)
    {
        ksort($params);
        unset($params['sign']);
        return md5(join(null, $params).$secretKey);
    }

    /**
     * @param $method
     * @param array $params
     * @param $secretKey
     * @return string
     */
    private function getSha256SignatureByMethodAndParams($method, array $params, $secretKey)
    {
        $delimiter = '{up}';
        ksort($params);
        unset($params['sign']);
        unset($params['signature']);

        return hash('sha256', $method.$delimiter.join($delimiter, $params).$delimiter.$secretKey);
    }
}
