(function(){
	var app = angular.module('consignmentApp', ['ui.bootstrap']);

	app.controller('ConsignmentCtrl', function($scope, $log) {
		signContract = false;

		$scope.contact = {
			'fname': '',
			'lname': '',
			'sno': '',
			'email': '',
			'phno': '',
			'faculty': '',
			'discovery': ''
		};

		$scope.fname = fname;
		console.log($scope.contact.fname);

		$scope.createJson = function() {
			consignor = {'student_id': $scope.contact.sno,
						'first_name': $scope.contact.fname,
						'last_name': $scope.contact.lname,
						'email': $scope.contact.email,
						'phone_number': $scope.contact.phno};
			books = [];
			consignments = [];

			for (i = 0; i < bookList.length; i++) {
				book = {
					'isbn': bookList[i].isbn,
					'title': bookList[i].title,
					'author': bookList[i].author,
					'edition': 1,
					'courses': bookList[i].courses			
				};

				consignment = {
					'isbn': bookList[i].isbn,
					'student_id': $scope.contact.sno,
					'price': bookList[i].price,
					'current_state': '1',
					'date': 'Now'
				}

				books.push(book);
				consignments.push(consignment);
			}

			jsonObj = {'consignor': consignor,
						'books': books,
						'consignments': consignments};

			console.log(JSON.stringify(jsonObj));

			var confirmation = window.open();
			confirmation.document.write(JSON.stringify(jsonObj));
		}

	});

	// app.controller('ContactCtrl', function($scope, $log) {
	// 	$scope.fname = fname;
	// 	$scope.lname = lname;
	// 	$scope.sno = sno;
	// 	$scope.email = email;
	// 	$scope.phno = phno;
	// 	$scope.faculty = faculty;
	// 	$scope.discover = discovery;

	// });

	app.controller('BookFormCtrl', function($scope, $log) {
		$scope.books = bookList;

	});

	app.controller('ConsignFormCtrl', function($log) {
		this.consignedBook = {
			isbn: '',
			courses: [],
			price: '',
			title: '',
			author: ''
		};

		this.addBook = function() {
			$log.info('Consigning book ' + this.consignedBook.isbn + " for course" + this.consignedBook.courses[0]);
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
	var contactInfo = [];
	var fname = '';
	var lname = '';
	var sno = '';
	var email = '';
	var phno = '';
	var faculty = '';
	var discovery = '';

})()