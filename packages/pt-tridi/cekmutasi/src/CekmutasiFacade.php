<?php

namespace PTTridi\Cekmutasi;

use Illuminate\Support\Facades\Facade;

class CekmutasiFacade extends Facade
{
	protected static function getFacadeAccessor() {
	    return 'Cekmutasi';
	}
}