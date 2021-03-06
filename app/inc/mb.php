<?php
	namespace app\inc;

	// Функції яких мені не хватає в php
	// взято з github спеіально для цьой ігри
	class mb
	{

		/**
		 * @param mixed $string The input string.
		 * @param mixed $replacement The replacement string.
		 * @param mixed $start If start is positive, the replacing will begin at the start'th offset into string.  If start is negative, the replacing will begin at the start'th character from the end of string.
		 * @param mixed $length If given and is positive, it represents the length of the portion of string which is to be replaced. If it is negative, it represents the number of characters from the end of string at which to stop replacing. If it is not given, then it will default to strlen( string ); i.e. end the replacing at the end of string. Of course, if length is zero then this function will have the effect of inserting replacement into string at the given start offset.
		 * @return string The result string is returned. If string is an array then array is returned.
		 */
		public static function substr_replace ( $string , $replacement , $start , $length = NULL )
		{
    		
    		if ( is_array ( $string ) ) {

        		$num = count ( $string );
       			
       			// $replacement
	        	$replacement = is_array ( $replacement ) ? array_slice ( $replacement , 0 , $num ) : array_pad ( array ( $replacement ) , $num , $replacement );

	        	// $start
	        	if  ( is_array( $start ) ) {

	        	    $start = array_slice ( $start , 0 , $num );
	        	    foreach ( $start as $key => $value )
	        	        $start[$key] = is_int ( $value ) ? $value : 0;

	        	} else {

	        	    $start = array_pad ( array ( $start ) , $num , $start );

	        	}

	        	// $length
	        	if ( !isset ( $length ) ) {

	        	    $length = array_fill ( 0 , $num , 0 );

	        	} elseif ( is_array ( $length ) ) {
            		
            		$length = array_slice ( $length , 0 , $num );
            		foreach ( $length as $key => $value )
                		$length[$key] = isset ( $value ) ? ( is_int ( $value ) ? $value : $num ) : 0;

                } else {
            		
            		$length = array_pad ( array ( $length ) , $num , $length );

        		}

        		// Recursive call
        		return array_map(__FUNCTION__, $string, $replacement, $start, $length);

    		}
    		
    		preg_match_all ( '/./us' , (string) $string , $smatches );
    		preg_match_all ('/./us' , (string) $replacement , $rmatches );

   			if ( $length === NULL )
   				$length = mb_strlen ( $string );

    		array_splice ( $smatches[0] , $start , $length , $rmatches[0] );

    		return join ( $smatches[0] );

		}

		/**
 * Replace all occurrences of the search string with the replacement string.
 *
 * @author Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license http://creativecommons.org/publicdomain/zero/1.0/
 * @link http://php.net/manual/function.str-replace.php
 *
 * @param mixed $search
 * @param mixed $replace
 * @param mixed $subject
 * @param int $count
 * @return mixed
 */
		public static function str_replace ( $search , $replace, $subject, &$count = 0) {
		if (!is_array($subject)) {
			// Normalize $search and $replace so they are both arrays of the same length
			$searches = is_array($search) ? array_values($search) : array($search);
			$replacements = is_array($replace) ? array_values($replace) : array($replace);
			$replacements = array_pad($replacements, count($searches), '');

			foreach ($searches as $key => $search) {
				$parts = mb_split(preg_quote($search), $subject);
				$count += count($parts) - 1;
				$subject = implode($replacements[$key], $parts);
			}
		} else {
			// Call mb_str_replace for each subject in array, recursively
			foreach ($subject as $key => $value) {
				$subject[$key] = mb_str_replace($search, $replace, $value, $count);
			}
		}

		return $subject;
	}

	}