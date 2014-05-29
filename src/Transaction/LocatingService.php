<?php
namespace PHPSC\PagSeguro\Transaction;

use PHPSC\PagSeguro\BaseService;
use PHPSC\PagSeguro\Client;
use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\TransactionLocatingService;

class LocatingService extends BaseService implements TransactionLocatingService
{
    /**
     * @var string
     */
    const TRANSACTIONS = '/v2/transactions';

    /**
     * @var string
     */
    const NOTIFICATIONS = '/v2/transactions/notifications';

    /**
     * @var Decoder
     */
    private $decoder;

    /**
     * @param Credentials $credentials
     * @param Client $client
     * @param Decoder $decoder
     */
    public function __construct(
        Credentials $credentials,
        Client $client = null,
        Decoder $decoder = null
    ) {
        parent::__construct($credentials, $client);

        $this->decoder = $decoder ?: new Decoder();
    }

    /**
     * @param string $code
     *
     * @return Transaction
     */
    public function getByCode($code)
    {
        return $this->decoder->decode($this->get(static::TRANSACTIONS . '/' . $code));
    }

    /**
     * @param string $code
     *
     * @return Transaction
     */
    public function getByNotification($code)
    {
        return $this->decoder->decode($this->get(static::NOTIFICATIONS . '/' . $code));
    }
}