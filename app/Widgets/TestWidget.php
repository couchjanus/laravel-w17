<?php

namespace App\Widgets;

use App\Widgets\Contracts\ContractWidget;

/**
 * Class TestWidget
 * Класс для демонстрации работы расширения
 * @package App\Widgets
 */
class TestWidget implements ContractWidget{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function execute(){
				
		return view('widgets::test');
		
	}	
}
