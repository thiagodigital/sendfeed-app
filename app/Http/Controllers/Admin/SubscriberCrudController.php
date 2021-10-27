<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendEmailFeed;
use App\Events\SendFeedEvent;
use App\Events\ZapitoApiEvent;
use App\Http\Requests\SubscriberRequest;
use App\Models\Feed;
use App\Models\Subscriber;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

/**
 * Class SubscriberCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubscriberCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Subscriber::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subscriber');
        CRUD::setEntityNameStrings('subscriber', 'subscribers');
    }

    public function show(Request $request)
    {
        $data = Subscriber::countAudiences($request->id);
        $crud = $this->crud;
        return view('subscriber.show', compact('data', 'crud'));

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('phone');
        CRUD::addColumn([
            'name'  =>  'status',
            'label' =>  'Status',
            'type'  =>  'radio',
            'options' => [
                1 => 'Ativo',
                0 => 'Inativo'
            ],
            'inline' => true,
            'default' => 1
        ]);
        CRUD::addColumn([
            'name'  =>  'feeds',
            'label' =>  'Audience',
            'type'  =>  'relationship_count',
            'suffix' => ' views'
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubscriberRequest::class);

        CRUD::field('name');
        CRUD::field('phone');
        CRUD::addField([
            'name'  =>  'status',
            'label' =>  'Status',
            'type'  =>  'radio',
            'options' => [
                1 => 'Ativo',
                0 => 'Inativo'
            ],
            'inline' => true,
            'default' => 1
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store(Request $request)
    {
        $subscriber = Subscriber::create($request->all());

        event(new ZapitoApiEvent($subscriber));

        return redirect('/admin/subscriber')->withSuccess('Você esta inscrito na lista de recebimento!');
    }

}
