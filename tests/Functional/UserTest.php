<?php

namespace Tests\Functional;

class UserTest extends BaseTestCase

{
    /**
    * Test the model for the presence of users as well as ensuring the model isn't an empty array.
    */
    public function testRetrieveModel()
    {
        $app = $this->getApp();
        $model= $app->getContainer()->model;

        $this->assertArrayHasKey('users',$model);
        $this->assertEmpty($model);
    }
    // TODO: Check the rest of the Google Authenticate tutorial and make sure what this returns incorporates all
    // functions.
}
