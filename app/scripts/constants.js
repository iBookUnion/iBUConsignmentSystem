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
      'available': 'available',
      'sold': 'sold',
      'unavailable': 'not in store',
      'complete': 'complete'
    };
    return {
      'bookState': bookStateMapping,
      'bookStates': _.values(bookStateMapping),
      'faculties': ['Arts', 'Commerce', 'Music', 'Science', 'Applied Science',
        'Forestry', 'Dentistry', 'Human Kinetics',
        'Creative and Critical Studies', 'Land and Food Systems', 'Law',
        'Pharmaceutical Sciences', 'Medicine',
        'Management', 'School of Social Work and Family Studies', 'Other']
    };
  }()));