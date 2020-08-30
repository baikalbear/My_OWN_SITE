<?php
	class View
	{
		//Задаю путь к скриптам шаблонов
		const VIEWS_PATH = "./views/";
		
		/**
		 * Store variables which we are going to use in view file
		 */
		public $data;
		
		/**
		 * Store full html for the view
		 */
		public $html = '';
		
		/**
		 * Store content for each $block in view. A block constist of content
		 * between $this->start($block) and $this->stop($block) constructions.
		 */
		public $blocks = [];

		//Сюда буду сохранять имя скрипта шаблона
		public $view = '';
		
		//Здесь я буду хранить имя родительского шаблона
		public $parentView = '';

		//Буду выполнять эту функцию при обращении к недоступным свойствам объекта
		public function __get($name) {
			if (isset($this->data[$name])) return $this->data[$name];
			return "";
		}
		
		/**
		 * Process view file and return resulting content
		 * 
		 * @param string $view View file name, can include path relative
		 *    to views root directory
		 * 
		 * @return string Processed content of view
		 */
		public function load($view, $params = [])
		{
			//Save params values to use it in view file
			if (count($params) > 0) {
				$this->data = $params;
			}
			
			//Store the view which we work with
			$this->view = $view;
			
			//Проверяю наличие файла шаблона
			if(!file_exists(static::VIEWS_PATH.$view.'.html.php')) {
				crash("Файл шаблона " . static::VIEWS_PATH.$view.'.html.php' . " не найден");
			}
			
			//Исполняю дочерний скрипт шаблона, в результате исполнения вывод скрипта оказывается в переменной $this->blocks['имя блока']
			require(static::VIEWS_PATH . $view . '.html.php');
			
			//Начинаем сохранять вывод в буфер
			ob_start();
			
			//Выполняем скрипт родительского шаблона
			require(static::VIEWS_PATH.$this->parentView.'.html.php');
			
			//Возврат буферизированного вывода методу контроллера
			return ob_get_clean();
		}
		
		/**
		 * Add var to use in view file
		 */
		public function setVar($name, $value) {
		   $this->data[$name] = $value;
		}
		
		//С помощью данной функции я определяю имя родительского шаблона из файла шаблона
		public function extend($parent_view)
		{
			$this->parentView = $parent_view;
		}
		
		//Алиас для extend с 2020/08/30
		public function setParentView($parent_view){
			return $this->extend($parent_view);
		}
		
		//Эту функцию использую в скрипте шаблона, чтобы начать буферизацию вывода
		public function start($block)
		{
			ob_start();
		}
		
		//Эту функцию использую, чтобы остановить начатую с помощью start() функции буферизацию вывода
		//и сохранить полученный буфер в переменную $this->blocks['имя блока'].
		public function stop($block)
		{
			//Записываю буфер после чего очищаю его
			$this->blocks[$block] = ob_get_clean();
		}
		
		/**
		 * Insert block of content from child view to parent view.
		 */
		public function output($block)
		{
			if (!isset($this->blocks[$block])) {
				echo '';
			} else{
				echo $this->blocks[$block];
			}
		}
		
		/**
		 * Add css asset link to view file
		 */
		public function assetCSS($file)
		{
			echo '<link href="'.ASSETS_PATH.$file.'" rel="stylesheet">'."\n";
		}
		
		/**
		 * Add java script asset link to view file
		 */
		public function assetJS($file)
		{
			echo '<script src="'.\ASSETS_PATH.$file.'"></script>'."\n";
		}
	}