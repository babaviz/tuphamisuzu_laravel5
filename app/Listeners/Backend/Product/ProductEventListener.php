<?php

namespace App\Listeners\Backend\Product;

/**
 * Class UserEventListener.
 */
class ProductEventListener
{
    /**
     * @var string
     */
    private $history_slug = 'User';

    /**
     * @param $event
     */
    public function onCreated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->product->id)
            ->withText('trans("history.backend.products.created") <strong>{product}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'product_link' => ['admin.product.show', $event->product->name, $event->product->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->product->id)
            ->withText('trans("history.backend.products.updated") <strong>{product}</strong>')
            ->withIcon('save')
            ->withClass('bg-aqua')
            ->withAssets([
                'product_link' => ['admin.product.show', $event->product->name, $event->product->id],
            ])
            ->log();
    }

    /*TODO: add deleted event*/

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withText('trans("history.backend.users.deleted") <strong>{user}</strong>')
            ->withIcon('trash')
            ->withClass('bg-maroon')
            ->withAssets([
                'user_link' => ['admin.access.user.show', $event->user->name, $event->user->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withText('trans("history.backend.users.restored") <strong>{user}</strong>')
            ->withIcon('refresh')
            ->withClass('bg-aqua')
            ->withAssets([
                'user_link' => ['admin.access.user.show', $event->user->name, $event->user->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withText('trans("history.backend.users.permanently_deleted") <strong>{user}</strong>')
            ->withIcon('trash')
            ->withClass('bg-maroon')
            ->withAssets([
                'user_string' => $event->user->name,
            ])
            ->log();

        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withAssets([
                'user_string' => $event->user->name,
            ])
            ->updateUserLinkAssets();
    }

    /**
     * @param $event
     */
    public function onPasswordChanged($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withText('trans("history.backend.users.changed_password") <strong>{user}</strong>')
            ->withIcon('lock')
            ->withClass('bg-blue')
            ->withAssets([
                'user_link' => ['admin.access.user.show', $event->user->name, $event->user->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onDeactivated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withText('trans("history.backend.users.deactivated") <strong>{user}</strong>')
            ->withIcon('times')
            ->withClass('bg-yellow')
            ->withAssets([
                'user_link' => ['admin.access.user.show', $event->user->name, $event->user->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onReactivated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withText('trans("history.backend.users.reactivated") <strong>{user}</strong>')
            ->withIcon('check')
            ->withClass('bg-green')
            ->withAssets([
                'user_link' => ['admin.access.user.show', $event->user->name, $event->user->id],
            ])
            ->log();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Product\ProductCreated::class,
            'App\Listeners\Backend\Product\ProductEventListener@onCreated'
        );
        $events->listen(
            \App\Events\Backend\Product\ProductUpdated::class,
            'App\Listeners\Backend\Product\ProductEventListener@onUpdated'
        );
        $events->listen(
            \App\Events\Backend\Product\ProductDeleted::class,
            'App\Listeners\Backend\Product\ProductEventListener@onDeleted'
        );
        $events->listen(
            \App\Events\Backend\Product\ProductRestored::class,
            'App\Listeners\Backend\Product\ProductEventListener@onRestored'
        );
        $events->listen(
            \App\Events\Backend\Product\ProductPermanentlyDeleted::class,
            'App\Listeners\Backend\Product\ProductEventListener@onPermanentlyDeleted'
        );
    }
}
