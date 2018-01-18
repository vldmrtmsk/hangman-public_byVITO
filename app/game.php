<?php
	
	/**
     * @author : Володимир Тимощук (VITO, TIMA, VLDMRTMSK)
     * @link : http://vk.com/vldmrtmsk
     * @link : http://instaram.com/vldmrtmsk
     * @link : http://github.com/vldmrtmsk
     **/

	// Просторове ім`я
	namespace app;

	// Клас з ігрой 
	class Game
	{

		/**
		 * Тут буде список слів
		 **/
		private static $word = [];

		/**
		 * Адреса файлу з словами
		 **/
		private static $file_word = '/app/data/word.dat';

		/**
		 * Html
		 **/
		public static $html = '';


		public function __construct ( )
		{

			if ( is_file ( dirname ( __DIR__ ) . self::$file_word ) ) {

				self::$word = file ( dirname ( __DIR__ ) . self::$file_word , FILE_IGNORE_NEW_LINES );

			} else
				throw new \Exception ( "Не можу знайти базу слів!" , 1 );
				
			// Запускаэм гру
			return self::start ( );

		}

		// Для вибору случайного слова
		public static function random ( array $arr )
		{

			// Підраховуємо кількість
			$c = count($arr)-1;
			$rand = mt_rand ( 0, $c );

			// Віддаєм
			return rtrim ( $arr[$rand] );

		}

		// Запускаэм гру
		public static function start ( )
		{

			if ( !isset ( $_SESSION['word'] ) or isset ( $_GET['restart'] ) ) {

				self::__restart ( );

			}

			if ( !isset ( $_SESSION['end'] ) )
					$_SESSION['end'] = 1;

			// Перевірям букву
			if ( isset ( $_GET['key'] ) ) {

				$l = View::$liter[(int) $_GET['key']];
				$word = mb_strtoupper( $_SESSION['word'] );

				if ( strpos ( $word , $l ) !== false ) {
				
					$_SESSION['liter'][$l] = true;

				} else {

					$_SESSION['end']++;
					$_SESSION['liter'][$l] = false;

				}

			}

			if ( $_SESSION['end'] > 7 ) {

				self::__restart ( );

				self::$html .= '<script>dialog.showModal();</script>';

				$_SESSION['ends'] = true;

			}

			self::$html .= '<center><img src="/assets/Game/hang_' . $_SESSION['end'] . '.jpg"/></center>';

		}

		// Функція заміняє невідомі слова
		public static function word ( )
		{
			
			// level 1			
			$word = mb_strtoupper ( $_SESSION['word'] );
			$st = mb_substr ( $word , 0 , 1 );
			$countWord = mb_strlen ( $word , 'utf-8');
			$se = mb_substr ( $word , $countWord-1 , 1 );
			$l = $_SESSION['liter'];

			foreach ( $l as $key => $value ) {

				if ( mb_stristr ( $word , $key ) !== false ) {
			
					$word = inc\mb::str_replace ( $key , ":|{$key}|:" , $word );

				}

			}

			// level 2
			$e = explode ( ':' , $word );

			foreach ( $e as $key => $val ) {

				if ( $val != null )
					if ( mb_stristr ( $val , '|' ) !== false ) 

						$e[$key] = inc\mb::str_replace ( '|' , '' , $val );

					else {

						$i = 1;
						$c = mb_strlen ( $val );
						$e[$key] = '';

						while ( $i <= $c ) {

							if ( $i === 0 ) false;
							$e[$key] .= '?';
							$i++;

						}

					}

			}

			// level 3 boss;)
			$word = '';
			$i = 0;
			foreach ( $e as $val ) {

				$word .= $val;

			}

			$word = $st . inc\mb::substr_replace ( $word , '' , 0 , 1 );
			$word = mb_substr ( $word , 0 , $countWord-1 ) . $se;

			// Вдруг виграли
			if ( mb_substr_count ( $word , "?" ) == 0 ) {

				$_SESSION['peremog']++;
				return self::peremoha ( );

			} elseif ( $_SESSION['ends'] == true ) {
				$_SESSION['progral']++;
				$_SESSION['ends'] = false;
				return $_SESSION['word'];

			} else {

				return $word;

			}

		}

		// Вдруг хтось виграє
		private static function peremoha ( )
		{

			self::__restart ( );

			return '<script>dialog1.showModal();</script>';

		}

		// Statistic
		public static function statistic ( string $data )
		{

			if ( $data == 'p' )
				return $_SESSION['peremog'];
			elseif ( $data == 'pr' )
				return $_SESSION['progral'];
			else
				return 0;


		}

		// Restart
		private static function __restart ( )
		{

			unset ( $_SESSION['word'] );
			unset ( $_SESSION['end'] );
			unset ( $_SESSION['liter'] );
			$_SESSION['word'] = self::random ( self::$word );
			$_SESSION['end'] = 1;
			$_SESSION['liter'] = [];

			if ( !isset ( $_SESSION['peremog'] ) )
				$_SESSION['peremog'] = 0;
			if ( !isset ( $_SESSION['progral'] ) )
				$_SESSION['progral'] = 0;

		}

	}
