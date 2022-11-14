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

    /**
     * Извлекает из ответа Геокодера долготу
     * @param  $adress string Адрес, по которому ищутся координаты
     * @return string Longitude
     */
    public function getLong($adress):string
    {
        $location = explode(' ', ArrayHelper::getValue($this->loadLocation($adress), self::GEOCODE_COORDINATES_KEY));

        return $location[self::GEOCODE_LONGITUDE];
    }

    /**
     * Извлекает из ответа Геокодера широту
     * @param $adress string Адрес, по которому ищутся координаты
     * @return string Longitude
     */
    public function getLat($adress):string
    {
        $location = explode(' ', ArrayHelper::getValue($this->loadLocation($adress), self::GEOCODE_COORDINATES_KEY));

        return $location[self::GEOCODE_LATITUDE];
    }

    /**
     * Извлекает из ответа Геокодера адрес
     * @param $adress string Координаты, по которым ищется адрес
     * @return mixed Адреc
     */
    public function getAddress($adress):string
    {
        return ArrayHelper::getValue($this->loadLocation($adress), self::GEOCODER_ADDRESS_KEY);
    }

    /**
     * Geocoder ApiKey
     * @return string Возвращает АПИ ключ из конфига
     */
    public function getApiKey():string
    {
        return $this->apiKey;
    }

    /**
     * Связывается с ЯндексГеокодер и возвращает ответ в виде массива данных
     * @param $adress string Адрес|координаты, которые передаются в API Геокодера
     * @return mixed возвращает массив данных от Геокодера
     */
    private function loadLocation($adress):array
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