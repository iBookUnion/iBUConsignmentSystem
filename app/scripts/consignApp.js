'use strict';

(function(){
	var app = angular.module('consignmentApp', ['ui.bootstrap', 'ngRoute', 'ngResource']);

	app.config(function ($routeProvider) {
		$routeProvider
			.when('/', {
				templateUrl: '../views/consignmentForm.html'
			})
			.when('/admin', {
				templateUrl: 'views/inventory.html',
				controller: 'InventoryCtrl'
			})
			.when('/admin/forms', {
				templateUrl: 'views/forms.html',
				controller: 'FormsCtrl'
			})
			.when('/admin/consignorInfo/:sno', {
				templateUrl: 'views/consignorInfo.html',
				controller: 'ConsignorInfoCtrl'
			})
			.otherwise({
				redirectTo: '/'
			});
	});

	app.directive('contactForm', function() {
		return {
			restrict: 'E',
			templateUrl: 'views/consignmentForm/contactForm.html'
		};
	})
		.directive('bookList', function() {
			return {
				restrict: 'E',
				templateUrl: 'views/consignmentForm/bookList.html'
			};
		})
		.directive('agreement', function() {
			return {
				restrict: 'E',
				templateUrl: 'views/consignmentForm/agreement.html'
			};
		});

	app.controller('ConsignmentCtrl', ['$scope', 'BookCartService', function($scope, BookCartService) {
		var bookList = BookCartService.getItems;

		$scope.contact = {
			'fname': '',
			'lname': '',
			'sno': '',
			'email': '',
			'phno': '',
			'faculty': '',
			'discovery': ''
		};

		$scope.fname = '';
		console.log($scope.contact.fname);

		$scope.createJson = function() {
			var consignor = {'student_id': $scope.contact.sno,
						'first_name': $scope.contact.fname,
						'last_name': $scope.contact.lname,
						'email': $scope.contact.email,
						'phone_number': $scope.contact.phno};
			var books = [];
			var consignments = [];

			for (var i = 0; i < bookList.length; i++) {
				var book = {
					'isbn': bookList[i].isbn,
					'title': bookList[i].title,
					'author': bookList[i].author,
					'edition': 1,
					'courses': bookList[i].courses			
				};

				var consignment = {
					'isbn': bookList[i].isbn,
					'student_id': $scope.contact.sno,
					'price': bookList[i].price,
					'current_state': '1',
					'date': 'Now'
				};

				books.push(book);
				consignments.push(consignment);
			}

			var jsonObj = {'consignor': consignor,
						'books': books,
						'consignments': consignments};

			console.log(JSON.stringify(jsonObj));

			var confirmation = window.open();
			confirmation.document.write(JSON.stringify(jsonObj));
		};

	}]);

	app.controller('BookFormCtrl', ['$scope', '$modal', '$log', 'BookCartService',
		function ($scope, $modal, $log, BookCartService) {
			$scope.books = BookCartService.getItems();


			$scope.open = function () {
				var modalInstance = $modal.open({
					templateUrl: 'views/consignmentForm/bookModal.html',
					controller: 'ModalInstanceCtrl',
					resolve: {
						consignedBook: function () {
							return $scope.consignedBook;
						}
					}
				});

				modalInstance.result.then(function (consignedBook) {
					$scope.consignedBook = consignedBook;
				}, function () {
					$log.info('Modal dismissed at: ' + new Date());
				});
			};
		}]);

	app.controller('ConsignFormCtrl', ['$scope', '$log', 'BookCartService', function($scope, $log, BookCartService) {

		//TODO: Either complete or remove support multiple courses.
		// Need to instantiate empty array for courses on init.
		this.consignedBook = {
			courses: []
		};

		this.resetForm = function() {
			this.consignedBook = {
				isbn: '',
				courses: [],
				price: '',
				title: '',
				author: ''
			};
			$scope.consignForm.$setPristine();
			$log.info('reset');
		};

		this.addBook = function() {
			$log.info('Consigning book ' + this.consignedBook.isbn + ' for course ' + this.consignedBook.courses[0]);
			BookCartService.addItem(this.consignedBook);
			this.resetForm();
		};
	}]);

	app.controller('ModalInstanceCtrl', function ($scope, $modalInstance) {
		$scope.consignedBook = {};

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	});
})();