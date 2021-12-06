<?php
namespace Phpritesh\Rksms\Services;
use GuzzleHttp\Client;

abstract class Sms
{
    protected $text;
    protected $username;
    protected $password;
    protected $recipients = [];
    private static $httpClient;
    protected $sender;
    protected $response;
    protected $client;
    protected $request;
    protected $dltctid;

    public $httpError;


    public static function getInstance()
    {
        if (! self::$httpClient) {
            self::$httpClient = new Client();
        }

        return self::$httpClient;
    }

    public function ctid($id)
    {
        if(!empty($id))
        {
            $this->setCtId($id);
        }

    }

    public function setCtId($id)
    {
        $this->dltctid = $id;
    }

    public function getCtId()
    {
        return $this->dltctid;
    }


    public function to($numbers)
    {
        $numbers = is_array($numbers) ? $numbers : func_get_args();

        if (count($numbers)) {
            $this->setRecipients($numbers);
        }

        return $this;
    }

    private function setRecipients($numbers)
    {
        foreach ($numbers as $number) {
            $this->recipients[] = $this->numberFormat($number);
        }

        return $this;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function text($text = null)
    {
        if ($text) {
            $this->setText($text);
        }

        return $this;
    }

    private function numberFormat($number)
    {
        $number = (string) $number;
        $number = trim($number);
        $number = preg_replace("/\s|\+|-/", '', $number);

        return $number;
    }

    public function setText($text)
    {
        $this->text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($text));

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function from($from)
    {
        $this->sender = $from;

        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getException()
    {
        return $this->httpError;
    }

   
    public function hasRecipients()
    {
        return property_exists($this, 'recipients') && ! empty($this->recipients);
    }

}