<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeedRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FeedCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FeedCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
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
        CRUD::setModel(\App\Models\Feed::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/feed');
        CRUD::setEntityNameStrings('feed', 'feeds');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name'  =>  'image',
            'label' =>  'Imagem',
            'type'  =>  'image'
        ]);
        CRUD::column('title');
        CRUD::addColumn([
            'name'    => 'status',
            'label'   => 'Status',
            'type'    => 'select_from_array',
            'options' => [1 => 'Não enviado', 2 => 'Enviado', 3 => 'Arquivado'],
        ]);



        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
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

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name'  =>  'image',
            'label' =>  'Imagem',
            'type'  =>  'image'
        ]);
        CRUD::addColumn([
            'name'  =>  'title',
            'label' =>  'Titulo',
            'type'  =>  'text'
        ]);
        CRUD::addColumn([
            'name'  =>  'description',
            'label' =>  'Descrição',
            'type'  =>  'text'
        ]);
        CRUD::addColumn([
            'name'    => 'status',
            'label'   => 'Status',
            'type'    => 'select_from_array',
            'options' => [1 => 'Não enviado', 2 => 'Enviado', 3 => 'Arquivado'],
        ]);

    }
}
