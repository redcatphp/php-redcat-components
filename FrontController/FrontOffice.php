<?php
namespace RedCat\Framework\FrontController;
use RedCat\Route\Router;
use RedCat\Wire\Di;
use RedCat\Framework\Templix\Templix;
class FrontOffice extends FrontController{
	protected $l10n;
	function __construct(Router $router,Di $di,$l10n=null){
		$this->l10n = $l10n;
		parent::__construct($router,$di);
		$this->map([
			['backend/','new:RedCat\Framework\FrontController\Backoffice'],
			[['new:RedCat\Route\Match\Extension','css|js|png|jpg|jpeg|gif'],'new:RedCat\Framework\FrontController\Synaptic'],
			[['new:RedCat\Framework\RouteMatch\ByTml'.($this->l10n?'L10n':''),'','template'],'new:RedCat\Framework\Templix\Templix'.($this->l10n?'L10n':'')],
			[['new:RedCat\Framework\RouteMatch\ByTml'.($this->l10n?'L10n':''),'','shared/template'],'new:RedCat\Framework\Templix\Templix'.($this->l10n?'L10n':'')],
		]);
	}
	function run($path,$domain=null){
		if(!parent::run($path,$domain)){
			$this->di->create(Templix::class)->query(404);
			exit;
		}
		return true;
	}
}