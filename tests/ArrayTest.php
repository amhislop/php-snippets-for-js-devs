<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestArraySnippets extends TestCase
{

  /**
   * @dataProvider providerArraySome
   * 
   * @param   array     $data
   * @param   callable  $callback
   * @param   *         $expected
   * 
   * @return  null
   */
  public function testArraySome( array $data, callable $callback, bool $expected ) : void
  { 
    $result = array_some( $callback, $data );

    $this->assertIsBool($result);
    $this->assertSame( $result, $expected );
  }


  /**
   * @dataProvider  providerArrayEvery
   * 
   * @param   array     $data
   * @param   callable  $callback
   * @param   *         $expected
   * 
   * @return null
   */
  public function testArrayEvery( array $data, callable $callback, bool $expected ) : void
  {

    $result = array_every( $callback, $data );

    $this->assertIsBool($result);
    $this->assertSame( $result, $expected );

  }

  /**
   * @dataProvider providerArrayFind
   */
  public function testArrayFind( array $data, callable $callback, $expected ) : void
  {

    $result = array_find( $callback, $data );

    $this->assertSame( $result, $expected );
  }

  /**
   * @dataProvider providerArraySort
   * 
   * @param   array         $data
   * @param   callable|null $callback
   * @param   *             $expected The expected result
   * 
   * @return null
   */
  public function testArraySort( array $data, callable $callback = null, $expected ) : void
  {
    $result = array_sort( $data, $callback );

    $this->assertIsArray( $result );
    $this->assertSame( $result, $expected );
  }

  /**
   * @dataProvider providerArrayFlat
   * 
   * @param   array         $data
   * @param   int|INF       $depth
   * @param   *             $expected The expected result
   * 
   * @return null
   */
  public function testArrayFlat( array $data, $depth, $expected ) : void
  {
    
    $result = $depth ? array_flat( $data, $depth ) : array_flat( $data );

    $this->assertIsArray( $result );
    $this->assertSame( $result, $expected );
  }


  // --------------
  // DATA PROVIDERS
  // --------------

  public function providerArraySome()
  {
    $cb = function($n) { return is_integer($n); };

    return [
      'numbers'         => [ ['13', '85', '15', 23], $cb, true ],
      'integers'        => [ [13, 85, 15, 23], $cb, true ],
      'associative'     => [ ['first' => 15, 'second' => '85', 'third' => 23], $cb, true ],
      'non-sequential'  => [ [ 3 => '13', 5 => '15', 0 => '23' ], $cb, false ]
    ];
  }

  public function providerArrayEvery()
  {
    $cb = function($n) { return is_integer($n); };

    return [
      'numbers'         => [ ['13', '85', '15', 23], $cb, false ],
      'integers'        => [ [13, 85, 15, 23], $cb, true ],
      'associative'     => [ ['first' => 15, 'second' => '85', 'third' => 23], $cb, false ],
      'non-sequential'  => [ [ 3 => '13', 5 => '15', 0 => '23' ], $cb, false ]
    ];
  }

  public function providerArrayFind()
  {
    $cb_strings = function($n) { return $n === 'Lucy'; };
    $cb_integers = function($n) { return $n === 15; };
    $cb_arrays = function($n) { return in_array('b', $n); };

    return [
      'strings'   => [ ['Sam', 'Damo', 'Kate', 'Lucy'], $cb_strings, 'Lucy' ],
      'integers'  => [ [ 3, 5, 6, 84, 3 ], $cb_integers, null ],
      'arrays'    => [ [ 
        [ 1, 2, 3 ], 
        [ 'a', 'b', 'c' ], 
        [ false, true, true ] 
      ], $cb_arrays, [ 'a', 'b', 'c' ] ]
    ];
  }

  public function providerArraySort()
  {
    $cb_desc_sort = function($a, $b) { return $b - $a; };

    return [
      'desc-numbers'  => [[1, 7, 3, 2, 8], $cb_desc_sort, [ 8, 7, 3, 2, 1 ]],
      'asc-numbers'   => [[1, 7, 3, 2, 8], null, [ 1, 2, 3, 7, 8 ]],
      'associative'   => [ [
        'a' => 15, 
        'b' => 185, 
        'c' => 23
      ], $cb_desc_sort, [
        'b' => 185,
        'c' => 23, 
        'a' => 15
      ]],
    ];
  }

  public function providerArrayFlat()
  {
    $data = [ 1, 2, [ 3, 4, [ 5, 6, [ 7, 8 ] ] ] ];
    return [
      'explicit-depth' => [ $data, 2, [ 1, 2, 3, 4, 5, 6, [ 7, 8 ] ] ],
      'implicit-depth' => [ $data, null, [ 1, 2, 3, 4, [ 5, 6, [ 7, 8 ] ] ] ],
      'infinite'  => [ $data, INF, [ 1, 2, 3, 4, 5, 6, 7, 8 ] ]
    ];
  }

}
