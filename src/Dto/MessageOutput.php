<?php

namespace App\Dto;


class MessageOutput
{
   /**
    * @var string
    */
   public $account_name;

   /**
    * @var \DateTimeInterface
    */
   public $date;

   /**
    * @var string
    */
   public string $message;
}