<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

class Geocoder extends Component
{
    public string $apiKey;
    public string $baseUri;
    public Client $client;
    const RESPONSE_CODE_OK = 200;
    const GEOCODE_COORDINATES_KEY = 'response.GeoObjectCollection.featureMember.0.GeoObject.Point.pos';
    const GEOCODER_ADDRESS_KEY = 'response.GeoObjectCollection.featureMember.0.GeoObject.name';
    const GEOCODE_LONGITUDE = 0;
    const GEOCODE_LATITUDE = 1;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->client = new Client(['base_uri' => $this->baseUri]);
    }

    public function getLong($adress)
    {
        $location = explode(' ', ArrayHelper::getValue($this->loadLocation($adress), self::GEOCODE_COORDINATES_KEY));

        return $location[self::GEOCODE_LONGITUDE];
    }

    public function getLat($adress)
    {
        $location = explode(' ', ArrayHelper::getValue($this->loadLocation($adress), self::GEOCODE_COORDINATES_KEY));

        return $location[self::GEOCODE_LATITUDE];
    }

    public function getAddress($adress)
    {
        return ArrayHelper::getValue($this->loadLocation($adress), self::GEOCODER_ADDRESS_KEY);
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    private function loadLocation($adress)
    {
        $response = $this->client->request('GET', '1.x',
            ['query' => ['apikey' => $this->apiKey, 'geocode' => $adress, 'format' => 'json']]);

        if ($response->getStatusCode() !== self::RESPONSE_CODE_OK) {
            throw new Exception('Ошибка запроса');
        }
        $content = $response->getBody()->getContents();
        $responseData = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Ошибка формата ответа');
        }

        return $responseData;
    }
}