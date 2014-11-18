(function(){
	var app = angular.module('consignmentApp', ['ui.bootstrap']);
	app.controller('ConsignmentCtrl', function($scope, $log) {
		$scope.books = bookList;
		$scope.consignedBook = {
			'isbn': '',
			'course': '',
			'price': '',
			'title': '',
			'author': ''
		};

	});

	app.controller('ConsignFormCtrl', function($log) {
		this.consignedBook = {
			isbn: '',
			course: '',
			price: '',
			title: '',
			author: ''
		};

		this.addBook = function() {
			$log.info('Consigning book ' + this.consignedBook.isbn + " for course" + this.consignedBook.course);
			bookList.push(this.consignedBook);
			this.consignedBook = {};
		}
	});
	
	app.controller('BookModalCtrl', function($scope, $modal, $log) {
		$scope.open = function() {
			var modalInstance = $modal.open({
				templateUrl: 'bookModal.html',
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
	});

	app.controller('ModalInstanceCtrl', function ($scope, $modalInstance, consignedBook) {
		$scope.consignedBook = {};

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	});

	var bookList = [];

})()