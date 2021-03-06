<?php

namespace FondOfSpryker\Zed\AvailabilityAlertDataImport\Business\Model;

use Exception;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription;
use FondOfSpryker\Zed\AvailabilityAlertDataImport\Business\Model\Reader\AvailabilityAlertRateReaderInterface;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscriptionQuery;
use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AvailabilityAlertWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    const BULK_SIZE = 100;

    const KEY_EMAIL = 'email';
    const KEY_PRODUCT_ABSTRACT_SKU = 'product_abstract_sku';
    const KEY_LOCALE = 'locale';
    const KEY_SENT_AT = 'sent_at';
    const KEY_STATUS = 'status';

    const KEY_FK_PRODUCT_ABSTRACT = 'fk_product_abstract';
    const KEY_FK_LOCALE = 'fk_locale';

    /**
     * @var int[] Keys are locale name values are locale ids.
     */
    protected static $localeIdsCache = [];

    /**
     * @var int[] Keys are product abstract skus, values are product abstract ids.
     */
    protected static $productAbstractIdsCache = [];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet)
    {
        $availabilityAlertEntity = $this->findOrCreateAvailabilityAlert($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription
     */
    protected function findOrCreateAvailabilityAlert(DataSetInterface $dataSet)
    {

        $dataSet[static::KEY_FK_PRODUCT_ABSTRACT] = $this->getProductAbstractIdBySku($dataSet[static::KEY_PRODUCT_ABSTRACT_SKU]);
        $dataSet[static::KEY_FK_LOCALE] = $this->getLocaleByName($dataSet[static::KEY_LOCALE]);

        $availabilityAlertEntity = FosAvailabilityAlertSubscriptionQuery::create()
            ->filterByEmail($dataSet[static::KEY_EMAIL])
            ->filterByFkProductAbstract($dataSet[static::KEY_FK_PRODUCT_ABSTRACT])
            ->findOneOrCreate();


        if ($availabilityAlertEntity->isNew() || $availabilityAlertEntity->isModified()) {
            try {
                $availabilityAlertEntity->setFkProductAbstract($dataSet[static::KEY_FK_PRODUCT_ABSTRACT]);
                $availabilityAlertEntity->setFkLocale($dataSet[static::KEY_FK_LOCALE]);
                $availabilityAlertEntity->setEmail($dataSet[static::KEY_EMAIL]);
                if (isset($dataSet[static::KEY_SENT_AT])) {
                    $availabilityAlertEntity->setSentAt($dataSet[static::KEY_SENT_AT]);
                }

                $availabilityAlertEntity->setStatus($dataSet[static::KEY_STATUS]);

                $availabilityAlertEntity->save();

            }catch (Exception $e) {
                print $e->getMessage(); exit();
            }

        }

        return $availabilityAlertEntity;

    }

    /**
     * @param string $countryIso2Code
     *
     * @return int
     */
    protected function getProductAbstractIdBySku($sku): int
    {
        if (!isset(static::$productAbstractIdsCache[$sku])) {
            static::$productAbstractIdsCache[$sku] = SpyProductAbstractQuery::create()
                ->findOneBySku($sku)
                ->getIdProductAbstract();
        }

        return static::$productAbstractIdsCache[$sku];
    }

    /**
     * @param string $countryIso2Code
     *
     * @return int
     */
    protected function getLocaleByName($name): int
    {
        if (!isset(static::$localeIdsCache[$name])) {
            static::$localeIdsCache[$name] = SpyLocaleQuery::create()
                ->findOneByLocaleName($name)
                ->getIdLocale();
        }

        return static::$localeIdsCache[$name];
    }
}