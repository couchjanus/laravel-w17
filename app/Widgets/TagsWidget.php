<?php

namespace App\Widgets;

use App\Widgets\Contracts\ContractWidget;
use App\Tag;

/**
 * Class TestWidget
 * Класс для демонстрации работы расширения
 * @package App\Widgets
 */
class TagsWidget implements ContractWidget{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function execute(){

        $data = Tag::all();
        return view('widgets::tags', [
           'data' => $data
           ]
        );

	}	
}
