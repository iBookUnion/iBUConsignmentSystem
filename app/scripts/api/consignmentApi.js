angular.module('consignmentApp')
  .service('ConsignmentApi', ['$http', '$location', 'API_URI', 'ContractService',
    function ($http, $location, API_URI, ContractService) {
      return {
        'submitForm': submitForm
        //'searchConsignments': searchConsignments,
        //'getConsignments': getConsignments
      };

      //function searchConsignments(params) {
      //  return $http.get(API_URI.consignment,
      //    {params: params})
      //    .then(function (response) {
      //      return response.data.consignments;
      //    })
      //    .then(convertToCamelCase);
      //}
      //
      //function getConsignments(consignmentId) {
      //  var consignmentParam = consignmentId ? '/' + consignmentId : '';
      //  return $http.get(API_URI.consignment + consignmentParam)
      //    .then(function (response) {
      //      return response.data.consignments;
      //    })
      //    .then(convertToCamelCase);
      //}

      function submitForm(form) {
        form = angular.fromJson(angular.toJson(form)); // Strips Angular $ properties
        return Parse.Cloud.run('postConsignment', form);
      }
    }]);