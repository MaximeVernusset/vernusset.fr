<?php
	
	abstract class Entity {
		
		/**
		 * Hydrates class attributes whith given data.
		 * @param array $data data to hydrate.
		 */
		protected function hydrate(array $data) {
			foreach($data as $key => $value) {
				$method = 'set'.ucfirst($key);
				if(method_exists($this, $method))
					$this->$method($value);
			}
		}
		
		/**
		 * Serialize object into string.
		 * @return string serialized object.
		 */
		public abstract function toString();
	}