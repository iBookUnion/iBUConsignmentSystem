'use strict';

angular.module('consignmentApp')
  .factory('ConsignmentService', ['ConsignmentApi', 'Consignors',
    function (ConsignmentAPI, Consignors) {
      return {
        'createNewForm': createNewForm,
        'submitForm': submitForm,
        'retrieveExistingForm': retrieveExistingForm
      };

      function submitForm(form) {
        return ConsignmentAPI.submitForm(form);
      }

      function createNewForm() {
;       return {
          consignments: []
        };        
//return getTestData();

      }

      function retrieveExistingForm(studentId) {
        var form;
        return Consignors.getConsignors(studentId)
          .then(function (consignor) {
            form = angular.copy(consignor);
            return Consignors.getConsignmentItems(studentId);
          })
          .then(function (consignedBooks) {
            form.consignments = consignedBooks;
            return form;
          });
      }

      function getTestData() {
        return {
          "email": "timch326@asdf.ca",
          "faculty": "Arts",
          "firstName": "Hello",
          "lastName": "World",
          "phoneNumber": "1237771234",
          "studentId": "12345678",
          "objectId": "Ay6k25dDFc",
          "createdAt": "2015-08-09T22:30:14.822Z",
          "updatedAt": "2015-08-23T01:18:09.822Z",
          "consignments": [{
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "doLjOHvWBP",
            "createdAt": "2015-08-11T19:52:28.625Z",
            "updatedAt": "2015-08-11T19:52:28.625Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "BhxJqB5a0C",
            "createdAt": "2015-08-11T19:54:43.230Z",
            "updatedAt": "2015-08-11T19:54:43.230Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "WD1fSwt5DJ",
            "createdAt": "2015-08-11T19:58:05.142Z",
            "updatedAt": "2015-08-11T19:58:05.142Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "7Ya6DyDlXq",
            "createdAt": "2015-08-11T19:58:48.819Z",
            "updatedAt": "2015-08-11T19:58:48.819Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "6zh20zZt2w",
            "createdAt": "2015-08-11T19:59:12.902Z",
            "updatedAt": "2015-08-11T19:59:12.902Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "64oqwivYcf",
            "createdAt": "2015-08-11T20:01:16.416Z",
            "updatedAt": "2015-08-11T20:01:16.416Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "qPDhfRpjqS",
            "createdAt": "2015-08-11T20:03:58.110Z",
            "updatedAt": "2015-08-11T20:03:58.110Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "New Author",
              "copiesAvailable": 1,
              "courses": "BOOK 100",
              "edition": "New Edition",
              "isbn": "4321876509321",
              "title": "Some new Book",
              "objectId": "6PWUEJN9UF",
              "createdAt": "2015-08-11T20:03:57.958Z",
              "updatedAt": "2015-08-11T20:03:58.323Z"
            }],
            "price": 45,
            "objectId": "9QYE9qamxm",
            "createdAt": "2015-08-11T20:03:58.350Z",
            "updatedAt": "2015-08-11T20:03:58.350Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Fun Author",
              "copiesAvailable": 7,
              "courses": "FUNN 999",
              "edition": "Fun Edition",
              "isbn": "1111222233334",
              "title": "Funny Book",
              "objectId": "Tt2PEOulVH",
              "createdAt": "2015-08-12T03:01:35.632Z",
              "updatedAt": "2015-08-12T03:25:25.019Z"
            }],
            "price": 99,
            "objectId": "aZcx1dqYdT",
            "createdAt": "2015-08-12T03:01:36.653Z",
            "updatedAt": "2015-08-12T03:01:36.653Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "AUYnBJ44lP",
            "createdAt": "2015-08-12T03:01:36.776Z",
            "updatedAt": "2015-08-12T03:01:36.776Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Fun Author",
              "copiesAvailable": 7,
              "courses": "FUNN 999",
              "edition": "Fun Edition",
              "isbn": "1111222233334",
              "title": "Funny Book",
              "objectId": "Tt2PEOulVH",
              "createdAt": "2015-08-12T03:01:35.632Z",
              "updatedAt": "2015-08-12T03:25:25.019Z"
            }],
            "price": 99,
            "objectId": "3qK9l5MTNz",
            "createdAt": "2015-08-12T03:07:01.727Z",
            "updatedAt": "2015-08-12T03:07:01.727Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "ieGpvCaMvp",
            "createdAt": "2015-08-12T03:07:01.944Z",
            "updatedAt": "2015-08-12T03:07:01.944Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "yj4WzfO8Rf",
            "createdAt": "2015-08-12T03:16:09.218Z",
            "updatedAt": "2015-08-12T03:16:09.218Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Fun Author",
              "copiesAvailable": 7,
              "courses": "FUNN 999",
              "edition": "Fun Edition",
              "isbn": "1111222233334",
              "title": "Funny Book",
              "objectId": "Tt2PEOulVH",
              "createdAt": "2015-08-12T03:01:35.632Z",
              "updatedAt": "2015-08-12T03:25:25.019Z"
            }],
            "price": 99,
            "objectId": "ycnWSegdzn",
            "createdAt": "2015-08-12T03:16:09.516Z",
            "updatedAt": "2015-08-12T03:16:09.516Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Fun Author",
              "copiesAvailable": 7,
              "courses": "FUNN 999",
              "edition": "Fun Edition",
              "isbn": "1111222233334",
              "title": "Funny Book",
              "objectId": "Tt2PEOulVH",
              "createdAt": "2015-08-12T03:01:35.632Z",
              "updatedAt": "2015-08-12T03:25:25.019Z"
            }],
            "price": 99,
            "objectId": "DCkXTiMxgB",
            "createdAt": "2015-08-12T03:22:57.058Z",
            "updatedAt": "2015-08-12T03:22:57.058Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "4JuM2qUBOP",
            "createdAt": "2015-08-12T03:22:57.078Z",
            "updatedAt": "2015-08-12T03:22:57.078Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Fun Author",
              "copiesAvailable": 7,
              "courses": "FUNN 999",
              "edition": "Fun Edition",
              "isbn": "1111222233334",
              "title": "Funny Book",
              "objectId": "Tt2PEOulVH",
              "createdAt": "2015-08-12T03:01:35.632Z",
              "updatedAt": "2015-08-12T03:25:25.019Z"
            }],
            "price": 99,
            "objectId": "k2vf98TIZQ",
            "createdAt": "2015-08-12T03:24:04.217Z",
            "updatedAt": "2015-08-12T03:24:04.217Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "mXfmVrHpUV",
            "createdAt": "2015-08-12T03:24:04.278Z",
            "updatedAt": "2015-08-12T03:24:04.278Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "lyj9aAFc06",
            "createdAt": "2015-08-12T03:24:16.668Z",
            "updatedAt": "2015-08-12T03:24:16.668Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Fun Author",
              "copiesAvailable": 7,
              "courses": "FUNN 999",
              "edition": "Fun Edition",
              "isbn": "1111222233334",
              "title": "Funny Book",
              "objectId": "Tt2PEOulVH",
              "createdAt": "2015-08-12T03:01:35.632Z",
              "updatedAt": "2015-08-12T03:25:25.019Z"
            }],
            "price": 99,
            "objectId": "lJlfTcq2ci",
            "createdAt": "2015-08-12T03:24:16.985Z",
            "updatedAt": "2015-08-12T03:24:16.985Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Fun Author",
              "copiesAvailable": 7,
              "courses": "FUNN 999",
              "edition": "Fun Edition",
              "isbn": "1111222233334",
              "title": "Funny Book",
              "objectId": "Tt2PEOulVH",
              "createdAt": "2015-08-12T03:01:35.632Z",
              "updatedAt": "2015-08-12T03:25:25.019Z"
            }],
            "price": 99,
            "objectId": "CE0nlVEQl7",
            "createdAt": "2015-08-12T03:25:25.047Z",
            "updatedAt": "2015-08-12T03:25:25.047Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "qD5N27z2pO",
            "createdAt": "2015-08-12T03:25:25.109Z",
            "updatedAt": "2015-08-12T03:25:25.109Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 100,
            "objectId": "5T5tpiwa46",
            "createdAt": "2015-08-12T03:38:20.547Z",
            "updatedAt": "2015-08-12T03:38:20.547Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "John Ubyssey",
              "copiesAvailable": 1,
              "courses": "UBCO 100",
              "edition": "Canadian Edition",
              "isbn": "0987654321123",
              "title": "Tour Around UBC",
              "objectId": "IPEVIHUz0M",
              "createdAt": "2015-08-12T03:38:20.333Z",
              "updatedAt": "2015-08-12T03:38:20.666Z"
            }],
            "price": 111,
            "objectId": "nfpD6Bo20S",
            "createdAt": "2015-08-12T03:38:20.713Z",
            "updatedAt": "2015-08-12T03:38:20.713Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 50,
            "objectId": "5cWRHdXo1o",
            "createdAt": "2015-08-12T03:45:20.244Z",
            "updatedAt": "2015-08-12T03:45:20.244Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 10,
            "objectId": "8yePxoUbBg",
            "createdAt": "2015-08-12T04:28:28.851Z",
            "updatedAt": "2015-08-12T04:28:28.851Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 10,
            "objectId": "NjoZIkjQf0",
            "createdAt": "2015-08-12T04:31:56.477Z",
            "updatedAt": "2015-08-12T04:31:56.477Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 10,
            "objectId": "dOqlamyykB",
            "createdAt": "2015-08-12T04:32:13.843Z",
            "updatedAt": "2015-08-12T04:32:13.843Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 10,
            "objectId": "UOb3x5OJFs",
            "createdAt": "2015-08-12T04:35:14.635Z",
            "updatedAt": "2015-08-12T04:35:14.635Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 10,
            "objectId": "ncnJweqRux",
            "createdAt": "2015-08-12T04:37:20.478Z",
            "updatedAt": "2015-08-12T04:37:20.478Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 34,
            "objectId": "8ysBrxv3vO",
            "createdAt": "2015-08-22T19:31:33.637Z",
            "updatedAt": "2015-08-22T19:31:33.637Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "asdf",
              "copiesAvailable": 1,
              "courses": "TEST 101",
              "edition": "Some edition",
              "isbn": "1234567890123",
              "title": "Help",
              "objectId": "p9V9soCW4N",
              "createdAt": "2015-08-11T19:45:29.909Z",
              "updatedAt": "2015-08-11T19:45:30.213Z"
            }],
            "price": 10,
            "objectId": "ppCE3VveMJ",
            "createdAt": "2015-08-11T19:45:30.265Z",
            "updatedAt": "2015-08-11T19:45:30.265Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 12,
            "objectId": "JC4IfBAui7",
            "createdAt": "2015-08-11T19:46:57.028Z",
            "updatedAt": "2015-08-11T19:46:57.028Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 12,
            "objectId": "mTP7GfqeS3",
            "createdAt": "2015-08-11T19:48:58.740Z",
            "updatedAt": "2015-08-11T19:48:58.740Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "Xintu5SD9h",
            "createdAt": "2015-08-11T19:51:01.447Z",
            "updatedAt": "2015-08-11T19:51:01.447Z"
          }, {
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "objectId": "CT38WZGMc4",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }],
            "price": 13,
            "objectId": "01GJFCKqth",
            "createdAt": "2015-08-11T19:52:08.745Z",
            "updatedAt": "2015-08-11T19:52:08.745Z"
          }]
        };
      }
    }]);
