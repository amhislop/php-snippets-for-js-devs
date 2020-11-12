<?php
/**
 * PHP helper functions for the JavaScript developer
 *
 * @author    Aidan Hislop | https://github.com/amhislop
 * @version   1.0.0
 * @license   MIT
 */

if( ! function_exists( 'array_some' ) ) {
  /**
  * The array_some function checks if any elements in an array 
  * pass a conditional set by a callback function
  *
  * @param   callable  $callback  The function to execute per iteration
  * @param   array     $arr       The array to be iterated over
  * 
  * @return  boolean              Returns TRUE if condition in callback is met for at least one array item
  */
  function array_some( callable $callback, array $arr ): bool
  {
    
    $i = 0;
    
    foreach( $arr as $item ) {
      if ( $callback( $item, $i ) ) return true;
      $i++;
    }
    
    return false;
  }
}

if( ! function_exists( 'array_every' ) ) {
  /**
   * The array_every function checks if all elements in an array 
   * pass a conditional set by a callback function
   *
   * @param   callable  $callback  The function to execute per iteration
   * @param   array     $arr       The array to be iterated over
   * 
   * @return  boolean              Returns TRUE if condition in callback is met for all array items
   */
  function array_every( callable $callback, array $arr ): bool
  {
    $i = 0;
    
    foreach( $arr as $item ) {
      if ( !$callback( $item, $i ) ) return false;
      $i++;
    }
    
    return true;
  }
}

if( ! function_exists( 'array_find' ) ) {
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
    
    $i = 0;
    
    foreach( $arr as $item ) {
      if ( $callback( $item, $i ) ) return $item;
      $i++;
    }
    
    return null;
  }
}

if( ! function_exists( 'array_sort' ) ) {
  /**
   * The array_sort function sorts the items of a given array
   *
   * @param   array     $arr       The array to be sorted
   * @param   callable  $callback  A function that compares two consecutive values in the array
   *
   * @return  array                The sorted array
   */
  function array_sort( array $arr, callable $callback = null ): array
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
      
      // Check if associative array
      $associative = array_keys($arr) !== range( 0, count($arr) - 1 );
      
      // Convert associative arrays to entries
      if( $associative ) {
        $new_array = [];
        
        foreach( $arr as $key => $value ) {
          $new_array[] = [ $key, $value ];
        }
        $arr = $new_array;
      }
      
      for ( $i = 1, $sort = false; $i < count( $arr ); $i++ ) {
        // Get current values
        $a = $arr[$i - 1];
        $b = $arr[$i];
        
        $result = !$associative ? $callback( $a, $b ) : $callback( $a[1], $b[1] );
        
        if( $result !== 0 && ( $result > 0 || $result == false ) ) {
          
          // Switch values
          $arr[$i - 1] = $b;
          $arr[$i] = $a;
          
          // Sort required
          $sort = true;
          
        }
      }
      
      // Restore array if orignially associative
      if( $associative ) {
        $new_array = [];
        
        foreach( $arr as $entry ) {
          [$key, $value] = $entry;
          $new_array[$key] = $value;
        }
        
        $arr = $new_array;
      }
      
    } while ( $sort );
    
    return $arr;  
  }
}

if( ! function_exists( 'array_flat' ) ) {
  /**
   * The array_flat function creates a new array with all sub-array elements added into it recursively up to the specified depth.
   *
   * @param   array       $arr       The nested array to be flattened
   * @param   int|INF     $depth     The depth level specifying how deep a nested array structure should be flattened. Defaults to 1.
   *
   * @return  array                  The new array with the sub array elements added to it
   */
  function array_flat( array $arr, $depth = 1 ): array
  {
    
    $depth_remaining = $depth;
    $has_sub_arrays = true;
    
    while( $depth_remaining && $has_sub_arrays ) {
      
      $arr = array_reduce( $arr, function( $acc, $curr ) {
        if( is_array( $curr ) ) {
          foreach($curr as $sub_item) $acc[] = $sub_item;
        } else {
          $acc[] = $curr;
        }
        return $acc;
      });
      
      // Check if $arr contains an array
      $has_sub_arrays = false;
      foreach( $arr as $item ) {
        if( is_array( $item ) ) $has_sub_arrays = true;
      }
      
      $depth_remaining--;
    }
    
    return $arr;
  }
}

if( ! function_exists( 'array_entries' ) ) {
  /**
   * The array_entries function returns a new array containing arrays 
   * of the keys and values of the given array
   *
   * @param   array  $arr  The array whos [key => value] pairs are to be returned
   *
   * @return  array        An array of arrays containing the given arays [key => value] pairs
   */
  function array_entries( array $arr ): array
  {
    $new_array = [];
    
    foreach($arr as $key => $value) {
      $new_array[] = [ $key, $value ];
    }
    
    return $new_array;
  }
}

if( ! function_exists( 'array_from_entries' ) ) {
  /**
   * The array_from_entries function restores a new [key => value] array based on 
   * the arrays provided by the given array
   *
   * @param   array  $arr  The array whos arrays are to be restored to a string-keyed [key => value] format
   *
   * @return  array        A new array of keyed properties matching the given arrays items
   */
  function array_from_entries( array $arr ): array
  {
    $new_array = [];
    
    foreach( $arr as $entry ) {
      [ $key, $value ] = $entry;
      $new_array[$key] = $value;
    }
    
    return $new_array;
  }
}

function string_includes( string $haystack, string $needle  ): boolean
{
  return '' === $needle || false !== strpos( $haystack, $needle );
}