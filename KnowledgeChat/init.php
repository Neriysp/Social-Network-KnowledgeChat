<?php
define('ASSET_ROOT', 
'http://'.$_SERVER['HTTP_HOST']
.str_replace($_SERVER['DOCUMENT_ROOT'],
'',
str_replace('\\','/',dirname(__DIR__).'/new'
))
);