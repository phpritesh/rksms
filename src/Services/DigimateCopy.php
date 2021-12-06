<?php
namespace Phpritesh\Rksms\Services;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
class DigimateCopy extends Sms
{

    private $baseUrl = 'https://digimate.airtel.in:15443/BULK_API/SendMessage';

    /**
     * Class Constructor.
     * @param null $message
     */
    public function __construct($message = null)
    {
        $this->username = config('rksms.digimate.username');

        if ($message) {
            $this->text($message);
        }

        $this->client = self::getInstance();
        $this->request = new Request('POST', $this->baseUrl.'create');
    }

    /**
     * @param null $text
     * @return bool
     */
    public function send($text = null): bool
    {
       
        if ($text) {
            $this->setText($text);
        }
        try {
          
            $response = $this->client->send($this->request, [
                'form_params' => [
                    'loginID' => config('digimate.digimate.username'),
                    'password' => config('digimate.digimate.password'),
                    'mobile' => implode(',', $this->recipients),
                    'senderid' => $this->sender ?? config('digimate.sender'),
                    'text' => $this->text,
                    'DLT_TM_ID' => config('digimate.tmid'),
                    'DLT_CT_ID' => $this->getCtId,
                    'DLT_PE_ID' => config('digimate.peid'),
                    'route_id' => 'DLT_SERVICE_IMPLICT',
                    'Unicode' => 0,
                    'camp_name' => config('digimate.camp_name'),
                ],
            ]);

            $response = json_decode($response->getBody()->getContents(), true) ?? [];
            $this->response = array_key_exists('error', $response) ? $response['error']['message'] : $response['data']['message'];

            return $response['data']['status'] == 'success' ? true : false;
        } catch (ClientException $e) {
            logger()->error('HTTP Exception in '.__CLASS__.': '.__METHOD__.'=>'.$e->getMessage());
            $this->httpError = $e;

            return false;
        } catch (\Exception $e) {
            logger()->error('SMS Exception in '.__CLASS__.': '.__METHOD__.'=>'.$e->getMessage());
            $this->httpError = $e;

            return false;
        }
    }

}