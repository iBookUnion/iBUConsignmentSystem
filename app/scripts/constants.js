'use strict';

angular.module('consignmentApp')
  .constant('API_URI', (function () {
    var baseURL = 'http://timadvance.me/ibu_test/v1';
    return {
      'baseURL': baseURL,
      'inventory': baseURL + '/inventory',
      'books': baseURL + '/books/:isbn',
      'consignors': baseURL + '/users',
      'consignor': baseURL + '/user/:consignorId',
      'consignment': baseURL + '/consignments'
    };
  })())
  .constant('OPTIONS', (function () {
    var bookStateMapping = {
      'available': 'Available',
      'sold': 'Sold',
      'unavailable': 'Not in Store',
      'complete': 'Consignment Complete'
    };
    return {
      'bookState': bookStateMapping,
      'bookStates': _.values(bookStateMapping),
      'faculties': ['Arts', 'Commerce', 'Music', 'Science', 'Applied Science', 'Forestry', 'Dentistry', 'Human Kinetics']
    };
  }()));