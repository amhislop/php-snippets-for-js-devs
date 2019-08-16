<?php
/**
 * PHP helper functions for the JavaScript developer
 *
 * @author    Aidan Hislop | https://github.com/amhislop
 * @version   1.0.0
 * @license   http://opensource.org/licenses/gpl-license.php  GNU Public License
 */

/**
 * The array_some function checks if any elements in an array 
 * pass a conditional set by a callback function
 *
 * @param   callable  $callback  The function to execute per iteration
 * @param   array     $arr       The array to be iterated over
 * 
 * @return  boolean              Returns TRUE if condition in callback is met for at least one array item
 */
function array_some( callable $callback, array $arr )
{
    for( $i = 0; $i < count( $arr ); $i++ ) {
        if ( $callback( $arr[$i], $i ) ) return true;
    }
    return false;
}

/**
 * The array_every function checks if all elements in an array 
 * pass a conditional set by a callback function
 *
 * @param   callable  $callback  The function to execute per iteration
 * @param   array     $arr       The array to be iterated over
 * 
 * @return  boolean              Returns TRUE if condition in callback is met for all array items
 */
function array_every( callable $callback, array $arr )
{
    for( $i = 0; $i < count( $arr ); $i++ ) {
        if ( !$callback( $arr[$i], $i ) ) return false;
    }
    return true;
}

/**
 * The array_find function iterates through an array and returns the first
 * item which meets the conditional set in the callback function
 *
 * @param   callable  $callback  The function to execute per iteration
 * @param   array     $arr       The array to be iterated over
 *
 * @return  mixed[]|null         Returns the first item that meets condition set in callback
 */
function array_find( callable $callback, array $arr )
{
  for( $i = 0; $i < count( $arr ); $i++ ) {
    if ( $callback( $arr[$i], $i ) ) return $arr[$i];
  }
  return null;
}

/**
 * The array_sort function sorts the items of a given array
 *
 * @param   array     $arr       The array to be sorted
 * @param   callable  $callback  A function that compares two consecutive values in the array
 *
 * @return  array                The sorted array
 */
function array_sort( array $arr, callable $callback = null )
{
  if( !$callback ) {

    $type = false;

    foreach( $arr as $item ) { 
      $type = gettype( $item );
      if($type === 'string') break;
    }

    switch( $type ) {
      case 'string' :
        $callback = function( string $a, string $b) {
            return strcmp($a, $b);
        };
        break;
      default :
        $callback = function( int $a, int $b ) {
          return $a - $b;
        };
        break;
    }
  }

  $sort;

	do {
		for ( $i = 1, $sort = false; $i < count( $arr ); $i++ ) {
      // Get current values
      $a = $arr[$i - 1];
      $b = $arr[$i];

      $result = $callback( $a, $b );
            
			if( $result !== 0 && ( $result > 0 || $result == false ) ) {

        // Switch values
        $arr[$i - 1] = $b;
        $arr[$i] = $a;

        // Sort required
        $sort = true;

			}
    }
	} while ( $sort );

  return $arr;  
}

/**
 * The array_entries function returns a new array containing arrays 
 * of the keys and values of the given array
 *
 * @param   array  $arr  The array whos [key => value] pairs are to be returned
 *
 * @return  array        An array of arrays containing the given arays [key => value] pairs
 */
function array_entries( array $arr )
{
	$new_array = [];

	foreach($arr as $key => $value) {
		$new_array[] = [ $key, $value ];
	}

	return $new_array;
}

/**
 * The array_restore function restores a new [key => value] array based on 
 * the arrays provided by the given array
 *
 * @param   array  $arr  The array whos arrays are to be restored to a string-keyed [key => value] format
 *
 * @return  array        A new array of keyed properties matching the given arrays items
 */
function array_restore( array $arr ) {
	$new_array = [];

	foreach( $arr as $entry ) {
		[ $key, $value ] = $entry;
		$new_array[$key] = $value;
	}

	return $new_array;
}

