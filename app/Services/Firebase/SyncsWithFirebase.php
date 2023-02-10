<?php

namespace App\Services\Firebase;

use App\Jobs\SyncsWithFirebaseJob;
use Arr;
/**
 * Class SyncsWithFirebase
 * @package App\Traits
 */
trait SyncsWithFirebase
{
    /**
     * Boot the trait and add the model events to synchronize with firebase
     */
    public static function bootSyncsWithFirebase()
    {
        static::created(function ($model) {
            $model->saveToFirebase('set');
        });

        static::updated(function ($model) {
            $model->saveToFirebase('update');
        });

        static::deleted(function ($model) {
            $model->saveToFirebase('delete');
        });
    }

    /**
     * Get sync data from model
     *
     * @return array
     */
    protected function getFirebaseSyncData()
    {
        if ($fresh = $this->fresh()) {
            return Arr::only($fresh->toArray(), $this->firebaseSyncFields ?? ['id']);
        }

        return [];
    }

    /**
     * Save data to firebase
     *
     * @param $mode
     */
    protected function saveToFirebase($mode)
    {
        SyncsWithFirebaseJob::dispatch($mode, $this->getTable() . '/' . $this->getKey(), $this->getFirebaseSyncData());
    }
}
