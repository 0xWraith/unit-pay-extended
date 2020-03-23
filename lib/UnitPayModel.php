<?php

class UnitPayModel
{
    private $server1_mysqli;
    private $server2_mysqli;
    private $server3_mysqli;
    private $server4_mysqli;

    static function getInstance()
    {
        return new self();
    }

    private function __construct()
    {
        $this->server1_mysqli = @new mysqli (
            Config::SERVER1_DB_HOST, Config::SERVER1_DB_USER, Config::SERVER1_DB_PASS, Config::SERVER1_DB_NAME, ini_get("mysqli.default_port")
        );
        $this->server2_mysqli = @new mysqli (
            Config::SERVER2_DB_HOST, Config::SERVER2_DB_USER, Config::SERVER2_DB_PASS, Config::SERVER2_DB_NAME, ini_get("mysqli.default_port")
        );
        $this->server3_mysqli = @new mysqli (
            Config::SERVER3_DB_HOST, Config::SERVER3_DB_USER, Config::SERVER3_DB_PASS, Config::SERVER3_DB_NAME, ini_get("mysqli.default_port")
        );
        $this->server4_mysqli = @new mysqli (
            Config::SERVER4_DB_HOST, Config::SERVER4_DB_USER, Config::SERVER4_DB_PASS, Config::SERVER4_DB_NAME, ini_get("mysqli.default_port")
        );
        if (mysqli_connect_errno()) {
            throw new Exception('Не удалось подключиться к бд');
        }
    }

    function createPayment($unitpayId, $account, $sum, $itemsCount, $server)
    {
        switch($server)
        {
            case 1:
            {
                $query = '
                    INSERT INTO
                        unitpay_payments (unitpayId, account, sum, itemsCount, dateCreate, status)
                    VALUES
                        (
                            "'.$this->server1_mysqli->real_escape_string($unitpayId).'",
                            "'.$this->server1_mysqli->real_escape_string($account).'",
                            "'.$this->server1_mysqli->real_escape_string($sum).'",
                            "'.$this->server1_mysqli->real_escape_string($itemsCount).'",
                            NOW(),
                            0
                        )
                ';
                return $this->server1_mysqli->query($query);
                break;
            }
            case 2:
            {
                $query = '
                    INSERT INTO
                        unitpay_payments (unitpayId, account, sum, itemsCount, dateCreate, status)
                    VALUES
                        (
                            "'.$this->server2_mysqli->real_escape_string($unitpayId).'",
                            "'.$this->server2_mysqli->real_escape_string($account).'",
                            "'.$this->server2_mysqli->real_escape_string($sum).'",
                            "'.$this->server2_mysqli->real_escape_string($itemsCount).'",
                            NOW(),
                            0
                        )
                ';
                return $this->server2_mysqli->query($query);
                break;
            }
            case 3:
            {
                $query = '
                    INSERT INTO
                        unitpay_payments (unitpayId, account, sum, itemsCount, dateCreate, status)
                    VALUES
                        (
                            "'.$this->server3_mysqli->real_escape_string($unitpayId).'",
                            "'.$this->server3_mysqli->real_escape_string($account).'",
                            "'.$this->server3_mysqli->real_escape_string($sum).'",
                            "'.$this->server3_mysqli->real_escape_string($itemsCount).'",
                            NOW(),
                            0
                        )
                ';
                return $this->server3_mysqli->query($query);
                break;
            }
            case 4:
            {
                $query = '
                    INSERT INTO
                        unitpay_payments (unitpayId, account, sum, itemsCount, dateCreate, status)
                    VALUES
                        (
                            "'.$this->server4_mysqli->real_escape_string($unitpayId).'",
                            "'.$this->server4_mysqli->real_escape_string($account).'",
                            "'.$this->server4_mysqli->real_escape_string($sum).'",
                            "'.$this->server4_mysqli->real_escape_string($itemsCount).'",
                            NOW(),
                            0
                        )
                ';
                return $this->server4_mysqli->query($query);
                break;
            } 
            default:
            {
                $query = '
                    INSERT INTO
                        unitpay_payments (unitpayId, account, sum, itemsCount, dateCreate, status)
                    VALUES
                        (
                            "'.$this->server1_mysqli->real_escape_string($unitpayId).'",
                            "'.$this->server1_mysqli->real_escape_string($account).'",
                            "'.$this->server1_mysqli->real_escape_string($sum).'",
                            "dont work",
                            NOW(),
                            0
                        )
                ';
                return $this->server1_mysqli->query($query);
                break;
            }   
        }

        return 1;
    }

    function getPaymentByUnitpayId($unitpayId, $server)
    {
        
        switch($server)
        {
            case 1:
            {
                $query = '
                    SELECT * FROM
                        unitpay_payments
                    WHERE
                        unitpayId = "'.$this->server1_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';

                $result = $this->server1_mysqli->query($query);
        
                if (!$result){
                    throw new Exception($this->server1_mysqli->error);
                }
                break;
            }
            case 2:
            {
                $query = '
                    SELECT * FROM
                        unitpay_payments
                    WHERE
                        unitpayId = "'.$this->server2_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';

                $result = $this->server2_mysqli->query($query);
        
                if (!$result){
                    throw new Exception($this->server2_mysqli->error);
                }
                break;
            }
            case 3:
            {
                $query = '
                    SELECT * FROM
                        unitpay_payments
                    WHERE
                        unitpayId = "'.$this->server3_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';

                $result = $this->server3_mysqli->query($query);
        
                if (!$result){
                    throw new Exception($this->server3_mysqli->error);
                }
                break;
            }
            case 4:
            {
                $query = '
                    SELECT * FROM
                        unitpay_payments
                    WHERE
                        unitpayId = "'.$this->server4_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';

                $result = $this->server4_mysqli->query($query);
        
                if (!$result){
                    throw new Exception($this->server4_mysqli->error);
                }
                break;
            }     
        } 

        return $result->fetch_object();
    }

