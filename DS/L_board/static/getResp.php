<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-12-24
 * Time: 22:13
 */
require './Http.php';

$size = empty($_GET['size']) ? 8 : $_GET['size'];

$h = new Http();

try {
    $url = '' . $size;
    echo $h->get($url);

} catch (Exception $e) {
    $h->status( $e->getCode());
    echo $e->getCode() . ': ' . $e->getMessage();
}

//echo '{
//  "n": 4,
//  "initial_occupied_block": {
//    "row": 3,
//    "col": 2
//  },
//  "pieces": [
//    {
//      "loc": [
//        {
//          "row": 1,
//          "col": 1
//        },
//        {
//          "row": 1,
//          "col": 2
//        },
//        {
//          "row": 2,
//          "col": 1
//        }
//      ]
//    },
//    {
//      "loc": [
//        {
//          "row": 0,
//          "col": 0
//        },
//        {
//          "row": 0,
//          "col": 1
//        },
//        {
//          "row": 1,
//          "col": 0
//        }
//      ]
//    },
//    {
//      "loc": [
//        {
//          "row": 0,
//          "col": 2
//        },
//        {
//          "row": 0,
//          "col": 3
//        },
//        {
//          "row": 1,
//          "col": 3
//        }
//      ]
//    },
//    {
//      "loc": [
//        {
//          "row": 2,
//          "col": 0
//        },
//        {
//          "row": 3,
//          "col": 0
//        },
//        {
//          "row": 3,
//          "col": 1
//        }
//      ]
//    },
//    {
//      "loc": [
//        {
//          "row": 2,
//          "col": 2
//        },
//        {
//          "row": 2,
//          "col": 3
//        },
//        {
//          "row": 3,
//          "col": 3
//        }
//      ]
//    }
//  ]
//}';
