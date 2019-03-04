<?php
   namespace App\Controller;

   use App\Controller\AppController;

   class TestController extends AppController
   {
       public function index(...$path)
       {
           $this->set('Product_Name','XYZ');
       }
   }
