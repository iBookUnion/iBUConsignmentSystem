'use strict';

angular.module('consignmentApp')
  .factory('Consignors', ['API_URI', function () {
	return {
		'getConsignors': getConsignors,
		'getBooks': getBooks
	};

    function getConsignors(studentId) {
		var Consignor = Parse.Object.extend('Consignor');
		var query = new Parse.Query(Consignor);

		if (studentId)
			query.equalTo("studentId", studentId);
		return query.first()
		.then(function(consignor) {
			return consignor;
		}, function(error) {
			// there was some error retreiving consignor.
			console.log('Consignors.getConsignors: ' + error);
		});
	};

    function getBooks(studentId) {
		var Consignor = Parse.Object.extend('Consignor');
		var Book = Parse.Object.extend('Book');
		var ConsignmentItem = Parse.Object.extend('ConsignmentItem');

		var query = new Parse.Query(ConsignmentItem);
		var consignorQuery = new Parse.Query(Consignor);

		consignorQuery.equalTo("studentId", studentId);
		query.matchesQuery("consignor", consignorQuery)
		query.include('items');
		
		return query.find()
		.then(function(consignments) {
			return consignments;
		}).then(function(consignments) {
			var booksList = consignments.map(function(consignment) {
				// get book item objectId
				var bookAttr = consignment.attributes;

				// returns object containing books and associated price, status
				return {"items": bookAttr.items[0], 
						"price": bookAttr.price, 
						"currentState": bookAttr.currentState};
			});

			return booksList;
		}, function(error) {
			// there was some error retreiving consigned books.
			console.log('Consignors.getBooks: ' + error);
		});
	};
  }]);
