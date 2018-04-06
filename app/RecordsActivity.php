<?php
/**
 * Created by PhpStorm.
 * User: jt
 * Date: 04.04.2018
 * Time: 09:24
 */

namespace App;


trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {

        if (auth()->guest()) return;

        foreach (static::getRecordEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });

    }

    protected static function getRecordEvents()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }

}