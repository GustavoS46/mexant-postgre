<?php

namespace App\WebService;

use function Psy\debug;

class Speedio {

    /**
     * URL base para as requisições.
     * @var string
     */
    const URL_BASE = 'https://api-publica.speedio.com.br';

    /**
     * Realiza uma requisição GET para consultar um CNPJ.
     *
     * @param string $cnpj O CNPJ a ser consultado.
     * @return array|null Um array com os dados retornados pela requisição ou null em caso de falha.
     */
    public function consultarCNPJ($cnpj) {
        return $this->get('/buscarcnpj=' . $cnpj);
    }

    /**
     * Realiza uma requisição GET para uma URL fornecida.
     *
     * @param string $resource O recurso a ser acessado na URL base.
     * @return array|null Um array com os dados retornados pela requisição ou null em caso de falha.
     */
    public function get($resource) {
        $endpoint = self::URL_BASE . $resource;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $responseArray = json_decode($response, true);

        return is_array($responseArray) ? $responseArray : [];
    }
}

?>
