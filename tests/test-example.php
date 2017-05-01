<?php
class NF_Auth_Example_Tests extends WP_UnitTestCase {
    function setUp() {
        parent::setUp();
    }
    function test_assert_true() {
        $this->assertTrue( true );
    }
    function test_assert_false() {
        $this->assertFalse( false );
    }
}