<?php

namespace App\Widgets;

use App\Widgets\Contracts\ContractWidget;
use App\Category;

/**
 * Class CategoriesWidget
 * 
 * @package App\Widgets
 */
class CategoriesWidget implements ContractWidget{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function execute(){

        $data = Category::all();
        return view('widgets::categories', [
           'data' => $data
           ]
        );

	}	
}
