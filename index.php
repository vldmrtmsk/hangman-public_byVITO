<?php
	
	/**
     * @author : Володимир Тимощук (VITO, TIMA, VLDMRTMSK)
     * @link : http://vk.com/vldmrtmsk
     * @link : http://instaram.com/vldmrtmsk
     * @link : http://github.com/vldmrtmsk
     **/

	// Буферизація даних
	ob_start ( );
	ob_implicit_flush ( 0 );

	// Запускаєм сесію
	session_start ( );

	// Підгружаєм класи для ігри
	require_once __DIR__ . '/app/game.php';
	require_once __DIR__ . '/app/view.php';
	require_once __DIR__ . '/app/inc/mb.php';

	use \App\Game;
	use \App\View;
	use \App\inc\mb;

	// Запускаєм ігру
	$app = new Game;
	$view = new View;

	echo $view -> hangman ( $app );

?>