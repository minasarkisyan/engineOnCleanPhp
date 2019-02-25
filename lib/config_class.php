<?php

abstract class Config {

    const SITENAME = "MyRusakov.ru";
    const SECRET = "DGJDG5";
    const ADDRESS = "http://lesson.ru";
    const ADM_NAME = "Минас Саркисян";
    const ADM_EMAIL = "postpay24@gmail.com";

    const API_KEY = "DKEL39DL";

    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_NAME = "marusakov";
    const DB_PREFIX = "xyz_";
    const DB_SYM_QUERY = "?";

    const DIR_IMG = "/images/";
    const DIR_IMG_ARTICLES = "/images/articles/";
    const DIR_IMG_AVATAR = "/images/avatar/";
    const DIR_TMPL = "H:/OSPanel/domains/mysite.local/tmpl/";
    const DIR_EMAILS = "H:/OSPanel/domains/mysite.local/tmpl/emails/";

    const FILE_MESSAGES = "H:/OSPanel/domains/mysite.local/text/messages.ini";
    const LAYOUT = "main";

    const FORMAT_DATE = "%d.%m.%Y %H:%M:%S";

    const SEF_SUFFIX = ".html";

    const COUNT_ARTICLES_ON_PAGE = 3;
    const LEN_SEARCH_RES = 255;
    const COUNT_SHOW_PAGES = 10;

    const DEFAULT_AVATAR = "default.png";
    const MAX_SIZE_AVATAR = 51200;

}