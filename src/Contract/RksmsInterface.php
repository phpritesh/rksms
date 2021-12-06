<?php 
namespace Phpritesh\Rksms\Contract;
use Phpritesh\Rksms\Services\Sms;
interface RksmsInterface  {

    public function to($numbers): self;

    
    public function ctid($numbers): self;


    /**
     * @param $text
     * @return $this | string
     */
    public function text($text = null): self;

    /**
     * @param $from
     * @return string
     */
    public function from(string $from): self;

    /**
     * @return mixed
     */
    public function getResponse(): string;

    /**
     * @return \Exception|null
     */
    public function getException(): Sms;

    /**
     * @param null $text
     * @return bool
     */
    public function send($text = null): bool;
}