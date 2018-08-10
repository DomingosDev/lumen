<?php
namespace App\Helpers;

use Mustache_Engine;
use Mustache_LambdaHelper;
use Mustache_Loader_FilesystemLoader;

class UI
{
	private $m = null;
	public function __call($key,$params){
	    if(!isset($this->{$key})) throw new Exception("Call to undefined method ".get_class($this)."::".$key."()");
	    $subject = $this->{$key};
	    call_user_func_array($subject,$params);
	}

	public static function getInstance(){
	  static $instance = null;
	  if (null === $instance){
	  	$instance = new static();

	  	$app = app();
	  	$instance->m = new Mustache_Engine([ 
                                    'loader' => new Mustache_Loader_FilesystemLoader( $app->path() . '/Views', ['extension' => '.html']),
                                    'partials_loader' => new Mustache_Loader_FilesystemLoader( $app->path() . '/Views/partials', ['extension' => '.html']),
                                    'strict_callables' => true
                                ]);
	  } 
	  return $instance;
	}



       public function render($template){
       		return $this->m->render( $template, $this );
       }

	public function config($data){
		foreach($data as $key => $value){ $this->$key = $value; }

		if( isset($data['fields']) ){
			$compileFields = function( $self, $field ){
				$field = (object) $field;
				$field_name = "_field-" . $field->name;
				$self->$field_name = $this->m->render( 'UI/field_' . $field->type, $field );

				return $self;
			};

			array_reduce( $data['fields'], $compileFields, $this );
		}


		$this->te = function($text, Mustache_LambdaHelper $helper){
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
