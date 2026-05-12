<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'spiderpunkers@gmail.com';
    public string $fromName   = 'PM System - PT Vitech Asia';

    public string $protocol = 'smtp';
    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'spiderpunkers@gmail.com';
    public string $SMTPPass = 'qrnvpycancgmdqoa';
    public int $SMTPPort = 587;
    public string $SMTPCrypto = 'tls';
    public bool $SMTPAuth = true;

    public string $mailType = 'html';
    public string $charset = 'UTF-8';
    public string $newline = "\r\n";
    public string $CRLF = "\r\n";
}