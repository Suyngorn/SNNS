<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Book::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/book');
        CRUD::setEntityNameStrings('book', 'books');
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
        CRUD::addColumn([
            'label'     => 'Author', // Table column heading
            'type'      => 'select',
            'name'      => 'author_id', // the column that contains the ID of that connected entity;
            'entity'    => 'author', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "App\Models\Auhor", // foreign key model
        ]);

        CRUD::addColumn([
            'label'     => 'Room', // Table column heading
            'type'      => 'select_multiple',
            'name'      => 'library', // the method that defines the relationship in your Model
            'entity'    => 'library', // the method that defines the relationship in your Model
            'attribute' => 'room', // foreign key attribute that is shown to user
            'model'     => 'App\Models\Library', // foreign key model
        ]);
        CRUD::column('created_at');
        CRUD::column('updated_at');

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
        CRUD::setValidation(BookRequest::class);

        CRUD::field('name');
        CRUD::addField([
            'label'       => "Author", // Table column heading
            'type'        => "select2_from_ajax",
            'name'        => 'author_id', // the column that contains the ID of that connected entity
            'entity'      => 'author', // the method that defines the relationship in your Model
            'attribute'   => "name", // foreign key attribute that is shown to user
            'data_source' => url("api/author"), // url to controller search function (with /{id} should return    model)
        
            // OPTIONAL
            // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
            'placeholder'             => "Select a Author", // placeholder for the select
            'minimum_input_length'    => 2, // minimum characters to type before querying results
            // 'model'                   => "App\Models\Category", // foreign key model
            // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
            // 'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
            // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
        ]);


        CRUD::addField([
            'label'     => "Room",
            'type'      => 'select2_multiple',
            'name'      => 'library', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'library', // the method that defines the relationship in your Model
            'model'     => "App\Models\library", // foreign key model
            'attribute' => 'room', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            // 'select_all' => true, // show Select All and Clear buttons?

            // optional
            // 'options'   => (function ($query) {
            //     return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
            // }),
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
}
