<?php
	
	/**
     * @author : Володимир Тимощук (VITO, TIMA, VLDMRTMSK)
     * @link : http://vk.com/vldmrtmsk
     * @link : http://instaram.com/vldmrtmsk
     * @link : http://github.com/vldmrtmsk
     **/

	// Просторове ім`я
	namespace app;

	// Клас з тим що ми будем бачити
	class View
	{

		// Масив
		public static $liter = [ 'Й' , 'Ц' , 'У' , 'К' , 'Е' , 'Н' , 'Г' , 'Ш' , 'Щ' , 'З' , 'Х' , 'Ї' , 'Ф' , 'І' , 'В' , 'А' , 'П' , 'Р' , 'О' , 'Л' , 'Д' , 'Ж' , 'Є' , 'Я' , 'Ч' , 'С' , 'М' , 'И' , 'Т' , 'Ь' , 'Б' , 'Ю' ];

		public function __construct ( )
		{

			return true;

		}

		/**
		 * Той прикольний чувачок;)
		 **/
		public static function hangman ( \App\Game $game )
		{

			$game = Game::$html;

			return self::__main ( $game );

		}

		/**
		 * HTML шаблон
		 **/
		public static function __main ( string $content = "Hello, World!" )
		{

			$html = file_get_contents ( dirname ( __DIR__ ) . "/assets/Game/Pages/main.html" );

			$html = str_ireplace ( "{content}", $content , $html );

			$html = str_ireplace ( "{word}", Game::word () , $html );

			$html = $html = str_ireplace ( "{peremog}", Game::statistic ( 'p' ) , $html );
			$html = $html = str_ireplace ( "{progral}", Game::statistic ( 'pr' ) , $html );

			// Key board
			$html = str_ireplace ( "{keyboard}" , self::__keyboard ( ) , $html );

			return $html;

		}

		/**
		 * Keyboard
		 **/
		private static function __keyboard ( array $liter = null )
		{

			if ( $liter == null )
				$liter = self::$liter;

			$html = '';
			$i = 0;
			$i_ = 0;
			foreach ( $liter as $key => $val ) {

				if ( $i == 12 )
					$html .='<br />';
				else if ( $i == 23 )
					$html .='<br />';

				if ( isset ( $_SESSION['liter'][$val] ) )
					$html .= '<a><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">' . $val . '</button></a>';
				else
					$html .= '<a href="/?key=' . $key . '"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">' . $val . '</button></a>';

				$i++;

			}

			return $html;

		}

	}