<?php
require "Parser.php";

use TemplateParser\Parser as Parser;

$template = 'Hi, {{userName}}.
Welcome to {{companyName}}! Go to {{siteUrl}} to activate your account.
Regards, {{companyName}}.
{{currentDate}}';

$parser = new Parser($template);

$message = $parser
    ->setUserName("John")
    ->setCompanyName("Google")
    ->setSiteUrl("http://www.google.com")
    ->parseTemplate();

echo $message;