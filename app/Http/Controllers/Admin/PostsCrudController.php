<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PostsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Posts::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/posts');
        CRUD::setEntityNameStrings('posts', 'posts');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title');
        CRUD::column('body');
        CRUD::column('trainer_id');
        CRUD::addColumn([
            'name'      => 'thumbnail', // The db column name
            'label'     => 'Cover', // Table column heading
            'type'     => 'closure',
            'function' => function($entry) {
                // return "<img width='50' src='".asset($entry->thumbnail)."'/>";

                
                return '<a class="example-image-link" href="' .asset($entry->thumbnail). '" data-lightbox="lightbox-' . $entry->id . '">
                    <img class="example-image" src="'.asset($entry->thumbnail) . '" alt="" width="35" style="cursor:pointer"/>
                    </a>';
            }
        ]);


        // CRUD::addColumn([
        //     'name'      => 'thumbnail', // The db column name
        //     'label'     => 'Cover', // Table column heading
        //     'type'     => 'closure',
        //     'function' => function($entry) {
        //         return "<image width='50' src='".asset($entry->thumbnail)."'/>";
        //     }
        // ]);

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
        CRUD::setValidation(PostsRequest::class);

        CRUD::field('title');
        CRUD::field('body');
        CRUD::addField([
            'label' => "Thumnail",
            'name' => "thumbnail",
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);
        CRUD::addField([
            'label'     => "Trainer",
            'type'      => 'select2',
            'name'      => 'trainer_id', // the db column for the foreign key

            // optional
            'entity'    => 'trainer', // the method that defines the relationship in your Model
            'model'     => "App\Models\Trainer", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 2, // set the default value of the select2

                // also optional
            // 'options'   => (function ($query) {
            //         return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
            //     }),
        ]);

        CRUD::addField([
            'label'     => "Category",
            'type'      => 'select2_multiple',
            'name'      => 'category', // the method that defines the relationship in your Model
       
            // optional
            'entity'    => 'category', // the method that defines the relationship in your Model
            'model'     => "App\Models\Categories", // foreign key model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            // 'select_all' => true, // show Select All and Clear buttons?
       
            // optional
            // 'options'   => (function ($query) {
            //     return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
            // }), 
        ]);
        // CRUD::addField(['name' => 'price', 'type' => 'number']);
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