    function confirmPaymentByUnitpayId($unitpayId, $server)
    {
        switch($server)
        {
            case 1:
            {
                $query = '
                    UPDATE
                        unitpay_payments
                    SET
                        status = 1,
                        dateComplete = NOW()
                    WHERE
                        unitpayId = "'.$this->server1_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';
                return $this->server1_mysqli->query($query);
                break;
            }
            case 2:
            {
                $query = '
                    UPDATE
                        unitpay_payments
                    SET
                        status = 1,
                        dateComplete = NOW()
                    WHERE
                        unitpayId = "'.$this->server2_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';
                return $this->server2_mysqli->query($query);
                break;
            }
            case 3:
            {
                $query = '
                    UPDATE
                        unitpay_payments
                    SET
                        status = 1,
                        dateComplete = NOW()
                    WHERE
                        unitpayId = "'.$this->server3_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';
                return $this->server3_mysqli->query($query);
                break;
            }
            case 4:
            {
                $query = '
                    UPDATE
                        unitpay_payments
                    SET
                        status = 1,
                        dateComplete = NOW()
                    WHERE
                        unitpayId = "'.$this->server4_mysqli->real_escape_string($unitpayId).'"
                    LIMIT 1
                ';
                return $this->server4_mysqli->query($query);
                break;
            }     
        }

        return 1;
    }
    
    function getAccountByName($account, $server)
    {
        $result;

        switch($server)
        {
            case 1:
            {
                $sql = "
                    SELECT
                        *
                    FROM
                    ".Config::TABLE_ACCOUNT."
                    WHERE
                    ".Config::TABLE_ACCOUNT_NAME." = '".$this->server1_mysqli->real_escape_string($account)."'
                    LIMIT 1
                ";
                
                $result = $this->server1_mysqli
                    ->query($sql);

                if (!$result){
                    throw new Exception($this->server1_mysqli->error);
                }

                break;
            }
            case 2:
            {
                $sql = "
                    SELECT
                        *
                    FROM
                    ".Config::TABLE_ACCOUNT."
                    WHERE
                    ".Config::TABLE_ACCOUNT_NAME." = '".$this->server2_mysqli->real_escape_string($account)."'
                    LIMIT 1
                ";
                
                $result = $this->server2_mysqli
                    ->query($sql);

                if (!$result){
                    throw new Exception($this->server2_mysqli->error);
                }
                break;
            }
            case 3:
            {
                $sql = "
                    SELECT
                        *
                    FROM
                    ".Config::TABLE_ACCOUNT."
                    WHERE
                    ".Config::TABLE_ACCOUNT_NAME." = '".$this->server3_mysqli->real_escape_string($account)."'
                    LIMIT 1
                ";
                
                $result = $this->server3_mysqli
                    ->query($sql);

                if (!$result){
                    throw new Exception($this->server3_mysqli->error);
                }
                break;
            }
            case 4:
            {
                $sql = "
                    SELECT
                        *
                    FROM
                    ".Config::TABLE_ACCOUNT."
                    WHERE
                    ".Config::TABLE_ACCOUNT_NAME." = '".$this->server4_mysqli->real_escape_string($account)."'
                    LIMIT 1
                ";
                
                $result = $this->server4_mysqli
                    ->query($sql);

                if (!$result){
                    throw new Exception($this->server4_mysqli->error);
                }
                break;
            }
        }
        return $result->fetch_object();
    }
    
    function donateForAccount($account, $count, $server)
    {
        switch($server)
        {
            case 1:
            {
                $query = "
                    UPDATE
                        ".Config::TABLE_ACCOUNT."
                    SET
                        ".Config::TABLE_ACCOUNT_DONATE." = ".Config::TABLE_ACCOUNT_DONATE." + ".$this->server1_mysqli->real_escape_string($count)."
                    WHERE
                        ".Config::TABLE_ACCOUNT_NAME." = '".$this->server1_mysqli->real_escape_string($account)."'
                ";

                return $this->server1_mysqli->query($query);
                break;
            }
            case 2:
            {
                $query = "
                    UPDATE
                        ".Config::TABLE_ACCOUNT."
                    SET
                        ".Config::TABLE_ACCOUNT_DONATE." = ".Config::TABLE_ACCOUNT_DONATE." + ".$this->server2_mysqli->real_escape_string($count)."
                    WHERE
                        ".Config::TABLE_ACCOUNT_NAME." = '".$this->server2_mysqli->real_escape_string($account)."'
                ";

                return $this->server2_mysqli->query($query);
                break;
            }
            case 3:
            {
                $query = "
                    UPDATE
                        ".Config::TABLE_ACCOUNT."
                    SET
                        ".Config::TABLE_ACCOUNT_DONATE." = ".Config::TABLE_ACCOUNT_DONATE." + ".$this->server3_mysqli->real_escape_string($count)."
                    WHERE
                        ".Config::TABLE_ACCOUNT_NAME." = '".$this->server3_mysqli->real_escape_string($account)."'
                ";

                return $this->server3_mysqli->query($query);
                break;
            }
            case 4:
            {
                $query = "
                    UPDATE
                        ".Config::TABLE_ACCOUNT."
                    SET
                        ".Config::TABLE_ACCOUNT_DONATE." = ".Config::TABLE_ACCOUNT_DONATE." + ".$this->server4_mysqli->real_escape_string($count)."
                    WHERE
                        ".Config::TABLE_ACCOUNT_NAME." = '".$this->server4_mysqli->real_escape_string($account)."'
                ";

                return $this->server4_mysqli->query($query);
                break;
            }     
        }
        return 1;
    }
}