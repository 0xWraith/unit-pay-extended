<?php

class Config
{
    // Ваш секретный ключ (из настроек проекта в личном кабинете UnitPay )
    const SECRET_KEY = '1f9b3939409d62ec6aafe36f31fe4824';
    // Стоимость товара в руб.
    const ITEM_PRICE = 1;

    // Таблица начисления товара, например `users`
    const TABLE_ACCOUNT = 'users';
    // Название поля из таблицы начисления товара по которому производится поиск аккаунта/счета, например `email`
    const TABLE_ACCOUNT_NAME = 'u_name';
    const TABLE_ACCOUNT_DONATE= 'u_donate';

    //BD Server 1
    const SERVER1_DB_HOST = 'remotemysql.com';
    const SERVER1_DB_USER = 'rMlNJik9Wt';
    const SERVER1_DB_PASS = 'ggsLlcqh1A';
    const SERVER1_DB_NAME = 'rMlNJik9Wt';
    //BD Server 2
    const SERVER2_DB_HOST = 'remotemysql.com';
    const SERVER2_DB_USER = 'XfBCD5zXf4';
    const SERVER2_DB_PASS = '2sl76msZM4';
    const SERVER2_DB_NAME = 'XfBCD5zXf4';
    //BD Server 3
    const SERVER3_DB_HOST = 'remotemysql.com';
    const SERVER3_DB_USER = '5q3Agw9jaJ';
    const SERVER3_DB_PASS = 'dDY0KTLYbg';
    const SERVER3_DB_NAME = '5q3Agw9jaJ';
    //BD Server 4
    const SERVER4_DB_HOST = 'remotemysql.com';
    const SERVER4_DB_USER = '5q3Agw9jaJ';
    const SERVER4_DB_PASS = 'dDY0KTLYbg';
    const SERVER4_DB_NAME = '5q3Agw9jaJ';

}