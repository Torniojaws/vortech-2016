<?php

     /**
      * Tests that all settings and rights are correct to install the site.
      */
     class SetupTest extends PHPUnit_Framework_TestCase
     {
         public function testPhotoUploadAccessRights()
         {
             $errors = 0;
             $files_that_need_special_permits = array(
                './apps/photos/admin/add-photos.php',
                './apps/shop/admin/add-shopitem.php',
                './classes/ImageUploader.php',
                './classes/ImageResizer.php',
             );
             foreach ($files_that_need_special_permits as $file) {
                 $perms = substr(decoct(fileperms($file)), 2);
                 if ($perms == '0777' || $perms == '0755') {
                     continue;
                 } else {
                     $errors += 1;
                 }
             }

             $this->assertEquals(0, $errors);
         }
     }
