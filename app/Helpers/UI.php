<?php
namespace App\Helpers;
use Mustache_LambdaHelper;
class UI
{
	public function __call($key,$params){
	    if(!isset($this->{$key})) throw new Exception("Call to undefined method ".get_class($this)."::".$key."()");
	    $subject = $this->{$key};
	    call_user_func_array($subject,$params);
	}

	public static function getInstance(){
	  static $instance = null;
	  if (null === $instance) $instance = new static();
	  return $instance;
	}

	public function config($data){
		foreach($data as $key => $value){ $this->$key = $value; }


		$this->te = function($text, Mustache_LambdaHelper $helper){
			echo '<pre>';
			var_dump( $this );
			echo '</pre>';
			return 'periquito';
		};

		return $this;
	}

	public static function __callStatic($name, $args){
		$class = get_called_class();
	  	$function = $class::getInstance()->{$name};
		$item = call_user_func_array($function, $args);
		return $item;
	}


}
